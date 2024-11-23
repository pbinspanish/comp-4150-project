<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';   
?>

<h2>Employee Salary Information</h2>


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
                    e.employee_id,
                    s.start_date,
                    s.end_date,
                    s.salary
                FROM
                    people p
                JOIN
                    employees e ON p.person_id = e.person_id
                JOIN
                    salaries s ON e.employee_id = s.employee_id
                WHERE
                    p.ssn = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['ssn']]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employee) {
          
            echo '<div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) . '</h5>
                        <p class="card-text">
                            <strong>Employee ID:</strong> ' . htmlspecialchars($employee['employee_id']) . '<br>
                            <strong>Start Date:</strong> ' . htmlspecialchars($employee['start_date']) . '<br>
                            <strong>End Date:</strong> ' . ($employee['end_date'] ? htmlspecialchars($employee['end_date']) : 'Present') . '<br>
                            <strong>Salary:</strong> $' . number_format($employee['salary'], 2) . '
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


<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-secondary" href="/manager/manager_dashboard.php" role="button">Return to Dashboard</a>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';  
?>
