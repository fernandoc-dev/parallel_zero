<?php
// App/Models/UserModel.php

namespace App\Models;

use ParallelZero\Core\Model;

class UserModel extends Model {

    /**
     * Create a user with validation
     * 
     * @param array $data User data
     * @return array Result of the create operation
     */
    public function createUserWithValidation(array $data): array {
        $existing_users = parent::read("username = :username", ['username' => $data['username']]);
    
        if(!empty($existing_users)){
            return ['status' => false, 'message' => 'User already exists'];
        }
    
        $create_status = parent::create($data);
    
        if ($create_status) {
            return ['status' => true, 'message' => 'User created'];
        } else {
            return ['status' => false, 'message' => 'User not created'];
        }
    }
    
}
