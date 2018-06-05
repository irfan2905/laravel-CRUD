<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest {
    public function authorize() {
        return true;
    }
        /*
        $users = new User;
        $users->username = $request->post('username');
        $users->password = $request->post('password');
        $users->email = $request->post('email');
        $users->phone_number = $request->post('phone_number');
        $users->role = $request->post('role');
        */
    
    public function rules() {        
        $validation = array();
        $validation['username'] = 'required';
        $validation['password'] = 'required';
        $validation['email'] = 'required';
        $validation['phone_number'] = 'required';
        $validation['role'] = 'required';
        
        return $validation;
    }
    
    public function messages() {
        $validationMessage = array();
        
        $validationMessage['username.required'] = "Please Input Username";
        $validationMessage['password.required'] = "Please Input Password";
        $validationMessage['email.required'] = "Please Input Email";
        $validationMessage['phone_number.required'] = "Please Input Phone";
        $validationMessage['role.required'] = "Please Input Product Role";
        
        return $validationMessage;
    }
}