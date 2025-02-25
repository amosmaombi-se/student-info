<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListSectionsData extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'class_id' => ['required','exists:classes,id'],
        ];
    }
}