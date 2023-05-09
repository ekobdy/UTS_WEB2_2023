<?php
namespace Model;
use Koneksi\Koneksi;

class Supplier {
    protected $id_supplier;
    protected $nama_supplier;
    protected $conn;

    public function __construct(){
        $this->conn = new Koneksi();
    }

    public function setIdSupplier($id_supplier){
        $this->id_supplier = $id_supplier;
    }

    public function setNamaSupplier($nama_supplier){
        $this->nama_supplier = $nama_supplier;
    }

    public function getIdSupplier(){
        return $this->id_supplier;
    }

    public function getNamaSupplier(){
        return $this->nama_supplier;
    }

    public function getAllSupplier(){
        $query = "SELECT * FROM supplier";
        $result = $this->conn->query($query);

        if($result->num_rows > 0){
            $data = array();
            while($row = $result->fetch_assoc()){
                $supplier = new Supplier();
                $supplier->setIdSupplier($row['id_supplier']);
                $supplier->setNamaSupplier($row['nama_supplier']);
                $data[] = $supplier;
            }
            return $data;
        }else{
            return false;
        }
    }
}
