<?php
session_start();
require 'config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengajuanId = $_POST['pengajuan_id'];
    $status = $_POST['status'];
    $statusField = '';
    $statusTimestamp = '';

    switch ($status) {
        case 1:
            $statusField = 'status_acc_staff';
            break;
        case 2:
            $statusField = 'status_acc_kabag';
            break;
        case 3:
            $statusField = 'status_acc_kabak';
            break;
        default:
            echo json_encode(['success' => false, 'error' => 'Invalid status']);
            exit;
    }

    if (isset($_POST[$statusField])) {
        $statusTimestamp = $_POST[$statusField];
    }

    // Update the database
    $sql = "UPDATE pengajuans SET status = ?, $statusField = ? WHERE pengajuan_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $status, $statusTimestamp, $pengajuanId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>