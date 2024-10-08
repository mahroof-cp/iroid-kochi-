<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => [
                'required',
                'string',
                'min:10',
                'regex:/^[0-9]+$/',
                'unique:students,phone,' . $this->id,
            ],
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
