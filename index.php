<?php

include 'database/bd.php';
header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        $query="select * from task where id=".$_GET['id'];
        $response=getMethod($query);
        echo json_encode($response->fetch(PDO::FETCH_ASSOC));
    }else{
        $query="select * from task";
        $response=getMethod($query);
        echo json_encode($response->fetchAll()); 
    }
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='POST'){
    unset($_POST['METHOD']);
    $title=$_POST['title'];
    $description=$_POST['description'];
    $query="insert into task(title,description) values ('$title', '$description')";
    $queryAutoIncrement="select MAX(id) as id from task";
    $response=postMethod($query, $queryAutoIncrement);
    echo json_encode($response);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $title=$_POST['title'];
    $description=$_POST['description'];
    
    $query="UPDATE task SET title='$title', description='$description' WHERE id='$id'";
    $response=putMethod($query);
    echo json_encode($response);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $query="DELETE FROM task WHERE id='$id'";
    $response=deleteMethod($query);
    echo json_encode($response); //* parse an array to string whereas json_decode parse a string to array
    header("HTTP/1.1 200 OK");
    exit();
}
header("HTTP/1.1 400 Bad Request");
?>