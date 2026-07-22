<?php

namespace App\Http\Controllers\Api\Subcategory;

use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\statusCategoryRequest;
use App\Http\Requests\Subcategory\SubcategoryCreateRequest;
use App\Http\Requests\Subcategory\SubcategoryUpdateRequest;
use App\Http\Resources\Subcategory\SubcategoryResource;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\Subcategory\SubcategoryQueryServices;
use Illuminate\Http\Request;

class CrudSubcategoryController extends APIController
{
    protected $filter;


    public function __construct(SubcategoryQueryServices $filter)
    {
        $this->filter = $filter;
    }
    public function index(Request $request )
    {
        $subcategory = Subcategory::query();
        $this->filter->getcategory($request ,$subcategory);
        $subcategory=$subcategory->paginate(15);
        return  $this->sendResponce(SubcategoryResource::collection($subcategory),'success', 200,true);
    }
    public function create(SubcategoryCreateRequest $request)
    {
        $data = $request->validated();
        $subcategory = Subcategory::create($data);
        return  $this->sendResponce($subcategory, 'success', 200);
    }
    public function update($id, SubcategoryUpdateRequest $request)
    {
        $data = $request->validated();
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'status' => $data['status'],
            'category_id' => $data['category_id']
        ]);
        return $this->sendResponce(null, 'success update', 200);
    }
    public function updateStatus($id, statusCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Subcategory::findOrFail($id);
        $category->update([
            'status' => $data['status']
        ]);
        return $this->sendResponce($category, 'success', 200);
    }
    public function delete($id)
    {
        $category = Subcategory::findOrFail($id);
        $category->delete();
        return $this->sendResponce(null, 'success delete', 200);
    }
}
