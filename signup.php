<?php
include_once("./Config/ketnoi.php");
if ($_SERVER["REQUEST_METHOD"]=="POST"){
  $username = $_POST["username"];
  $fullname = $_POST["fullname"];
  $email = $_POST["txt_email"];
  $phone_number = $_POST["phone_number"];
  $address = $_POST["address"];
  $password = $_POST["password"];
  
  $sql = "INSERT INTO users (username,fullname,email,phone_number,address,password) VALUES ('$username','$fullname','$email','$phone_number','$address','$password')";
  
  if($conn->query($sql)=== TRUE){
    header("Location: login.php"); // Redirect to login page
    exit();
  }
  else{
    echo "Đăng ký thất bại" .$sql."<br>".$conn->error;
  }
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/signup_style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
</head>

<body class="body">
    <div class="login-page">
        <div class="form">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <lottie-player
                    src="https://assets4.lottiefiles.com/datafiles/XRVoUu3IX4sGWtiC3MPpFnJvZNq7lVWDCa8LSqgS/profile.json"
                    background="transparent" speed="1" style="justify-content: center" loop autoplay></lottie-player>
                <input type="text" id="username" name="username" placeholder="pick a username" required />
                <input type="text" id="fullname" name="fullname" placeholder="full name" required />
                <input type="email" id="email" name="email" placeholder="email" required />
                <input type="text" id="phone_number" name="phone_number" placeholder="phone number" required />
                <input type="text" id="address" name="address" placeholder="address" required />
                <input type="password" id="password" name="password" placeholder="set a password" required />
                <i class="fas fa-eye" onclick="show()"></i>
                <br>
                <br>
                <button type="submit">SIGN UP</button>
                <button type="button" onclick="window.location.href= 'login.php'">LOGIN </button>
            </form>
        </div>
    </div>

    <script>
    function show() {
        var password = document.getElementById("password");
        var icon = document.querySelector(".fas");

        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }
    }
    </script>
</body>

</html>