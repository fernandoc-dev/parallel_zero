<?php
// App/Controllers/HomeController.php

namespace App\Controllers;

use ParallelZero\Core\Controller;
use App\Models\UserModel;

class ExampleController extends Controller{

    /**
     * Index method
     * The default method that will be run when no route parameters are provided.
     */
    public function index() {
        $this->view('index', ['title' => 'ParallelZero', 'message' => 'Be simple, be fast.']);
    }

    public function create_user() {
        $data = [
            'username' => 'johndoe99',
            'name' => 'Jhon Dew',
            'password' => '123456'
        ];
        $userModel = $this->container->load('UserModel', UserModel::class, $this->container, 'users');
        if($userModel->createUserWithValidation($data)){
            echo 'User created';
        }else{
            echo 'User not created';
        }
    }

    public function read_user($id=null) {
        $userModel = $this->container->load('UserModel', UserModel::class, $this->container, 'users');
        if($id){
            $result=$userModel->read("id = $id");
        }else{
            $result=$userModel->read();
        }
        var_dump($result);
    }

    public function update_user($id) {
        $data = [
            'username' => 'johndoe100',
            'name' => 'Jhon Doe',
            'password' => '654321'
        ];

        $userModel = $this->container->load('UserModel', UserModel::class, $this->container, 'users');
        $userModel->update($data,"id = $id");
    }

    public function delete_user($id) {
        $userModel = $this->container->load('UserModel', UserModel::class, $this->container, 'users');
        $userModel->delete("id = $id");
    }
}
