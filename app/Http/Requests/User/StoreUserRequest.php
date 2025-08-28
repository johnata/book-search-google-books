<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // public access
        return true;

        // example with auth
        // return auth()->check();
        // example with admin role
        // return auth()->check() && auth()->user()->hasRole('admin');
        // example with specific permission
        // return auth()->check() && auth()->user()->can('create-users');
        // example with policy
        // return auth()->check() && auth()->user()->can('create', User::class);
        // example with gate
        // return auth()->check() && Gate::allows('create-users');
        // example with multiple conditions
        // return auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->can('create-users'));
        // example with custom logic
        // return auth()->check() && $this->customAuthorizationLogic();
        // example with post ownership
        // return auth()->check() && $this->post && auth()->user()->id === $this->post->user_id;
        // example with profileId
        // return auth()->check() && $this->profileId && auth()->user()->id === $this->profileId;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[#?!@$%^&*-]/',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.regex' => 'A senha deve conter pelo menos um caractere especial (#?!@$%^&*-).',
        ];
    }
}
