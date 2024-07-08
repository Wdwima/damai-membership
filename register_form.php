<form id="registerForm" action="index.php" method="post">
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
