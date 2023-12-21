<?php
session_start();
include "../include/connections.php";

if(!isset( $_SESSION["email"])){
  header("location: ../pages/login.html?user=not-set");
  exit;
}
$email = $_SESSION["email"];
$query = mysqli_query($conn, "SELECT * FROM freelancers WHERE email='$email'");
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
$checkQuery = mysqli_query($conn, "SELECT * FROM orders WHERE  orderId='$orderId'");
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
        main, header{
            max-width: 100vw;
            overflow-x: hidden;
        }
        body{
            position: relative;
            /* background: #f3f4f5; */
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
.btn button{
    background: none;
    padding: 8px 16px;
    border: none;
    background: red;
    color: white;
    margin:  0 20px;
}
.content button:first-of-type{
    background:#106d46;
    color:white;
}
.content h2{
    color:#6BBF6D;
}
.modalr{
    width: 100vw;
    height: 100vh;
  display: none;
    background: rgba(0,0,0,0.9);
    z-index: 999;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
transition: opacity 1s ease-in;
}
.modalr.active{
    display: block;
    transition: opacity 1s ease-in;
}
.modal-content{
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 90%;
    margin:  4%auto;
    height: 300px;
    max-height: 400px;
    height: 80vh;
    display: flex;
    overflow: auto;
    flex-direction: column;
    max-width: 600px;
}
.btn{
    display: flex;
    flex-wrap: wrap;
}
.btn button{
    margin-bottom: 10px;
    border-radius: 3px;
}
.modal-content{
    position: relative;
}
.modal-content span{
    position: absolute;
    left: 0;
    top: -14px;
    font-size: 50px;
    color: red;
    cursor: pointer;
}
button{
    cursor: pointer;
}
.modal-content button:first-of-type{
    background:#106d46;
    color:white;
}
.modal-content h3{
    margin-bottom: 10px;
}
.modal-content li{
    margin-bottom: 6px;
}
  
.modal-content ul{
    margin-bottom: 14px;
}

/* handle gallery */
#gallery h3{
    color: #6BBF6D;
    margin-bottom: 30px;
}
#gallery {
            display: flex;
            flex-wrap: wrap;
        }

        .thumbnail-container {
            margin: 5px;
            cursor: pointer;
            width: 200px;
            position: relative;
        }

        .thumbnail {
            width: 100%;
            height: auto;
            cursor: pointer;
        }

        .download-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            color: #fff;
            cursor: pointer;
        }
        .file{
           
            display: block;
            width: 100%;
            margin-bottom: 20px;
        }
        .file a{
            color: #6BBF6D;
            text-decoration: underline;
            padding-bottom: 10px;
        }
        .file i{
            font-size: 20px;
            color: #106d46;
        }

        #previewContainer {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
        }

        #previewImageContainer {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 80%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #previewImage {
            width: 100%;
            height: 100%;
            cursor: pointer;
            object-fit: contain;
        }

        #loadingIndicator {
            color: #fff;
            font-size: 24px;
            margin-top: 20%;
        }

        #controls {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 20px;
            color: #fff;
            max-width: 99%;
            margin: 0 auto;
        }

        #controls button{
            background: none;
        }
        .control-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #fff;
        }

        .download-icon-full {
            cursor: pointer;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
        }
   </style>
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
    
  <div class="modalr">
   <div class="modal-content">
    <span class="hide-modal">&times;</span>
   <h3>are you sure you wants to accept this order?</h3>
     <h4>Note:</h4>
     <ul>
        <li>Accept only want you are sure you can provide answer for</li>
        <li>Order accepted cannot be rejected</li>
        <li>Wrong Answer to user's orders when reported to can lead to account termination</li>
        <li>Be sure to do your best to achieve higher ratings</li>
        <li>If a customer is not satisy with your service, it might lead to you not getting paid</li>
     </ul>
     <div class="btn">
        <button id="accept"><i class="fa fa-check" aria-hidden="true"></i>  &nbsp; Accept Order</button>
        <button class="hide-modal"><i class="fa fa-ban" aria-hidden="true"></i> &nbsp;Close</button>
     </div>
   </div>
  </div>
    <div class="content">
        <h2><?php echo $title;?></h2>
        <p><?php echo $des;?></p>
       <!-- handle images -->
       <div id="gallery">
        <!-- Thumbnail images will be dynamically populated here -->
        <?php
        $checkImg = mysqli_query($conn, "SELECT * FROM orderFiles WHERE orderId='$orderId'");
        if(mysqli_num_rows($checkImg) > 0){
            echo '<h3>Related files for this project</h3>';
               $counter = 0;
            while($rows = mysqli_fetch_assoc($checkImg)){
                $filepath=$rows["file_path"];
                $fileExtension = pathinfo($filepath, PATHINFO_EXTENSION);
                $fileExtension = strtolower($fileExtension);
                if($fileExtension == "jpg" ||$fileExtension == "png" ||$fileExtension == "jpeg" ||$fileExtension == "gif" ||$fileExtension == "svg"){
                  echo '
                  <div class="thumbnail-container" onclick="showPreview('.$counter.')">
                  <img class="thumbnail" src="../php/'.$filepath.'" alt="Image '.$counter.'">
                  <i class="fas fa-download download-icon" onclick="downloadImage('.$counter.')"></i>
              </div>
                  ';
                  
                }else{
                    $filename = basename($filepath);
                    echo '<div class="file">
                    <a href="../php/'.$filepath.'"><span><i class="fa-solid fa-file"></i>'.$filename.'</span></a>
                    </div>';
                }
                $counter++;
            }
        }
        
        ?>
      
        <!-- <div class="thumbnail-container" onclick="showPreview(1)">
            <img class="thumbnail" src="../img/aerial-view-businessman-using-computer-laptop.jpg" alt="">
            <i class="fas fa-download download-icon" onclick="downloadImage(1)"></i>
        </div>
        <div class="thumbnail-container" onclick="showPreview(2)">
            <img class="thumbnail" src="../img/from-worker-typing-laptop (1).jpg" alt="Image 3">
            <i class="fas fa-download download-icon" onclick="downloadImage(2)"></i>
        </div> -->
        <!-- Add more images as needed -->
    </div>
    
    <div id="previewContainer">
        <div id="previewImageContainer">
            <div id="controls">
                <button class="control-button" onclick="prevImage()"><i class="fas fa-chevron-left"></i></button>
                <button class="control-button" onclick="zoomOut()"><i class="fas fa-search-minus"></i></button>
                <button class="control-button" onclick="closePreview()"><i class="fas fa-times"></i></button>
                <button class="control-button" onclick="zoomIn()"><i class="fas fa-search-plus"></i></button>
                <button class="control-button" onclick="nextImage()"><i class="fas fa-chevron-right"></i></button>
            </div>
            <img id="previewImage" src="" alt="Preview Image">
            <i class="fas fa-download download-icon-full" onclick="downloadImage(currentIndex)"></i>
        </div>
        <div id="loadingIndicator">Loading...</div>
    </div>
        <!-- handle images  ends-->

        <div class="btn">
            <button onclick="showModal();"><i class="fa fa-check" aria-hidden="true"></i>Accept Order</button>
           
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
<script>
    const modal = document.querySelector(".modalr");
    let hideModal = document.querySelectorAll(".hide-modal");
    const accept = document.getElementById("accept");
    accept.addEventListener("click", function(){
        acceptOrder('<?php echo $orderId;?>')
    })
    hideModal.forEach((btn)=>{
        btn.addEventListener("click", function(){
            modal.classList.remove('active');
        })
    })
    function showModal(){
        modal.classList.add("active");
    }

    
 function acceptOrder(id){
  $.ajax({
      type:"post",
      data:{id:id, email:'<?php echo $email;?>'},
    //   contentType:false,
    //   processData:false,
      url:"../php/acceptOrder.php",
      success:function(res){
       console.log(res);
       modal.classList.remove("active");
       
    //  getAcceptedOrders()
        },
        error:function(xhr, status, error){
            console.log(error)
        } 
     
     
  })
 }
    

 document.addEventListener('DOMContentLoaded', function () {
            const gallery = document.getElementById('gallery');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            const loadingIndicator = document.getElementById('loadingIndicator');
            let currentIndex;
            let zoomLevel = 1;

            // Populate thumbnails and set click event
            const thumbnailContainers = document.querySelectorAll('.thumbnail-container');
            thumbnailContainers.forEach((container, index) => {
                container.addEventListener('click', function () {
                    showPreview(index);
                });
            });

            function showPreview(index) {
                currentIndex = index;
                const imageUrl = thumbnailContainers[index].querySelector('.thumbnail').src;
                previewImage.src = imageUrl;
                zoomLevel = 1;
                applyZoom();
                previewContainer.style.display = 'flex';
                loadingIndicator.style.display = 'none';
            }

            function applyZoom() {
                previewImage.style.transform = `scale(${zoomLevel})`;
            }

            window.closePreview = function () {
                previewContainer.style.display = 'none';
            };

            window.zoomIn = function () {
                zoomLevel += 0.1;
                applyZoom();
            };

            window.zoomOut = function () {
                if (zoomLevel > 0.1) {
                    zoomLevel -= 0.1;
                    applyZoom();
                }
            };

            window.downloadImage = function (index) {
                const link = document.createElement('a');
                link.href = thumbnailContainers[index].querySelector('.thumbnail').src;
                link.download = `image_${index + 1}.jpg`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };

            window.prevImage = function () {
                if (currentIndex > 0) {
                    currentIndex--;
                    showPreview(currentIndex);
                }
            };

            window.nextImage = function () {
                if (currentIndex < thumbnailContainers.length - 1) {
                    currentIndex++;
                    showPreview(currentIndex);
                }
            };
        });
</script>

</body>
</html>

