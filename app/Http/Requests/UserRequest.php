<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'max:25', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:300'],
            'role' => 'required',
            'status' => 'required'
        ];

        if ($this->user) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
            $rules['password_confirmation'] = ['nullable', 'string', 'min:8'];
        }

        return $rules;
    }
}
