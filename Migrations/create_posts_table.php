<?php 

require_once __DIR__ . '/../src/DB.php';

$db = DB::mysql();

$db->query("CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

echo "Migration create_posts_table completed successfully.";