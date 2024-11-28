<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $complaint_text = $_POST['complaint_text'];

    $sql = "UPDATE complaints SET complaint_text = '$complaint_text' WHERE id = $id";
    $conn->query($sql);
    header('Location: dashboard.php'); // Kembali ke dashboard setelah update
}

// Ambil data pengaduan berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM complaints WHERE id = $id AND user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
$complaint = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengaduan</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Pengaduan</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $complaint['id']; ?>">
            <div class="form-group">
                <label for="complaint_text">Pengaduan:</label>
                <textarea name="complaint_text" required><?php echo htmlspecialchars($complaint['complaint_text']); ?></textarea>
            </div>
            <button type="submit">Update Pengaduan</button>
        </form>
        <a href="dashboard.php" class="back-link">Kembali ke Dashboard</a>
    </div>

    <footer>
        <p>&copy; 2024 Website Pengaduan | Afsar Fakhri</p>
    </footer>
</body>
</html>
