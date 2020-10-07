<!-- this file is operator in the back-end to check the user exist or not, if exist save in session and jump
to customer index page, if not, back to log in page -->
<?php
include("connect.php");

$log = $_GET['log'];

$user = $_POST["username"];
$psw = $_POST["password"];
if($user == "" || $psw == "")
{
    echo "<script>alert('Please enter username or password！'); history.go(-1);</script>";
}
else
{
    $psw = hash("sha256",$psw);
    if($log == 'customer') {
        $sql = "SELECT username, password FROM customer WHERE (username = '$user' and password = '$psw')";
    } else if ($log == 'reps'){
        $sql = "SELECT username, password FROM reps WHERE (username = '$user' and password = '$psw')";
    } else if ($log == 'manager'){
        $sql = "SELECT username, password FROM manager WHERE (username = '$user' and password = '$psw')";
    }
    $result = $conn->query($sql);

    $nrows = $result->num_rows;
    if($nrows>0)
    {
        session_start();
        $_SESSION['username'] = $user;
        if($log == 'customer') {
            header("location:../customer-index.php");
        } else if ($log == 'reps'){
            header("location:../reps-index.php");
        } else if ($log == 'manager'){
            echo "<script>alert('$user');</script>";
            if($user == "admin" && $psw == "8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918") {
                header("location:../admin-index.php");
            } else {
                header("location:../manager-inform.php");
            }
        }
    }
    else
    {
        echo "<script>alert('Username or password is not correct！');history.go(-1);</script>";
    }
}
$conn->close();
?>