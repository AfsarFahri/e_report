<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

$id = $_GET['id'];
$sql = "DELETE FROM complaints WHERE id = $id AND user_id = " . $_SESSION['user_id'];
$conn->query($sql);
header('Location: dashboard.php'); // Kembali ke dashboard setelah dihapus
?>