<?php

include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysqli_escape_string($conn, $_POST["email"]);
    $password = mysqli_escape_string($conn, $_POST["password"]);
    $compassword= mysqli_escape_string($conn, $_POST["cpassword"]);
    $hashedpassword  = password_hash($password, PASSWORD_BCRYPT);

    if($password != $compassword){
        echo json_encode(array("message"=>"password does not match", "status"=>false));
    exit; 
    }

   $sql ="SELECT * FROM users WHERE email='$email'";
   $query = mysqli_query($conn, $sql);
   $num = mysqli_num_rows($query);
   if($num > 1){
    echo json_encode(array("message"=>"user already exist", "status"=>false));
    exit;
   }

   $sql = "INSERT INTO users (email, password) 
values('$email', '$hashedpassword')";
mysqli_query($conn, $sql);
echo json_encode(array("message"=>"Account created successfully", "status"=>true));
exit;
   
}