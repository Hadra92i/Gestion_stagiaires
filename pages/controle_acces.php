<?php

if($_SESSION['PROFILE']['role_u'] != 'ADMIN'){
  header('location:../index.php');
}
