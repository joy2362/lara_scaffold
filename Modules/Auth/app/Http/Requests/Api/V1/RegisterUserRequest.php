<?php

namespace Modules\Auth\Http\Requests\Api\V1;

use App\Http\Requests\Base\BaseFormRequest;

class RegisterUserRequest extends BaseFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'min:3', 'max:255' , 'unique:users,email'],
            'password' => [
                'required', 'string', 'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{}:;,.<>?\/|~\\"]).{8,}$/',
            ],
            'confirm_password' => ['required', 'same:password'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('The name field is required'),
            'email.required' => __('The email field is required'),
            'email.email' => __('The email must be a valid email address'),
            'email.min' => __('The email must be at least :min characters', ['min' => 3]),
            'email.max' => __('The email may not be greater than :max characters', ['max' => 255]),
            'password.required' => __('The password field is required'),
            'password.min' => __('The password must be at least :min characters', ['min' => 1]),
            'password.max' => __('The password may not be greater than :max characters', ['max' => 255]),
        ];
    }
}
