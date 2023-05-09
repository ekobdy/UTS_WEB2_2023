<?php
namespace Model;
use Koneksi\Koneksi;
use Model\Kategori;
use Model\Supplier;

class Barang {
    protected $id_barang;
    protected $nama_barang;
    protected $harga_barang;
    protected $kategori;
    protected $supplier;
    protected $conn;

    public function __construct(){
        $this->conn = new Koneksi();
        $this->kategori = new Kategori();
        $this->supplier = new Supplier();
    }

    public function setIdBarang($id_barang){
        $this->id_barang = $id_barang;
    }

    public function setNamaBarang($nama_barang){
        $this->nama_barang = $nama_barang;
    }

    public function setHarga($harga_barang){
        $this->harga_barang = $harga_barang;
    }

    public function setKategori($id_kategori){
        $this->kategori->setIdKategori($id_kategori);
    }

    public function setSupplier($id_supplier){
        $this->supplier->setIdSupplier($id_supplier);
    }

    public function getIdBarang(){
        return $this->id_barang;
    }

    public function getNamaBarang(){
        return $this->nama_barang;
    }

    public function getKategori(){
        return $this->kategori->getNamaKategori();
    }

    public function getSupplier(){
        return $this->supplier->getNamaSupplier();
    }

    public function getHarga(){
        return $this->harga_barang;
    }

    public function getAllBarang()
    {
    $query = "SELECT barang.id_barang, barang.nama_barang, barang.harga_barang, kategori.nama_kategori, supplier.nama_supplier  FROM barang INNER JOIN kategori ON barang.id_kategori = kategori.id_kategori INNER JOIN supplier ON barang.id_supplier = supplier.id_supplier ORDER BY barang.id_barang DESC";

    $result = $this->conn->query($query);

    if (!$result) {
        die("Query error: " . $this->conn->error);
    }

    $barangs = array();

    while ($row = $result->fetch_assoc()) {
        $barang = new Barang();
        $barang->setIdBarang($row['id_barang']);
        $barang->setNamaBarang($row['nama_barang']);
        $barang->setHarga($row['harga_barang']);
        $barang->kategori->setNamaKategori($row['nama_kategori']);
        $barang->supplier->setNamaSupplier($row['nama_supplier']);
        $barangs[] = $barang;
    }

    return $barangs;
    }


    public function tambahBarang(){
        $query = "INSERT INTO barang(id_barang, nama_barang, harga_barang, id_kategori, id_supplier) VALUES ('".$this->id_barang."','".$this->nama_barang."', '".$this->harga_barang."', '".$this->kategori->getIdKategori()."', '".$this->supplier->getIdSupplier()."')";
        $result = $this->conn->query($query);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function getBarangById($id_barang){
        $query = "SELECT * FROM barang JOIN kategori ON barang.id_kategori=kategori.id_kategori JOIN supplier ON barang.id_supplier=supplier.id_supplier WHERE id_barang='".$id_barang."'";
        $result = $this->conn->query($query);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $this->setIdBarang($row['id_barang']);
            $this->setNamaBarang($row['nama_barang']);
            $this->setHarga($row['harga_barang']);
            $this->setKategori($row['id_kategori']);
            $this->setSupplier($row['id_supplier']);
            
            return true;
        }else{
            return false;
        }
    }

    public function updateBarang(){
        $query = "UPDATE barang SET nama_barang='".$this->nama_barang."', harga_barang='".$this->harga_barang."', id_kategori='".$this->kategori->getIdKategori()."', id_supplier='".$this->supplier->getIdSupplier()."' WHERE id_barang='".$this->id_barang."'";
        $result = $this->conn->query($query);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function hapusBarang(){
        $query = "DELETE FROM barang WHERE id_barang='".$this->id_barang."'";
        $result = $this->conn->query($query);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function searchBarang($keyword)
    {
    $query = "SELECT * FROM barang WHERE nama_barang LIKE '%{$keyword}%'";
    $result = $this->conn->query($query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}