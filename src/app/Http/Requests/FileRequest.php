<?php

namespace App\Http\Requests;

use App\Helpers\Handler\Tools\Type;
use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
        $files = $this->toArray();

        $type = Type::fromRequest($this);
        $allowed = Type::derivative($type);

        $rules = [];

        foreach($files as $key=>$file) {
            $rules[$key] = "mimes:$allowed|max:10240";
        }

        return $rules;
    }
}
