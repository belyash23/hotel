<?php

namespace App\Http\Requests;

use App\Models\Guest;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuestUpdateRequest extends FormRequest
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
            'email' => ['required', 'string', Rule::unique('guests')->ignore(Guest::query()->where('id', $id)->first()->id),],
        ];
    }
}
