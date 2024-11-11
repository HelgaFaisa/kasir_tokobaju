<?php
// Proses input form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_supplier = isset($_POST['id_supplier']) ? htmlspecialchars($_POST['id_supplier']) : null;
    $nama_supplier = htmlspecialchars($_POST['nama_supplier']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $telepon = htmlspecialchars($_POST['telepon']);

    try {
        if ($id_supplier) {
            // Update data
            $sql = 'UPDATE supplier SET nama_supplier = ?, alamat = ?, telepon = ? WHERE id_supplier = ?';
            $stmt = $config->prepare($sql);
            $stmt->execute([$nama_supplier, $alamat, $telepon, $id_supplier]);
            $message = 'Update Data Berhasil!';
        } else {
            // Insert data baru
            $sql = 'INSERT INTO supplier (nama_supplier, alamat, telepon) VALUES (?, ?, ?)';
            $stmt = $config->prepare($sql);
            $stmt->execute([$nama_supplier, $alamat, $telepon]);
            $message = 'Data berhasil disimpan!';
        }

        // Menampilkan notifikasi berhasil
        echo '<div class="alert alert-success text-center"><p>' . $message . '</p></div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger text-center"><p>Gagal menyimpan data: ' . htmlspecialchars($e->getMessage()) . '</p></div>';
    }
}

// Cek status penghapusan
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        echo '<div class="alert alert-success text-center"><p>Data berhasil dihapus!</p></div>';
    } elseif ($_GET['status'] === 'error') {
        echo '<div class="alert alert-danger text-center"><p>Gagal menghapus data!</p></div>';
    }
}

?>
<h4 style="text-align: center; color: #333;">Data Suppliers</h4>
<br />
<!-- Form Input Data Supplier -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5><?= !empty($_GET['uid']) ? 'Edit Supplier' : 'Tambah Supplier Baru'; ?></h5>
        </div>
        <div class="card-body">
            <?php 
            $nama_supplier = $alamat = $telepon = ''; 
            if (!empty($_GET['uid'])) {
                $id_supplier = intval($_GET['uid']);
                $sql = "SELECT * FROM supplier WHERE id_supplier = ?";
                $row = $config->prepare($sql);
                $row->execute([$id_supplier]);
                $edit = $row->fetch();

                if ($edit) {
                    $nama_supplier = $edit['nama_supplier'];
                    $alamat = $edit['alamat'];
                    $telepon = $edit['telepon'];
                }
            }
            ?>
            <form method="POST" action="">
                <?php if (!empty($edit)) { ?>
                    <input type="hidden" name="id_supplier" value="<?= $id_supplier; ?>">
                <?php } ?>
                <div class="form-group">
                    <label>Nama Supplier</label>
                    <input type="text" class="form-control" name="nama_supplier" value="<?= htmlspecialchars($nama_supplier); ?>" required placeholder="Masukkan Nama Supplier">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat" required placeholder="Masukkan Alamat"><?= htmlspecialchars($alamat); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="tel" class="form-control" name="telepon" value="<?= htmlspecialchars($telepon); ?>" required placeholder="Masukkan Telepon">
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> <?= !empty($edit) ? 'Update Data' : 'Tambah Data'; ?>
                </button>
            </form>
        </div>
    </div>
</div>

<br />
<!-- Tabel Data Supplier -->
<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="example1">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT * FROM supplier";
                $stmt = $config->prepare($sql);
                $stmt->execute();
                $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $no = 1;
                foreach ($hasil as $isi) {
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= htmlspecialchars($isi['nama_supplier']); ?></td>
                        <td><?= htmlspecialchars($isi['alamat']); ?></td>
                        <td><?= htmlspecialchars($isi['telepon']); ?></td>
                        <td class="text-center">
                            <a href="index.php?page=supplier&uid=<?= $isi['id_supplier']; ?>" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="fungsi/hapus/hapus.php?supplier=hapus&id=<?= $isi['id_supplier']; ?>" onclick="return confirm('Hapus Data Supplier?');" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>
