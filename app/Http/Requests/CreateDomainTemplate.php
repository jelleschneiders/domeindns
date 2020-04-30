<?php

namespace App\Http\Requests;

use App\Rules\Domain;
use App\Rules\FQDN;
use Illuminate\Foundation\Http\FormRequest;

class CreateDomainTemplate extends FormRequest
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
            'domain' => ['required', 'bail', new FQDN, new Domain],
            'template' => ['required'],
        ];
    }
}
