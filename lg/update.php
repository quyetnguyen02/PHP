<?php
session_start();
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !==true){
    header("location:login_demo.php");
    exit();
}
?>
<?php
require_once "config_demo.php";

$name=$address=$salary="";
$name_err=$address_err=$salary_err="";

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id=$_POST["id"];

    //validate
    $input_name=trim($_POST["name"]);
    if(empty($input_name)){
        $name_err="Please enter a name";
    }elseif (!filter_var($input_name,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err="Please enter a valid name";
    }else{
        $name=$input_name;
    }

    $input_address=trim($_POST["address"]);
    if(empty($input_address)){
        $address_err="please enter an address.";
    }else{
        $address=$input_address;
    }

    $input_salary=trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err="Please enter the salary amount.";
    }elseif (!ctype_digit($input_salary)){
        $salary_err="Please enter a positive integer values.";
    }else{
        $salary=$input_salary;
    }

    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        $sql="update employees set name=?, address=?, salary=? where id=?";

        if($stmt=$mysqli->prepare($sql)){
            $stmt->bind_param("sssi",$param_name, $param_address, $param_salary, $param_id);
            $param_name=$name;
            $param_address=$address;
            $param_salary=$salary;
            $param_id=$id;

            if($stmt->execute()){
                header("location:dashboard.php");
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
        $sql="select * from employees where id=?";
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
                    $name=$row["name"];
                    $address=$row["address"];
                    $salary=$row["salary"];
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
    <title>Update Record</title>
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
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the employee record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER["REQUEST_URI"]));?>" method="post">
                    <div class="form-group">
                        <label for="#">Name</label>
                        <input type="text" name="name" class="form-control
                            <?php echo (!empty($name_err)) ? 'is-invalid' : '';?>" value="<?php echo $name;?>">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </div>

                    <div class="form-group">
                        <label for="#">Address</label>
                        <textarea name="address" class="form-control
                              <?php echo (!empty($address_err)) ? 'is-invalid' : '';?>" value="<?php echo $address;?>"></textarea>
                        <span class="invalid-feedback"><?php echo $address_err;?></span>
                    </div>
                    <div class="form-group">
                        <label for="#">Salary</label>
                        <input type="text" name="salary" class="form-control
                            <?php echo (!empty($salary_err)) ? 'is-invalid' : '';?>" value="<?php echo $salary;?>">
                        <span class="invalid-feedback"><?php echo $salary_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="dashboard.php" class="btn btn-secondary m1-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>