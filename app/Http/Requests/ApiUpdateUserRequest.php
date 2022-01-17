<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiUpdateUserRequest extends FormRequest
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
            'username' => ['required', 'alpha_dash', 'max:255', 'unique:users,username,' . $this->user()->id],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $this->user()->id, 'email', 'indisposable'],
            'phone' => ['required', 'phone:AUTO,JP',],
            'password' => ['required', 'alpha_num', 'confirmed', 'string', 'min:8'],
        ];
    }
}
