<?php 

namespace App\Http\Models;

use Core\Model;

class User extends Model {
    protected static $table = "users";

    // Thuộc tính để lưu giá trị từ cơ sở dữ liệu
    public $id;
    public $username;
    public $password;
    public $address;

    // Getter methods
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAddress()
    {
        return $this->address;
    }

    // Setter methods
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
}
