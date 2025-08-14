<?php

namespace App\Http\Requests;

use App\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class BaseRequest extends FormRequest
{
    /**
     * Define dynamic rules.
     */
    protected array $rules = [];

    /**
     * Define dynamic messages.
     */
    protected array $messages = [];

    /**
     * Set the validation rules dynamically.
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * Set the validation messages dynamically.
     */
    public function messages(): array
    {
        return array_merge(trans('validation'), $this->messages);
    }

    /**
     * Automatically merge authenticated user_id into request.
     */
    protected function prepareForValidation(){
        if (auth()->check()) {
            $this->merge([
                'user_id' => Auth::id(),
            ]);
        }
    }


    /**
     * Allow authorization dynamically.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Override failedValidation to return only the first error message.
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->first();
        $response = ApiResponse::error($errors)->toJsonResponse();
        throw new HttpResponseException($response);
    }
}
