<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    protected $table = 'users';

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->key = $value;
        }
    }

    /**
     * Save the user model with the current property values
     * @return void
     */
    public function save()
    {
        $sql = "INSERT INTO " . $this->table . " (name, email, password_hash) VALUES (:name, :email, :password_hash)";
        $db = static::getDB() ;
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
    }
}
