<?php
include 'config.php'; // Pastikan ini menghubungkan ke database

if (isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    $sql = "SELECT * FROM transactions WHERE member_id = $member_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Tampilkan data transaksi
            echo "<p>Date: " . $row['tanggal'] . "</p>";
            echo "<p>Amount: " . $row['jumlah'] . "</p>";
            // Tambahkan kolom lain sesuai kebutuhan
        }
    } else {
        echo "No transactions found.";
    }
}
?>
