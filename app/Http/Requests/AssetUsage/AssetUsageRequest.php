<?php

namespace App\Http\Requests\AssetUsage;

use Illuminate\Foundation\Http\FormRequest;

class AssetUsageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'usage_date' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'purpose' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Aset wajib dipilih.',
            'usage_date.required' => 'Tanggal penggunaan wajib diisi.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.min' => 'Jumlah minimal adalah 1.',
            'purpose.required' => 'Tujuan penggunaan wajib diisi.',
        ];
    }
}
