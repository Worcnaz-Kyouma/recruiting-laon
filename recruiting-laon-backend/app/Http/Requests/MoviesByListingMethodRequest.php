<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoviesByListingMethodRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            "listing_method" => "required|in:popular,top_rated,trending,upcoming",
            "page" => "required|integer|min:1"
        ];
    }
}
