<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

session_start();

try {
    
    $pdo = connectDB();
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ssn'])) {
    $ssn = $_POST['ssn'];

    $sql = "
        SELECT e.employee_id
        FROM employees e
        JOIN people p ON e.person_id = p.person_id
        JOIN job_titles j ON e.title_id = j.title_id
        WHERE p.ssn = :ssn AND j.title_name = 'Manager'
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ssn', $ssn);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                
                $_SESSION['ssn'] = $ssn;
                header('Location: /manager/manager_dashboard.php');
                exit;
            } else {
                $error_message = "Invalid SSN or you are not a manager.";
            }
        } else {
            $error_message = "Failed to execute query.";
        }
    } catch (PDOException $e) {
        $error_message = "Database query error: " . $e->getMessage();
    }
}
?>

<div class="row">
    <div class="col-auto">
        <h1>Manager Login</h1>
    </div>
</div>

<form method="POST" class="mb-4">
    <div class="mb-3">
        <label for="ssn" class="form-label">Enter Manager SSN:</label>
        <input type="text" class="form-control" id="ssn" name="ssn" pattern="[0-9]{9}" maxlength="9" required>
    </div>
    <button type="submit" class="btn btn-primary">Sign In</button>
</form>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-secondary" href="javascript:history.back()" role="button">Return</a>
    </div>
</div>

<?php
if (isset($error_message)) {
    echo "<div class='alert alert-danger mt-3' role='alert'>$error_message</div>";
}

include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>
