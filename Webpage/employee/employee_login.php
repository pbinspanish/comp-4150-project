<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Employee Login</h1>
	</div>
</div>

<form method="POST" class="mb-4">
	<div class="mb-3">
		<label for="ssn" class="form-label">Enter Employee SSN:</label>
		<input type="text" class="form-control" id="ssn" name="ssn" pattern="[0-9]{9}" maxlength="9" required>
	</div>
	<button type="submit" class="btn btn-primary">Sign In</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ssn'])) {
	session_start();

	$_SESSION['ssn'] = $_POST['ssn'];

	header('Location: /employee/employee_dashboard.php');
	exit;

	# add some error handling, actually go to the database and make sure the
	# employee exists
}
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>