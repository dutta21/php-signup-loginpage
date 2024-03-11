<!DOCTYPE html>
<html lang="en">
<head>
<title>Job Application Portal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
     integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    

</head>


<body id="bdetails">
    
<div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Border around the form -->
        <div id="form-container">
          <h2 class="text-center mb-4">Sign Up</h2>



          <form action="index.php" method="post">
          <div class="form-group">
              <label >Full Name:</label>
              <input type="text" class="form-control" name="name" placeholder="Enter your fullname">
            </div>  

            <div class="form-group">
              <label >Email:</label>
              <input type="email" class="form-control" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label >Password:</label>
              <input type="text" class="form-control" name="password" placeholder="Enter your password">
            </div>
            <div class="form-group">
              <label >Re-enter password:</label>
              <input type="password" class="form-control" name="repassword" placeholder="Enter your password again">
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" value="Submit" name="submit">
            </div>
            <div class="text-center pt-1">
                <a href="login.php">Already a user? Login</a>
            </div>
 <!-- Border around the form -->
  <?php
                if(isset($_POST["submit"])){
                  $Name = $_POST["name"];
                  $Email = $_POST["email"];
                  $Password = $_POST["password"];
                  $Repassword = $_POST["repassword"];
                  
                  $passwordHash = password_hash($Password , PASSWORD_DEFAULT);
                  $errors = array();

                  if(empty($Name) OR empty($Email) OR empty($Password) OR empty($Repassword)){
                      array_push($errors ,"All fields are required");
                  }
                  if(!filter_var($Email , FILTER_VALIDATE_EMAIL)){
                      array_push($errors , "Email not valid");
                  }
                  if(strlen($Password)<8){
                      array_push($errors , "Password should have atleast 8 characters");
                  }
                  if($Password!=$Repassword){
                      array_push($errors , "password doesnot match");
                  }
                  require_once "database.php";
                  $sql = "SELECT * FROM users WHERE email = '$Email'";
                  $result = mysqli_query($conn,$sql);
                  $rowCount = mysqli_num_rows($result);
                  if($rowCount>0){
                    array_push($errors,"Email already exsists!");
                  }

                  if(count($errors)>0){
                      foreach($errors as $error){
                          echo "<div class='alert alert-danger'>$error</div>";
                      }
                  }
                  else{
                      
                      $stmt = mysqli_stmt_init($conn);
                      $sql = "INSERT INTO users(name,email,password) VALUES (?,?,?)";
                      $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                      if($prepareStmt){
                        mysqli_stmt_bind_param($stmt,"sss",$Name,$Email,$passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>Registration Successful.</div>";
                      }else{
                        die("Something went wrong.");
                      }
                  }
              }
              ?>
              <?php
                session_start();
                if(isset($_SESSION["user"])){
                header("Location: welcome.php");
                }
              ?>




          </form>
        </div>
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>