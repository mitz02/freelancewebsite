<?php
session_start();
if(!isset( $_SESSION["email"])){
  header("location: ../pages/login.html?user=not-set");
  exit;
}
include "../include/connections.php";
$email = $_SESSION["email"];
$query = mysqli_query($conn, "SELECT * FROM freelancers WHERE email='$email'");
$num = mysqli_num_rows($query);
if($num < 1){
  header("location: ../pages/login.html?user=not-freelancer");
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
.logo img:last-of-type{
    width: 25px;
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
    max-width: 600px;
}
.order-item .fa-clock{
    color: orangered;
}
.order{
    position: relative;
}
.side-nav{
    position: fixed;
    right: 100px;
    height: 80vh;
    background: #f3f4f5;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99;
    box-shadow: 0 0 6px rgba(0,0,0,0.1);

}
.side-nav-content div{
    font-size: 16px;
    margin-bottom: 20px;
    transition: all 0.7s ease;
    padding: 4px 40px;
    cursor: pointer;
}

.side-nav-content div:hover{
  background: #cbfce8;
}
.side-nav-content{
    display: flex;
    flex-direction: column;
    justify-content: center;
    
}
.order .sidebar{
    position: fixed;
    left: 40px;
    
    top: 15%;
    box-shadow:  0 0 10px rgba(0,0,0,0.1);
    width: 300px;
    background: white;
    height: 400px;
    display: flex;
    flex-direction: column;
    text-align: center;
    justify-content: center;
    padding: 10px 20px;
    z-index: 99;
    transform: translate(-100vw);
    transition:transform 0.8s ease;

}
.sidebar.active{
transform: translate(0);
   
}

.sidebar h3{
    width: 100%;
    color: orangered;
    /* border: 1px solid red; */
}
.sidebar button{
    background:#106d46;
    color:  #f3f4f5;
   width: 100%;
   padding: 10px;
   border: none;
}
.sidebar h2{
    width: 100%;
    background: orangered;
    color: #106d46;
}

.sidebar h2 i{
    font-size: 16px;
}
.sidebar select{
    width: 100%;
    padding: 10px;
}
.filter-item{
    margin-bottom: 30px;
}
.order-container a{
    color:#6BBF6D;
}
.order-container{
    display: none;
}

.order-container.active{
    display: block;
}
.side-nav-content span{
    margin-right: 10px;
    color: #106d46;
}
.logout i{
    color:  red;
}
.finance{
  
   display: flex; 
padding: 30px;

}
.finance-item{
    background: #f3f4f5;
    margin:  10px;
    max-width: 500px;
    padding: 30px;
box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
.finance-item p{
    margin-bottom: 20px;
}
.finance h2{
    color: #106d46;
    margin-bottom: 10px;
    font-size: 40px;


}
    </style>
</head>
<body>
    <header>
        <div class="navigation">
            <div class="logo">
                <img src="../img/gigger2.png" alt="">
                <img  id="toggleFilter" src="../img/mobile-dark-nav-icon.svg" alt="">
            </div>
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
       <div class="side-nav">
        <div class="side-nav-content">
             <div class="allorders">
                <span><i class="fa-solid fa-list"></i></span>All Orders
             </div>
             <div class="complorders">
              <span><i class="fa fa-check" aria-hidden="true"></i></span> Completed Orders
              
             </div>

             <div class="myorders">
              <span><i class="fa-solid fa-user"></i></span>My Orders
             </div>

             <div class="finance">
               <span><i class="fas fa-money-bill"></i></span>Finance
             </div>

             <div class="setting">
               <span><i class="fa fa-cog" aria-hidden="true"></i></span>Settings
             </div>

             <div class="logout">
               <span><i class="fa fa-sign-out" aria-hidden="true"></i></span>Logout
             </div>
        </div>
    </div>
       <div class="sidebar">
            <h2><i class="fa-solid fa-filter"></i>Filter</h2>
            <div class="filter-lists">
                <div class="filter-item">
                    <h3>subject</h3>
                <select name="" id="">
                    <option value="none">all subjects</option>
                    <option value="none">english</option>
                    <option value="none">computer science</option>
                    <option value="none">maths</option>
                    <option value="none">economics</option>
                 </select>
                </div>

                <div class="filter-item">
                    <h3>Price</h3>
                <select name="" id="">
                    <option value="none">all price</option>
                    <option value="none">500 to 5000</option>
                    <option value="none">6,000 to 15,0000</option>
                    <option value="none">16000 to 50,000</option>
                    <option value="none">51,0000 to 200,000</option>
                    <option value="none">200,000 to More</option>
                  
                 </select>
                 
                </div>

                <div class="filter-item">
                    <h3>submission date</h3>
                <select name="" id="">
                    <option value="none">Today</option>
                    <option value="none">3 to 7 days</option>
                    <option value="none">8 to 12 days</option>
                    <option value="none">13 days to 20 days</option>
                    <option value="none">21 days to 1 month</option>
                    <option value="none">more than 1month</option>
                 </select>
                </div>
               <button>submit filter</button>
            </div>
         </div>
         <div class="order-container active ordercontainer0"> 
       
         </div>
         <div class="order-container ordercontainer1" id="complOrders"> 
       
         </div>

         <div class="order-container  ordercontainer2" id="acceptedOrders"> 
       
         </div>

         <div class="order-container  ordercontainer3" id="finance"> 
              <div class="finance">
                <div class="finance-item">
                <p>TOTAL EARNING</p>
                <h2>N340000</h2>
                  
                </div>
                <div class="finance-item">
                     <p>PENDING  EARNING</p>
                     <h2>N340000</h2>
                      
                </div>
              </div>
          </div>
       <div class="order-container  ordercontainer4" id="setting"> 
       
       </div>


       </div>
       
    </main>
    <footer></footer>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script>
    const navBtn =document.querySelectorAll(".side-nav-content div");

  const sidebar = document.querySelector(".sidebar");
  const modalwrapper = document.getElementById("modal-wrapper");
  const toggleFilter= document.querySelector("#toggleFilter");
  let timesx = document.querySelectorAll(".timesx");
  const orderContainer = document.querySelectorAll(".order-container");

  function hideOrderContainers(){
    orderContainer.forEach((order)=>{
        order.classList.remove("active")
    })
  }
  for(let x = 0; x < navBtn.length - 1; x++){
    navBtn[x].addEventListener("click", function(){
        hideOrderContainers()
        let showContainer = document.querySelector(".ordercontainer"+x); 
        showContainer.classList.add("active");
    })
  }
  timesx.forEach((item)=>{
   item.addEventListener("click", function(){
     closeModal();
   })
  })
 
  toggleFilter.addEventListener("click", function(){
     sidebar.classList.toggle("active");
  })
 
 getAllOrders();
  function getAllOrders(){
   $.ajax({
       type:"post",
       url:"../php/getOrders.php",
       success:function(res){
     //   console.log(res)
       $(".ordercontainer0").html(res)
       }, 
       error:function(xhr, status, err){
        console.log(err)
       }
   })
  }
//  setInterval(() => {
//    getAllOrders();
//  }, 3000);
getCompletedOrders()
function getCompletedOrders(){
            $.ajax({
            type:"post",
            url:"../php/freelancecompleted.php",
            data:{data:'<?php echo $email;?>'},
            success:function(res){
                console.log(res);
                $("#complOrders").html(res)
            },
            error:function(xhr, status, error){
                console.log(error)
            }
            })
            }

  getAcceptedOrders();
  function getAcceptedOrders(){
   $.ajax({
       type:"post",
       data:{email:'<?php echo $email;?>'},
     //   contentType:false,
     //   processData:false,
       url:"../php/getacceptedOrders.php",
       success:function(res){
         $("#acceptedOrders").html(res)
       },
       error:function(xhr, status, error){
         console.log(error)
       } 
      
   })
  }
 </script>
</body>
</html>