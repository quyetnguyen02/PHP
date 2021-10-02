<?php
	require_once "config_demo.php";

    //define variables and initialize with empty values
    $username=$password=$confirm_password="";
    $username_err=$password_err=$confirm_password_err="";

    //processing form date when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //validate username
        if(empty(trim($_POST["username"]))){
            $username_err="Please enter a username";
        }else if(!preg_match('/^[a-zA-z0-9_]+$/',trim($_POST["username"]))){
            $username_err="Username can only contain letters, numbers, and underscores.";
        }else{
            //prepare a select statement
            $sql="select id from users1 where username = ?";
            if($stmt = $mysqli->prepare($sql)){
                //bind variables to the prepared statement as parameters
                $stmt->bind_param("s",$param_username);

                //set parameters
                $param_username=trim($_POST["username"]);

                //attempt to execute the prepared statement
                if($stmt->execute()){
                    $stmt->store_result();

                    if($stmt->num_rows ==1){
                        $username_err="this username is already taken.";
                    }
                    else{
                        $username=trim($_POST["username"]);
                    }
                }else{
                    echo "Oops! Something went wrong.Please try again later.";
                }
                $stmt->close();
            }
        }
        //validate password
        if(empty(trim($_POST["password"]))){
            $password_err="Please enter a password";
        }else if(strlen(trim($_POST["password"]))<6){
            $password_err="Password must have atleast 6 characters.";
        }else{
            $password=trim($_POST["password"]);
        }

        //validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err="Please confirm password";
        }else{
            $confirm_password=trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err="Password did not match";
            }
        }

        //check inout errors before inserting tin database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            //prepage an insert statement
            $sql="insert into users1(username,password) values(?,?)";

            if($stmt = $mysqli->prepare($sql)){
                //bind variables to the prepared statement as parameters
                $stmt->bind_param("ss",$param_username,$param_password);

                //set parameters

               $param_username=$username;
               $param_password=password_hash($password,PASSWORD_DEFAULT);//creates a password hash

               //attempt to execute the prepared statement
               if($stmt->execute()){
                   //redirect to login page
                   header("location:login_demo.php");
               }else{
                   echo "Oops! Something went wrong.Please try again later.";
               }
               $stmt->close();
            }
        }
        $mysqli->close();
    }

    
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login_demo.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>