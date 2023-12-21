<?php
session_start();
include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $email = mysqli_escape_string($conn, $_POST["email"]);
    $password = mysqli_escape_string($conn, $_POST["password"]);

$stmt = $conn->prepare("SELECT * FROM freelancers WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0){
    
    $rows = $result->fetch_assoc();
   $databasePassword = $rows["password"];
   if(password_verify($password, $databasePassword)){
    $_SESSION["email"] = $email;
    echo json_encode(array("message"=>"login successful!", "status"=>true));
    exit;
   }else{
    echo json_encode(array("message"=>"wrong password", "status"=>false));
    exit;
   }

   
    
}else{
    echo json_encode(array("message"=>"invalid credentials", "status"=>false));
    exit;
}


}else{
    echo $_SERVER["REQUEST_METHOD"];
}