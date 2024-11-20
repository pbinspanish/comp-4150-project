<?php
require_once 'db_config.php';
include 'header.php';
?>

<h2>Employee Projects</h2>

<form method="POST" class="mb-4">
	<div class="mb-3">
		<label for="ssn" class="form-label">Enter Employee SSN:</label>
		<input type="text" class="form-control" id="ssn" name="ssn" pattern="[0-9]{9}" maxlength="9" required>
	</div>
	<button type="submit" class="btn btn-primary">Find Projects</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ssn'])) {
	try {
		$pdo = connectDB();
		$sql = "SELECT
					p.project_name,
					w.hours,
					l.location_name,
					d.department_name
				FROM
					people pe
				JOIN
					employees e
					ON pe.person_id = e.person_id
				JOIN
					works_on w
					ON e.employee_id = w.employee_id
				JOIN
					projects p
					ON w.project_id = p.project_id
				JOIN
					departments d
					ON p.department_id = d.department_id
				LEFT JOIN
					locations l
					ON p.location_id = l.location_id
				WHERE
					pe.ssn = ?";
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_POST['ssn']]);
		$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if ($projects) {
			echo '<div class="table-responsive mt-4">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Project Name</th>
								<th>Hours</th>
								<th>Location</th>
								<th>Department</th>
							</tr>
						</thead>
						<tbody>';
			foreach ($projects as $project) {
				echo '<tr>
						<td>' . htmlspecialchars($project['project_name']) . '</td>
						<td>' . htmlspecialchars($project['hours']) . '</td>
						<td>' . htmlspecialchars($project['location_name'] ?? 'N/A') . '</td>
						<td>' . htmlspecialchars($project['department_name']) . '</td>
					  </tr>';
			}
			echo '</tbody></table></div>';
		} else {
			echo '<div class="alert alert-warning">No projects found for the employee with the provided SSN.</div>';
		}
	} catch(PDOException $e) {
		echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
	}
}
?>

<?php
include 'footer.php';
?>