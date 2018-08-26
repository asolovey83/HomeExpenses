<?php
require_once('header.php');
session_start();
session_destroy();
header("Location: datainput.php");
?>