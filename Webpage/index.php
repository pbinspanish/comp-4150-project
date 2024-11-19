<?php
require_once 'db_config.php';
include 'header.php';
?>

<div class="jumbotron">
	<h1 class="display-4 mb-4">Employee Database</h1>
	<div class="list-group">
		<a href="employee_info.php" class="list-group-item list-group-item-action">
			<h5 class="mb-1">Employee Information</h5>
			<p class="mb-1">Look up employee details using SSN</p>
		</a>
		<a href="employee_projects.php" class="list-group-item list-group-item-action">
			<h5 class="mb-1">Employee Projects</h5>
			<p class="mb-1">Find projects an employee is working on</p>
		</a>
		<a href="department_summary.php" class="list-group-item list-group-item-action">
			<h5 class="mb-1">Department Summary</h5>
			<p class="mb-1">View department statistics and employee counts</p>
		</a>
	</div>
</div>

<?php
include 'footer.php';
?>