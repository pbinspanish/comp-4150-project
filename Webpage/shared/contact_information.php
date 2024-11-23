<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Contact Information</h1>
	</div>
</div>

<?php
session_start();

try {
	$pdo = connectDB();
	$sql = "SELECT 
				pn.phone_number AS phone_number,
				pn.phone_number_description AS phone_desc
			FROM 
				people p
			JOIN 
				phone_numbers pn ON p.person_id = pn.person_id
			WHERE 
				p.ssn = ?";

	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_SESSION['ssn']]);
	$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($projects) {
		echo '<div class="table-responsive mt-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Phone Number</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>';
		foreach ($projects as $project) {
			echo '<tr>
					<td>' . htmlspecialchars($project['phone_number']) . '</td>
					<td>' . htmlspecialchars($project['phone_desc']) . '</td>
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