<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemPickupRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1|max:100',
            'taken_date' => 'required|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Minimal satu barang harus dipilih.',
            'items.array' => 'Format data barang tidak valid.',
            'items.min' => 'Minimal satu barang harus dipilih.',
            'items.*.item_id.required' => 'ID barang harus diisi.',
            'items.*.item_id.exists' => 'Barang yang dipilih tidak valid.',
            'items.*.quantity.required' => 'Jumlah barang harus diisi.',
            'items.*.quantity.integer' => 'Jumlah barang harus berupa angka.',
            'items.*.quantity.min' => 'Jumlah barang minimal 1.',
            'items.*.quantity.max' => 'Jumlah barang maksimal 100.',
            'taken_date.required' => 'Tanggal pengambilan harus diisi.',
            'taken_date.date' => 'Format tanggal pengambilan tidak valid.',
        ];
    }
}
