<!-- delete the quota, also can put this part in the start of 'login.php' -->
<?php
session_start();
if(isset($_SESSION["username"]))
    unset($_SESSION["username"]);

header("location:../login.php");
?>