<?php

namespace App\Jobs\Products;

use App\Enum\Product\ProductImageEnum;
use App\Models\Products;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class ProductsMediaJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $mainImage,
        public int $productId,
      

        
    )
    {
        //
    }

    /**
     * Execute the job.
     */
   public function handle(): void
{
    $product = Products::find($this->productId);

    if (! $product) {
        Log::warning("Product {$this->productId} not found.");

        return;
    }

    if (! Storage::disk('local')->exists($this->mainImage)) {
        Log::warning("Main image not found: {$this->mainImage}");

        return;
    }

    $product
        ->addMedia(Storage::disk('local')->path($this->mainImage))
        ->toMediaCollection(
            ProductImageEnum::MAIN->value
        );
        
}
}
