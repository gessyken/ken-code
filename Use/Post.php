<?php

require_once __DIR__ . '/../src/KenOrm.php';

class Post extends KenOrm
{
    protected static $table = 'posts';
    
    protected static $fillable = ['title', 'content'];
}
