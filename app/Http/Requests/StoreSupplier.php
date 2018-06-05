<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupplier extends FormRequest {
    public function authorize() {
        return true;
    }
        /*
        $supplier = new Supplier;
        $supplier->name = $request->post('name');
        $supplier->address = $request->post('address');
        $supplier->phone = $request->post('phone');
        $supplier->save();
        */
    
    public function rules() {        
        $validation = array();
        $validation['name'] = 'required';
        $validation['address'] = 'required';
        $validation['phone'] = 'required';
        
        return $validation;
    }
    
    public function messages() {
        $validationMessage = array();
        
        $validationMessage['name.required'] = "Please Input Name";
        $validationMessage['address.required'] = "Please Input Address";
        $validationMessage['phone.required'] = "Please Input Phone";
        
        return $validationMessage;
    }
}