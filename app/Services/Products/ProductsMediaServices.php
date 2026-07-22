<?php

namespace App\Services\Products;

use App\Jobs\Products\ProductsMediaColorJob;
use App\Jobs\Products\ProductsMediaGallaryJob;
use App\Jobs\Products\ProductsMediaJob;

class ProductsMediaServices
{
    public function media($id, $request)
    {
        // Gallary Color ::
        if ($request->hasFile('gallery_color')) {
            $galleryImagescolor = [];
            foreach ($request->file('gallery') as $image) {
                $galleryImagescolor[] = $image->store('temp_color');
            }
            // = $data['gallery_color']->store('temp');
            ProductsMediaColorJob::dispatch($id, $galleryImagescolor);
        }
        // Gallary ::

        if ($request->hasFile('gallery')) {
            $galleryImages = [];

            foreach ($request->file('gallery') as $image) {
                $galleryImages[] = $image->store('temp');
            }

            ProductsMediaGallaryJob::dispatch(
                $id,
                $galleryImages
            );
        }
    }
    public function mediabasic($id,$data){
        $mainImage = $data['image']->store('temp');
        ProductsMediaJob::dispatch($mainImage, $id);

    }
}
