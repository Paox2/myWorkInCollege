<!-- Add the order into database and update reps quota of masks -->
<?php
        include("connect.php");
        session_start();
		$user = $_SESSION["username"];
		$reps = $_COOKIE["reps"];
        
        $sql = "SELECT quotaN95, quotaN95m, quotaSm FROM reps WHERE username='$reps'";
        $resultQuota = $conn->query($sql);
        $rows = $resultQuota->fetch_assoc();
        $quotaN95 = $rows['quotaN95']; 
        $quotaN95m = $rows['quotaN95m'];
        $quotaSm = $rows['quotaSm'];
        
		$N95 = $_COOKIE["N95"];
		$Sm = $_COOKIE["Sm"];
		$N95m = $_COOKIE["N95m"];
		$sumprice = $_COOKIE["sum"];
		$region = $_COOKIE["region"];
        setcookie("reps","",time() - 100,'/');
        setcookie("N95","",time() - 100,'/');
        setcookie("Sm","",time() - 100,'/');
        setcookie("N95m","",time() - 100,'/');
        setcookie("sum","",time() - 100,'/');
        setcookie("region","",time() - 100,'/');

        // if not purchase something, not add into order
		if($sumprice == '0.0' || $sumprice == '0.00') {
            header("location:../customer-purchase.php");
        } else {
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO ordering (time, customerName, repsName,region, N95, sm, N95m, sumprice) VALUES (now(), '$user', '$reps','$region', '$N95', '$Sm', '$N95m', '$sumprice')";

            if($conn->query($sql) === true)
            {
                echo "<script>alert('submit successful');</script>";

                $aN95 = $quotaN95 - $N95;
                $aN95m = $quotaN95m - $N95m;
                $aSm = $quotaSm - $Sm;
                $sql = "UPDATE reps SET quotaN95 = '$aN95', quotaSm = '$aSm', quotaN95m = '$aN95m' WHERE username = '$reps'";
                $conn->query($sql);

                header("location:../customer-index.php");
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;

            }
		}
$conn->close();
?>