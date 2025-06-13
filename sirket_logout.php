<?php
session_start();
session_destroy();
header("Location: sirket_login.php");
exit();
?> 