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
        <h1>Manager Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-auto">
        <p>Welcome, <?php echo $_SESSION['ssn']; ?></p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-auto">
        <a class="btn btn-primary" href="../shared/personal_information.php" role="button">Personal Information</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/projects/project_dashboard.php" role="button">Manage Projects</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/assign_job_title.php" role="button">Assign Job Title</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/manage_department_locations.php" role="button">Manage Department Locations</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/manage_locations.php" role="button">Manage Locations</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/tasks.php" role="button">Tasks</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-primary" href="/manager/salaries.php" role="button">Salaries</a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-secondary" href="../shared/logout.php" role="button">Log Out</a>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; 
?>
