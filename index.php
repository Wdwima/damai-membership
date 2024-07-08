<?php
include 'auth.php'; // Memasukkan file auth.php untuk otorisasi
include 'config.php'; // Memasukkan file config.php untuk koneksi ke database

// Proses filter transaksi berdasarkan tanggal
if (isset($_POST['filter'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT * FROM transactions WHERE tanggal BETWEEN '$start_date' AND '$end_date'";
    $result = $conn->query($sql);
}

// Proses pencarian berdasarkan nama member
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];

    $sql_search = "SELECT * FROM members WHERE nama LIKE '%$search_term%'";
    $result_search = $conn->query($sql_search);
}

// Proses tambah transaksi
if (isset($_POST['add_transaction'])) {
    $member_id = $_POST['member_id'];
    $transaction_date = $_POST['transaction_date'];
    $amount = $_POST['amount'];

    // Hitung poin berdasarkan jumlah transaksi
    $points = floor($amount / 1000000) * 100;

    // Query untuk memasukkan transaksi baru ke dalam database
    $sql_add_transaction = "INSERT INTO transactions (member_id, tanggal, jumlah, poin) 
                            VALUES ('$member_id', '$transaction_date', '$amount', '$points')";

    if ($conn->query($sql_add_transaction) === TRUE) {
        echo "<script>alert('Transaction added successfully');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error adding transaction: " . $conn->error . "');</script>";
    }
}

// Proses update anggota
if (isset($_POST['update_member'])) {
    $update_id = $_POST['update_id'];
    $update_nama = $_POST['update_nama'];
    $update_tanggal_lahir = $_POST['update_tanggal_lahir'];
    $update_jenis_member = $_POST['update_jenis_member'];
    $update_no_telepon = $_POST['update_no_telepon'];
    $update_alamat = $_POST['update_alamat'];

    $sql_update = "UPDATE members SET 
                    nama='$update_nama', 
                    tanggal_lahir='$update_tanggal_lahir', 
                    jenis_member='$update_jenis_member', 
                    no_telepon='$update_no_telepon', 
                    alamat='$update_alamat' 
                   WHERE id=$update_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Member updated successfully');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error updating member: " . $conn->error . "');</script>";
    }
}

// Proses registrasi member
if (isset($_POST['register_member'])) {
    $register_nama = $_POST['register_nama'];
    $register_tanggal_lahir = $_POST['register_tanggal_lahir'];
    $register_jenis_member = $_POST['register_jenis_member'];
    $register_no_telepon = $_POST['register_no_telepon'];
    $register_alamat = $_POST['register_alamat'];

    // Query untuk memasukkan member baru ke dalam database
    $sql_register_member = "INSERT INTO members (nama, tanggal_lahir, jenis_member, no_telepon, alamat) 
                            VALUES ('$register_nama', '$register_tanggal_lahir', '$register_jenis_member', '$register_no_telepon', '$register_alamat')";

    if ($conn->query($sql_register_member) === TRUE) {
        echo "<script>alert('Member registered successfully');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error registering member: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 1000;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .main {
            margin-left: 200px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .main {
                margin-left: 0;
            }
            .sidebar {
                position: static;
                box-shadow: none;
                padding: 20px 0;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Member Management System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            Member List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">
                            Register Member
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#updateModal">
                            Update Member
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#addTransactionModal">
                            Add Transaction
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main">
            <h2 class="mb-4">Member List</h2>
            
            <!-- Search Form -->
            <form method="post" action="index.php" class="my-3">
                <div class="form-group">
                    <label for="search_term">Search by Member Name:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_term" name="search_term" placeholder="Enter member name">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Filter Transactions by Date Form -->
            <div class="my-4">
                <form method="post" action="index.php" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="start_date" class="mr-2">Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group mr-2">
                        <label for="end_date" class="mr-2">End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <button type="submit" name="filter" class="btn btn-secondary">Filter Transactions</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Member</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Riwayat Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($result_search)) {
                            if ($result_search->num_rows > 0) {
                                while ($row = $result_search->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nama'] . "</td>";
                                    echo "<td>" . $row['tanggal_lahir'] . "</td>";
                                    echo "<td>" . $row['jenis_member'] . "</td>";
                                    echo "<td>" . $row['no_telepon'] . "</td>";
                                    echo "<td>" . $row['alamat'] . "</td>";
                                    echo "<td><a href='#' class='btn btn-primary transaction-detail-link' data-member-id='" . $row['id'] . "' data-toggle='modal' data-target='#transactionModal'>View Transactions</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No members found.</td></tr>";
                            }
                        } else {
                            // Default: Tampilkan semua member
                            $sql_all_members = "SELECT * FROM members";
                            $result_all_members = $conn->query($sql_all_members);

                            if ($result_all_members->num_rows > 0) {
                                while ($row = $result_all_members->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nama'] . "</td>";
                                    echo "<td>" . $row['tanggal_lahir'] . "</td>";
                                    echo "<td>" . $row['jenis_member'] . "</td>";
                                    echo "<td>" . $row['no_telepon'] . "</td>";
                                    echo "<td>" . $row['alamat'] . "</td>";
                                    echo "<td><a href='#' class='btn btn-primary transaction-detail-link' data-member-id='" . $row['id'] . "' data-toggle='modal' data-target='#transactionModal'>View Transactions</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No members found.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Modal untuk Transaction Details -->
<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Transaction History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten transaksi akan dimuat melalui AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Register Member -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register New Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form registrasi member -->
                <form method="post" action="index.php">
                    <div class="form-group">
                        <label for="register_nama">Nama:</label>
                        <input type="text" class="form-control" id="register_nama" name="register_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="register_tanggal_lahir">Tanggal Lahir:</label>
                        <input type="date" class="form-control" id="register_tanggal_lahir" name="register_tanggal_lahir" required>
                    </div>
                    <div class="form-group">
                        <label for="register_jenis_member">Jenis Member:</label>
                        <input type="text" class="form-control" id="register_jenis_member" name="register_jenis_member" required>
                    </div>
                    <div class="form-group">
                        <label for="register_no_telepon">No Telepon:</label>
                        <input type="text" class="form-control" id="register_no_telepon" name="register_no_telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="register_alamat">Alamat:</label>
                        <input type="text" class="form-control" id="register_alamat" name="register_alamat" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="register_member">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Update Member -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form update member -->
                <form method="post" action="index.php">
                    <input type="hidden" id="update_id" name="update_id">
                    <div class="form-group">
                        <label for="update_nama">Nama:</label>
                        <input type="text" class="form-control" id="update_nama" name="update_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="update_tanggal_lahir">Tanggal Lahir:</label>
                        <input type="date" class="form-control" id="update_tanggal_lahir" name="update_tanggal_lahir" required>
                    </div>
                    <div class="form-group">
                        <label for="update_jenis_member">Jenis Member:</label>
                        <input type="text" class="form-control" id="update_jenis_member" name="update_jenis_member" required>
                    </div>
                    <div class="form-group">
                        <label for="update_no_telepon">No Telepon:</label>
                        <input type="text" class="form-control" id="update_no_telepon" name="update_no_telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="update_alamat">Alamat:</label>
                        <input type="text" class="form-control" id="update_alamat" name="update_alamat" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_member">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk tambah transaksi -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Add Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form tambah transaksi -->
                <form method="post" action="index.php">
                    <div class="form-group">
                        <label for="member_id">Select Member:</label>
                        <select class="form-control" id="member_id" name="member_id" required>
                            <?php
                            $sql_members = "SELECT * FROM members";
                            $result_members = $conn->query($sql_members);

                            if ($result_members->num_rows > 0) {
                                while ($row = $result_members->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="transaction_date">Transaction Date:</label>
                        <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="text" class="form-control" id="amount" name="amount" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_transaction">Add Transaction</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('.transaction-detail-link').click(function(e) {
        e.preventDefault();
        var memberId = $(this).data('member-id');
        $.ajax({
            url: 'get_transactions.php',
            type: 'POST',
            data: { member_id: memberId },
            success: function(response) {
                $('#transactionDetailContent').html(response);
                $('#transactionDetailModal').modal('show'); // Menampilkan modal setelah data diterima
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
    <script>
        // Mengisi form update member dengan data member yang dipilih
        $('.update-member-link').click(function () {
            var update_id = $(this).data('member-id');
            var update_nama = $(this).data('nama');
            var update_tanggal_lahir = $(this).data('tanggal-lahir');
            var update_jenis_member = $(this).data('jenis-member');
            var update_no_telepon = $(this).data('no-telepon');
            var update_alamat = $(this).data('alamat');

            $('#update_id').val(update_id);
            $('#update_nama').val(update_nama);
            $('#update_tanggal_lahir').val(update_tanggal_lahir);
            $('#update_jenis_member').val(update_jenis_member);
            $('#update_no_telepon').val(update_no_telepon);
            $('#update_alamat').val(update_alamat);
        });
</script>

</body>
</html>
