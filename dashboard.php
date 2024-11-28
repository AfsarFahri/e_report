<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $complaint_text = $_POST['complaint_text'];

    $sql = "INSERT INTO complaints (user_id, name, complaint_text) VALUES ('$user_id', '$name', '$complaint_text')";
    $conn->query($sql);
}

// Ambil pengaduan dari database
$sql = "SELECT * FROM complaints WHERE user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengaduan</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        /* Gaya umum container */
        /* Container utama */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    font-family: 'Plus Jakarta Sans', Tahoma, Geneva, Verdana, sans-serif;
}

/* Judul halaman */
h1 {
    color: white;
    font-size: 32px;
    margin-bottom: 20px;
    font-weight: 600;
}

/* Formulir pengaduan */
form {
    margin-bottom: 30px;
    text-align: left;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
    color: #34495e;
}

.form-group input, .form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #bdc3c7;
    border-radius: 6px;
    font-size: 15px;
    box-sizing: border-box;
    font-family: 'Plus Jakarta Sans', Tahoma, Geneva, Verdana, sans-serif;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #2980b9;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-family: inherit;
}

button:hover {
    background-color: #3498db;
}

/* Tabel pengaduan */
.complaints-section {
    margin-top: 30px;
    text-align: center;
}

.complaints-section h2 {
    font-size: 26px;
    color: #ffffff;
    margin-bottom: 15px;
}

.center-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.center-table th, .center-table td {
    padding: 14px;
    border-bottom: 1px solid #ecf0f1;
    font-size: 15px;

}

.center-table th {
    background-color: #ecf0f1;
    color: #2c3e50;
    font-weight: 600;
    text-align: left;
}

.center-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.center-table tr:hover {
    background-color: #ecf0f1;
}

.center-table td a {
    border-radius: 10px;
    padding: 10px;
    background-color: #2980b9;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
}

.center-table td a:hover {
    background-color: #3498db;
    text-decoration: none;
}

/* Link logout */
a.logout {
    display: inline-block;
    margin-top: 20px;
    color: #ffffff;
    padding-left: 100px;
    padding-right: 100px;
    text-decoration: none;
    font-weight: 400;
    border-radius: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    background-color: #2980b9;
}

a.logout:hover {
    background-color: #3498db;
    text-decoration: none;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Pengaduan</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="complaint_text">Pengaduan:</label>
                <textarea name="complaint_text" id="complaint_text" required></textarea>
            </div>
            <button type="submit">Kirim Pengaduan</button>
        </form>

        <div class="complaints-section">
            <h2>Daftar Pengaduan Anda</h2>
            <table class="center-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Pengaduan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['complaint_text']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <a href="edit_complaint.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="delete_complaint.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
