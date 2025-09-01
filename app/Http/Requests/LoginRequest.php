<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    protected function prepareForValidation()
    {
        $this->setRules([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

    }
    private function setRules(array $rules)
    {
        $this->rules = $rules;
    }
}
