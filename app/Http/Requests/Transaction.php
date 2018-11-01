<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Transaction extends FormRequest
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
            'amount' => 'required|min:1',
            'category' => 'required',
            'type' => 'required',
            'comment' => '',
            'date' => 'date',
            'tag' => 'min:1',
        ];
    }
}
