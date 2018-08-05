<div id="login-bar" class="top-bar container-fluid text-right">
<?php
if (\Di\Di::getAuth()->isLoggedIn()) {
    $user = \Di\Di::getAuth()->getLoggedInUser();
?>
You are logged in as <?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?>. <a href="/Auth/logout">Log Out</a>
<?php } else { ?>
<form action="/Auth/login" method="post">
    Log In
    Email:<input type="text" name="email" value="">
    Password:<input type="password" name="password" value="">
    <input type="submit" value="Submit">
</form>
<?php } ?>
</div>
