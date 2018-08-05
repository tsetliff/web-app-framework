<?php $this->insertTemplate('header.php'); ?>
<div class="container">
    <h1>Hello <?php echo(($name) ? $name : 'world'); ?>!</h1>
    <form action="" method="post">
        Your Name:<input type="text" name="name" value="<?php echo $name; ?>">
        <input type="submit" value="Submit">
    </form>
</div>
<?php $this->insertTemplate('footer.php'); ?>
