<?php
namespace Model;
use Koneksi\Koneksi;

class Kategori {
    protected $id_kategori;
    protected $nama_kategori;
    protected $conn;

    public function __construct(){
        $this->conn = new Koneksi();
    }

    public function setIdKategori($id_kategori){
        $this->id_kategori = $id_kategori;
    }

    public function setNamaKategori($nama_kategori){
        $this->nama_kategori = $nama_kategori;
    }

    public function getIdKategori(){
        return $this->id_kategori;
    }

    public function getNamaKategori(){
        return $this->nama_kategori;
    }

    public function getAllKategori(){
        $query = "SELECT * FROM kategori";
        $result = $this->conn->query($query);

        if($result->num_rows > 0){
            $data = array();
            while($row = $result->fetch_assoc()){
                $kategori = new Kategori();
                $kategori->setIdKategori($row['id_kategori']);
                $kategori->setNamaKategori($row['nama_kategori']);
                $data[] = $kategori;
            }
            return $data;
        }else{
            return false;
        }
    }
}
