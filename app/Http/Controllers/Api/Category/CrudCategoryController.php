<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use App\Models\Category;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\statusCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\category\CreateCategoryResource;
use App\Http\Resources\category\ListCategoryResource;
use App\Services\Category\CategoryQueryServices;

class CrudCategoryController extends APIController
{
  protected $filter;


  public function __construct(CategoryQueryServices $filter)
  {
    $this->filter = $filter;
  }
  public function index(Request $request)
  {
    $category = Category::query();
    $this->filter->getcategory($request, $category);
    $categories = $category->paginate(15);
    return $this->sendResponce(ListCategoryResource::collection($categories), 'success', 200, true);
  }
  public function show($id)
  {
    $category = Category::findOrFail($id)->get();
    return $this->sendResponce(ListCategoryResource::collection($category), 'success', 200);
  }
  public function create(CreateCategoryRequest $request)
  {
    $data = $request->validated();
    $category = Category::create($data);
    return $this->sendResponce(CreateCategoryResource::make($category), 'success', 200);
  }
  public function update($id, UpdateCategoryRequest $request)
  {
    $data = $request->validated();
    $category = Category::findOrFail($id);
    $category->update([
      'name' => $data['name'],
      'slug' => $data['slug'],
      'description' => $data['description'],
      'status' => $data['status']
    ]);
    return $this->sendResponce(null, 'success update', 200);
  }
  public function updateStatus($id, statusCategoryRequest $request)
  {
    $data = $request->validated();
    $category = Category::findOrFail($id);
    $category->update([
      'status' => $data['status']
    ]);
    return $this->sendResponce(null, 'success update status', 200);
  }
  public function delete($id)
  {
    $category = Category::findOrFail($id);
    $category->delete();
    return $this->sendResponce(null, 'success delete', 200);
  }
}
