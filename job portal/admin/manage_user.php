<?php
// Fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../assets/css/tailwind.css">
</head>
<body class="bg-gray-100">
    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Manage Users</h1>

        <!-- Add User Form -->
        <form action="add_user.php" method="POST" class="mb-6 bg-white p-4 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-4">Add New User</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="Full Name" class="border p-2 rounded" required>
                <input type="email" name="email" placeholder="Email" class="border p-2 rounded" required>
                <select name="role" class="border p-2 rounded" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="hr">HR</option>
                    <option value="candidate">Candidate</option>
                </select>
                <button type="submit" name="add_user" class="bg-blue-500 text-white px-4 py-2 rounded">Add User</button>
            </div>
        </form>

        <!-- User Table -->
        <table class="min-w-full bg-white border border-gray-200 rounded">
            <thead>
                <tr>
                    <th class="py-2 border-b">ID</th>
                    <th class="py-2 border-b">Name</th>
                    <th class="py-2 border-b">Email</th>
                    <th class="py-2 border-b">Role</th>
                    <th class="py-2 border-b">Status</th>
                    <th class="py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td class="py-2 border-b"><?php echo $row['id']; ?></td>
                    <td class="py-2 border-b"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td class="py-2 border-b"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td class="py-2 border-b"><?php echo ucfirst($row['role']); ?></td>
                    <td class="py-2 border-b"><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                    <td class="py-2 border-b">
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
