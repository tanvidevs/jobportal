<?php
// Include database connection
include('/includes/db.php');

// Start a session and check if the user is an HR (or Admin) to ensure access control
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'hr' && $_SESSION['role'] != 'admin')) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Check if the required POST data is provided
if (isset($_POST['application_id']) && isset($_POST['status'])) {
    // Get and sanitize the input data
    $application_id = intval($_POST['application_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validate status
    $valid_statuses = ['pending', 'approved', 'rejected'];
    if (!in_array($status, $valid_statuses)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid status']);
        exit();
    }

    // Update the status in the database
    $query = "UPDATE applications SET status='$status' WHERE application_id=$application_id";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}

mysqli_close($conn);
?>
