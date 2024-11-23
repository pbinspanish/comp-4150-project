<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';   
?>

<h2>Manage Department Locations</h2>

<form method="POST" class="mb-4">
    <div class="mb-3">
        <label for="department_id" class="form-label">Enter Department ID:</label>
        <input type="text" class="form-control" id="department_id" name="department_id" pattern="[0-9]+" required>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['department_id'])) {
    try {
        $pdo = connectDB();
        
        
        $sql = "SELECT
                    dl.department_id,
                    dl.location_id,
                    l.location_name
                FROM
                    department_locations dl
                JOIN
                    locations l ON dl.location_id = l.location_id
                WHERE
                    dl.department_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['department_id']]);
        $department_location = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($department_location) {
            echo '<div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Department ID: ' . htmlspecialchars($department_location['department_id']) . '</h5>
                        <p class="card-text">
                            <strong>Location ID:</strong> ' . htmlspecialchars($department_location['location_id']) . '<br>
                            <strong>Location Name:</strong> ' . htmlspecialchars($department_location['location_name']) . '
                        </p>
                        <form method="POST">
                            <input type="hidden" name="department_id" value="' . htmlspecialchars($department_location['department_id']) . '">
                            <div class="mb-3">
                                <label for="new_location_id" class="form-label">Enter New Location ID:</label>
                                <input type="text" class="form-control" id="new_location_id" name="new_location_id" pattern="[0-9]+" required>
                            </div>
                            <button type="submit" name="action" value="update" class="btn btn-warning">Update Location</button>
                        </form>
                    </div>
                </div>';
        } else {
            echo '<div class="alert alert-warning">No location found for the provided Department ID.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update' && !empty($_POST['department_id']) && !empty($_POST['new_location_id'])) {
    $departmentId = $_POST['department_id'];
    $newLocationId = $_POST['new_location_id'];

    try {
        $pdo = connectDB();

        
        $sql = "UPDATE department_locations SET location_id = ? WHERE department_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$newLocationId, $departmentId]);

        echo '<div class="alert alert-success mt-4">Department location updated successfully!</div>';
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
