<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateItemRequestRequest extends FormRequest
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

        // Only admin can update status
        if (Auth::user()->role === 'admin') {
            $rules['status'] = 'nullable|in:pending,approved,rejected';
        }

        return $rules;
    }

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
