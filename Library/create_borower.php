<?php
require_once "config.php";

$id=$tenbd=$sachID=$ngaymuon=$ngaytra="";
$id_err=$tenbd_err=$sachID_err=$ngaymuon_err=$ngaytra_err="";

if($_SERVER["REQUEST_METHOD"] =="POST"){
$input_id=trim($_POST["id"]);
    if(empty($input_id)){
        $id_err="Moi Nhap id.";
    }elseif (!ctype_digit($input_id)){
        $id_err="Moi nhap vao chu cai";
    }else{
        $id=$input_id;
    }


    $input_tenbd=trim($_POST["tenbd"]);
    if(empty($input_tenbd)){
        $tenbd_err="Moi Nhap Ten Nguoi Muon.";
    }elseif (!ctype_digit($input_tenbd)){
        $tenbd_err="Moi nhap vao chu cai";
    }else{
        $tenbd=$input_tenbd;
    }

    $input_sachID=trim($_POST["sachID"]);
    if(empty($input_sachID)){
        $sachID_err="Moi Nhap Ten Sach.";
    }elseif (!ctype_digit($input_sachID)){
        $sachID_err="Moi nhap vao chu cai";
    }else{
        $sachID=$input_sachID;
    }


    $input_ngaymuon=trim($_POST["ngaymuon"]);
    if(empty($input_ngaymuon)){
        $ngaymuon_err="Moi Nhap Ngay Muon.";
    }else{
        $ngaymuon=$input_ngaymuon;
    }

    $input_ngaytra=trim($_POST["ngaytra"]);
    if(empty($input_ngaytra)){
        $ngaytra_err="Moi Nhap Ngay Tra.";
    }else{
        $ngaytra=$input_ngaytra;
    }

    if(empty($id_err) && empty($tenbd_err) && empty($tensach_err) && empty($ngaymuon_err) && empty($ngaytra_err)){
        $sql="select id,bd_id,ngaymuon,ngaytra from muonsach where bd_id=?";
        if($stmt=$mysqli->prepare($sql)){

            $stmt->bind_param("i",$param_bdid,);


            $param_bdid=$tenbd;

            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows<2){
                    $sql1="insert into muonsach(bd_id,ngaymuon,ngaytra)";
                    if($stmt1=$mysqli->prepare($sql1)){
                        $stmt1->bind_param("iidd",$param_id,$param_bd,$param_ngaymuon,$param_ngaytra);
                        $param_id=$id;
                        $param_bd=$tenbd;
                        $param_ngaymuon=$ngaymuon;
                        $param_ngaytra=$ngaytra;
                        if($stmt1->execute()){
                            $sql2="insert into muonsach_chitiet(muonsach_id, sach_id) values (?,?)";
                            if($stmt2 =$mysqli->prepare($sql2)){
                                $stmt2->bind_param("ii",$param_muonsachID,$param_sachID);

                                $param_muonsachID=$id;
                                $param_sachID=$sachID;
                                if($stmt2->execute()){
                                    header("location:book_borrower.php");
                                    exit();
                                }else{
                                    echo  "loi dong 77";
                                }
                                $stmt2->close();
                            }else{
                                echo "sai dong 74";
                            }
                        }else{
                            echo "loi dong 72";
                        }$stmt1->close();
                    }
                }else{

                    $tenbd_err="Ten Da MUon Qua 3 lan";

                }$stmt->close();


            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }
        }else{
            echo "sai dong53";
        }


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
                        <label for="#">ID</label>
                        <input type="text" name="id" class="form-control
                            <?php echo (!empty($id_err)) ? 'is-invalid' : '';?>" value="<?php echo $id;?>">
                        <span class="invalid-feedback"><?php echo $id_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Mã Người Mượn</label>
                        <input type="text" name="tenbd" class="form-control
                            <?php echo (!empty($tenbd_err)) ? 'is-invalid' : '';?>" value="<?php echo $tenbd;?>">
                        <span class="invalid-feedback"><?php echo $tenbd_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Mã Sách</label>
                        <input type="text" name="sachID" class="form-control
                            <?php echo (!empty($sachID_err)) ? 'is-invalid' : '';?>" value="<?php echo $sachID;?>">
                        <span class="invalid-feedback"><?php echo $sachID_err;?></span>
                    </div>


                    <div class="form-group">
                        <label for="#">Ngày Mượn</label>
                        <input type="text" name="ngaymuon" class="form-control
                            <?php echo (!empty($ngaymuon_err)) ? 'is-invalid' : '';?>" value="<?php echo $ngaymuon;?>">
                        <span class="invalid-feedback"><?php echo $ngaymuon_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Ngày Trả</label>
                        <input type="text" name="ngaytra" class="form-control
                            <?php echo (!empty($ngaytra_err)) ? 'is-invalid' : '';?>" value="<?php echo $ngaytra;?>">
                        <span class="invalid-feedback"><?php echo $ngaytra_err;?></span>
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