<?php

namespace App\Http\Requests;

use App\Status;
use App\Zone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRecord extends FormRequest
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
     * @throws \Exception
     */
    public function rules(){
        $zone = Zone::where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $this->request->get('zone_id')],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        return [
            'zone_id' => ['required', 'uuid'],
            'type' => ['required', 'in:' . implode(',', config('domeindns.dns.types'))],
            'name' => ['nullable', 'regex:/(^[A-Za-z0-9-_*.]+$)+/', 'max:100'],
            'content' => ['required', Rule::unique('records')->where(function ($query) {
                return $query->where('record_type', $this->request->get('type'))
                    ->where('name', $this->request->get('name'))
                    ->where('zone_id', '=' , $this->request->get('zone_id'))
                    ->whereNull('deleted_at');
            }), 'max:500', $this->recordValidator($this->request->get('content'), $this->request->get('type'))],
            'ttl' => ['numeric', 'between:60,604800'],
        ];
    }

    private function recordValidator($content, $type) {
        if(! in_array($type, config('domeindns.dns.types'))) {
            throw new \Exception('Invalid DNS type to validate');
        }

        $namespace = "App\Rules\DNS\\";
        $class = $namespace . strtoupper($type);

        return new $class($content);
    }
}
