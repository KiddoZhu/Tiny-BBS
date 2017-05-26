<?php

include('utils/general.php');

session_unset();
session_destroy();
header('location:/index.html');
?>
