<?php
include "../include/connections.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"];
    $query = mysqli_query($conn, "SELECT * FROM orders WHERE orderId='$id'");
    $num  = mysqli_num_rows($query);
    if($num < 1){
        echo "Order Not available";
        exit;
    }

    
   $rows = mysqli_fetch_assoc($query);
   $title = $rows['title'];
   $desc = $rows["description"];
   $subject= $rows["subject"];
   $subdate = $rows["subdate"];
   $orderId = $rows["orderId"];
    echo'
    <div>
    <div class="time">
    <span><i class="fa-solid fa-clock fa-beat"></i></span>
    <p>Must be submitted before: '.$subdate.'</p>

   
</div>
<div class="price">
    <span><i class="fa-solid fa-naira-sign"></i></span>
    <h3>45000</h3>
</div>

<h3>'.$title.'</h3>
<h4>INSTRUCTIONS</h4>
<p>'.$desc.'</p>
<div class="modal-btn">
<button onclick=acceptOrder("'.$orderId.'")>Accept project</button>
<button onclick=closeModal();>Close</button>
</div>
</div>

    ';
   

   
}
?>