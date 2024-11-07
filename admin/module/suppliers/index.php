<h4 style="text-align: center; color: #333;">Data Suppliers</h4>
<br />
<?php if (isset($_GET['success']) && $_GET['success'] == 'tambah-data') { ?>
    <div class="alert alert-success text-center">
        <p>Data berhasil disimpan!</p>
    </div>
<?php } ?>
<?php if (isset($_GET['success-edit'])) { ?>
    <div class="alert alert-success text-center">
        <p>Update Data Berhasil!</p>
    </div>
<?php } ?>
<?php if (isset($_GET['remove'])) { ?>
    <div class="alert alert-danger text-center">
        <p>Hapus Data Berhasil!</p>
    </div>
<?php } ?>

<!-- Form Input Data Supplier -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5><?= !empty($_GET['uid']) ? 'Edit Supplier' : 'Tambah Supplier Baru'; ?></h5>
        </div>
        <div class="card-body">
            <?php 
            // Inisialisasi variabel form input kosong secara default
            $nama_supplier = $alamat = $telepon = ''; 
            if (!empty($_GET['uid'])) {
                $id_supplier = intval($_GET['uid']); // Pastikan integer untuk mencegah SQL injection
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
            <!-- Form untuk input atau edit supplier -->
            <form method="POST" action="<?= !empty($edit) ? 'fungsi/edit/edit.php?supplier=edit' : 'fungsi/tambah/tambah.php?supplier=tambah'; ?>">
                <?php if (!empty($edit)) { ?>
                    <!-- Menambahkan input hidden untuk id_supplier -->
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
                // Mengambil data supplier dari database
                $sql = "SELECT * FROM supplier";
                $stmt = $config->prepare($sql);
                $stmt->execute();
                $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Menampilkan data ke tabel
                $no = 1;
                foreach ($hasil as $isi) {
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= htmlspecialchars($isi['nama_supplier']); ?></td>
                        <td><?= htmlspecialchars($isi['alamat']); ?></td>
                        <td><?= htmlspecialchars($isi['telepon']); ?></td>
                        <td class="text-center">
                            <!-- Link edit dengan parameter uid=id_supplier -->
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
