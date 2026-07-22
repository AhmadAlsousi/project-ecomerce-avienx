<?php

namespace App\Jobs\Products;

use App\Enum\Product\ProductImageEnum;
use App\Models\Products;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductsMediaGallaryJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(
        public int $productId,
        public array $gallery,
    ) {
    }

    public function handle(): void
    {
        $product = Products::find($this->productId);

        if (! $product) {
            Log::warning('Product not found.', [
                'product_id' => $this->productId,
            ]);

            return;
        }

        foreach ($this->gallery as $imagePath) {
            try {
                if (! Storage::disk('local')->exists($imagePath)) {
                    Log::warning('Gallery image not found.', [
                        'product_id' => $this->productId,
                        'image_path' => $imagePath,
                    ]);

                    continue;
                }

                $media = $product
                    ->addMediaFromDisk($imagePath, 'local')
                    ->toMediaCollection(
                        ProductImageEnum::GALLARY->value
                    );

                Log::info('Gallery image added successfully.', [
                    'product_id' => $this->productId,
                    'media_id' => $media->id,
                    'collection_name' => $media->collection_name,
                    'disk' => $media->disk,
                ]);
            } catch (Throwable $exception) {
                Log::error('Failed to add gallery image.', [
                    'product_id' => $this->productId,
                    'image_path' => $imagePath,
                    'error' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ]);

                throw $exception;
            }
        }
    }
}