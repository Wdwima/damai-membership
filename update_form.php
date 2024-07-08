<form id="updateForm" action="index.php" method="post">
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
