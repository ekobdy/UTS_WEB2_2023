

<h1>Form Edit Barang</h1>
    <form action="index.php" method="POST">
    <input type="hidden" id="id_barang" name="id_barang" value="<?php echo isset($data_barang['id_barang']) ? $data_barang['id_barang'] : ''; ?>">
    <label for="nama_barang">Nama Barang</label>
    <input type="text" id="nama_barang" name="nama_barang" value="<?php echo isset($data_barang['nama_barang']) ? $data_barang['nama_barang'] : ''; ?>">
    <br>
    <label for="harga_barang">Harga Barang</label>
    <input type="number" id="harga_barang" name="harga_barang" value="<?php echo isset($data_barang['harga_barang']) ? $data_barang['harga_barang'] : ''; ?>">
    <br>
    <label for="nama_kategori">Kategori Barang</label>
    <select id="nama_kategori" name="nama_kategori">
        <?php foreach ($data_kategori as $kategori): ?>
        <option value="<?php echo $kategori->getIdKategori(); ?>" <?php if (isset($data_barang) && is_object($data_barang) && $kategori->getIdKategori() == $data_barang->getKategori()) echo 'selected'; ?>><?php echo $kategori->getNamaKategori(); ?>
                </option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="nama_supplier">Supplier Barang</label>
    <select id="nama_supplier" name="nama_supplier">
        <?php foreach ($data_supplier as $supplier): ?>
        <option value="<?php echo $supplier->getIdSupplier(); ?>" <?php if (isset($data_barang) && is_object($data_barang) && $supplier->getIdSupplier() == $data_barang->getSupplier()) echo 'selected'; ?>><?php echo $supplier->getNamaSupplier(); ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <button type="submit" name="submit_edit" value="submit_edit">Update</button>
    <button type="submit" name="cancel_edit" value="cancel_edit">Cancel</button>
</form>
<br>