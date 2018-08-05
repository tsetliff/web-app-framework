<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
        <?php
        if (\Di\Di::getAuth()->isLoggedIn()) {
            $user = \Di\Di::getAuth()->getLoggedInUser();
        ?>
        <form class="form-inline my-2 my-lg-0" action="/Auth/logout" method="post">
            <label class="navbar-label navbar-text">You are logged in as <?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?>. </label>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log Out</button>
        </form>
        <?php } else { ?>
        <form class="form-inline my-2 my-lg-0" action="/Auth/login" method="post">
            <div class="form-group">
                <label for="loginEmail" class="navbar-text navbar-label">Email</label>
                <input class="form-control mr-sm-2" id="loginEmail" name="email" type="text" placeholder="Login Email" aria-label="Email">
            </div>
            <div class="form-group">
                <label for="loginPassword" class="navbar-text navbar-label">Password</label>
                <input class="form-control mr-sm-2" id="loginPassword" name="password" type="password" placeholder="Password" aria-label="Password">
            </div>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log In</button>
        </form>
        <?php } ?>
    </div>
</nav>