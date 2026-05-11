<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DocumentUpdateRequest extends FormRequest
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
            'title'          => 'required|string|max:255',
            'date' => 'required|date',
            'category_id'    => 'nullable|exists:document_categories,id',
            'description'    => 'nullable|string|max:5000',
            'file_path'      => 'nullable|file|max:100000', // Max file size in kilobytes (100 MB)
            'is_published'   => 'required|boolean',
            'is_protected'   => 'boolean',
            'access_password' => 'nullable|string|min:6|max:255',
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
