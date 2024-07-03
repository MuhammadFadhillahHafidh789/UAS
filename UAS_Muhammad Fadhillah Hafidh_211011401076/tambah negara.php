<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$groups = $conn->query("SELECT * FROM groups");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['groups_id'];
    $country_name = $_POST['nama_negara'];
    $wins = $_POST['menang'];
    $draws = $_POST['draw'];
    $losses = $_POST['kalah'];
    $points = $_POST['points'];

    $sql = "INSERT INTO negara (groups_id, nama_negara, menang, draw, kalah, points) VALUES ('$group_id', '$country_name', '$wins', '$draws', '$losses', '$points')";
    if ($conn->query($sql) === TRUE) {
        echo "New country added successfully";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Country</title>
</head>
<body>
    <form method="post" action="">
        Group:
        <select name="groups_id" required>
            <?php while ($row = $groups->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['group_name']; ?></option>
            <?php endwhile; ?>
        </select><br>
        Country Name: <input type="text" name="nama_negara" required><br>
        Wins: <input type="number" name="menang" required><br>
        Draws: <input type="number" name="draw" required><br>
        Losses: <input type="number" name="kalah" required><br>
        Points: <input type="number" name="points" required><br>
        <button type="submit">Add Country</button>
    </form>
</body>
</html>
