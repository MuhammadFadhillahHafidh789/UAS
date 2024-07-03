<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_name = $_POST['group_name'];

    $sql = "INSERT INTO groups (group_name) VALUES ('$group_name')";
    if ($conn->query($sql) === TRUE) {
        echo "New group created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Group</title>
</head>
<body>
    <form method="post" action="">
        Group Name: <input type="text" name="group_name" required><br>
        <button type="submit">Add Group</button>
    </form>
</body>
</html>
 