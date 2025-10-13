<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TVSeriesByListingMethodRequest extends CustomFormRequest {
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "listing-method" => "required|in:popular,top_rated,trending,on_the_air",
            "page" => "required|integer|min:1"
        ];
    }
}
