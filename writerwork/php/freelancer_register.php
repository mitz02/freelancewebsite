<?php

include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $firstname= mysqli_escape_string($conn, $_POST["fname"]);
    $lastname = mysqli_escape_string($conn, $_POST["lname"]);
    $email = mysqli_escape_string($conn, $_POST["email"]);
    $password = mysqli_escape_string($conn, $_POST["password"]);
    $compassword= mysqli_escape_string($conn, $_POST["cpassword"]);
    $country = mysqli_escape_string($conn, $_POST["country"]);
    $state = mysqli_escape_string($conn, $_POST["password"]);
    $study = mysqli_escape_string($conn, $_POST["study"]);
    $hashedpassword  = password_hash($password, PASSWORD_BCRYPT);

    if($password != $compassword){
        echo json_encode(array("message"=>"password does not match", "status"=>false));
    exit; 
    }

   $sql ="SELECT * FROM freelancers WHERE email='$email'";
   $query = mysqli_query($conn, $sql);
   $num = mysqli_num_rows($query);
   if($num > 1){
    echo json_encode(array("message"=>"user already exist", "status"=>false));
    exit;
   }

   $sql = "INSERT INTO freelancers(fname, lname, email, password, country, state, study) 
values('$firstname', '$lastname', '$email', '$hashedpassword', '$country', '$state', '$study')";
mysqli_query($conn, $sql);
echo json_encode(array("message"=>"Account created successfully", "status"=>true));
exit;
   
}else{
    echo $_SERVER["REQUEST_METHOD"];
}