<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'user_id' => ['required', 'exists:users,id'],
            'description' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
            'value' => ['required', 'numeric'],
        ];
    }
}
