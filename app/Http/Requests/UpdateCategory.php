<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class UpdateCategory extends FormRequest {
    public function authorize() {
        return true;
    }
    
    public function rules() {        
        $validation = array();
        $validation['category'] = 'required';
        
        return $validation;
    }
    
    public function messages() {
        $validationMessage = array();
        
        $validationMessage['category.required'] = "Please Input Category";
        
        return $validationMessage;
    }
}