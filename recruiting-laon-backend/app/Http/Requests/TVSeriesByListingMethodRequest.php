<?php

namespace App\Http\Requests;

class TVSeriesByListingMethodRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            "listing_method" => "required|in:popular,top_rated,trending,on_the_air",
            "page" => "required|integer|min:1"
        ];
    }

    
    public function messages(): array {
        return [
            'listing_method.required' => 'O método de listagem é obrigatório.',
            'listing_method.in'       => 'O método de listagem deve ser "popular", "top_rated", "trending" ou "on_the_air".',

            'page.required' => 'O número da página é obrigatório.',
            'page.integer'  => 'O número da página deve ser um número inteiro.',
            'page.min'      => 'O número da página deve ser no mínimo 1.',
        ];
    }
}
