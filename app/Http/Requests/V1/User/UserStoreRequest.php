<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'description' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'Tên nhóm thành viên',
            'description' => 'Mô tả',
        ];
    }
}
