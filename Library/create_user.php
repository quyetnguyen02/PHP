<?php
session_start();
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !==true){
    header("location:login.php");
    exit();
}
?>
<?php
require_once "config.php";
$mabd=$tenbd=$diachi="";
$mabd_err=$tenbd_err=$diachi_err="";

if($_SERVER["REQUEST_METHOD"] =="POST"){

    $input_mabd=trim($_POST["mabd"]);
    if(empty($input_mabd)){
        $mabd_err="Moi Nhap Ma Nguoi Dung.";
    }else{
        $mabd=$input_mabd;
    }

    $input_tenbd=trim($_POST["tenbd"]);
    if(empty($input_tenbd)){
        $tenbd_err="Moi Nhap Ten Nguoi Dung.";
    }elseif (!filter_var($input_tenbd,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tenbd_err="Moi nhap vao chu cai";
    }else{
        $tenbd=$input_tenbd;
    }

    $input_diachi=trim($_POST["diachi"]);
    if(empty($input_diachi)){
        $diachi_err="Moi Nhap Dia Chi Nguoi Dung.";
    }elseif (!filter_var($input_diachi,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $diachi_err="Moi nhap vao chu cai";
    }else{
        $diachi=$input_diachi;
    }
    if(empty($mabd_err) && empty($tenbd_err) && empty($diachi_err)){
        $sql="insert into bandoc(mabd,tenbd,diachi)values (?,?,?)";
        if($stmt=$mysqli->prepare($sql)){

            $stmt->bind_param("sss",$param_mabd,$param_tenbd,$param_diachi);


            $param_mabd=$mabd;
            $param_tenbd=$tenbd;
            $param_diachi=$diachi;
            if($stmt->execute()){
                header("location:user.php");
                exit();
            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }
        }$stmt->close();

    }
    $mysqli->close();


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
                        <label for="#">Mã Người Dùng</label>
                        <input type="text" name="mabd" class="form-control
                            <?php echo (!empty($macn_err)) ? 'is-invalid' : '';?>" value="<?php echo $mabd;?>">
                        <span class="invalid-feedback"><?php echo $mabd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Tên Người Dùng</label>
                        <input type="text" name="tenbd" class="form-control
                            <?php echo (!empty($tenbd_err)) ? 'is-invalid' : '';?>" value="<?php echo $tenbd;?>">
                        <span class="invalid-feedback"><?php echo $tenbd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Địa Chỉ</label>
                        <input type="text" name="diachi" class="form-control
                            <?php echo (!empty($diachi_err)) ? 'is-invalid' : '';?>" value="<?php echo $diachi;?>">
                        <span class="invalid-feedback"><?php echo $diachi_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create">
                    <a href="User.php" class="btn btn-secondary m1-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>