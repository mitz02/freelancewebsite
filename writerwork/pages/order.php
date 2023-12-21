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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body{
            overflow-x: hidden;
           
        }
        .modal-wrapper{
        position:fixed;
        height: 100vh;
        width: 100vw;
        right: 0;
        /* border: 1px solid red; */
        z-index: 999999999;
        transition: transform 0.6s ease-in ;
       transform: translate(100vw);
      }

      .modal-content{
          width:calc(100vw - 290px);
          background: #186243;
          position: absolute;
        right: 0;
        top: 10px;
        height: 95vh;
        padding: 20px;

      }
      .times{
        color:#991f0f;
        font-size: 20px;
        position: absolute;
        top: 10px;
      }
      .modal-btn{
        position: absolute;
        bottom: 10px;
        display: flex;
        justify-content: space-between;
        
        
        width: 80%;
        margin:  9 auto;
      }
      .modal-btn button{
        flex: 1;
        border: none;
        background: none;
        border-radius: 20px;
    margin:  0 30px;
        color:white;
        padding: 4px 0;
      }
      .modal-btn button:last-of-type{
     background: #991f0f;
      }
      .modal-btn button:first-of-type{
        background: #0f9964;
      }
      .modal-content h3{
        color:#c2ffe8;
        margin-bottom: 20px;    
      }

      .modal-content h4{
        color: white;
        font-size: 16px;
      }
      .modal-content p{
        color:white;
      }
        .sidebar{
            max-width: 250px;
            width: 80%;
            position: fixed;
            top: 0;
            bottom: 0;
            background:#047542;
            color: white;
            box-shadow: 0 0 10px rgba(0,0,0, 0.2);
            padding: 10px 20px;
            z-index: 9999999;
            padding-top: 100px;
        }
      .main-content{
        width: 90%;
        margin:  0 auto;
        width: calc(100vw - 270px);
        margin-left: 280px;
        max-width: 700px;
        /* border: 1px solid red; */
        /* height: 100%; */
        min-height: 90vh;
        padding: 10px 20px;
    
        position: absolute;
         box-shadow: 0 0 10px rgba(0,0,0,0.2);
         /* background:rgb(243, 247, 243) */

         
      }
      .toggler{
        position:absolute;
        right: 0;
        top: 10px;
        display: none;
        cursor: pointer;
      }

      @media screen and (max-width: 600px) {
        .sidebar{
           transform: translate(-100vw);
           transition: transform 0.5s ease;
           
        }
        .sidebar.active{
            transform: translate(0vw);
        }

        .toggler{
        display: block;
      }

        .main-content{
            margin-left: 0;
            width: 90%;
            margin:  0 auto;
            
           
        }
      }
.order-list{
  
    border:  0 0 4px rgba(0,0,0, 0.2);
    padding: 0 20px;
    border-radius: 10px;
    margin:  10px 0;
border:  1px solid rgb(212, 210, 210);
position: relative;
margin-bottom: 20px;
}
.order-list h3{
    font-size: 16px;
    margin-bottom: 3px;
    color: #186243;
}
.details{
    font-size: 12px;
    display: flex;
    
}

.details p{
   margin-right: 40px; 
}

.details p:last-of-type{
background: rgb(218, 245, 218);
padding: 0 10px;
border-radius: 4px;
}
      .order-title{
        display: flex;
        
      }
      .order-title span{
          position: absolute;
          top: 20px;
          right:20px;
          font-size: 13px;

      }
      .order-title h3{
        width: 80%;

      }
      .order-list .details{
        display: flex;
      }

      .btn{
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 40px;
       
      }
      .btn button{
        border: none;
        background: none;
        background:  #e7f5f0;
        /* color:  #106d46; */
        
        width: 100%;
        border-radius:4px;
      }
      .nav-link {
        color: #083824 !important;
      }

      .time{
        display: flex;

      }
      .time i{
        color: white;
        font-size: 20px;
        margin-right: 20px;
      }
.price{
    display: flex;
    align-items: center;
    font-size: 20px;

}
.price i{
    color:white;
    font-size: 20;

}
#modal-instru{
    width: 90%;
    margin: 0 auto;
    max-width: 700px;
}
    
    </style>
    <title>Orders Page</title>
</head>
<body>
    <div class="modal-wrapper" id="modal-wrapper">
        <div class="modal-content" id="modal-content">
                <span class="times timesx"><i class="fa-solid fa-x"></i></span>
                <div class="modal-instru" id="modal-instru">
                     
                </div>
               
        </div>
   </div>
<main>
  
    <div class="sidebar">
    <!-- sidebar ends here -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <label for="typeFilter">Filter by Type:</label>
            <select class="form-control" id="typeFilter">
                <option value="">All Types</option>
                <option value="writing">Writing</option>
                <option value="assignment">Assignment</option>
                <!-- Add more options as needed -->
            </select>
        </li>
        <li class="nav-item">
            <label for="dateFilter">Filter by Submission Date:</label>
            <input type="date" class="form-control" id="dateFilter">
        </li>
        <li class="nav-item">
            <label for="priceFilter">Filter by Price:</label>
            <select class="form-control" id="priceFilter">
                <option value="">All Prices</option>
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </li>
    </ul>

    <div class="btn">
        <button>Apply filter</button>
    </div>
</div>
    <div class="main-content">
          <!-- Bootstrap Tabs for Navigation -->
          <div class="toggler">
            <img src="../img/mobile-dark-nav-icon.svg" alt="">
          </div>
          <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="allOrdersTab" data-toggle="tab" href="#allOrders">
                    All Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="myOrdersTab" data-toggle="tab" href="#myOrders">
                    My Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="completedOrdersTab" data-toggle="tab" href="#completedOrders">
                    Completed Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="orderRevisionTab" data-toggle="tab" href="#orderRevision">
                    Order Revision
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="allOrders">
                <!-- Order List for All Orders -->
                <div class="order-list">
                    <div class="order-title">
                        <h3 onclick="showModal('this is the stuff')">Design a website for me</h3>
                         <span>22 Nov 20203</span>
                    </div>
                    <div class="details">
                        <p>type:content</p>
                        <p> computer science<p?>
                    </div>
                </div>

               

                
            </div>
            <div class="tab-pane fade" id="myOrders">
                <!-- Order List for My Orders -->
                <div class="order-list">
                    <!-- Sample data, replace with actual order data -->
                    <!-- ... -->
                </div>
            </div>
            <div class="tab-pane fade" id="completedOrders">
                <!-- Order List for Completed Orders -->
                <div class="order-list">
                    <!-- Sample data, replace with actual order data -->
                    <!-- ... -->
                </div>
            </div>
            <div class="tab-pane fade" id="orderRevision">
                <!-- Order List for Order Revision -->
                <div class="order-list">
                    <!-- Sample data, replace with actual order data -->
                    <!-- ... -->
                </div>
            </div>
        </div>
    </div>
    <!-- .main content ends here -->
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
 const sidebar = document.querySelector(".sidebar");
 const modalwrapper = document.getElementById("modal-wrapper");
 const toggler = document.querySelector(".toggler");
 let timesx = document.querySelectorAll(".timesx");
 timesx.forEach((item)=>{
  item.addEventListener("click", function(){
    closeModal();
  })
 })

 toggler.addEventListener("click", function(){
    sidebar.classList.toggle("active");
 })

getAllOrders();
 function getAllOrders(){
  $.ajax({
      type:"post",
      url:"../php/getOrders.php",
      success:function(res){
    //   console.log(res)
      $("#allOrders").html(res)
      }, 
      error:function(xhr, status, err){
       console.log(err)
      }
  })
 }
setInterval(() => {
  getAllOrders();
}, 3000);
 async function showModal(id){
  modalwrapper.style.transform="translate(0)";
//   console.log(id)
  await showSingleOrder(id);
  const closeBtn = document.getElementById("closeBtn");
 closeBtn.addEventListener("click", function(){
    closeModal();
 })
 }
 function closeModal(){
    modalwrapper.style.transform="translate(100vw)";
 }

 function showSingleOrder(id){
    $.ajax({
      type:"post",
      data:{id:id},
    //   contentType:false,
    //   processData:false,
      url:"../php/getSingleOrder.php",
      success:function(res){
      console.log(res)
      $("#modal-instru").html(res)
      }, 
      error:function(xhr, status, err){
       console.log(err)
       $("#modal-instru").html(res)
      }
  })

  
 }
 

 function acceptOrder(id){
  $.ajax({
      type:"post",
      data:{id:id, email:'<?php echo $email;?>'},
    //   contentType:false,
    //   processData:false,
      url:"../php/acceptOrder.php",
      success:function(res){
        if(res =="true"){
          alert("you cant choose multiple order")
        }
        else{
          alert("order accepted successful!")
     getAcceptedOrders()
        }  
     closeModal();
     
      }, 
     
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
        $("#myOrders").html(res)
      },
      error:function(xhr, status, error){
        console.log(error)
      } 
     
  })
 }
</script>

</body>
</html>
