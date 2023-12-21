<?php
include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $query = mysqli_query($conn, "SELECT * FROM orders WHERE assignto IS NULL");
    $num  = mysqli_num_rows($query);
    if($num < 1){
        echo json_encode(array("message"=>"No tasks available", "status"=>false));
        exit;
    }

   while($rows = mysqli_fetch_assoc($query)){
    $title =  $rows["title"];
    $subject = $rows["subject"];
    $subtime = $rows["subtime"];
    $subdate = $rows["subdate"];
    $type = $rows["type"];
    $orderId = $rows["orderId"];
    echo '<div class="order-item">
    <h2><a href="projectDetails.php?orderID='.$orderId.'">'.$title.'</a></h2>
    <h3><i class="fa-solid fa-money-bill"></i>Price: N'.$rows["price"].'</h3>
    <p><i class="fa-solid fa-book"></i>subject: computer science</p>
    <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
    
</div>
';
    
   }

   
}
?>