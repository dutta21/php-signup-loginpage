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
          <form action="login.php" method="post">
            <h2 class="text-center mb-4">Login</h2>
          
           

            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" placeholder="Enter your email">
            </div>
            
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" placeholder="Enter your password">
            </div>

            <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" value="Login" name="login">
            </div>

            <div class="text-center pt-1">
                <a href="index.php">Not a user? Sign up</a>
            </div>


            <?php
              if(isset($_POST["login"])){
                $Email = $_POST["email"];
                $Password = $_POST["password"];
                require_once "database.php";
                $sql = "SELECT * FROM users WHERE email = '$Email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if($user){
                  if(password_verify($Password, $user["password"])){
                    session_start();
                    $_SESSION["user"]="yes";
                    header("Location: welcome.php");
                    die();
                  }else{
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                  }
                }else{
                  echo "<div class='alert alert-danger'>Email does not exist</div>";
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