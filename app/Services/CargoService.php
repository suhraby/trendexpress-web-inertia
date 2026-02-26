<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\CargoStatus;
use Illuminate\Support\Facades\Log;

class CargoService
{
    public function findCargoByNumber(string $cargoNumber)
    {
        return Cargo::where('number', $cargoNumber)
            ->with(['orderedHistories', 'user'])
            ->first();
    }

    public function getCargoImages(Cargo $cargo): array
    {
        $images = [];
        $media = $cargo->getMedia('cargo_images');

        foreach ($media as $mediaItem) {
            $images[] = [
                'url' => $mediaItem->getUrl('main'),
                'thumbnail' => $mediaItem->getUrl('thumbnail'),
                'original' => $mediaItem->getUrl(),
                'name' => $mediaItem->name,
                'file_name' => $mediaItem->file_name,
                'size' => $mediaItem->size,
                'mime_type' => $mediaItem->mime_type,
            ];
        }

        return $images;
    }

    public function hasImages(Cargo $cargo): bool
    {
        return $cargo->getMedia('cargo_images')->isNotEmpty();
    }

    public function getFirstImageUrl(Cargo $cargo): ?string
    {
        $urls = $this->getAllImageUrls($cargo);
        return $urls[0] ?? null;
    }

    public function getAllImageUrls(Cargo $cargo): array
    {
        $urls = $cargo->getMedia('cargo_images')
            ->map(function ($media) {
                try {
                    $url = $media->getUrl('main');

                    if (!str_starts_with($url, 'http')) {
                        $baseUrl = rtrim(config('app.url'), '/');
                        $url = $baseUrl . '/' . ltrim($url, '/');
                    }

                    $url = str_replace('http://', 'https://', $url);

                    return $url;
                } catch (\Exception $e) {
                    Log::error('Error generating image URL', [
                        'media_id' => $media->id,
                        'error' => $e->getMessage(),
                    ]);
                    return null;
                }
            })
            ->filter() // Remove nulls
            ->values()
            ->toArray();

        return $urls;
    }

    public function isValidCargoNumber(string $cargoNumber): bool
    {
        // TODO:Adjust this regex based on your cargo number format
        // Example: Alphanumeric, 6-20 characters
        return preg_match('/^[A-Z0-9]{6,20}$/i', $cargoNumber) === 1;
    }

    public function formatCargoInfo(Cargo $cargo): string
    {
        $currentStatus = $cargo->current_status;

        $message = "📦 *Kargo maglumatlary*\n\n";
        $message .= "🔢 *Kargo nomeri:* `{$cargo->number}`\n";
        $message .= "👤 *Eýesi:* {$cargo->user->fullname}\n";

        if ($currentStatus) {
            $updatedDate = $cargo->current_status_at ? date('d.m.Y', strtotime($cargo->current_status_at)) : 'N/A';
            $message .= "📍 *Şu wagtky ýeri:* *{$currentStatus->getTranslation('name', 'tm')}*\n";
            $message .= "🕒 *Soňky üýtgeşme:* {$updatedDate}\n";
        } else {
            $message .= "📍 *Ýagdaý:* Hiç hili ýeri barada görkezilmedik\n";
        }

        if (isset($cargo->weight)) {
            $message .= "⚖️ *Agramy:* {$cargo->weight}\n";
        }

        $imageCount = $cargo->getMedia('cargo_images')->count();

        if ($imageCount > 0) {
            $message .= "🖼️ *Surat:* {$imageCount} sany\n";
        }

        return $message;
    }

    public function formatStatusHistory(Cargo $cargo): string
    {
        $history = $cargo->orderedHistories;

        if (empty($history)) {
            return "\n\n📋 *Status taryhy:* hiç hili satatus taryhy ýok";
        }

        $message = "\n\n📋 *Status taryhy:*\n";

        foreach ($history as $index => $item) {
            $statusDate = $cargo->current_status_at ? date('d.m.Y', strtotime($cargo->current_status_at)) : 'N/A';
            $emoji = $index === 0 ? "🔵" : "⚪";
            $message .= "{$emoji} {$item->status->getTranslation('name', 'tm')} - {$statusDate}\n";
        }

        return $message;
    }
}
