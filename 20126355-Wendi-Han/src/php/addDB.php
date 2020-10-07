<!-- this file deal with register application, add the user in database and if username exist give a warning
 and back to register page -->
<?php
include("connect.php");

$log = $_GET['log'];

$user = $_POST["username"];
$psw = hash("sha256",$_POST["password"]);

// recognize different people search in different table
if($log == 'customer') {
    $sql = "SELECT username, password FROM customer WHERE (username = '$user' and password = '$psw')";
} else if ($log == 'reps'){
    $sql = "SELECT username, password FROM reps WHERE (username = '$user' and password = '$psw')";
} else if ($log == 'manager'){
    $sql = "SELECT username, password FROM manager WHERE (username = '$user' and password = '$psw')";
}

$sql = "SELECT username, password FROM reps WHERE (username='$user' and password='$psw')";
$result = $conn->query($sql);
$nrows = $result->num_rows;

if($nrows === 0){
    $realname = $_POST["realname"];
    $passport = $_POST["passport"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $region = $_POST["region"];

    // different insert into different table
    if($log == 'customer') {
        $sql = "INSERT INTO customer (username, password, realname, passport,tel, email, region) VALUES ('$user', '$psw', '$realname', '$passport','$tel', '$email', '$region')";
    } else if ($log == 'reps'){
        $ID = $_POST['ID'];
        $MAN = $_POST['MAN'];
        $sql = "INSERT INTO reps (ID, username, password, realname, passport,tel, email, region, managerName) VALUES ('ID', '$user', '$psw', '$realname', '$passport','$tel', '$email', '$region', '$MAN')";
    } else if ($log == 'manager'){
        $sql = "INSERT INTO manager (username, password, realname, passport,tel, email, region) VALUES ('$user', '$psw', '$realname', '$passport','$tel', '$email', '$region')";
    }

    if($conn->query($sql) === true)
    {
        session_start();
        $_SESSION['username']=$user;
        echo "Register successfully";
        $conn->close();
        if ($log == 'customer') {
            header("location:../customer-index.php");
        } else if($log == 'reps') {
            header("location:../reps-index.php");
        }else if($log == 'manager'){
            header("location:../manager-index.php");
        }
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
else {
    echo "<script>alert('user have existed！'); history.go(-1);</script>";
}
$conn->close();

?>