<?php
require_once '../../libs/database.php';

class manageServiceModel{

    public $serviceID, $spID, $servicetype, $itemname, $itemprice, $itemimage;

    function addItem(){
        $sql = "insert into service(spID, servicetype, itemname, itemprice, itemimage) values(:spID, :servicetype, :itemname, :itemprice, :itemimage)";
        $args = [':spID'=>$this->spID, ':servicetype'=>$this->servicetype, ':itemname'=>$this->itemname, ':itemprice'=>$this->itemprice, ':itemimage'=>$this->itemimage];
        $stmt = DB::run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function deleteItem(){
        $sql = "delete from service where serviceID=:serviceID";
        $args = [':serviceID'=>$this->serviceID];
        return DB::run($sql,$args);
    }

    function viewAllItem(){
        $sql = "select * from service where spID=:spID ORDER BY servicetype";
        $args = [':spID'=>$this->spID];
        return DB::run($sql, $args);
    }

    function viewPerItem(){
        $sql = "select * from service where serviceID=:serviceID";
        $args = [':serviceID'=>$this->serviceID];
        return DB::run($sql,$args);
    }
    
    function updateItem(){
        $sql = "UPDATE service SET itemname = :itemname, itemprice = :itemprice, servicetype = :servicetype";
        $args = [
            ':itemname' => $this->itemname,
            ':itemprice' => $this->itemprice,
            ':servicetype' => $this->servicetype,
            ':serviceID' => $this->serviceID
        ];
    
        // Check if a new image is provided
        if (!empty($this->itemimage)) {
            $sql .= ", itemimage = :itemimage";
            $args[':itemimage'] = $this->itemimage;
        }
    
        $sql .= " WHERE serviceID = :serviceID";
        
        return DB::run($sql, $args);
    } 
}
?>
