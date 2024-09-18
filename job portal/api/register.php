<?php
include('/includes/db.php'); // Include database connection

header('Content-Type: application/json');

// Retrieve POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Validate inputs
if (empty($name) || empty($email) || empty($password) || empty($role)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit();
}

// Check if email already exists
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
    exit();
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert new user into the database
$query = "INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, 1)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Registration successful.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
