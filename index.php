<?php

include 'Connection.php';
//error_reporting(0);
set_time_limit(1000);


if (isset($_POST['submit'])) {
    $p_User_Id = $_POST['p_User_Id'];
    $p_User_Pass = $_POST['p_User_Pass'];

    // execute query starts
    // $curs = oci_new_cursor($conn);

    $returnval = 0;
    $stid = oci_parse($conn, "begin DPG_ADMIN_LOGIN.DPD_ADMIN_LOGIN(:o_status,:p_User_Id,:p_User_Pass); end;");


    // oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
    oci_bind_by_name($stid, ":o_status", $returnval, -1, SQLT_INT);
    oci_bind_by_name($stid, ":p_User_Id", $p_User_Id, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_User_Pass", $p_User_Pass, -1, SQLT_CHR);

    oci_execute($stid);
    // oci_execute($curs);
    // execute query ends

    echo $returnval;

    if ($returnval == 1) {
        session_start();
        $_SESSION['USERNAME'] = $p_User_Id;

        header("Location: dashboard.php");
    }
}



?>
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="./img/logo1.ico" type="image/ico">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Login</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
            /* background-color: green; */
            background: url('./img/bg.jpg');
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .box {
            display: flex;
            flex-flow: column;
            height: 100%;
        }

        /* .box .row {
            border: 1px dotted grey;
        } */
        .box .row.header {
            flex: 0 1 auto;
            /* The above is shorthand for:
  flex-grow: 0,
  flex-shrink: 1,
  flex-basis: auto
  */
        }

        .box .row.content {
            flex: 1 1 auto;
        }

        .box .row.footer {
            flex: 0 1 80px;
            background-color: grey;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input {
            display: block;
        }

        .login {
            height: 500px;
            width: 300px;
            /* background-color: yellowgreen; */
        }

        .box1 {
            width: 300px;
            height: 400px;
            padding: 40px;
            /* position: absolute; */
            /* top: 50%; */
            /* left: 50%; */
            /* transform: translate(-50%, -50%); */
            background: #192a56;
            text-align: center;
        }

        .box1 h1 {
            color: #e84118;
            text-transform: uppercase;
            font-size: 14px;
            margin-top: 5px;
        }

        .box1 input[type="text"],
        .box1 input[type="password"] {
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #718093;
            padding: 10px 6px;
            /* padding: 14px 10px; */
            width: 160px;
            /* width: 200px; */
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;


        }

        .box1 input[type="text"]:focus,
        .box1 input[type="password"]:focus {
            width: 200px;
            /* width: 230px; */
            border-color: #e84118;
        }

        .box1 input[type="submit"] {
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #e84118;
            padding: 10px 30px;
            /* padding: 14px 40px; */
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            cursor: pointer;
        }

        .box1 input[type="submit"]:hover {
            background: #e84118;
        }
    </style>
</head>

<body>
    <div class="box">
        <!-- <div class="row header">
            <p><b>header</b>
                <br />
                <br />(sized to content)</p>
        </div> -->
        <div class="row content center ">
            <div class="login center">
                <!-- <div class="box1"> -->
                    <form action="" method="post" class="box1">
                        <img src='./img/Logo.png' alt='BPDB Logo' height='80px' width='80px'>

                        <input type="text" name="p_User_Id" placeholder="Username">
                        <input type="password" name="p_User_Pass" placeholder="Password">
                        <input type="submit" id="submit" name="submit" value="Login">
                    </form>
                <!-- </div> -->
            </div>
        </div>
        <div class="row footer center" style="background-color: #34495e; color: #fff;">
            <div class="title">
                <strong>Powered By Isaam Enterprise Limited</strong>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>