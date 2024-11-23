<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';   
?>

<h2>Assign Job Title to Employee</h2>


<form method="POST" class="mb-4">
    <div class="mb-3">
        <label for="ssn" class="form-label">Enter Employee SSN:</label>
        <input type="text" class="form-control" id="ssn" name="ssn" pattern="[0-9]{9}" maxlength="9" required>
    </div>
    <button type="submit" name="action" value="search" class="btn btn-primary">Search</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'search' && !empty($_POST['ssn'])) {
    try {
        $pdo = connectDB();

        
        $sql = "SELECT
                    p.first_name,
                    p.last_name,
                    j.title_name,
                    e.employee_id
                FROM
                    people p
                JOIN
                    employees e ON p.person_id = e.person_id
                JOIN
                    job_titles j ON e.title_id = j.title_id
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
                            <strong>Current Job Title:</strong> ' . htmlspecialchars($employee['title_name']) . '
                        </p>
                    </div>
                </div>';

            
            echo '<form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="job_title" class="form-label">Select New Job Title:</label>
                        <select class="form-control" id="job_title" name="job_title" required>';

            
            $sql_titles = "SELECT title_id, title_name FROM job_titles";
            $stmt_titles = $pdo->prepare($sql_titles);
            $stmt_titles->execute();
            while ($row = $stmt_titles->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . htmlspecialchars($row['title_id']) . '">' . htmlspecialchars($row['title_name']) . '</option>';
            }

            echo '  </select>
                    </div>
                    <input type="hidden" name="employee_id" value="' . htmlspecialchars($employee['employee_id']) . '">
                    <button type="submit" name="action" value="update" class="btn btn-success">Update Job Title</button>
                </form>';
        } else {
            echo '<div class="alert alert-warning">No employee found with the provided SSN.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update' && !empty($_POST['job_title']) && !empty($_POST['employee_id'])) {
    try {
        $pdo = connectDB();

        $update_sql = "UPDATE employees SET title_id = ? WHERE employee_id = ?";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([$_POST['job_title'], $_POST['employee_id']]);

        echo '<div class="alert alert-success mt-4">Job title updated successfully!</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger mt-4">Error: ' . $e->getMessage() . '</div>';
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
