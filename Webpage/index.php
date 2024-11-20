<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

<div class="row">
	<div class="col-auto">
		<h1>Employee Database</h1>
	</div>
</div>

<div class="row mt-4">
	<div class="col-auto">
		<a class="btn btn-primary" href="/employee/employee_login.php" role="button">Employee Login</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-primary" href="/manager/manager_login.php" role="button">Manager Login</a>
	</div>
</div>

<div class="row mt-3">
	<div class="col-auto">
		<a class="btn btn-secondary" href="javascript:close()" role="button">Close</a>
	</div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>