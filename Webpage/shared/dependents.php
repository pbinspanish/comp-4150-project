<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Dependents</h1>
	</div>
</div>

<?php
session_start();

try {
	$pdo = connectDB();
	$sql = "SELECT
				dp.first_name AS first_name,
				dp.last_name AS last_name,
				d.relationship AS relationship
			FROM 
				employees e
			JOIN 
				people p ON e.person_id = p.person_id
			JOIN 
				dependents d ON e.employee_id = d.employee_id
			JOIN 
				people dp ON d.person_id = dp.person_id
			WHERE 
				p.ssn = ?";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_SESSION['ssn']]);
	$dependents = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($dependents) {
		echo '<div class="table-responsive mt-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Relationship</th>
						</tr>
					</thead>
					<tbody>';
		foreach ($dependents as $dependent) {
			echo '<tr>
					<td>' . htmlspecialchars($dependent['first_name']) . ' ' . htmlspecialchars($dependent['last_name']) . '</td>
					<td>' . htmlspecialchars($dependent['relationship']) . '</td>
				  </tr>';
		}
		echo '</tbody></table></div>';
	} else {
		echo '<div class="alert alert-warning">No dependents found.</div>';
	}
} catch(PDOException $e) {
	echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}
?>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/shared/remove_dependent.php" role="button">Remove Dependents</a>
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