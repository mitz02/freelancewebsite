<?php
include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] =="POST"){
    $email = $_POST["data"];
    
    $query = mysqli_query($conn, "SELECT * FROM orders WHERE assignto='$email' AND status =1");
    $num = mysqli_num_rows($query);
    if($num < 1){
        echo "empty";
        exit;
    }
    while($rows = mysqli_fetch_assoc($query)){
        $title =$rows["title"];
        $subject =$rows["subject"];
        $subdate =$rows["subdate"];
        $type =$rows["type"];
        $orderId =$rows["orderId"];
        echo '<div class="order-item">
        <h2>'.$title.'</h2>
        <h3><i class="fa-solid fa-money-bill"></i>Price: N'.$rows["price"].'</h3>
        <p><i class="fa-solid fa-book"></i>subject: computer science</p>
        <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
        <p><a href=""><i class="fa-solid fa-pen-to-square"></i>Edit</a></p>
        <p><i class="fa-solid fa-list-check"></i>status: <a href="">Pay for this Order</a></p>
    </div>
';
    }
}
?>