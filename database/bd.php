<?php

  $pdo = null;
  $host = "localhost";
  $user = "root";
  $password = "";
  $db = "to_do_list";

  function connect(){
    try{
      $GLOBALS['pdo'] = new PDO('mysql:host='.$GLOBALS['host'].";dbname=".$GLOBALS['db']."",$GLOBALS['user'], $GLOBALS['password']);
      $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('Error: No se puede conectar a la bd');
    }
  }
  function disconnect(){
    $GLOBALS['pdo'] = null;
  }
  function getMethod($query){
    try{
      connect();
      $statement = $GLOBALS['pdo']->prepare($query);
      $statement->setFetchMode(PDO::FETCH_ASSOC);
      $statement->execute();
      disconnect();
      return $statement;
    }catch(Exception $e){
      die('Error'.$e);
    }
  }
  function postMethod($query, $queryAutoIncrement){
    try{
      connect();
      $statement = $GLOBALS['pdo']->prepare($query);
      $statement->execute();
      $idAutoIncrement = getMethod($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
      $response = array_merge($idAutoIncrement,$_POST);
      $statement->closeCursor();
      disconnect();
      return $statement;
    }catch(Exception $e){
      die('Error'.$e);
    }
  }
  function putMethod($query){
    try{
        connect();
        $statement=$GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $resultado=array_merge($_GET, $_POST);
        $statement->closeCursor();
        disconnect();
        return $resultado;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function deleteMethod($query){
    try{
      connect();
      $statement=$GLOBALS['pdo']->prepare($query);
      $statement->execute();
      $statement->closeCursor();
      disconnect();
      return $_GET['id'];
    }catch(Exception $e){
        die("Error: ".$e);
    }
}
?>