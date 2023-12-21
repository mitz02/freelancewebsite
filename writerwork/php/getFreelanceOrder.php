<?php
include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] =="POST"){
    $email = $_POST["data"];
    
    $query = mysqli_query($conn, "SELECT * FROM orders WHERE email='$email'");
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
        $status = $rows["status"];
        $checkOrderIdQuery =mysqli_query($conn, "SELECT  order_id FROM payment WHERE order_id='$orderId'");
        if(mysqli_num_rows($checkOrderIdQuery) < 1){
             // payment has not being made
             echo '<div class="order-item">
             <h2><a href="detail.php?orderID='.$orderId.'">'.$title.'</a></h2>
             <h3><i class="fa-solid fa-money-bill"></i>Price: N'.$rows["price"].'</h3>
             <p><i class="fa-solid fa-book"></i>subject: computer science</p>
             <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
             <p><a href=""><i class="fa-solid fa-pen-to-square"></i>Edit</a></p>
             <p><i class="fa-solid fa-list-check"></i>status: <a href="../payment/flutter/pay.php?orderID='.$orderId.'">Pay for this Order</a></p>
         </div>
     ';
            
           
        }else{
          // payment has being made
          if($status ==1){
            // order has being completed
            echo ' <div class="order-item">
            <h2><a href="detail.php?orderID='.$orderId.'">'.$title.'</a></h2>
            <h3><i class="fa-solid fa-money-bill"></i>Price: N'.$rows["price"].'</h3>
            <p><i class="fa-solid fa-book"></i>subject: computer science</p>
            <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
            <p><a href=""><i class="fas fa-comment-alt"></i>Chat</a></p>
            <p><i class="fa-solid fa-list-check"></i>status:completed</p>
        </div>';
        }elseif($status == 2){
            // orders has being accepted but working on
            echo ' <div class="order-item">
            <h2><a href="detail.php?orderID='.$orderId.'">'.$title.'</a></h2>
            <h3><i class="fa-solid fa-money-bill"></i>Price: N'.$rows["price"].'</h3>
            <p><i class="fa-solid fa-book"></i>subject: computer science</p>
            <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
            <p><i class="fas fa-comment-alt"></i>Chat</a></p>
            <p><i class="fa-solid fa-list-check"></i>status:Pending  (Order  accepted and working on)</p>
        </div>';

        }else{
            // orders has not being accepted
            echo ' <div class="order-item">
            <h2><a href="detail.php?orderID='.$orderId.'">'.$title.'</a></h2>
            <h3><i class="fa-solid fa-money-bill"></i>Price: N'.$rows["price"].'</h3>
            <p><i class="fa-solid fa-book"></i>subject: computer science</p>
            <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
            <p><a href=""><i class="fa-solid fa-pen-to-square"></i>Edit</a></p>
            <p><i class="fa-solid fa-list-check"></i>status:Pending  (Orders not yet accepted)</p>
        </div>';

        } 
        }
    
        
        
        
      
    }
}
?>