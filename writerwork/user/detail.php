<?php
session_start();
include "../include/connections.php";

if(!isset( $_SESSION["email"])){
  header("location: ../pages/login.html?user=not-set");
  exit;
}
$email = $_SESSION["email"];
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$num  = mysqli_num_rows($query );
if($num < 1){
  header("location: ../pages/login.html?user=not-set");
  exit;
}

if(!isset($_GET['orderID'])){
   echo "NO ORDERS FOUND";
   exit;
}
$orderId = $_GET['orderID'];
$checkQuery = mysqli_query($conn, "SELECT * FROM orders WHERE email='$email' AND orderId='$orderId'");
if(mysqli_num_rows($checkQuery) < 1){
    echo "NO ORDERS FOUND";  
    exit;
}
$row = mysqli_fetch_assoc($checkQuery);
$title= $row['title'];
$des= $row['description'];
// $title= $row['title'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assignment details-Show details view of student assignment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
        *{
            margin:  0;
            padding: 0;
            text-decoration: none;
            
        }
        body{
            position: relative;
        }
        body, div, p {
  box-sizing: border-box;
}
        header{
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 13px;
            background: white;
            position: sticky;
      top: 0;
      margin-bottom: 20px;
      z-index: 100;
            
        }
        header .navigation{ 
          display: flex;
          align-items: center;
          justify-content: space-between;

       width: 90%;
       max-width: 1200px;
          margin:  0 auto;
        }
        header nav a{
            margin:  0 20px;
            color: #106d46;
        }
        .logo img{
    height: 30px;
    width: 300px;
}
.content{
    max-width: 800px;
    margin:  0 auto;
    width: 90%;
    box-shadow: 0 0 4px rgba(0,0,0,0.1);
    padding: 30px;
}
.content h2{
    margin-bottom: 20px;
}
.content p{
    margin-bottom: 20px;
    line-height: 27px;
}
.content button{
    padding: 8px 40px;
    border: none;
    border-radius: 2px;
}
.content button{
    background:red;
    color:white;
}
.content button:first-of-type{
    background:#106d46;
    color:white;
}
   
   </style>
<body>
<main>
<header>
        <div class="navigation">
            <div class="logo"><img src="../img/gigger2.png" alt=""></div>
        <nav>
            <a href="">home</a>
            <a href="">services</a>
            <a href="">About</a>
            <a href="">Contact</a>
        </nav>
        <div class="right-side">
            <a href="pages/login.html">Login <span><i class="fa fa-sign-in" aria-hidden="true"></i></span></a>
            <a href="pages/register.html">Signup</a>
        </div>
        </div>
    </header>
    <div class="content">
        <h2><?php echo $title;?></h2>
        <p><?php echo $des;?></p>
        <div class="btn">
            <button><i class="fa-solid fa-pen-to-square"></i>Edit</button>
            <button><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
        </div>
    </div>
</main>
</body>
</html>