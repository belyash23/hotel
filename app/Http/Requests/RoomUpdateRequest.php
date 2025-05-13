<?php

namespace App\Http\Requests;

use App\Models\Hotel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomUpdateRequest extends FormRequest
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
        return [
            'id',
            'num' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'count' => ['required', 'integer'],
            'cost' => ['required', 'integer'],
            'status' => ['required', 'string'],
            'is_free' => ['required', 'boolean'],
            'hotel.id' => [],
        ];
    }
}
