<?php
session_start();
session_destroy();
header("Location: captcha.php");
exit();
