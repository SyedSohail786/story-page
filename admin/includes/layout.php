<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title><?= $pageTitle ?? 'Admin Panel' ?></title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
    }
    .main-content {
      margin-left: 250px;
      padding: 30px;
    }
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>
  <div class="main-content">
