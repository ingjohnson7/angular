<?php

if (isset($_POST) && $_POST['action'] != '') {

    try{
        $con = new PDO('mysql:host=localhost;dbName=angular_p', 'root', '');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e)
    {
        return "Error: " . $e->getMessage();
    }

    if($_POST['action'] == 'insert') {
        $data = cleanFields();
        try{
            $query = "INSERT INTO clients VALUES (:name, :lastName, :phone, :registerDate)";    
            $stm = $con->prepare($query);
            $stm->bindParam(':name', $data['name']);
            $stm->bindParam(':lastName', $data['lastName']);
            $stm->bindParam(':phone', $data['phone']);
            $stm->bindParam(':registerDate', date('Y-m-d s-i-H'));
            $stm->execute();
    
            return "Client added correctly";
        }catch(PDOException $e){
            return "Error saving client: " . $e->getMessage();
        }

    } else if($_POST['action'] == 'select') {
        try{
            $query = "SELECT * FROM clients";    
            $stm = $con->query($query);
            $result = $stm->exec();
    
            return $result;
        }catch(PDOException $e){
            return "Error saving client: " . $e->getMessage();
        }
    }


}

function cleanFields() {
    $data = [];
    foreach($_POST as $key => $value) {
        $value = htmlspecialchars(trim($value));
        $data[$key] = $value;
    }
    return $data;
}