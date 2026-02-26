<?php

namespace App\Services;

use Telegram\Bot\Api;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\WebhookInfo;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramService
{
    protected Api $telegram;
    protected CargoService $cargoService;

    /**
     * Constructor
     *
     * @param CargoService $cargoService
     */
    public function __construct(CargoService $cargoService)
    {
        $this->telegram = new Api(config('telegram.bots.mybot.token'));
        $this->cargoService = $cargoService;
    }

    public function processMessage(array $update): void
    {
        try {
            if (!isset($update['message'])) {
                return;
            }

            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'] ?? '';

            // Handle commands
            if (str_starts_with($text, '/')) {
                $this->handleCommand($chatId, $text);
                return;
            }

            // Handle cargo number query
            $this->handleCargoQuery($chatId, $text);
        } catch (\Exception $e) {
            Log::error('Telegram bot error: ' . $e->getMessage(), [
                'update' => $update,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    protected function handleCommand(int $chatId, string $command): void
    {
        $parts = explode(' ', trim($command), 2);
        $cmd = strtolower($parts[0]);
        $params = $parts[1] ?? '';

        match ($cmd) {
            '/start' => $this->sendWelcomeMessage($chatId),
            '/help' => $this->sendHelpMessage($chatId),
            '/track' => $this->handleTrackCommand($chatId, $params),
            default => $this->sendMessage(
                $chatId,
                "❌ Näbelli buýruk. /help ulanyp, elýeterli buýruklary görüp bilersiňiz.."
            ),
        };
    }

    protected function handleTrackCommand(int $chatId, string $cargoNumber): void
    {
        if (empty($cargoNumber)) {
            $this->sendMessage(
                $chatId,
                "📦 *Kargoňyzy yzarlaň*\n\n" .
                    "Kargo nomeri ýazyň:\n\n" .
                    "Ulanyş: `/track ABC123456789`\n" .
                    "Ýa-da kargo nomerini gysgaça ýazyň.",
                true
            );
            return;
        }

        $this->handleCargoQuery($chatId, trim($cargoNumber));
    }

    protected function handleCargoQuery(int $chatId, string $cargoNumber): void
    {
        $cargoNumber = trim($cargoNumber);

        if (!$this->cargoService->isValidCargoNumber($cargoNumber)) {
            $this->sendMessage(
                $chatId,
                "❌ *Nädogry kargo nomeri formaty*\n\n" .
                    "Dogry kargo nomerini ýazyň (6-20 harp ýa-da san simwoly).\n" .
                    "Mysal üçin: `ABC123456789`",
                true
            );
            return;
        }

        $cargo = $this->cargoService->findCargoByNumber($cargoNumber);

        if (!$cargo) {
            $this->sendMessage(
                $chatId,
                "❌ *Kargoňyz tapylmady*\n\n" .
                    "Kargo nomeri: `{$cargoNumber}`\n\n" .
                    "Nomeri barlaň we täzeden synanyşyň.",
                true
            );
            return;
        }

        $this->sendCargoInformation($chatId, $cargo);
    }

    protected function sendCargoInformation(int $chatId, $cargo): void
    {
        $message = $this->cargoService->formatCargoInfo($cargo);
        $message .= $this->cargoService->formatStatusHistory($cargo);

        if ($this->cargoService->hasImages($cargo)) {
            $imageUrls = $this->cargoService->getAllImageUrls($cargo);

            $validUrls = array_filter($imageUrls, function ($url) {
                return $this->isValidUrl($url);
            });

            if (!empty($validUrls)) {
                $this->sendCargoWithImages($chatId, $cargo, $validUrls, $message);
            } else {
                $this->sendMessage($chatId, $message, true);

                Log::warning('No valid image URLs', [
                    'cargo_id' => $cargo->id,
                    'attempted_urls' => $imageUrls,
                ]);
            }
        } else {
            $this->sendMessage($chatId, $message, true);
        }
    }

    protected function isValidUrl(string $url): bool
    {
        if (!str_starts_with($url, 'https://')) {
            Log::warning('Invalid URL - not HTTPS', ['url' => $url]);
            return false;
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            Log::warning('Invalid URL format', ['url' => $url]);
            return false;
        }

        return true;
    }

    protected function sendCargoWithImages(int $chatId, $cargo, array $imageUrls, string $caption): void
    {
        try {
            $imageCount = count($imageUrls);

            if ($imageCount === 1) {
                $this->sendPhoto($chatId, $imageUrls[0], $caption);
            } elseif ($imageCount <= 10) {
                $this->sendMediaGroup($chatId, $imageUrls, $caption);
            } else {
                $firstTen = array_slice($imageUrls, 0, 10);
                $this->sendMediaGroup($chatId, $firstTen, $caption);

                $remaining = $imageCount - 10;
                $this->sendMessage(
                    $chatId,
                    "ℹ️ This cargo has {$remaining} more image(s). Only first 10 are shown.",
                    false
                );
            }
        } catch (\Exception $e) {
            Log::error('Failed to send cargo images', [
                'error' => $e->getMessage(),
                'cargo_id' => $cargo->id,
                'chat_id' => $chatId,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->sendMessage($chatId, $caption, true);
            $this->sendMessage(
                $chatId,
                "⚠️ Failed to load images. Please try again later.",
                false
            );
        }
    }

    protected function sendPhoto(int $chatId, string $photoUrl, string $caption): void
    {
        try {
            $this->telegram->sendPhoto([
                'chat_id' => $chatId,
                'photo' => InputFile::create($photoUrl),
                'caption' => $caption,
                'parse_mode' => 'Markdown',
            ]);

            Log::info('Photo sent successfully', [
                'chat_id' => $chatId,
                'url' => $photoUrl,
            ]);
        } catch (TelegramSDKException $e) {
            Log::error('Failed to send photo', [
                'error' => $e->getMessage(),
                'url' => $photoUrl,
            ]);
            throw $e;
        }
    }

    protected function sendMediaGroup(int $chatId, array $imageUrls, string $caption): void
    {
        try {
            $media = [];

            foreach ($imageUrls as $index => $url) {
                $mediaItem = [
                    'type' => 'photo',
                    'media' => $url,
                ];

                if ($index === 0) {
                    $mediaItem['caption'] = $caption;
                    $mediaItem['parse_mode'] = 'Markdown';
                }

                $media[] = $mediaItem;
            }

            $this->telegram->sendMediaGroup([
                'chat_id' => $chatId,
                'media' => json_encode($media),
            ]);

            Log::info('Media group sent successfully', [
                'chat_id' => $chatId,
                'image_count' => count($imageUrls),
                'urls' => $imageUrls,
            ]);
        } catch (TelegramSDKException $e) {
            Log::error('Failed to send media group', [
                'error' => $e->getMessage(),
                'urls' => $imageUrls,
            ]);
            throw $e;
        }
    }

    protected function sendDocument(int $chatId, string $fileUrl, string $caption = ''): void
    {
        try {
            $params = [
                'chat_id' => $chatId,
                'document' => $fileUrl,
            ];

            if ($caption) {
                $params['caption'] = $caption;
                $params['parse_mode'] = 'Markdown';
            }

            $this->telegram->sendDocument($params);
        } catch (TelegramSDKException $e) {
            Log::error('Failed to send document: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function sendWelcomeMessage(int $chatId): void
    {
        $message = "👋 *TrenExpress Kargo Gözegçilik Botuna hoş geldiňiz!*\n\n";
        $message .= "Kargoňyzy wagty-wagtyna yzarlamana kömek edýäris.\n\n";
        $message .= "🚀 *Çalt Başlangyç:*\n";
        $message .= "• Kargo nomeriňizi gönüden-göni iberiň: `ABC123456789`\n";
        $message .= "• ýa-da: `/track ABC123456789` ýazyň\n\n";
        $message .= "📋 *Elýeterli buýruklar:*\n";
        $message .= "/start - Hoş geldiňiz habaryny görkezýär\n";
        $message .= "/help - Kömel soraň bilersiňiz\n";
        $message .= "/track - Ýüküňizi yzarlamak\n\n";
        $message .= "💡 *Maslahat:* Elýeterli ähli buýruklary görmek üçin `/` ýazyň!";

        $this->sendMessage($chatId, $message, true);
    }

    /**
     * Send help message
     */
    protected function sendHelpMessage(int $chatId): void
    {
        $message = "📖 *Kömek we buýruklar*\n";
        $message .= "🎯 *Elýeterli Buýruklar:*\n\n";

        $message .= "🏁 `/start`\n";
        $message .= "Boty başladyň we hoş geldiňiz habaryny görüň\n\n";

        $message .= "❓ `/help`\n";
        $message .= "Bu kömek hatyny görkezýär\n\n";

        $message .= "📦 `/track `\n";
        $message .= "Kargoňyzy yzarlaň\n";
        $message .= "Mysal: `/track ABC123456789`\n\n";
        $message .= "📝 *Nähili ulanmaly:*\n";
        $message .= "1️⃣ 1-nji görnüş 1: Kargo nomeriňizi göni ýazyň\n";
        $message .= "   Mysal üçin: `ABC123456789`\n\n";
        $message .= "2️⃣ 2-nji görnüş: /track buýrugyny ulanyň\n";
        $message .= "   Mysal üçin: `/track ABC123456789`\n\n";

        $message .= "ℹ️ *Size ugradylar:*\n";
        $message .= "• Kargo we kargo eýesiniň maglumatlary\n";
        $message .= "• Şu wagtky statusy\n";
        $message .= "• Doly status ýagdaýy\n";
        $message .= "• Iň soňky status üýtgeşmeleri\n\n";

        $message .= "💡 *Maslahat:* Ähli buýruklary görmek üçin habar meýdanyna `/` ýazyň!";

        $this->sendMessage($chatId, $message, true);
    }

    public function sendMessage(int $chatId, string $text, bool $markdown = false): void
    {
        try {
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
            ];

            if ($markdown) {
                $params['parse_mode'] = 'Markdown';
            }

            $this->telegram->sendMessage($params);
        } catch (TelegramSDKException $e) {
            Log::error('Failed to send Telegram message: ' . $e->getMessage());
        }
    }

    public function setWebhook(string $url): array
    {
        try {
            $response = $this->telegram->setWebhook([
                'url' => $url,
            ]);

            return [
                'success' => true,
                'message' => 'Webhook set successfully',
                'response' => $response,
            ];
        } catch (TelegramSDKException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function removeWebhook(): array
    {
        try {
            $this->telegram->removeWebhook();

            return [
                'success' => true,
                'message' => 'Webhook removed successfully',
            ];
        } catch (TelegramSDKException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getWebhookInfo(): WebhookInfo|array
    {
        try {
            return $this->telegram->getWebhookInfo();
        } catch (TelegramSDKException $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function setBotCommands(): array
    {
        try {
            $commands = [
                [
                    'command' => 'start',
                    'description' => 'Boty başladyň we korgo maglumatlaryny alyň',
                ],
                [
                    'command' => 'help',
                    'description' => 'Elýeterli buýruklary serediň',
                ],
                [
                    'command' => 'track',
                    'description' => 'Ýüküňizi yzarlaň',
                ],
            ];

            $response = $this->telegram->setMyCommands([
                'commands' => json_encode($commands),
            ]);

            return [
                'success' => true,
                'message' => 'Bot commands set successfully',
                'commands' => $commands,
                'response' => $response,
            ];
        } catch (TelegramSDKException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getBotCommands(): array
    {
        try {
            $response = $this->telegram->getMyCommands();

            return [
                'success' => true,
                'commands' => $response,
            ];
        } catch (TelegramSDKException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function deleteBotCommands(): array
    {
        try {
            $this->telegram->deleteMyCommands();

            return [
                'success' => true,
                'message' => 'Bot commands deleted successfully',
            ];
        } catch (TelegramSDKException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
