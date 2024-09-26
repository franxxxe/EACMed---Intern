<?php
  session_start();
  unset($_SESSION['StudentSessionID']);
  session_destroy();
  header("Location: ../Student Login");
?>