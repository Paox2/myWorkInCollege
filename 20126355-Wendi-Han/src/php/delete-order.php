<!-- Deal with the order deleted by customer, and these number come back to reps' quota -->
<?php
    include("connect.php");
        session_start();
		$user = $_SESSION["username"];
		$orderID = $_COOKIE["orderID"];

        $sql = "SELECT N95, N95m, sm, repsName FROM ordering WHERE orderID='$orderID'";
        $resultQuota = $conn->query($sql);
        $rows = $resultQuota->fetch_assoc();
        $N95 = $rows['N95'];
        $N95m = $rows['N95m'];
        $Sm = $rows['sm'];
        $reps = $rows['repsName'];

        $sql = "SELECT quotaN95, quotaN95m, quotaSm FROM reps WHERE username='$reps'";
        $Quota = $conn->query($sql);
        $rows = $Quota->fetch_assoc();
        $quotaN95 = $rows['quotaN95'];
        $quotaSm = $rows['quotaSm'];
        $quotaN95m = $rows['quotaN95m'];
		setcookie("orderID","",time() - 100, '/');
		if($conn->connect_error)
		{
			die("Connection failed: " . $conn->connect_error);
		}
	
        $aN95 = $quotaN95 + $N95;
        $aN95m = $quotaN95m + $N95m;
        $aSm = $quotaSm + $Sm;
        $sql = "UPDATE reps SET quotaN95 = '$aN95', quotaSm = '$aSm', quotaN95m = '$aN95m' WHERE username = '$reps'";
        $conn->query($sql);
    
		$sql = "UPDATE ordering SET status = 1 WHERE ordering.orderID = $orderID";
		if($conn->query($sql) === true)
		{
			echo "<script>alert('cancel successful');</script>";
			$conn->close();
			header("location:../customer-order.php");
		}
		else
		{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
?>