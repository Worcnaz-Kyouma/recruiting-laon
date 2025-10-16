<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TVSeriesByListingMethodRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            "listing_method" => "required|in:popular,top_rated,trending,on_the_air",
            "page" => "required|integer|min:1"
        ];
    }
}
