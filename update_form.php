<?php
include 'database.php';
include 'user.php';

// Check if the 'matric' parameter exists in the GET request
if (isset($_GET['matric']) && !empty($_GET['matric'])) {
    // Retrieve the 'matric' value
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create a User object and fetch user details using the matric
    $user = new User($db);
    $userDetails = $user->getUser($matric);

    // Close the database connection
    $db->close();

    // Check if user details were found
    if (!$userDetails) {
        // Display an error if no user is found
        echo "<p>Error: No user found with matric '$matric'.</p>";
        exit; // Stop further execution
    }
} else {
    // Handle the case where 'matric' is not provided or empty
    echo "<p>Error: 'matric' parameter is missing or empty.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            margin-left: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Update User</h1>
    <form action="update.php" method="post">
        <!-- Hidden field for matric -->
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>" readonly>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required>

        <label for="role">Access Level:</label>
        <select name="role" id="role" required>
            <option value="">Please select</option>
            <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
            <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>Student</option>
        </select>

        <input type="submit" value="Update">
        <a href="user_list.php">Cancel</a>
    </form>
</body>

</html>
