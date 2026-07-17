<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreItemRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'request_date' => 'nullable|date',
        ];

        // Only admin can set status during creation
        if (Auth::user()->role === 'admin') {
            $rules['status'] = 'nullable|in:pending,approved,rejected';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama barang harus diisi',
            'name.string' => 'Nama barang harus berupa string',
            'name.max' => 'Nama barang maksimal 255 karakter',
            'description.required' => 'Deskripsi barang harus diisi',
            'description.string' => 'Deskripsi barang harus berupa string',
            'status.in' => 'Status harus berupa pending, approved, atau rejected',
            'request_date.date' => 'Tanggal pengajuan harus berupa tanggal',
        ];
    }
}
