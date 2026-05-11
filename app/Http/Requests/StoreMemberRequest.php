<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreMemberRequest extends FormRequest
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
            'nama' => 'required|string|max:150',
            'divisi' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'instagram_link' => 'nullable|string|max:255',
            'linkedin_link' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong.',
            'divisi.required' => 'Divisi tidak boleh kosong.',
            'foto.image' => 'File foto harus berupa gambar.',
            'instagram_link.url' => 'Format URL Instagram tidak valid.',
            'linkedin_link.url' => 'Format URL Linkedin tidak valid.',
            'facebook_link.url' => 'Format URL Facebook tidak valid.',
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
