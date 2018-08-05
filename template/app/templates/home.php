<?php $this->insertTemplate('header.php'); ?>
<?php $this->insertTemplate('users/loginBar.php'); ?>
Hello <?php echo(($name) ? $name : 'world'); ?>!
<form action="" method="post">
    Your Name:<input type="text" name="name" value="<?php echo $name; ?>">
    <input type="submit" value="Submit">
</form>
<?php $this->insertTemplate('footer.php'); ?>
