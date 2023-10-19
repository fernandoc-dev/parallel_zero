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
        if(parent::read("username = '{$data['username']}'")){
            return false;
        }
        return parent::create($data);
    }
}
