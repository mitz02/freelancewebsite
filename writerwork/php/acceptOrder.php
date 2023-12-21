<?php
include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"];
    $email = $_POST["email"];
    $checkQuery = mysqli_query($conn, "SELECT * FROM orders WHERE assignto='$email'");
   if(mysqli_num_rows($checkQuery) > 0){
    echo "you have an incompleted order";
    exit;
   }
    $query = mysqli_query($conn, "SELECT * FROM orders WHERE orderId='$id'");
    $num = mysqli_num_rows($query);
    if($num > 0){
       $row = mysqli_fetch_assoc($query);
       if($row["assignto"] == NULL){
        mysqli_query($conn, "UPDATE orders SET assignto='$email' WHERE orderId='$id'");
        echo "order accepted!";
        exit;
       }else{
        echo "Order Already Accepted by Another freelancer";
       }
    }else{
        echo '<h2>Order does not exist</h2>';
        exit;
    }
   
 
   
}
?>