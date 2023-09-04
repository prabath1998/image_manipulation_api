<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class StoreImageManipulationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'image' => ['required'],
            'w' => ['required', 'regex:/^\d+(\.\d+)?%?$/'],
            'h' => 'regex:/^\d+(\.\d+)?%?$/',
            'album_id' => 'exists:\App\Models\Album,id',
            'blur' => 'integer',
        ];

        $image = $this->all()['image'] ?? false;
        if ($image && $image instanceof UploadedFile) {
            $rules['image'][] = 'image';
        } else {
            $rules['image'][] = 'url';
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'w.regex' => 'Please specify width as a valid number in pixels or in %',
            'h.regex' => 'Please specify height as a valid number in pixels or in %',
        ];
    }
}
