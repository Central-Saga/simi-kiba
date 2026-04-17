<?php

namespace App\Http\Requests\AssetMutation;

use Illuminate\Foundation\Http\FormRequest;

class AssetMutationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'from_location_id' => ['required', 'exists:locations,id'],
            'to_location_id' => ['required', 'exists:locations,id'],
            'mutation_date' => ['required', 'date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Aset wajib dipilih.',
            'from_location_id.required' => 'Lokasi asal wajib dipilih.',
            'to_location_id.required' => 'Lokasi tujuan wajib dipilih.',
            'mutation_date.required' => 'Tanggal mutasi wajib diisi.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.min' => 'Jumlah minimal adalah 1.',
        ];
    }
}
