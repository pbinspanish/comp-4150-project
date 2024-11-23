<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';   
?>

<h2>Employee Task Information</h2>


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
                    pr.project_name,
                    w.hours
                FROM
                    people p
                JOIN
                    employees e ON p.person_id = e.person_id
                JOIN
                    works_on w ON e.employee_id = w.employee_id
                JOIN
                    projects pr ON w.project_id = pr.project_id
                WHERE
                    p.ssn = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['ssn']]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($tasks) {
            
            echo '<div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($tasks[0]['first_name'] . ' ' . $tasks[0]['last_name']) . '</h5>
                        <p class="card-text">
                            <strong>Employee ID:</strong> ' . htmlspecialchars($tasks[0]['employee_id']) . '
                        </p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Hours Worked</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach ($tasks as $task) {
                echo '<tr>
                        <td>' . htmlspecialchars($task['project_name']) . '</td>
                        <td>' . htmlspecialchars($task['hours']) . '</td>
                    </tr>';
            }
            echo '</tbody></table>
                    </div>
                </div>';
        } else {
            echo '<div class="alert alert-warning">No tasks found for the provided SSN.</div>';
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
