<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';   
?>

<h2>Assign Projects</h2>

<?php
try {
    
    $pdo = connectDB();
    
    //query to fetch all unassigned projects
    $sql = "SELECT
                p.project_id,
                p.project_name,
                p.location_id,
                p.department_id
            FROM
                projects p
            LEFT JOIN
                works_on w ON p.project_id = w.project_id
            WHERE
                w.project_id IS NULL";  

    
    $stmt = $pdo->query($sql);

    //check if there are any unassigned projects
    if ($stmt->rowCount() > 0) {
        echo '<form method="POST" action="">';
        
        //display unassigned projects with a dropdown to assign to an employee
        echo '<div class="mb-3">
                <label for="project_id" class="form-label">Select Project to Assign:</label>
                <select class="form-control" id="project_id" name="project_id" required>';
        
        while ($project = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . htmlspecialchars($project['project_id']) . '">
                    Project ID: ' . htmlspecialchars($project['project_id']) . ' - ' . htmlspecialchars($project['project_name']) . '</option>';
        }
        
        echo '</select></div>';

        //query to fetch all employees
        $empSql = "SELECT
                    e.employee_id,
                    p.first_name,
                    p.last_name
                   FROM employees e
                   JOIN people p ON e.person_id = p.person_id";

        $empStmt = $pdo->query($empSql);
        
        //display employees in a dropdown
        echo '<div class="mb-3">
                <label for="employee_id" class="form-label">Select Employee to Assign:</label>
                <select class="form-control" id="employee_id" name="employee_id" required>';
        
        while ($employee = $empStmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . htmlspecialchars($employee['employee_id']) . '">
                    ' . htmlspecialchars($employee['first_name']) . ' ' . htmlspecialchars($employee['last_name']) . ' - Employee ID: ' . htmlspecialchars($employee['employee_id']) . '</option>';
        }
        
        echo '</select></div>';

        echo '<button type="submit" class="btn btn-primary">Assign Project</button>';
        echo '</form>';
    } else {
        echo '<div class="alert alert-warning">No unassigned projects found.</div>';
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id']) && isset($_POST['employee_id'])) {
        $projectId = $_POST['project_id'];
        $employeeId = $_POST['employee_id'];

        //insert into works_on table to assign the employee to the selected project
        $assignSql = "INSERT INTO works_on (employee_id, project_id, hours) VALUES (?, ?, 0)";
        $assignStmt = $pdo->prepare($assignSql);

        if ($assignStmt->execute([$employeeId, $projectId])) {
            echo '<div class="alert alert-success">Project assigned successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error assigning project.</div>';
        }
    }
} catch (PDOException $e) {
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
