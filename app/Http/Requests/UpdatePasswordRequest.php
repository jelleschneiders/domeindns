<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current' => 'required|min:6',
            'new' => 'required|min:6',
            'newconfirm' => 'required|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'current' => 'current password',
            'new' => 'new password',
            'newconfirm' => 'new password confirmation',
        ];
    }
}
