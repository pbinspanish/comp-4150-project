<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Employee Overview</h1>
	</div>
</div>

<?php
session_start();

try {
	$pdo = connectDB();
	$sql = "SELECT 
				p.first_name AS first_name,
				p.last_name AS last_name,
				jt.title_name AS job_title,
				sp.first_name AS sp_first_name,
				sp.last_name AS sp_last_name,
				d.department_name AS department_name
			FROM 
				employees e
			JOIN 
				people p ON e.person_id = p.person_id
			JOIN 
				job_titles jt ON e.title_id = jt.title_id
			JOIN 
				departments d ON e.department_id = d.department_id
			LEFT JOIN 
				employees s ON e.supervisor_employee_id = s.employee_id
			LEFT JOIN 
				people sp ON s.person_id = sp.person_id
			WHERE 
				p.ssn = ?";

	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_SESSION['ssn']]);
	$employee = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($employee) {
		echo '<div class="card mt-4">
				<div class="card-body">
					<h5 class="card-title">' . htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) . '</h5>
					<p class="card-text">
						<strong>Job Title:</strong> ' . htmlspecialchars($employee['job_title']) . '<br>
						<strong>Supervisor:</strong> ' . htmlspecialchars($employee['sp_first_name'] . ' ' . $employee['sp_last_name']) . '<br>
						<strong>Department:</strong> ' . htmlspecialchars($employee['department_name']) . '
					</p>
				</div>
			</div>';
	} else {
		echo '<div class="alert alert-warning">No employee found with the provided SSN.</div>';
	}
} catch (PDOException $e) {
	echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}
?>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-secondary" href="javascript:history.back()" role="button">Return</a>
	</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>