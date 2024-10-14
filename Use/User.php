<?php

require_once __DIR__ . '/../src/KenOrm.php';

class User extends KenOrm
{
    protected static $table = 'users';

    protected static $fillable = ['name', 'email', 'password'];
}
