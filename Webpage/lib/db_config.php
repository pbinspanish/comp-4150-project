<?php
// db_config.php
$db_config = [
    'host' => 'localhost',
    'dbname' => 'hensonj_4150lab3',
    'username' => 'hensonj_4150lab3',
    'password' => 'hensonj_4150lab3'
];

function connectDB() {
    global $db_config;
    try {
        $pdo = new PDO(
            "mysql:host={$db_config['host']};dbname={$db_config['dbname']}",
            $db_config['username'],
            $db_config['password']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>