<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';  

session_start();

if (!isset($_SESSION['ssn'])) {
    header('Location: /manager/manager_login.php');
    exit;
}
?>

<div class="row">
    <div class="col-auto">
        <h1>Project Management Dashboard</h1>
    </div>
</div>

<div class="row mt-4">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/projects/project_information.php" role="button">Project Information</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/projects/assign_projects.php" role="button">Assign Projects</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-secondary" href="/manager/manager_dashboard.php" role="button">Return to Dashboard</a>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';  
?>
