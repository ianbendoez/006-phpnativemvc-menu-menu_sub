<?php 
class db extends dbconn {

    public function __construct()
    {
        $this->initDBO();
    }
    
    // -- START -- SELECT
    public function cekMenusUser($username,$id_menus)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "SELECT
                      tbl_users_menus.*,
                      tbl_menus.nama_menus,
                      tbl_menus.keterangan,
                      tbl_menus.status 
                    FROM
                      tbl_users_menus
                      INNER JOIN tbl_menus ON tbl_users_menus.id_menus = tbl_menus.id_menus
                    WHERE
                      tbl_users_menus.username = :username AND tbl_users_menus.id_menus = :id_menus AND tbl_menus.status = 'a' 
                    ";
            $stmt = $db->prepare($query);
            $stmt->bindParam("username",$username);
            $stmt->bindParam("id_menus",$id_menus);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stat[2] = $stmt->rowCount();
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }

    public function getReferensi($kode,$item)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "SELECT * FROM tbl_referensi WHERE kode = :kode AND item = :item";
            $stmt = $db->prepare($query);
            $stmt->bindParam("kode",$kode);
            $stmt->bindParam("item",$item);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stat[2] = $stmt->rowCount();
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }

    public function getReferensiByKode($kode)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "SELECT * FROM tbl_referensi WHERE kode = :kode AND status = 'a'";
            $stmt = $db->prepare($query);
            $stmt->bindParam("kode",$kode);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stat[2] = $stmt->rowCount();
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }

    public function getTable($kriteria)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "SELECT * FROM tbl_menu_sub WHERE id_menu_sub LIKE '%$kriteria%' OR nama_menu_sub LIKE '%$kriteria%' ORDER BY LENGTH(id_menu) ASC, id_menu ASC, LENGTH(urut_menu_sub) ASC, urut_menu_sub ASC LIMIT 100";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stat[2] = $stmt->rowCount();
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }

    public function getDataById($id)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "SELECT * FROM tbl_menu_sub WHERE id_menu_sub = :id  LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->bindParam("id",$id);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stat[2] = $stmt->rowCount();
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }

    public function getMenuById($id)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "SELECT * FROM tbl_menu WHERE id_menu = :id_menu";
            $stmt = $db->prepare($query);
            $stmt->bindParam("id_menu",$id);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stat[2] = $stmt->rowCount();
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }

    public function getMenu()
    {
        $db = $this->dblocal;
        try
        {   
            $query = "SELECT * FROM tbl_menu ORDER BY nama_menu ASC";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stat[2] = $stmt->rowCount();
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }
    // -- END -- SELECT

    // -- START -- DELETE
    public function delete($id)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "DELETE FROM tbl_menu_sub WHERE id_menu_sub = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam("id",$id);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = "HAPUS!";
            $stat[2] = "Data berhasil dihapus.";
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = "HAPUS!";
            $stat[2] = $ex->getMessage();
            return $stat;
        }
    }
    // -- END -- DELETE

    // -- START -- CREATE
    public function create($nama_menu_sub,$urut_menu_sub,$icon_menu_sub,$id_menu)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "INSERT INTO tbl_menu_sub (nama_menu_sub, urut_menu_sub, icon_menu_sub, id_menu) VALUES (:nama_menu_sub, :urut_menu_sub, :icon_menu_sub, :id_menu)";
            $stmt = $db->prepare($query);
            $stmt->bindParam("nama_menu_sub",$nama_menu_sub);
            $stmt->bindParam("urut_menu_sub",$urut_menu_sub);
            $stmt->bindParam("icon_menu_sub",$icon_menu_sub);
            $stmt->bindParam("id_menu",$id_menu);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = "TAMBAH!";
            $stat[2] = "Data berhasil ditambahkan.";
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = "TAMBAH!";
            $stat[2] = $ex->getMessage();
            return $stat;
        }
    }
    // -- END -- CREATE

    // -- START -- UPDATE
    public function update($id,$nama_menu_sub,$urut_menu_sub,$icon_menu_sub,$id_menu)
    {
        $db = $this->dblocal;
        try
        {   
            $query = "UPDATE tbl_menu_sub SET nama_menu_sub = :nama_menu_sub, urut_menu_sub = :urut_menu_sub, icon_menu_sub = :icon_menu_sub, id_menu = :id_menu WHERE id_menu_sub = :id_menu_sub";
            $stmt = $db->prepare($query);
            $stmt->bindParam("id_menu_sub",$id);
            $stmt->bindParam("nama_menu_sub",$nama_menu_sub);
            $stmt->bindParam("urut_menu_sub",$urut_menu_sub);
            $stmt->bindParam("icon_menu_sub",$icon_menu_sub);
            $stmt->bindParam("id_menu",$id_menu);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = "EDIT!";
            $stat[2] = "Data berhasil dirubah.";
            return $stat;
        }
        catch(PDOException $ex)
        {
            $stat[0] = false;
            $stat[1] = "EDIT!";
            $stat[2] = $ex->getMessage();
            return $stat;
        }
    }
    // -- END -- UPDATE

}