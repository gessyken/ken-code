<?php

class DB
{
    public static function mysql()
    {
        return new PDO('mysql:host=127.0.0.1;dbname=ken_orm', 'root', '');
    }

    public static function sqlite()
    {
        return new PDO('sqlite:' . __DIR__ . '/../database.sqlite');
    }

    
}
