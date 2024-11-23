<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_config.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';   
?>

<h2>Project Information</h2>

<?php
try {
    
    $pdo = connectDB();
    
    $sql = "SELECT
                project_id,
                project_name,
                location_id,
                department_id
            FROM
                projects";
    
    $stmt = $pdo->query($sql);

    
    if ($stmt->rowCount() > 0) {
        
        while ($project = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Project ID: ' . htmlspecialchars($project['project_id']) . '</h5>
                        <p class="card-text">
                            <strong>Project Name:</strong> ' . htmlspecialchars($project['project_name']) . '<br>
                            <strong>Location ID:</strong> ' . htmlspecialchars($project['location_id']) . '<br>
                            <strong>Department ID:</strong> ' . htmlspecialchars($project['department_id']) . '
                        </p>
                    </div>
                  </div>';
        }
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
