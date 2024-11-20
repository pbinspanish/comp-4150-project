<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Employee Dashboard</h1>
	</div>
</div>

<div class="row">
	<div class="col-auto">
		<p>Welcome, <?php session_start(); echo $_SESSION['ssn']; ?></h1>
	</div>
</div>

<div class="row mt-4">
	<div class="col-auto">
		<a class="btn btn-primary" href="../shared/personal_information.php" role="button">Personal Information</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/employee_overview.php" role="button">Overview</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/assigned_projects.php" role="button">Assigned Projects</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/timesheet.php" role="button">View Timesheet</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/employee_directory.php" role="button">Employee Directory</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-secondary" href="javascript:history.back()" role="button">Log Out</a>
	</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>