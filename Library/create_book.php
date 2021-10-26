<?php
require_once "config.php";

$id=$masach=$tensach=$tacgia=$namxb=$trangthai=$macn="";
$id_err=$masach_err=$tensach_err=$tacgia_err=$namxb_err=$trangthai_err=$macn_err="";

if($_SERVER["REQUEST_METHOD"] =="POST"){

    $input_sach=trim($_POST["masach"]);
    if(empty($input_sach)){
        $masach_err="Moi Nhap Ma Sach.";
    }elseif (!filter_var($input_sach,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $masach_err="Moi nhap vao chu cai";
    }else{
        $masach=$input_sach;
    }

    $input_tsach=trim($_POST["tensach"]);
    if(empty($input_tsach)){
        $tensach_err="Moi Nhap ten sach.";
    }elseif (!filter_var($input_tsach,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tensach_err="Moi nhap vao chu cai";
    }else{
        $tensach=$input_tsach;
    }

    $input_tacgia=trim($_POST["tacgia"]);
    if(empty($input_sach)){
        $tacgia_err="Moi Nhap Ten Tac Gia.";
    }elseif (!filter_var($input_tacgia,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tacgia_err="Moi nhap vao chu cai";
    }else{
        $tacgia=$input_tacgia;
    }

    $input_namxb=trim($_POST["namxb"]);
    if(empty($input_namxb)){
        $namxb_err="Moi Nhap Nam San Xuat.";
    }elseif (!ctype_digit($input_namxb)){
        $namxb_err="Moi nhap vao so";
    }else{
        $namxb=$input_namxb;
    }

    $input_tthai=trim($_POST["trangthai"]);
    if(empty($input_tthai)){
        $trangthai_err="Moi Nhap Trang Thai.";
    }elseif (!ctype_digit($input_tthai)){
        $trangthai_err="Moi nhap vao so";
    }else{
        $trangthai=$input_tthai;
    }


    $input_macn=trim($_POST["macn"]);
    if(empty($input_macn)){
        $macn_err="Moi Nhap Ma The Loai.";
    }elseif (!filter_var($input_macn,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $masach_err="Moi nhap vao chu cai";
    }else{
        $macn=$input_macn;
    }

    if(empty($id_err) && empty($masach_err) && empty($tensach_err) && empty($tacgia_err) && empty($namxb_err)
             && empty($trangthai_err) && empty($macn_err)){
        $sql="insert into sach(masach,tensach,tacgia,namxb,trangthai,macn) values (?,?,?,?,?,?)";
        if($stmt=$mysqli->prepare($sql)){

            $stmt->bind_param("sssiis",$param_masach,
                 $param_tensach,$param_tacgia,$param_namxb,$param_trangthai,$param_macn);


            $param_masach=$masach;
            $param_tensach=$tensach;
            $param_tacgia=$tacgia;
            $param_namxb=$namxb;
            $param_trangthai=$trangthai;
            $param_macn=$macn;
            if($stmt->execute()){
                header("location:book.php");
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
                        <label for="#">Ma Sach</label>
                        <input type="text" name="masach" class="form-control
                            <?php echo (!empty($masach_err)) ? 'is-invalid' : '';?>" value="<?php echo $masach;?>">
                        <span class="invalid-feedback"><?php echo $masach_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Ten Sach</label>
                        <input type="text" name="tensach" class="form-control
                            <?php echo (!empty($tensach_err)) ? 'is-invalid' : '';?>" value="<?php echo $tensach;?>">
                        <span class="invalid-feedback"><?php echo $tensach_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Tac Gia</label>
                        <input type="text" name="tacgia" class="form-control
                            <?php echo (!empty($tacgia_err)) ? 'is-invalid' : '';?>" value="<?php echo $tacgia;?>">
                        <span class="invalid-feedback"><?php echo $tacgia_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Nam Xuat Ban</label>
                        <input type="text" name="namxb" class="form-control
                            <?php echo (!empty($namxb_err)) ? 'is-invalid' : '';?>" value="<?php echo $namxb;?>">
                        <span class="invalid-feedback"><?php echo $namxb_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Trang Thai</label>
                        <input type="text" name="trangthai" class="form-control
                            <?php echo (!empty($trangthai_err)) ? 'is-invalid' : '';?>" value="<?php echo $trangthai;?>">
                        <span class="invalid-feedback"><?php echo $trangthai_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Ma The Loai</label>
                        <input type="text" name="macn" class="form-control
                            <?php echo (!empty($macn_err)) ? 'is-invalid' : '';?>" value="<?php echo $macn;?>">
                        <span class="invalid-feedback"><?php echo $macn_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create">
                    <a href="dashboard.php" class="btn btn-secondary m1-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>