<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/21/18
 * Time: 1:30 PM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class Budget extends FormRequest
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
            'name' => ['required', 'min:1', 'max:250'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
            'starting_balance' => ['required', ],
            'categories' => '',
        ];
    }
}