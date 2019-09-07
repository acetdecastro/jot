<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:contacts,email',
                    'birthday' => 'required',
                    'company' => 'required',
                ];
            }
            case 'PATCH':
            {
                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:contacts,email,' . $this->route('contact')->id,
                    'birthday' => 'required',
                    'company' => 'required',
                ];
            }
            default:
                break;
        }
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'E-mail is required.',
            'email.email' => 'Email must be valid.',
            'birthday.required' => 'Birthday is required.',
            'company.required' => 'Company is required.',
        ];
    }
}
