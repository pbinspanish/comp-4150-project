<?php
require_once 'db_config.php';
include 'header.php';

try {
	$pdo = connectDB();
	$sql = "SELECT
				d.department_name, 
				COUNT(DISTINCT e.employee_id) AS employee_count,
				COUNT(DISTINCT p.project_id) AS project_count,
				l.location_name
			FROM
				departments d
			LEFT JOIN
				employees e
				ON d.department_id = e.department_id
			LEFT JOIN
				projects p
				ON d.department_id = p.department_id
			LEFT JOIN
				department_locations dl ON d.department_id = dl.department_id
			LEFT JOIN
				locations l ON dl.location_id = l.location_id
			GROUP BY
				d.department_id,
				d.department_name,
				l.location_name
			ORDER BY
				d.department_name";
	
	$stmt = $pdo->query($sql);
	$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo '<h2>Department Summary</h2>';
	
	if ($departments) {
		echo '<div class="table-responsive mt-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Department</th>
							<th>Employees</th>
							<th>Projects</th>
							<th>Location</th>
						</tr>
					</thead>
					<tbody>';
		foreach ($departments as $dept) {
			echo '<tr>
					<td>' . htmlspecialchars($dept['department_name']) . '</td>
					<td>' . htmlspecialchars($dept['employee_count']) . '</td>
					<td>' . htmlspecialchars($dept['project_count']) . '</td>
					<td>' . htmlspecialchars($dept['location_name'] ?? 'N/A') . '</td>
				  </tr>';
		}
		echo '</tbody></table></div>';
	} else {
		echo '<div class="alert alert-warning">No departments found.</div>';
	}
} catch(PDOException $e) {
	echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}

include 'footer.php';
?>