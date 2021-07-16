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
    public $errors = [];

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Save the user model with the current property values
     * @return bool
     */
    public function save()
    {
        $this->validate();

        if (!empty($this->errors)) {
            return false;
        }
        $passwordHash = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO " . $this->table . " (name, email, password_hash) VALUES (:name, :email, :password_hash)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $this->data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function validate()
    {
        // Name
        if ($this->data['name'] == '') {
            $this->errors[] = 'Name is required';
        }

        // Email
        if (filter_var($this->data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }

        // Password
        if ($this->data['password'] != $this->data['password_confirmation']) {
            $this->errors[] = 'Passwords not match';
        }

        if (strlen($this->data['password']) < 6) {
            $this->errors[] = 'Please enter at least 6 characters for the password';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->data['password']) == 0) {
            $this->errors[] = 'Password needs at least one letter';
        }

        if (preg_match('/.*\d+.*/i', $this->data['password']) == 0) {
            $this->errors[] = 'Password needs at least one number';
        }
    }
}
