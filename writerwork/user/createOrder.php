<?php
session_start();
if(!isset( $_SESSION["email"])){
  header("location: ../pages/login.html?user=not-set");
  exit;
}
$email = $_SESSION["email"];
?> 
<!doctype html>
<html lang="en"> 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Hello, world!</title>

    <style>
        .wrapper{
            width: 90%;
            margin: 0 auto;
            max-width: 600px;
        }
    </style>
  </head>
  <body>
    
   <div class="wrapper">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Place Your Order</h5>
                <form id="orderForm" action="../php/createorder.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="orderTitle">Order Title</label>
                        <input name="title" type="text" class="form-control" id="orderTitle" placeholder="Enter order title">
                    </div>
                    <div class="form-group">
                        <label for="orderDescription">Order Description</label>
                        <textarea name="desc" class="form-control" id="orderDescription" rows="3" placeholder="Enter order description"></textarea>
                    </div>
                      <input type="hidden" name="email" value="<?php echo $email;?>">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="orderSubject">Subject</label>
                        <input name="subject" type="text" class="form-control" id="orderSubject" placeholder="Enter subject">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="submissionDate">Submission Date</label>
                        <input name="subdate" type="date" class="form-control" id="submissionDate">
                    </div>
                  </div>
                 <div class="form-row">
                    <div class="form-group form col-md-6">
                        <label for="orderType">Order Type</label>
                        <select name="ordertype" class="form-control" id="orderType">
                            <option value="assignment">Assignment</option>
                            <option value="typingJob">Typing Job</option>
                            <option value="contentWriting">Content Writing</option>
                        </select>
                    </div> 
                    <div class="form-group col-md-6">
                        <label for="subtime">Submission Time</label>
                        <input name="subtime" type="time" class="form-control" name="subtime" id="subtime">
                    </div>
                 </div>
                 <div class="form-group form-group">
                        <label for="price">Price (Amount are willing to pay for this Order)</label>
                         <input type="number" class="form-control"  name="price" id="price" min="500" value="500" step="100">
                    </div>
                    <div class="form-group">
                    <label for="files">Uploade files related to your project(optiona) (PDF, DOCX, Images, etc.):</label>
                     <input type="file" name="files[]" multiple accept=".pdf, .docx, .doc, .xlsx, .xls, .pptx, .ppt, image/*"><br>

                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
    

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>

        const orderForm = document.getElementById("orderForm");
        orderForm.addEventListener("submit", function(event){
            event.preventDefault();
            const formData = new FormData(this);

            submitForm(formData);
        })
 function submitForm(data) {
   

    $.ajax({
        type: "POST",
        url: "../php/createorder.php",
        data:data,
        contentType: false,
        processData: false,
        success: function(response) {
            alert(response);
            clearForm(orderForm)
        },
        error:function(xhr, status, error){
            console.log(error)
        }
    });
}

function clearForm(form){
let elements = form.elements;
for(let i = 0; i<elements.length; i++){
    if(elements[i].type != "submit"){
       elements[i].value="";
    }
}
}
</script>
    </script>
    
  </body>
</html>