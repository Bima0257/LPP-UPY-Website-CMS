<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class UpdateCarouselRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'superadmin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'btn_link'  => 'nullable|url|max:150',
            'image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'is_published' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul tidak boleh kosong.',
            'btn_link.url' => 'Format URL tombol tidak valid.',
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
