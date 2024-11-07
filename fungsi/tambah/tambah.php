<?php
session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    
    // Tambah kategori
    if (!empty($_GET['kategori'])) {
        $nama = htmlentities($_POST['kategori']);
        $tgl = date("j F Y, G:i");
        $data[] = $nama;
        $data[] = $tgl;
        $sql = 'INSERT INTO kategori (nama_kategori, tgl_input) VALUES (?, ?)';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&success=tambah-data"</script>';
    }

    // Tambah barang
    if (!empty($_GET['barang'])) {
        $id = htmlentities($_POST['id']);
        $kategori = htmlentities($_POST['kategori']);
        $nama = htmlentities($_POST['nama']);
        $beli = htmlentities($_POST['beli']);
        $jual = htmlentities($_POST['jual']);
        $satuan = htmlentities($_POST['satuan']);
        $stok = htmlentities($_POST['stok']);
        $tgl = htmlentities($_POST['tgl']);

        $data[] = $id;
        $data[] = $kategori;
        $data[] = $nama;
        $data[] = $beli;
        $data[] = $jual;
        $data[] = $satuan;
        $data[] = $stok;
        $data[] = $tgl;
        $sql = 'INSERT INTO barang (id_barang, id_kategori, nama_barang, harga_beli, harga_jual, satuan_barang, stok, tgl_input) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=barang&success=tambah-data"</script>';
    }
    
    // Tambah penjualan
    if (!empty($_GET['jual'])) {
        $id = $_GET['id'];

        // Get tabel barang id_barang
        $sql = 'SELECT * FROM barang WHERE id_barang = ?';
        $row = $config->prepare($sql);
        $row->execute(array($id));
        $hsl = $row->fetch();

        if ($hsl['stok'] > 0) {
            $kasir = $_GET['id_kasir'];
            $jumlah = 1;
            $total = $hsl['harga_jual'];
            $tgl = date("j F Y, G:i");

            $data1[] = $id;
            $data1[] = $kasir;
            $data1[] = $jumlah;
            $data1[] = $total;
            $data1[] = $tgl;

            $sql1 = 'INSERT INTO penjualan (id_barang, id_member, jumlah, total, tanggal_input) VALUES (?, ?, ?, ?, ?)';
            $row1 = $config->prepare($sql1);
            $row1->execute($data1);

            echo '<script>window.location="../../index.php?page=jual&success=tambah-data"</script>';
        } else {
            echo '<script>alert("Stok Barang Anda Telah Habis !");
                    window.location="../../index.php?page=jual#keranjang"</script>';
        }
    }
 // Tambah supplier
 if (!empty($_GET['supplier'])) {
    $nama = htmlentities($_POST['nama_supplier']);
    $alamat = htmlentities($_POST['alamat']);
    $telepon = htmlentities($_POST['telepon']);

    // Buat array data untuk disisipkan
    $data = [$nama, $alamat, $telepon];

    try {
        $sql = 'INSERT INTO supplier (nama_supplier, alamat, telepon) VALUES (?, ?, ?)';
        $stmt = $config->prepare($sql);
        $stmt->execute($data);

        // Redirect ke halaman index dengan parameter success
        header('Location: ../../index.php?page=supplier&success=tambah-data');
        exit; // Pastikan exit di sini
    } catch (Exception $e) {
        // Menampilkan pesan kesalahan
        header('Location: ../../index.php?page=supplier&error=' . urlencode($e->getMessage()));
        exit; // Pastikan exit di sini
    }
}


}
