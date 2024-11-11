<?php 
session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';

    // Fungsi Hapus Kategori
    if (!empty(htmlentities($_GET['kategori']))) {
        $id = htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM kategori WHERE id_kategori=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&remove=hapus-data"</script>';
    }

    // Fungsi Hapus Barang
    if (!empty(htmlentities($_GET['barang']))) {
        $id = htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM barang WHERE id_barang=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=barang&&remove=hapus-data"</script>';
    }

    // Fungsi Hapus Penjualan Tertentu
    if (!empty(htmlentities($_GET['jual']))) {
        $dataI[] = htmlentities($_GET['brg']);
        $sqlI = 'SELECT * FROM barang WHERE id_barang=?';
        $rowI = $config->prepare($sqlI);
        $rowI->execute($dataI);
        $hasil = $rowI->fetch();

        $id = htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM penjualan WHERE id_penjualan=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=jual"</script>';
    }

    // Fungsi Hapus Semua Penjualan
    if (!empty(htmlentities($_GET['penjualan']))) {
        $sql = 'DELETE FROM penjualan';
        $row = $config->prepare($sql);
        $row->execute();
        echo '<script>window.location="../../index.php?page=jual"</script>';
    }

    // Fungsi Hapus Semua Laporan
    if (!empty(htmlentities($_GET['laporan']))) {
        $sql = 'DELETE FROM nota';
        $row = $config->prepare($sql);
        $row->execute();
        echo '<script>window.location="../../index.php?page=laporan&remove=hapus"</script>';
    }

// Fungsi Hapus Supplier
if (!empty(htmlentities($_GET['supplier']))) {
    $id = htmlentities($_GET['id']);  // Pastikan ID diambil dengan aman

    try {
        // Siapkan data untuk query
        $data[] = $id;
        $sql = 'DELETE FROM supplier WHERE id_supplier=?';
        $row = $config->prepare($sql);
        $row->execute($data);

        // Mengarahkan kembali ke halaman supplier setelah penghapusan
        echo '<script>window.location="../../index.php?page=supplier&&remove=hapus-data"</script>';
    } catch (Exception $e) {
        // Menampilkan pesan error jika gagal menghapus
        echo '<script>alert("Gagal menghapus supplier: ' . $e->getMessage() . '"); window.location="../../index.php?page=supplier"</script>';
    }
}


}
?>
