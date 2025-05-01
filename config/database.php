<?php
// Database configuration - store outside web root 
// Path: /path/to/project/config/database.php

$dbConfig = [
    'host'     => 'localhost',
    'dbname'   => 'mySocialApp',
    'username' => 'root', // Use a dedicated user with limited privileges
    'password' => '', // Use a strong password
];

// Never expose this file to web access
?>