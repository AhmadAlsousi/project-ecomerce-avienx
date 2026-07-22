<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enum\Users\UserStatusEnum;
use App\Enum\Users\UserTypeEnum;
use Illuminate\Validation\Rule;

class RegisterAdminRequest extends FormRequest
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
           'name' => [
                'required',
                'string',
                'max:191',
            ],

            'phone' => [
                'required',
                'string',
                'min:8',
                'max:30',
                'unique:users,phone',
            ],

            'email' => [
                'required',
                'email',
                'max:191',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                // 'confirmed',
            ],

            'type' => [
                'required',
                Rule::enum(UserTypeEnum::class),
            ],

            'status' => [
                'required',
                Rule::enum(UserStatusEnum::class),
            ],



            'department' => ['nullable', 'string'],
        ];
    }
}
