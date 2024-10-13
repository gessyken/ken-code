<?php

require_once 'Post.php';
require_once 'User.php';


$choice = readline("Welcome to KenOrm, we are going to start. \n Enter your choice: \n 1. Create a post \n 2. List all posts \n");

if ($choice == 1) {
    $title = readline("Enter the title of the post: ");
    $content = readline("Enter the content of the post: ");
    $post = Post::create([
        'title' => $title,
        'content' => $content
    ]);
    echo "Post created successfully with id: " . $post->id . "\n";
} else if ($choice == 2) {
    $posts = Post::all();
    foreach ($posts as $post) {
        echo "ID: " . $post->id . " Title: " . $post->title . " Content: " . $post->content . "\n";
    }
} else {
    echo "Invalid choice. Please try again.\n";
}