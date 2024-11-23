<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Assigned Projects</h1>
	</div>
</div>

<?php
session_start();

try {
	$pdo = connectDB();
	$sql = "SELECT 
				p.project_name AS project_name,
				d.department_name AS department_name,
				l.location_name AS location_name,
				w.hours AS hours
			FROM 
				works_on w
			JOIN 
				employees e ON w.employee_id = e.employee_id
			JOIN 
				projects p ON w.project_id = p.project_id
			JOIN 
				departments d ON p.department_id = d.department_id
			LEFT JOIN 
				locations l ON p.location_id = l.location_id
			JOIN 
				people pe ON e.person_id = pe.person_id
			WHERE 
				pe.ssn = ?";

	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_SESSION['ssn']]);
	$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($projects) {
		echo '<div class="table-responsive mt-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Project</th>
							<th>Department</th>
							<th>Location</th>
							<th>Hours Worked</th>
						</tr>
					</thead>
					<tbody>';
		foreach ($projects as $project) {
			echo '<tr>
					<td>' . htmlspecialchars($project['project_name']) . '</td>
					<td>' . htmlspecialchars($project['department_name']) . '</td>
					<td>' . htmlspecialchars($project['location_name']) . '</td>
					<td>' . htmlspecialchars($project['hours']) . '</td>
				  </tr>';
		}
		echo '</tbody></table></div>';
	} else {
		echo '<div class="alert alert-warning">No projects found.</div>';
	}
} catch(PDOException $e) {
	echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>