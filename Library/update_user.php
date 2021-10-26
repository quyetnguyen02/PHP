<?php
session_start();
if(!isset($_SESSION["loggedin"]) && empty($_SESSION["loggedin"]) !==true){
    header("location:login.php");
}

?>


<?php
require_once "config.php";

$mabd=$tenbd=$diachi="";
$mabd_err=$tenbd_err=$diachi_err="";


if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id=$_POST["id"];
         $input_mabd=trim($_POST["mabd"]);
    if(empty($input_mabd)){
        $mabd_err="moi nhap ma nguoi dung";
    }elseif (!filter_var($input_mabd,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $mabd_err = "vui long nhap vao chu cai";
    }else{
        $mabd=$input_mabd;
    }

    $input_tenbd=trim($_POST["tenbd"]);
    if(empty($input_tenbd)){
        $tenbd_err="moi nhap ma nguoi dung";
    }elseif (!filter_var($input_tenbd,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $tenbd_err = "vui long nhap vao chu cai";
    }else{
        $tenbd=$input_tenbd;
    }

    $input_diachi=trim($_POST["diachi"]);
    if(empty($input_diachi)){
        $diachi_err="moi nhap ma nguoi dung";
    }elseif (!filter_var($input_diachi,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $diachi_err = "vui long nhap vao chu cai";
    }else{
        $diachi=$input_diachi;
    }

    if(empty($mabd_err) && empty($tenbd) && empty($diachi_err)){
        $sql="update bandoc set mabd=?, tenbd=?,diachi=? where id=?";
        if($stmt=$mysqli->prepare($sql)){
            $stmt->bind_param("sssi",$param_mabd,$param_tenbd,$param_diachi,$param_id);
            $param_mabd=$mabd;
            $param_tenbd=$tenbd;
            $param_diachi=$diachi;
             $param_id=$id;
            if($stmt->execute()){
                header("location:book.php");
                exit();
            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }

        }$stmt->close();

    }$mysqli->close();
}else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id=trim($_GET["id"]);
        $sql="select * from bandoc where id=?";
        if($stmt=$mysqli->prepare($sql)){
            $stmt->bind_param("i",$param_id);
            $param_id=$id;
            if($stmt->execute()){
                $result=$stmt->get_result();
                if($result->num_rows==1){
                   $row= $result->fetch_array(MYSQLI_ASSOC);
                    $mabd=$row["mabd"];
                    $tenbd=$row["tenbd"];
                    $diachi=$row["diachi"];
                }
            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }
        }
        $stmt->close();
        $mysqli->close();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Book</title>
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
            <div class="col-md-12">
                <h2 class="mt-5">Update Users</h2>
                <p>Please edit the input values and submit to update the employee record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER["REQUEST_URI"]));?>" method="post">
                    <div class="form-group">
                        <label for="#">Ma Nguoi Dung</label>
                        <input type="text" name="mabd" class="form-control
                            <?php echo (!empty($mabd_err)) ? 'is-invalid' : '';?>" value="<?php echo $mabd;?>">
                        <span class="invalid-feedback"><?php echo $mabd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Ten Nguoi Dung</label>
                        <input type="text" name="tenbd" class="form-control
                            <?php echo (!empty($tenbd_err)) ? 'is-invalid' : '';?>" value="<?php echo $tenbd;?>">
                        <span class="invalid-feedback"><?php echo $tenbd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Dia Chi</label>
                        <input type="text" name="diachi" class="form-control
                            <?php echo (!empty($diachi_err)) ? 'is-invalid' : '';?>" value="<?php echo $diachi;?>">
                        <span class="invalid-feedback"><?php echo $diachi_err;?></span>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="user.php" class="btn btn-secondary m1-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>