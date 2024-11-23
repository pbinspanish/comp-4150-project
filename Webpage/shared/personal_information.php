<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Personal Information</h1>
	</div>
</div>

<?php
session_start();

try {
	$pdo = connectDB();
	$sql = "SELECT
				first_name,
				last_name,
				DATE_FORMAT(birthday, '%M %D, %Y') AS birthday,
				sex,
				address
			FROM
				people
			WHERE
				ssn = ?";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_SESSION['ssn']]);
	$employee = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if ($employee) {
		echo '<div class="card mt-4">
				<div class="card-body">
					<h5 class="card-title">' . htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) . '</h5>
					<p class="card-text">
						<strong>Address:</strong> ' . htmlspecialchars($employee['address']) . '<br>
						<strong>Birthday:</strong> ' . htmlspecialchars($employee['birthday']) . '<br>
						<strong>Sex:</strong> ' . htmlspecialchars($employee['sex']) . '
					</p>
				</div>
			</div>';
	} else {
		echo '<div class="alert alert-warning">No employee found with the provided SSN.</div>';
	}
} catch(PDOException $e) {
	echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}
?>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/shared/dependents.php" role="button">View Dependents</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/shared/contact_information.php" role="button">Contact Information</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-secondary" href="javascript:history.back()" role="button">Return</a>
	</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>