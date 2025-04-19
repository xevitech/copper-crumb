<?php

namespace App\Http\Requests;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
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
        return [
            'title'             => ['bail', 'required', 'min:1', 'max:200', Rule::unique('blogs')->ignore($this->blog)],
            'description' => ['bail', 'required'],
            'banner'            => ['bail', 'nullable', 'image', 'mimes:jpeg,jpg,png'],
            'status'            => ['bail', 'required', Rule::in([Blog::STATUS_ACTIVE, Blog::STATUS_INACTIVE])]
        ];
    }
}
