<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255|unique:users',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:password',
            'role' => ['required', Rule::in(['admin', 'superadmin'])],
            'avatar' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'confirm_password.same' => 'Konfirmasi password tidak cocok!'
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
