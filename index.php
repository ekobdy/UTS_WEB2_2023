<?php
require_once 'koneksi.php';
require_once 'model/Barang.php';
require_once 'model/Kategori.php';
require_once 'model/Supplier.php';

use \Model\Barang;
use \Model\Kategori;
use \Model\Supplier;

// proses pencarian barang
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $barang = new Barang();
    $data_barang = $barang->searchBarang($keyword);
} else {
    // tampilkan semua data barang
    $barang = new Barang();
    $data_barang = $barang->getAllBarang();
}

// proses tambah data barang
if (isset($_POST['submit_add'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];
    $nama_kategori = $_POST['nama_kategori'];
    $nama_supplier = $_POST['nama_supplier'];

    $barang = new Barang();
    $barang->setIdBarang($id_barang);
    $barang->setNamaBarang($nama_barang);
    $barang->setHarga($harga_barang);
    $barang->setKategori($nama_kategori);
    $barang->setSupplier($nama_supplier);

    if ($barang->tambahBarang()) {
        header('Location: index.php');
    } else {
        echo "Gagal menambah barang";
    }
}

// proses edit data barang
if (isset($_POST['submit_edit'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];
    $nama_kategori = $_POST['nama_kategori'];
    $nama_supplier = $_POST['nama_supplier'];

    $barang = new Barang();
    $barang->setIdBarang($id_barang);
    $barang->setNamaBarang($nama_barang);
    $barang->setHarga($harga_barang);
    $barang->setKategori($nama_kategori);
    $barang->setSupplier($nama_supplier);

    if ($barang->updateBarang()) {
        header('Location: index.php');
    } else {
        echo "Gagal mengupdate barang";
    }
}

// proses hapus data barang
if (isset($_POST['submit_delete'])) {
    $id_barang = $_POST['id_barang'];

    $barang = new Barang();
    $barang->setIdBarang($id_barang);

    if ($barang->hapusBarang()) {
        header('Location: index.php');
    } else {
        echo "Gagal menghapus barang";
    }
}

// check jika submit_edit_form di klik
if (isset($_POST['submit_edit_form'])) {
    // get id_barang dari selected row
    $id_barang = $_POST['id_barang'];
    // retrieve data of the selected row dari database
    $data_barang = $barang->getBarangById($id_barang);
    // retrieve data kategori dari database
    $kategori = new Kategori();
    $data_kategori = $kategori->getAllKategori();
    // retrieve data supplier dari database
    $supplier = new Supplier();
    $data_supplier = $supplier->getAllSupplier();
    
    
}

// proses tampilkan form edit jika id_barang di-set ver 2
if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];

    $barang = new Barang();
    $barang->setIdBarang($id_barang);

    $data_barang = $barang->getBarangById();
    $action = 'edit';
} else {
    $action = 'add';
}

$kategori = new Kategori();
$data_kategori = $kategori->getAllKategori();

$supplier = new Supplier();
$data_supplier = $supplier->getAllSupplier();
?>

<!DOCTYPE html>
<html>
<head>
    <title>2207101079_Eko Budiyanto_SI</title>
</head>
<body>
    
    <h3>UTS Web 2_2023_AUB</h3>
    <h3>Eko Budiyanto_2207101079_SI</h3>
    <h1>Form Add-Update Barang</h1>
    <form method="post" action="index.php">
        <label for="id_barang">Id Barang:</label>
        <input type="text" name="id_barang" value="<?= isset($barang) ? $barang->getIdBarang() : ''; ?>">
        <br>
        <label for="nama_barang">Nama Barang:</label>
        <input type="text" name="nama_barang" name="nama_barang" value="<?= isset($barang) ? $barang->getNamaBarang() : ''; ?>">
        <br>
        <label for="harga_barang">Harga:</label>
        <input type="text" name="harga_barang" name="harga_barang" value="<?= isset($barang) ? $barang->getHarga() : ''; ?>" step="0.01">
        <br>
        <label for="nama_kategori">Kategori:</label>
        <select name="nama_kategori" name="nama_kategori">
            
            <?php foreach($data_kategori as $kategori): ?>
                <option value="<?php echo $kategori->getIdKategori(); ?>" <?php if (isset($data_barang) && is_object($data_barang) && $kategori->getIdKategori() == $data_barang->getKategori()) echo 'selected'; ?>><?php echo $kategori->getNamaKategori(); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="nama_supplier">Supplier:</label>
        <select name="nama_supplier" name="nama_supplier">
            <?php foreach ($data_supplier as $supplier) { ?>
                <option value="<?php echo $supplier->getIdSupplier(); ?>" <?php if (isset($data_barang) && is_object($data_barang) && $supplier->getIdSupplier() == $data_barang->getSupplier()) echo 'selected'; ?>><?php echo $supplier->getNamaSupplier(); ?></option>
            <?php } ?>
        </select><br>
        
            <input type="submit" name="submit_add" value="Tambah">
            <input type="submit" name="submit_edit" value="Update">
            <input type="submit" name="cancel_edit" value="Cancel">
        
    </form>
    <br>


    <h1>Tabel Daftar Barang</h1>
    <form method="post" action="index.php">
        <input type="text" name="keyword">
        <input type="submit" name="search" value="Cari">
    </form>
    <br>
    <table border="1">
        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Aksi</th>
        </tr>
        <?php if (is_array($data_barang) || is_object($data_barang)) {
        foreach ($data_barang as $barang) {
            if (is_object($barang)) {?>
        <tr>
            <td><?php echo $barang->getIdBarang(); ?></td>
            <td><?php echo $barang->getNamaBarang(); ?></td>
            <td><?php echo $barang->getHarga(); ?></td>
            <td><?php echo $barang->getKategori(); ?></td>
            <td><?php echo $barang->getSupplier(); ?></td>
            <td>
                <form method="post" action="index.php">
                    <input type="hidden" name="id_barang" value="<?php echo $barang->getIdBarang(); ?>">
                    <input type="submit" name="submit_edit_form" value="Edit">
                    <input type="submit" name="submit_delete" value="Hapus">
                </form>
            </td>
        </tr>
    <?php } 
}
} else {
    echo "Lagi Proses Edit Data-Tabel Kosong Sementara";
}?>

    </table>
</body>
</html>
