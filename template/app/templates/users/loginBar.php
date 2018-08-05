<div id="login-bar" class="top-bar">
<?php
if (\Di\Di::getAuth()->isLoggedIn()) {
    $user = \Di\Di::getAuth()->getLoggedInUser();
?>
You are logged in as <?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?>. <a href="/Auth/logout">Log Out</a>
<?php } else { ?>
Please log in!
<form action="/Auth/login" method="post">
    Email:<input type="text" name="email" value="">
    Password:<input type="password" name="password" value="">
    <input type="submit" value="Submit">
</form>
<?php } ?>
</div>
