<?php

namespace Modules\Auth\Http\Requests\Api\V1;

use App\Http\Requests\Base\BaseFormRequest;

class ResetTokenValidationRequest extends BaseFormRequest
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
            'token' => ['required', 'exists:password_reset_tokens,token']
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
            'token.required' => __('The token field is required'),
            'token.exists' => __('The provided token is invalid or has expired'),
        ];
    }
}
