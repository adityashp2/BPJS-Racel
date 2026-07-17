<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreItemLoanRequest extends FormRequest
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
        return [
            'item_id' => 'required|exists:items,id',
            'user_id' => 'nullable|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'loan_date' => 'required|date',
            'return_date' => 'required|date',
            'status' => 'nullable|string',
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
            'item_id.required' => 'The item field is required.',
            'item_id.exists' => 'The selected item is invalid.',
            'user_id.required' => 'The user field is required.',
            'user_id.exists' => 'The selected user is invalid.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity field must be an integer.',
            'quantity.min' => 'The quantity field must be at least 1.',
            'loan_date.required' => 'The loan date field is required.',
            'loan_date.date' => 'The loan date field must be a valid date.',
            'return_date.required' => 'The return date field is required.',
            'return_date.date' => 'The return date field must be a valid date.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status field must be a string.',
        ];
    }
}