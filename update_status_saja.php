<?php
session_start();
require 'config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengajuanId = $_POST['pengajuan_id'];
    $status = $_POST['status'];

    // Update the database
    $sql = "UPDATE pengajuans SET status = ? WHERE pengajuan_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $pengajuanId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>