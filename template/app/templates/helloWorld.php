<?php require('header.php'); ?>
Hello <?php (isset($params['name'])) ? $params['name'] : 'world'; ?>!
<?php require('footer.php'); ?>
