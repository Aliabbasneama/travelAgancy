<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
            {    
                return [
                    'city'     => ['required'],
                    'province'    => ['required'],
                    'duration'    => ['required'],
                    'price'    => ['required'],
                    'description'    => ['required'],
                    'number'    => ['required'],
                    'image' => ['required',['image']],
                    
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'city'     => ['required'],
                    'province'    => ['required'],
                    'duration'    => ['required'],
                    'price'    => ['required'],
                    'description'    => ['required'],
                    'number'    => ['required'],
                    'image' => ['image'],
                ];                
            }
            default: break;
        }
    }
}
