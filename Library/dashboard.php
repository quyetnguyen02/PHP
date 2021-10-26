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
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

            font-family: 'Poppins', sans-serif;

        }
        .wrapper {

            height: 100%;

            width: 300px;

            position: relative;

        }
        .wrapper .menu-btn {

            position: absolute;

            left: 20px;

            top: 10px;

            background: #4a4a4a;

            color: #fff;

            height: 45px;

            width: 45px;

            z-index: 9999;

            border: 1px solid #333;

            border-radius: 5px;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            transition: all 0.3s ease;

        }
        #btn:checked~.menu-btn {

            left: 247px;

        }
        .wrapper .menu-btn i {

            position: absolute;

            transform: ;

            font-size: 23px;

            transition: all 0.3s ease;

        }
        .wrapper .menu-btn i.fa-times {

            opacity: 0;

        }
        #btn:checked~.menu-btn i.fa-times {

            opacity: 1;

            transform: rotate(-180deg);

        }
        #btn:checked~.menu-btn i.fa-bars {

            opacity: 0;

            transform: rotate(180deg);

        }
        #sidebar {

            position: fixed;

            background: #404040;

            height: 100%;

            width: 270px;

            overflow: hidden;

            left: -270px;

            transition: all 0.3s ease;

        }
        #btn:checked~#sidebar {

            left: 0;

        }
        #sidebar .title {

            line-height: 65px;

            text-align: center;

            background: #333;

            font-size: 25px;

            font-weight: 600;

            color: #f2f2f2;

            border-bottom: 1px solid #222;
        }
        #sidebar .list-items {

            position: relative;

            background: #404040;

            width: 100%;

            height: 100%;

            list-style: none;
            margin-right: 20px;
        }
        #sidebar .list-items li {

            padding-left: 40px;

            line-height: 50px;

            border-top: 1px solid rgba(255, 255, 255, 0.1);

            border-bottom: 1px solid #333;

            transition: all 0.3s ease;

        }
        #sidebar .list-items li:hover {

            border-top: 1px solid transparent;

            border-bottom: 1px solid transparent;

            box-shadow: 0 0px 10px 3px #222;

        }
        #sidebar .list-items li:first-child {

            border-top: none;

        }
        #sidebar .list-items li a {

            color: #f2f2f2;

            text-decoration: none;

            font-size: 18px;

            font-weight: 500;

            height: 100%;

            width: 100%;

            display: block;

        }
        #sidebar .list-items li a i {

            margin-right: 20px;

        }
        #sidebar .list-items .icons a:hover {

            background: #404040;

        }
        .list-items .icons a:first-child {

            margin-left: 0px;

        }
        .content {

            position: absolute;

            top: 50%;

            left: 50%;

            transform: translate(-50%, -50%);

            color: #202020;

            z-index: -1;

            width: 100%;

            text-align: center;

        }
        .content .header {

            font-size: 35px;

            font-weight: 700;

        }
        .content p {

            font-size: 40px;

            font-weight: 700;

        }
    </style>
</head>
<body>
<div class="wrapper">

    <input type="checkbox" id="btn" hidden>

    <label for="btn" class="menu-btn">

        <i class="fa fa-bars" style="font-size:24px"></i>

        <i class="fa fa-times"></i>

    </label>

    <nav id="sidebar">

        <div class="title">

            <i class="fa fa-home"></i>HOME</div>

        <ul class="list-items">

            <li><a  href="book.php" ><i class="fa fa-book"></i>Quản Lý Sách </a></li>

            <li><a  href="Category_book.php"><i class="fa fa-book"></i>Thể Loại Sách</a></li>

            <li><a href="user.php"><i class="fa fa-user"></i>Quản lý Người đọc</a></li>

            <li><a href="book_borrower.php"><i class="fa fa-user"></i>Quản lý Mượn sách</a></li>

            <li><a href="#"><i class="fa fa-cog"></i>Cài Đặt</a></li>

            <li><a href="#"><i class="fa fa-user"></i>Liên Hệ</a></li>

            <li><a href="logout.php">Đăng Xuất</a></li>
        </ul>

    </nav>

</div>

<div class="content">

    <div class="header">

        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?>
            </b>. Welcome to our site.</h1>

</div>
</body>
</html>