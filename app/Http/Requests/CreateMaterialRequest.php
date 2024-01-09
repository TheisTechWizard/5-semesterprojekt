<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMaterialRequest extends FormRequest
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
     * @return array, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'type' => 'string|required',
            'description' => 'string|required',
            'lesson_id' => 'int|required'
        ];
    }
}
