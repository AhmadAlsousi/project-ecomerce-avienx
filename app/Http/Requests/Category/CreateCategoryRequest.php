<?php

namespace App\Http\Requests\Category;

use App\Enum\Category\CategoryStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCategoryRequest extends FormRequest
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
            // ''=>'required|string',
            'name'=>'required|string',

            'slug'=>'required|string|unique:categories,slug',
            'description'=>'required|string',
            'status'=>['required',new Enum(CategoryStatusEnum::class)],
        ];
    }
        public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422));
    }
}
