<?php
require_once 'db_config.php';
include 'header.php';
?>

<h2>Employee Information</h2>

<form method="POST" class="mb-4">
	<div class="mb-3">
		<label for="ssn" class="form-label">Enter Employee SSN:</label>
		<input type="text" class="form-control" id="ssn" name="ssn" pattern="[0-9]{9}" maxlength="9" required>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ssn'])) {
	try {
		$pdo = connectDB();
		$sql = "SELECT
					p.first_name,
					p.last_name,
					p.address,
					s.salary, 
					j.title_name,
					d.department_name
				FROM
					people p
				JOIN
					employees e
					ON p.person_id = e.person_id
				JOIN
					salaries s
					ON e.employee_id = s.employee_id
				JOIN
					job_titles j
					ON e.title_id = j.title_id
				JOIN
					departments d
					ON e.department_id = d.department_id
				WHERE
					p.ssn = ?
					AND s.end_date IS NULL";
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_POST['ssn']]);
		$employee = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($employee) {
			echo '<div class="card mt-4">
					<div class="card-body">
						<h5 class="card-title">' . htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) . '</h5>
						<p class="card-text">
							<strong>Address:</strong> ' . htmlspecialchars($employee['address']) . '<br>
							<strong>Current Salary:</strong> $' . number_format($employee['salary'], 2) . '<br>
							<strong>Job Title:</strong> ' . htmlspecialchars($employee['title_name']) . '<br>
							<strong>Department:</strong> ' . htmlspecialchars($employee['department_name']) . '
						</p>
					</div>
				</div>';
		} else {
			echo '<div class="alert alert-warning">No employee found with the provided SSN.</div>';
		}
	} catch(PDOException $e) {
		echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
	}
}
?>

<?php
include 'footer.php';
?>