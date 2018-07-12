<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest {
    public function authorize() {
        return true;
    }
    
    public function rules() {        
        $validation = array();
        $validation['name'] = 'required';
        $validation['detail'] = 'required';
        $validation['photo1'] = 'required';
        
        return $validation;
    }
    
    public function messages() {
        $validationMessage = array();
        
        $validationMessage['name.required'] = "Please Input Product Name";
        $validationMessage['detail.required'] = "Please Input Product Detail";
        $validationMessage['photo1.required'] = "Please Input Product Photo";
        
        return $validationMessage;
    }
}