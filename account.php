<?php


function store($payload){
    require_once'../database.php';
    global $connection;
    $name = htmlspecialchars($payload['name']);
    $email = htmlspecialchars(string: $payload['email']);
    $password = $payload['password'];
    $passwordHashed = password_hash($password,PASSWORD_BCRYPT) ;
 
    $query = "INSERT INTO users (name, email, password) Values (?, ?,?)";         //sql inject res
    $stmt =$connection->prepare($query);
    $stmt->bind_param('sss', $name,$email, $passwordHashed );        //sss = string string string
    $stmt->execute();
 
    if($stmt->affected_rows > 0) {
        $stmt->close();
     header('Location: index.php');
     exit();
    } else {
        echo 'error to store user' . $stmt->error;
    }
}





?>