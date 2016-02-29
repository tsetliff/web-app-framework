<?php require('header.php'); ?>
Hello <?php echo(($name) ? $name : 'world'); ?>!
<form action="" method="post">
    Your Name:<input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <input type="submit" value="Submit">
</form>
<?php require('footer.php'); ?>
