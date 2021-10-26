<?php
session_start();
//kiểm tra xem người dùng đã đăng nhập chưa, nếu có thì chuyển hướng người đó đến trang chào mừng
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !==true){
    header("location:login.php");
    exit();
}
?>


<?php
require_once "config.php";

$macn=$tencn="";
$macn_err=$tencn_err="";

if($_SERVER["REQUEST_METHOD"] =="POST"){
    $input_macn=trim($_POST["macn"]);
    if(empty($input_macn)){
        $macn_err="Moi Nhap ID.";
    }elseif (!filter_var($input_macn,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $macn_err="Moi nhap vao chu cai";
    }else{
        $macn=$input_macn;
    }
    $input_tencn=trim($_POST["tencn"]);
    if(empty($input_tencn)){
        $macn_err="Moi Nhap Ten The Loai.";
    }elseif (!filter_var($input_tencn,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $macn_err="Moi nhap vao chu cai";
    }else{
        $tencn=$input_tencn;
    }
    if(empty($macn_err) && empty($tencn_err)){
        $sql="insert into chuyennganh(macn,tencn)values (?,?)";
        if($stmt=$mysqli->prepare($sql)){

            $stmt->bind_param("ss",$param_macn,$param_tencn);

            $param_macn=$macn;
            $param_tencn=$tencn;
            if($stmt->execute()){
                header("location:Category_book.php");
                exit();
            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }
        }$stmt->close();

    }$mysqli->close();



}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-ml-12">
                <h2 class="mt-5">Create Record</h2>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="#">ID</label>
                        <input type="text" name="macn" class="form-control
                            <?php echo (!empty($macn_err)) ? 'is-invalid' : '';?>" value="<?php echo $macn;?>">
                        <span class="invalid-feedback"><?php echo $macn_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Thể Loại</label>
                        <input type="text" name="tencn" class="form-control
                            <?php echo (!empty($tencn_err)) ? 'is-invalid' : '';?>" value="<?php echo $tencn;?>">
                        <span class="invalid-feedback"><?php echo $tencn_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create">
                    <a href="Category_book.php" class="btn btn-secondary m1-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>