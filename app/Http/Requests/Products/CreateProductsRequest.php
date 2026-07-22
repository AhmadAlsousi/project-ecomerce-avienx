<?php

namespace App\Http\Requests\Products;

use App\Enum\Category\CategoryStatusEnum;
use App\Enum\Product\ProductStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vendor_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'required|string',
            'price' => 'required|string',
            'status' => ['required', new Enum(ProductStatusEnum::class)],
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
            'gallery' => 'array|sometimes',
            'gallery.*' => 'required|image|mimes:jpg,jpeg,png,webp',
            'gallery_color' => 'array|sometimes',
            'gallery_color.*' => 'required|image|mimes:jpg,jpeg,png,webp',

        ];
    }
}
