<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Employee Directory</h1>
	</div>
</div>

<?php
session_start();

try {
	$pdo = connectDB();
	$sql = "SELECT 
				p.first_name AS first_name,
				p.last_name AS last_name,
				d.department_name AS department_name
			FROM 
				employees e
			JOIN 
				people p ON e.person_id = p.person_id
			JOIN 
				departments d ON e.department_id = d.department_id";

	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($projects) {
		echo '<div class="table-responsive mt-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Department</th>
						</tr>
					</thead>
					<tbody>';
		foreach ($projects as $project) {
			echo '<tr>
					<td>' . htmlspecialchars($project['first_name']) . ' ' . htmlspecialchars($project['last_name']) . '</td>
					<td>' . htmlspecialchars($project['department_name']) . '</td>
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

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-secondary" href="javascript:history.back()" role="button">Return</a>
	</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>