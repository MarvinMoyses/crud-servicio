<?php 
include 'Conexion.php';

$PDO = new Conexion();

if($_SERVER ['REQUEST_METHOD'] == 'GET'){
    if(isset ($_GET['id'])){
    
    $sql = $PDO->prepare("call loginbd.sp_consultaUserID(:id)");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit; 
}else{
    
    $sql = $PDO->prepare("call sp_datosUser()");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit; 
    }   

}
if($_SERVER ['REQUEST_METHOD'] == 'POST'){
    $sql = "call loginbd.sp_InsertarUsuario(:nombre,:APaterno, :AMaterno, :email, :Telefono, :Status);";
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue (':nombre', $_POST ['nombre']);
    $stmt->bindValue (':APaterno', $_POST ['APaterno']);
    $stmt->bindValue (':AMaterno', $_POST ['AMaterno']);
    $stmt->bindValue (':email', $_POST ['email']);
    $stmt->bindValue (':Telefono', $_POST ['Telefono']);
    $stmt->bindValue (':Status', $_POST ['Status']);
    $id=  $_POST ['id'];
    $stmt->execute();
    $idPost = $PDO->lastInsertId();
    if($idPost){
        header("HTTP/1.1 200 hay datos");
        echo json_encode($idPost);
        exit;
    }
}
if($_SERVER ['REQUEST_METHOD'] == 'PUT'){
    $sql = "call loginbd.sp_ActualizarUsuario(:id,:nombre,:APaterno, :AMaterno, :email, :Telefono, :Status);";
    $stmt = $PDO -> prepare($sql);
    $stmt ->bindValue (':nombre', $_POST ['nombre']);
    $stmt ->bindValue (':APaterno', $_POST ['APaterno']);
    $stmt ->bindValue (':AMaterno', $_POST ['AMaterno']);
    $stmt ->bindValue (':email', $_POST ['email']);
    $stmt ->bindValue (':Telefono', $_POST ['Telefono']);
    $stmt ->bindValue (':Status', $_POST ['Status']);
    $stmt ->bindValue (':id', $_GET ['id']);
    $stmt ->execute();
        header("HTTP/1.1 200 hay datos");
        exit;
}
if($_SERVER ['REQUEST_METHOD'] == 'DELETE'){
    $sql = "call loginbd.sp_EliminarUsario(:id);";
    $stmt = $PDO -> prepare($sql);
    $stmt ->bindValue (':id', $_GET ['id']);
    $stmt ->execute();
        header("HTTP/1.1 200 hay datos");
        exit;
}
header("HTTP/1.1 400 Bad Request");
?>