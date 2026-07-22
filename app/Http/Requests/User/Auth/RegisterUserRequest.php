<?php

namespace App\Http\Requests\User\Auth;

use App\Enum\Users\UserStatusEnum;
use App\Enum\Users\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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

            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],

            'gender' => [
                'required',
                'string',
            ],

            // 'department' => ['nullable', 'string'],
            // 'store_name' => ['required', 'string'],
            // 'slug' => ['required', 'string'],
            // 'description' => ['required', 'string'],
            // 'business_registration_number' => ['required', 'string'],
            // 'is_approved' => ['required', 'boolean']
        ];
    }
}
