<?php
	session_start();
//kiểm tra xem người dùng đã đăng nhập chưa, nếu có thì chuyển hướng người đó đến trang chào mừng
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] ==true){
    header("location:dashboard.php");
    exit();
}
//bao gồm tệp cấu hình
require_once "config_demo.php";
//xác định các biến và khởi tạo với các giá trị trống
$username=$password="";
$username_err=$password_err=$login_err="";
//xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if($_SERVER["REQUEST_METHOD"]=="POST"){
    //kiểm tra xem tên người dùng có trống không
    if(empty(trim($_POST["username"]))){
        $username_err="enter username";
    }else{
        $username=$_POST["username"];
    }
    //kiểm tra xem mật khẩu có trống không
    if(empty(trim($_POST["password"]))){
        $password_err="enter password";
    }else{
        $password=$_POST["password"];
    }
    //xác thực thông tin đăng nhập
    if(empty($username_err) && empty($password_err)){
        //chuẩn bị một tuyên bố lựa chọn

        $sql="select id,username,password from users1 where username=?";
        //ràng buộc các biến với câu lệnh chuẩn bị làm tham số
        if($stmt=$mysqli->prepare($sql)){
            //thiết lập các thông số
            $stmt->bind_param("s",$param_username);
              //cố gắng thực hiện tuyên bố đã chuẩn bị
            $param_username=$username;
            if($stmt->execute()){
                //kết quả lưu trữ
              $stmt->store_result();
                //kiểm tra xem tên người dùng có tồn tại không, nếu có thì hãy thay đổi mật khẩu
              if($stmt->num_rows==1){
                  //ràng buộc các biến kết quả
                  $stmt->bind_result($id,$username,$hashed_password);
                  //mật khẩu chính xác, vì vậy hãy bắt đầu một phiên mới
                  if($stmt->fetch()){
                      if(password_verify($password,$hashed_password)){
                          //store data in seesion varibles
                          session_start();
                          $_SESSION["loggedin"]=true;
                          $_SESSION["id"]=$id;
                          $_SESSION["username"]=$username;

                          //chuyển hướng người dùng đến trang chào mừng
                          header("location:dashboard.php");

                      }else{
                          $login_err="username or password false.";
                      }
                  }
              }else{
                  $login_err="username or password false.";
              }
            }else{
                echo "Oops! Something went wrong.Plese try again later.";
            }
            $stmt->close();
        }

    }$mysqli->close();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

       

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register_demo.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>