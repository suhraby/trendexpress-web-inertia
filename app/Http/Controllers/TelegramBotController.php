<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends Controller
{
    protected TelegramService $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function webhook(Request $request): JsonResponse
    {
        try {
            $update = $request->all();

            Log::info('Telegram webhook received', ['update' => $update]);

            $this->telegramService->processMessage($update);

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());

            return response()->json([
                'ok' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function setWebhook(): JsonResponse
    {
        $url = config('telegram.bots.mybot.webhook_url') ?? env('TELEGRAM_BOT_WEBHOOK_URL');

        if (!$url) {
            return response()->json([
                'success' => false,
                'message' => 'Webhook URL not configured',
            ], 400);
        }

        $result = $this->telegramService->setWebhook($url);

        return response()->json($result);
    }

    public function removeWebhook(): JsonResponse
    {
        $result = $this->telegramService->removeWebhook();

        return response()->json($result);
    }

    public function getWebhookInfo(): JsonResponse
    {
        $info = $this->telegramService->getWebhookInfo();

        return response()->json($info);
    }

    /**
     * Set bot commands menu
     */
    public function setBotCommands(): JsonResponse
    {
        $result = $this->telegramService->setBotCommands();

        return response()->json($result);
    }

    /**
     * Get bot commands
     */
    public function getBotCommands(): JsonResponse
    {
        $result = $this->telegramService->getBotCommands();

        return response()->json($result);
    }

    /**
     * Delete bot commands
     */
    public function deleteBotCommands(): JsonResponse
    {
        $result = $this->telegramService->deleteBotCommands();

        return response()->json($result);
    }
}
