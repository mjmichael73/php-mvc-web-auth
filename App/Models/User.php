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
    protected $data;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Save the user model with the current property values
     * @return void
     */
    public function save()
    {
        $passwordHash = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO " . $this->table . " (name, email, password_hash) VALUES (:name, :email, :password_hash)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $this->data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
        $stmt->execute();
    }
}
