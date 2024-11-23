<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';   
?>

<h2>Manage Locations</h2>


<h3>Search for a Location</h3>
<form method="POST" class="mb-4">
    <div class="mb-3">
        <label for="location_id" class="form-label">Enter Location ID:</label>
        <input type="text" class="form-control" id="location_id" name="location_id" pattern="[0-9]+" required>
    </div>
    <button type="submit" class="btn btn-primary" name="action" value="search">Search</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'search' && !empty($_POST['location_id'])) {
    try {
        $pdo = connectDB();
        
        $sql = "SELECT
                    location_id,
                    location_name
                FROM
                    locations
                WHERE
                    location_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['location_id']]);
        $location = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($location) {
            echo '<div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Location ID: ' . htmlspecialchars($location['location_id']) . '</h5>
                        <p class="card-text">
                            <strong>Location Name:</strong> ' . htmlspecialchars($location['location_name']) . '
                        </p>
                    </div>
                </div>';
        } else {
            echo '<div class="alert alert-warning">No location found with the provided Location ID.</div>';
        }
    } catch(PDOException $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}
?>


<h3>Add a New Location</h3>
<form method="POST" class="mb-4">
    <div class="mb-3">
        <label for="new_location_id" class="form-label">Location ID:</label>
        <input type="text" class="form-control" id="new_location_id" name="new_location_id" pattern="[0-9]+" required>
    </div>
    <div class="mb-3">
        <label for="new_location_name" class="form-label">Location Name:</label>
        <input type="text" class="form-control" id="new_location_name" name="new_location_name" maxlength="2000" required>
    </div>
    <button type="submit" class="btn btn-success" name="action" value="add">Add Location</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $newLocationId = $_POST['new_location_id'];
    $newLocationName = $_POST['new_location_name'];

    try {
        $pdo = connectDB();
        
        
        $sql = "INSERT INTO locations (location_id, location_name) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$newLocationId, $newLocationName]);

        echo '<div class="alert alert-success">New location added successfully!</div>';
    } catch (PDOException $e) {
        
        if ($e->getCode() === '23000') { 
            echo '<div class="alert alert-danger">Error: Location ID already exists.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<div class="row mt-3">
    <div class="col-auto">
        <a class="btn btn-secondary" href="javascript:history.back()" role="button">Return to Dashboard</a>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';  
?>
