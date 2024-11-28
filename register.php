<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="text-center"><h1>Registrasi</h1></div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Registrasi berhasil!</p>";
            } else {
                echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Daftar</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Website Pengaduan | Afsar Fakhri</p>
    </footer>
</body>
</html>