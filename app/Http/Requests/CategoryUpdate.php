<?php
/**
 * Created by PhpStorm.
 * User: after8
 * Date: 10/27/18
 * Time: 11:30 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdate extends FormRequest
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
            'icon' => 'max:250',
        ];
    }
}