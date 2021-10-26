<?php
session_start();
//kiểm tra xem người dùng đã đăng nhập chưa, nếu có thì chuyển hướng người đó đến trang chào mừng
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !==true){
    header("location:login.php");
    exit();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category Details </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

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
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Category Details</h2>
                    <a href="create_category.php" class="btn btn-success pull-right"><i class="fa fa-plus">Add New Category Book</i></a>
                </div>
                <?php
                require_once "config.php";

                $sql="SELECT * from chuyennganh";
                if($result=$mysqli->query($sql)){
                    if($result->num_rows>0){
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo  "<th>ID</th>";
                        echo  "<th>Thể Loại</th>";
                        echo  "<th>Hoạt Động</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row=$result->fetch_array()){
                            echo "<tr>";
                            echo  "<td>" . $row['macn']. "</td>";
                            echo  "<td>" . $row['tencn']. "</td>";
                            echo "<td>";
                            echo '<a href="read_category.php?macn=' . $row['macn'] . '" class="mr-3"
                                                 title="View Recound" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                            echo '<a href="update_category.php?id=' . $row['macn'] . '" class="mr-3"
                                                 title="Update Recound" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="delete_category.php?id=' . $row['macn'] . '"class="mr-3"
                                                 title="Delete Recound" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->free();;
                    }else{
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                }else{
                    echo "Oops!Something went wrong.Please try again later.";
                }
                $mysqli->close();



                ?>
                <p>
                    <a href="dashboard.php" class="btn btn-danger m1-3">Back To Home</a>
                </p>

            </div>
        </div>
    </div>
</div>

</body>
</html>