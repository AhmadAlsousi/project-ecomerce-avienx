<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Products\TagCateResorce;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class TagController extends APIController
{
    public function list_category(){
        $category=Category::all();
        return $this->sendResponce(TagCateResorce::collection($category),'success',200);
    }
    public function list_subcategory(){
        $subcategory=Subcategory::all();
        return $this->sendResponce(TagCateResorce::collection($subcategory),'success',200);
    }
}
