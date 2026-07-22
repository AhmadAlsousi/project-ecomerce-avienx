<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\APIController;
use App\Http\Requests\Products\CreateProductsRequest;
use App\Models\Products;
use App\Models\User;
use App\Services\Products\ProductsMediaServices;
use App\Services\ProductsQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CurdProductsController extends APIController
{
    protected $filter;
    protected $mediaService;

    public function __construct(ProductsQueryServices $filter, ProductsMediaServices $mediaService)
    {
        $this->filter = $filter;
        $this->mediaService = $mediaService;

    }
    public function index(Request $request)
    {
        $query = Products::query();
        $this->filter->getproducts($query, $request);
        $data = $query->paginate(15);
        return $this->sendResponce($data, 'success', 200, true);
    }
    public function create(CreateProductsRequest $request)
    {
        $data = $request->validated();
        $user = User::where('id', $data['vendor_id'])->where('type', 'vendor')->exists();
        if (!$user) {
            return $this->sendError('user is not vendor', 400);
        }
        $productData = Arr::except($data, [
            'image',
            'gallery',
            'gallery_color'
        ]);
        $products = Products::create($productData);

        $this->mediaService->mediabasic($products->id,$data);

        $this->mediaService->media($products->id,$request);
      

        return $this->sendResponce($products, 'success', 200);
    }
}
