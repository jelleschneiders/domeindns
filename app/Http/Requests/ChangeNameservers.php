<?php

namespace App\Http\Requests;

use App\Rules\Nameserver;
use Illuminate\Foundation\Http\FormRequest;

class ChangeNameservers extends FormRequest
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
            'ns1' => ['required', new Nameserver],
            'ns2' => ['required', new Nameserver],
            'ns3' => ['required', new Nameserver],
        ];
    }
}
