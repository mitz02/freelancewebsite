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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>writerGig: freelancing platforms that allows you to do student assignment, projects</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        .content{
            display: flex;
            width: 90%;
            margin:  0 auto;
            max-width: 1200px;
            height: 85vh;
            align-items: center;
            justify-content: center;
           
        }
        .top-content{
            background: #f8fcfa;
            background:  url(img/5073414.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .content img{
            max-width: 100%;
        }
        .right-content{
            position: relative;
            
            flex: 4;
        }
        .left-content{
        
            flex: 3;
        }
        .first-img, .second-img{
            width: 350px;
           
        }
        .first-img{
            position: absolute;
           bottom: 30px;
           right: 0;
            
        }
        .content h1{
            color: #17f89a;;
        }
        .why-wrapper{
            width: 80%;
            margin: 0 auto;
            display: flex;
         
            padding: 60px 0;
        }
        .left-wrapper, .right-wrapper{
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .why-item{
            margin-bottom: 30px;
          
        }
        .advice{
          
        }

        .advice-wrapper{
            width: 90%;
            margin: 0 auto;
            display: flex;
            padding: 60px 0;
            height: 80vh;
        }
    .advice-left h2{
        color: #cbfce8;
    }

    .advice-left h2{
        margin-bottom: 30px;
    }
    .advice-left h1{
        font-size: 40px;
    }
        .advice-left{
            flex: 5;
            background: #106d46;
            color: white;
            height: 100%;
            box-sizing: border-box;
            padding: 10px 0 0 10px;
        }

        .advice-right{
           flex: 3; 
           height: 100%;
        
        }
        .advice-right img{
            height: 100%;
            max-width: 100%;
        }

.logo img{
    height: 30px;
    width: 300px;
}
.order-container{
    width: 90%;
    /* margin:  0 auto; */
    width: 90%;
    max-width: 800px;
    margin-left: 100px;
}
.order-item i{
    margin-right: 10px;
    font-size: 16px;
    color: #106d46;
   
}
.order-item p, .order-item h3{
    margin-bottom: 10px;
}
.order-item{
    margin-bottom: 20px;
    box-shadow:  0 0 2px rgba(0,0,0,0.1);
    padding: 10px;
    max-width: 770px;
}
.order-item .fa-clock{
    color: orangered;
}
.order{
    position: relative;
}
.order .sidebar{
    position: fixed;
    right: 100px;
    top: 15%;
    width: 200px;
    /* background: #106d46; */
    height: 300px;
    display: flex;
    flex-direction: column;
    text-align: center;
    justify-content: center;
    padding: 10px;

}

.sidebar button{
    
    color:  #f3f4f5;
   width: 100%;
   padding: 10px;
   border: none;
   margin-bottom: 10px;
   font-size: 16px;
   color: #106d46;
   
}


.sidebar button.active{
    background:#f2f3f4f5;
    border-width: 2px;
   border-style: solid;
    color:  orangered;
    border-top-color: red;
    border-bottom-color: #106d46;
}
.ordercontainer{
    display: none;
}
.ordercontainer0.active, .ordercontainer1.active, .ordercontainer2.active{
    display: block;
}
.order-item a{
    color: #106d46;
}

    </style>

</head>
<body>
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
    <main>
       <div class="order">
        
       <div class="sidebar">
            <button class="active">All orders</button>
            <button>Completed orders</button>
            <button>Revision Orders</button>
         </div>
         <!-- all orders start -->
         <div class="order-container ordercontainer ordercontainer0 active"> 
         <div class="order-item">
                 <h2>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Unde, placeat?</h2>
                 <h3><i class="fa-solid fa-money-bill"></i>Price: N340</h3>
                 <p><i class="fa-solid fa-book"></i>subject: computer science</p>
                 <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
                 <p><a href=""><i class="fa-solid fa-pen-to-square"></i>Edit</a></p>
                 <p><i class="fa-solid fa-list-check"></i>status: <a href="">Pay for this Order</a></p>
             </div>

             <div class="order-item">
                 <h2>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Unde, placeat?</h2>
                 <h3><i class="fa-solid fa-money-bill"></i>Price: N340</h3>
                 <p><i class="fa-solid fa-book"></i>subject: computer science</p>
                 <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
                 <p><a href=""><i class="fa-solid fa-pen-to-square"></i>Edit</a></p>
                 <p><i class="fa-solid fa-list-check"></i>status:Pending  (Orders not yet accepted)</p>
             </div>

             
             <div class="order-item">
                 <h2>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Unde, placeat?</h2>
                 <h3><i class="fa-solid fa-money-bill"></i>Price: N340</h3>
                 <p><i class="fa-solid fa-book"></i>subject: computer science</p>
                 <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
                 <p><i class="fas fa-comment-alt"></i>Chat</a></p>
                 <p><i class="fa-solid fa-list-check"></i>status:Pending  (Order  accepted and working on)</p>
             </div>

             
             <div class="order-item">
                 <h2>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Unde, placeat?</h2>
                 <h3><i class="fa-solid fa-money-bill"></i>Price: N340</h3>
                 <p><i class="fa-solid fa-book"></i>subject: computer science</p>
                 <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
                 <p><a href=""><i class="fas fa-comment-alt"></i>Chat</a></p>
                 <p><i class="fa-solid fa-list-check"></i>status:completed</p>
             </div>
         </div>

       <!-- all orders ends-->

     <!-- completed orders start -->   
 <div class="order-container ordercontainer ordercontainer1"> 
         <div class="order-item">
                 <h2>Completed Order</h2>
                 <h3><i class="fa-solid fa-money-bill"></i>Price: N340</h3>
                 <p><i class="fa-solid fa-book"></i>subject: computer science</p>
                 <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
                 <p><a href=""><i class="fa-solid fa-pen-to-square"></i>Edit</a></p>
                 <p><i class="fa-solid fa-list-check"></i>status: <a href="">Pay for this Order</a></p>
             </div>
 </div>
 <!-- completed orders end -->
  <!-- Revision orders start -->
 <div class="order-container ordercontainer ordercontainer2"> 
         <div class="order-item">
                 <h2>Revision  Order</h2>
                 <h3><i class="fa-solid fa-money-bill"></i>Price: N340</h3>
                 <p><i class="fa-solid fa-book"></i>subject: computer science</p>
                 <p><i class="fa-solid fa-clock"></i>submission time: 20 Nov, 2023</p>
                 <p><a href=""><i class="fa-solid fa-pen-to-square"></i>Edit</a></p>
                 <p><i class="fa-solid fa-list-check"></i>status: <a href="">Pay for this Order</a></p>
             </div>
 </div>
 <!-- Revision orders ends -->
 </div>
</main>


    <footer></footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
    <script>
        const sidebarBtn = document.querySelectorAll(".sidebar button");
        const orderContainer =document.querySelectorAll(".ordercontainer");
        function removeActiveformBtns(){
            sidebarBtn.forEach((btn)=>{
                btn.classList.remove("active");
            
            })
        }

   
        sidebarBtnClick();
        function sidebarBtnClick(){
            
            sidebarBtn.forEach((btn, index)=>{
               
                btn.addEventListener("click", function(){
                     const selectedOrder = document.querySelector(".ordercontainer"+index);
                    console.log(selectedOrder)
                    removeActiveformBtns();
                    btn.classList.add("active");
                    hideAllOrders();
                    selectedOrder.classList.add("active")
                 
                })
            })
        }

        function hideAllOrders(){
            orderContainer.forEach((order)=>{
                order.classList.remove("active");
            })
        } 
getAllOrders()
            function getAllOrders(){

            $.ajax({
            type:"post",
            url:"../php/getFreelanceOrder.php",
            data:{data:'<?php echo $email;?>'},
            success:function(res){
            console.log(res);
            $(".ordercontainer0").html(res)
            },
            error:function(xhr, status, error){
            console.log(error)
            }
            })
getCompletedOrders();
            function getCompletedOrders(){
            $.ajax({
            type:"post",
            url:"../php/getCompletedOrders.php",
            data:{data:'<?php echo $email;?>'},
            success:function(res){
                console.log(res);
                $(".ordercontainer1").html(res)
            },
            error:function(xhr, status, error){
                console.log(error)
            }
            })
            }


            getRevisionOrders();
            function getRevisionOrders(){
            $.ajax({
            type:"post",
            url:"../php/getRevisionOrders.php",
            data:{data:'<?php echo $email;?>'},
            success:function(res){
                console.log(res);
                $(".ordercontainer2").html(res)
            },
            error:function(xhr, status, error){
                console.log(error)
            }
            })
            }
}
    </script>
</body>
</html>