<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostStoreRequest extends FormRequest
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
            'post_category_id' => 'nullable|exists:post_categories,id',
            'title' => 'required|string|max:200',
            'date' => 'required|date',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'is_published' => 'required|boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessages = implode('<br>', $validator->errors()->all());

        throw new HttpResponseException(
            back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessages)
                ->with('form_error', true)
        );
    }
}
