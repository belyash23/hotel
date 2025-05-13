<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $id = $this->id;
        return [
            'id',
            'name' => ['required', 'string', 'max:255'],
            'inn' => ['required', 'string', Rule::unique('users')->ignore(User::query()->where('id', $id)->first()->id),],
            'hotel.id' => [],
            'position.id' => ['required'],
        ];
    }
}
