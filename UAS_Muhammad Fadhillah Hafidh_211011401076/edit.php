<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$country = $conn->query("SELECT * FROM negara WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['groups_id'];
    $country_name = $_POST['nama_negara'];
    $wins = $_POST['menang'];
    $draws = $_POST['draw'];
    $losses = $_POST['kalah'];
    $points = $_POST['points'];

    $sql = "UPDATE negara SET groups_id='$group_id', nama_negara='$country_name', menang='$wins', draw='$draws', kalah='$losses', points='$points' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$groups = $conn->query("SELECT * FROM groups");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Country</title>
</head>
<body>
    <form method="post" action="">
        Group:
        <select name="groups_id" required>
            <?php while ($row = $groups->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $country['groups_id']) ? 'selected' : ''; ?>><?php echo $row['group_name']; ?></option>
            <?php endwhile; ?>
        </select><br>
        Country Name: <input type="text" name="nama_negara" value="<?php echo $country['nama_negara']; ?>" required><br>
        Wins: <input type="number" name="menang" value="<?php echo $country['menang']; ?>" required><br>
        Draws: <input type="number" name="draw" value="<?php echo $country['draw']; ?>" required><br>
        Losses: <input type="number" name="kalah" value="<?php echo $country['kalah']; ?>" required><br>
        Points: <input type="number" name="points" value="<?php echo $country['points']; ?>" required><br>
        <button type="submit">Update Country</button>
    </form>
</body>
</html>
