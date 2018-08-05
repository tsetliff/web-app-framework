<?php
namespace Model;

use WebAppFramework\ActiveRecord;

class User extends ActiveRecord
{
    protected static $table = 'users';
    protected static $idField = 'user_id';

    public function getFirstName()
    {
        return $this->get('first_name');
    }

    public function getLastName()
    {
        return $this->get('last_name');
    }

    public function getEmail()
    {
        return $this->get('email');
    }
}