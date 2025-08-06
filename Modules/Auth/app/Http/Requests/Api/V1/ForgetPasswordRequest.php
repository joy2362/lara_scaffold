<?php

namespace Modules\Auth\Http\Requests\Api\V1;

use App\Http\Requests\Base\BaseFormRequest;

class ForgetPasswordRequest extends BaseFormRequest
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
            'email' => ['required', 'email', 'min:3', 'max:255'],
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
            'email.required' => __('The email field is required'),
            'email.email' => __('The email must be a valid email address'),
            'email.min' => __('The email must be at least :min characters', ['min' => 3]),
            'email.max' => __('The email may not be greater than :max characters', ['max' => 255]),
        ];
    }
}
