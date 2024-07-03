<?php
session_start();
include "koneksi.php";

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

// Mengambil data dari database dengan JOIN dan urutkan berdasarkan poin
$countries = $conn->query("SELECT negara.*, groups.group_name FROM negara JOIN groups ON negara.groups_id = groups.id ORDER BY negara.points DESC");
if (!$countries) {
    die("Query Error: " . $conn->error);
}

// Menghapus data berdasarkan ID
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM negara WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['nim']); ?></h1>
    <a href="tambah_group.php">Add Group</a>
    <a href="tambah_negara.php">Add Country</a>
    <a href="pdf.php">Cetak PDF</a>
    <table border="1">
        <tr>
            <th>Group</th>
            <th>Country</th>
            <th>Wins</th>
            <th>Draws</th>
            <th>Losses</th>
            <th>Points</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $countries->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['group_name']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_negara']); ?></td>
                <td><?php echo htmlspecialchars($row['menang']); ?></td>
                <td><?php echo htmlspecialchars($row['draw']); ?></td>
                <td><?php echo htmlspecialchars($row['kalah']); ?></td>
                <td><?php echo htmlspecialchars($row['points']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                    <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>
