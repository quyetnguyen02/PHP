<?php
session_start();
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !==true){
    header("location:login.php");
    exit();
}
?>

<?php
require_once  "config.php";
$masach=$tensach=$tacgia=$namxb=$trangthai="";
$masach_err=$tensach_err=$tacgia_err=$namxb_err=$trangthai_err="";

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id=$_POST["id"];

    $input_masach=trim($_POST["masach"]);
    if(empty($input_masach)){
        $masach_err="Please enter a name";
    }elseif (!filter_var($input_masach,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $masach_err="Please enter a valid name";
    }else{
        $masach=$input_masach;
    }

    $input_tensach=trim($_POST["tensach"]);
    if(empty($input_tensach)){
        $tensach_err="Please enter a name";
    }elseif (!filter_var($input_tensach,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tensach_err="Please enter a valid name";
    }else{
        $tensach=$input_tensach;
    }

    $input_tacgia=trim($_POST["tacgia"]);
    if(empty($input_tacgia)){
        $tacgia_err="Please enter a name";
    }elseif (!filter_var($input_tacgia,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tacgia_err="Please enter a valid name";
    }else{
        $tacgia=$input_tacgia;
    }

    $input_namxb=trim($_POST["namxb"]);
    if(empty($input_namxb)){
        $namxb_err="Please enter a name";
    }elseif (!ctype_digit($input_namxb)){
        $namxb_err="Please enter a valid name";
    }else{
        $namxb=$input_namxb;
    }


    $input_trangthai=trim($_POST["trangthai"]);
    if(empty($input_trangthai)){
        $trangthai_err="Please enter a name";
    }elseif (!ctype_digit($input_trangthai)){
        $trangthai_err="Please enter a valid name";
    }else{
        $trangthai=$input_trangthai;
    }


    if(empty($masach_err) && empty($tensach_err) && empty($tacgia_err) && empty($namxb_err)
             && empty($trangthai_err) && empty($macn_err)){
        $sql="update sach set masach=?,tensach=?, tacgia=?, namxb=?,trangthai=? where id=?";
        if($stmt=$mysqli->prepare($sql)){
            $stmt->bind_param("sssiii",$param_masach,$param_tensach,$param_tacgia,
                $param_namxb,$param_trangthai,$param_id);

            $param_masach=$masach;
            $param_tensach=$tensach;
            $param_tacgia=$tacgia;
            $param_namxb=$namxb;
            $param_trangthai=$trangthai;

            $param_id=$id;
            if($stmt->execute()){
                header("location:book.php");
                exit();
            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }

        }
        $stmt->close();
    }
    $mysqli->close();
}else{
    //check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id=trim($_GET["id"]);
        $sql="select id,masach,tensach,tacgia,namxb,trangthai from sach where id=?";
        if($stmt=$mysqli->prepare($sql)){
            $stmt->bind_param("i",$param_id);
            $param_id=$id;
            if($stmt->execute()){
                $result=$stmt->get_result();
                if($result->num_rows==1){
                    /* fetch result row as an assoclative array.Since the result set contains only are row,we dont't need to use while loop
                    */
                    $row=$result->fetch_array(MYSQLI_ASSOC);
                    //retrieve individual field value
                    $masach=$row["masach"];
                    $tensach=$row["tensach"];
                    $tacgia=$row["tacgia"];
                    $namxb=$row["namxb"];
                    $trangthai=$row["trangthai"];


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
                <h2 class="mt-5">Update Book</h2>
                <p>Please edit the input values and submit to update the employee record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER["REQUEST_URI"]));?>" method="post">
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

                    <input type="hidden" name="id" value="<?php echo $id?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="book.php" class="btn btn-secondary m1-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>