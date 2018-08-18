<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:20|unique:tags'
        ];

        if($this->method() == 'PATCH') {
            $tag = $this->route()->parameter('tag');

            $rules['name'] = 'required|max:20|unique:tags,name,' . $tag->id;
        }

        return $rules;
    }
}
