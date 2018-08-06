<?php
use Di\Di;
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Your Website Name</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<?php
$this->insertTemplate('users/navBar.php'); ?>
<?php foreach (Di::getResponse()->getErrors() as $errorMessage) { ?>
<div class="alert alert-danger" role="alert"><?php echo $errorMessage; ?></div>
<?php } ?>
<?php foreach (Di::getResponse()->getMessages() as $message) { ?>
<div class="alert alert-success" role="alert"><?php echo $message; ?></div>
<?php } ?>