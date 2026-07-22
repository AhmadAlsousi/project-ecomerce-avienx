<?php

// use App\Http\Controllers\Api\Permission_Role\LinkRoleController;

use App\Http\Controllers\Api\Category\CrudCategoryController;
use App\Http\Controllers\Api\Subcategory\CrudSubcategoryController;

use App\Http\Controllers\Api\Permission_Role\LinkRoleController;
use App\Http\Controllers\Api\Permission_Role\PermissionController;
use App\Http\Controllers\Api\Permission_Role\RoleController;
use App\Http\Controllers\Api\Products\CurdProductsController;
use App\Http\Controllers\Api\Products\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\RegisterUserController;
use App\Http\Controllers\Api\User\Auth\LoginUserController;

//Authentication::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Register:::::::::::::::Admin & Vendor & Customer
Route::post('/registerAdmin', [RegisterUserController::class, 'create_admin']);
Route::post('/registerVendor', [RegisterUserController::class, 'create_vendor']);
Route::post('/register', [RegisterUserController::class, 'create']);
//Login:::::::::::::::
Route::post('/customer/login', [LoginUserController::class, 'loginCustomer']);
Route::post('/admin/login', [LoginUserController::class, 'loginAdmin']);
Route::post('/vendor/login', [LoginUserController::class, 'loginVendor']);

// refresh::
Route::post('/refresh', [LoginUserController::class, 'refresh']);
// verify account::
Route::post('/verify', [LoginUserController::class, 'verify']);


// logout::
Route::post('/logout', [LoginUserController::class, 'logout']);
// Information:
Route::get('/InfoUser', [LoginUserController::class, 'infoUser']);
// finish :: Authentication ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

// Authorization:::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Role::
Route::post('/Role/Create', [RoleController::class, 'create']);
Route::get('/Role/Admin', [RoleController::class, 'indexadmin']);
Route::get('/Role/Vendor', [RoleController::class, 'indexvendor']);
Route::post('/Role/LinkVendor', [LinkRoleController::class, 'linkVendor']);
Route::post('/Role/LinkAdmin', [LinkRoleController::class, 'linkAdmin']);

//Permission::
Route::post('/Permission/Create', [PermissionController::class, 'create']);
Route::get('/Permission/Admin', [PermissionController::class, 'indexadmin']);
Route::get('/Permission/Vendor', [PermissionController::class, 'indexvendor']);
// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// Category::
Route::post('/Category/Create', [CrudCategoryController::class, 'create']);
Route::get('/Category', [CrudCategoryController::class, 'index']);
Route::get('/Category/{id}', [CrudCategoryController::class, 'show']);
Route::post('/Category/update/{id}', [CrudCategoryController::class, 'update']);
Route::post('/Category/update/status/{id}', [CrudCategoryController::class, 'updateStatus']);
Route::delete('/Category/delete/{id}', [CrudCategoryController::class, 'delete']);
// Subcategory::
Route::get('/Subcategory', [CrudSubcategoryController::class, 'index']);
Route::post('/Subcategory/Create', [CrudSubcategoryController::class, 'create']);
Route::post('/Subcategory/update/{id}', [CrudSubcategoryController::class, 'update']);
Route::post('/Subcategory/update/status/{id}', [CrudSubcategoryController::class, 'updateStatus']);
Route::delete('/Subcategory/delete/{id}', [CrudSubcategoryController::class, 'delete']);
// Products::
Route::prefix('Products')->group(function () {
    Route::get('/', [CurdProductsController::class, 'index']);
    Route::post('/create', [CurdProductsController::class, 'create']);
});
// filter::
Route::prefix('tag')->group(function(){
    Route::get('/category',[TagController::class,'list_category']);
    Route::get('/subcategory',[TagController::class,'list_category']);

});