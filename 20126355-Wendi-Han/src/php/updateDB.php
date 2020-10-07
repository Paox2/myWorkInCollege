<!-- this file deal with the data from 'update.php', include user account update, quota update,
     quota re-grant, distribute reps to manager, distribute reps to different region, update the price -->
<?php
include("connect.php");
session_start();
$user = $_SESSION["username"];
$change = $_GET['change'];
$log = $_GET['log'];

if($log == 'repsMan'){
    $manName = $_POST['MAN'];
    $sql = "UPDATE reps SET managerName = '$manName' WHERE username='$change'";
    if ($conn->query($sql) === true) {
        echo "Record updated successfully";
        header("location:../admin-index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}else if($log == 'region') {
    $region = $_POST['region'];
    $sql = "UPDATE reps SET region = '$region' WHERE username='$change'";

    if ($conn->query($sql) === true) {
        echo "Record updated successfully";
        header("location:../manager-index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else if($log == 'regrant') {

    $quotaN95 = $_GET["N95"];
    $quotaSm = $_GET["Sm"];
    $quotaN95m = $_GET["N95m"];
    $N95 = $_POST["N95"];
    $Sm = $_POST["Sm"];
    $N95m = $_POST["N95m"];
    $remainN95 = $quotaN95 + $N95;
    $remainSm = $quotaSm + $Sm;
    $remainN95m = $quotaN95m + $N95m;
    $sql = "UPDATE reps SET quotaN95 = '$remainN95',quotaSm = '$remainSm',quotaN95m = '$remainN95m' WHERE username='$change'";

    if($conn->query($sql) === true)
    {
        echo "Record updated successfully";
        header("location:../manager-index.php");
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else if($log == 'update') {
    $N95 = $_POST["N95"];
    $Sm = $_POST["Sm"];
    $N95m = $_POST["N95m"];
    $sql = "UPDATE reps SET quotaN95 = '$N95',quotaSm = '$Sm',quotaN95m = '$N95m' WHERE username='$change'";

    if($conn->query($sql) === true)
    {
        echo "Record updated successfully";
        header("location:../manager-index.php");
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else if ($log == 'N95price') {
    $N95 = $_POST["N95"];
    $sql = "UPDATE prices SET price='$N95' WHERE name='N95'";

    if($conn->query($sql) === true)
    {
        echo "Record updated successfully";
        header("location:../manager-index.php");
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else if ($log == 'Smprice') {
    $Sm = $_POST["Sm"];
    $sql = "UPDATE prices SET price='$Sm' WHERE name='Sm'";

    if($conn->query($sql) === true)
    {
        echo "Record updated successfully";
        header("location:../manager-index.php");
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else if ($log == 'N95mprice') {
    $N95m = $_POST["N95m"];
    $sql = "UPDATE prices SET price='$N95m' WHERE name='N95m'";

    if($conn->query($sql) === true)
    {
        echo "Record updated successfully";
        header("location:../manager-index.php");
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else {
    if ($change == 'password') {
        $npwd = hash("sha256", $_POST["new-password"]);
        $sql = "UPDATE $log SET password = '$npwd' WHERE username='$user'";
    } else if ($change == 'realname') {
        $realname = $_POST["realname"];
        $sql = "UPDATE $log SET realname = '$realname' WHERE username='$user'";
    } else if ($change == 'passport') {
        $passport = $_POST["passport"];
        $sql = "UPDATE $log SET PASSPORT = '$passport' WHERE username='$user'";
    } else if ($change == 'tel') {
        $tel = $_POST["tel"];
        $sql = "UPDATE $log SET TEL = '$tel' WHERE username='$user'";
    } else if ($change == 'email') {
        $email = $_POST["email"];
        $sql = "UPDATE $log SET email = '$email' WHERE username='$user'";
    } else if ($change == 'region') {
        $region = $_POST["region"];
        $sql = "UPDATE $log SET region = '$region' WHERE username='$user'";
    }


    if ($conn->query($sql) === true) {
        echo "Record updated successfully";
        header("location:../$log-index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>