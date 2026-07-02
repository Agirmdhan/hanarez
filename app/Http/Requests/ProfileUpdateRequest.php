<?php

namespace App\Http\Requests;

use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id_user, 'id_user'),
            ],
            'nik' => [
                'nullable',
                'digits:16',
                Rule::unique(Penghuni::class)->ignore($this->user()->penghuni?->id_penghuni, 'id_penghuni'),
            ],
            'no_telepon' => ['nullable', 'required_with:nik', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['nullable', 'required_with:nik', 'string', 'max:1000'],
            'kontak_darurat' => ['nullable', 'regex:/^[0-9]{10,15}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.digits' => 'NIK harus terdiri dari 16 angka.',
            'nik.unique' => 'NIK sudah digunakan oleh penghuni lain.',
            'no_telepon.regex' => 'Nomor telepon harus terdiri dari 10 sampai 15 angka.',
            'kontak_darurat.regex' => 'Kontak darurat harus terdiri dari 10 sampai 15 angka.',
        ];
    }
}
