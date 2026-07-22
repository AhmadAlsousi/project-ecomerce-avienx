<?php

namespace App\Services;

class ProductsQueryServices
{
    public function getproducts($query, $request)
    {
        // Parameters ::
        $search = $request->input('search');
        $order_by = $request->input('order_by');
        $tag = $request->input('tag_category');
        $tag_sub = $request->input('tag_subcategory');
        // filtering ::
        if ($search) { 
            $query->where('slug', 'like', '%' . $search . '%');
        }
        if ($tag) {
            $query->where(function ($query) use ($tag) {
                $query->whereHas('category', function ($query) use ($tag) {
                    $query->where('slug', 'like', '%' . $tag . '%');
                });
            });
        }
        if ($tag_sub) {

            $query->where(function ($query) use ($tag) {
                $query->whereHas('subcategory', function ($query) use ($tag) {
                    $query->where('slug', 'like', '%' . $tag . '%');
                });
            });
        }
        if ($order_by) {
            $query->orderBy('name', $order_by);
        }
    }
}
