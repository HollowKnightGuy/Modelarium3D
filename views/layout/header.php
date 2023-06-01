<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <?php
    if(isset($_SESSION['identity']) && $_SESSION['identity'] != false){
        $session = $_SESSION['identity'];
    }else{
        $session = false;    
    }


    ?>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body style="cursor:auto;">
    <header>
        <nav class="generic-nav">
            <ul class="header-links">
                <div class="header-link dblockresponsive menu btn1" data-menu="1">
                    <div class="icon-left"></div>
                </div>
                <li class="header-logo">
                    <a href="<?= $_ENV['BASE_URL'] ?>">
                        <img src="<?= $_ENV['BASE_URL'] ?>img/logo/logo.png" alt="logo" class="logo">
                        <h1 class="header-title">Modelarium</h1>
                    </a>
                </li>
                <li class="header-link dnoneresponsive2">
                    <span>|</span>
                </li>

                <?php if(!isset($_SESSION['admin'])): ?>

                <li class="dnoneresponsive header-link">
                    <a href="<?= $_ENV['BASE_URL'] ?>home">Home</a>
                </li>
                <li class="dnoneresponsive header-link">
                    <a href="<?= $_ENV['BASE_URL'] ?>models">Models</a>
                </li>
                <li class="dnoneresponsive header-link">
                    <a href="<?= $_ENV['BASE_URL'] ?>contact">Contact</a>
                </li>
                <?php endif;?>

                
                <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                    <li class="dnoneresponsive header-link">
                        <a href="<?= $_ENV['BASE_URL'] ?>admin/requests">Requests</a>
                    </li>

                    <li class="dnoneresponsive header-link">
                        <a href="<?= $_ENV['BASE_URL'] ?>admin/users">Users</a>
                    </li>

                <?php endif;?>
                <?php if(!isset($_SESSION['admin']) || !$_SESSION['admin']): ?>
                    <li class="header-link searcher">
                        <form action="#" class="searchbar">
                            <input type="text" name="search">

                            <img class="link-icon magn-glass" src="<?= $_ENV['BASE_URL'] ?>img/icons/magn-glass.svg" alt="">
                        </form>
                    </li>
                <?php endif; ?>
                <div class="user-options dnoneresponsive2">
                    <?php if($session): ?>
                        <li class="header-link user-link transition">
                            <a href="<?= $_ENV['BASE_URL'] ?>logout">
                                logout
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php if(!isset($_SESSION['admin']) || !$_SESSION['admin']): ?>

                    <li class="header-link user-link transition">
                        <a href="<?= $_ENV['BASE_URL'] ?><?= $session ? 'profile' : 'login'; ?>">
                            <img class="link-icon heart-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/heart.svg" alt="">
                            <img class="none heart-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/heart-red.svg" alt="">
                        </a>
                    </li>
                    <li class="header-link user-link">
                        <a href="<?= $_ENV['BASE_URL'] ?><?= $session ? 'profile' : 'login'; ?>">
                            <img class="link-icon star-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/star.svg" alt="star.png">
                            <img class="none star-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/star-yellow.svg" alt="star.png">
                        </a>
                    </li>

                <?php endif; ?>

                    <li class="header-link user-link">
                        <a href="<?= $_ENV['BASE_URL'] ?><?= $session ? 'profile' : 'login'; ?>">
                            <img class="link-icon profile-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/profile.svg" alt="profile.png">
                            <img class="none profile-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/profile-blue.svg" alt="profile.png">

                        </a>
                    </li>
                </div>


            </ul>
            <form action="#">
                <div class="responsivesearcher transition">
                    <input type="text" name="search">
                </div>
            </form>

            <ul class="responsivemenu transition">
                <div id="general-menu-section">

                    <li>
                        <a class="transition" href="<?= $_ENV['BASE_URL'] ?>home">
                            <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/home.svg" alt="home.svg">
                            <span>Home</span>
                        </a>
                    </li>

                    <li>
                        <a class="transition" href="<?= $_ENV['BASE_URL'] ?>models">
                            <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/model.svg" alt="models.svg">
                            <span>Models</span>
                        </a>
                    </li>

                    <li>
                        <a class="transition" href="<?= $_ENV['BASE_URL'] ?>contact">
                            <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/contact.svg" alt="contact.svg">
                            <span>Contact</span>
                        </a>
                    </li>

                    <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?>">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/admin.svg" alt="admin.svg">
                                <span>Admin</span>
                            </a>
                        </li>
                    <?php endif;?>

                    <li>
                        <a class="transition" href="<?= $_ENV['BASE_URL'] ?>aboutus">
                            <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/team.svg" alt="team.svg">
                            <span>About us</span>
                        </a>
                    </li>
                    <?php if(!$session): ?>
                        <li>
                            <a class="transition" id="account-responsive-link" href="<?= $_ENV['BASE_URL'] ?>login" style="cursor:pointer;">
                                <div>
                                    <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/profile.svg" alt="account.svg">
                                    <span>Account</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if($session): ?>
                        <li>
                            <a class="transition" id="account-responsive-link" style="cursor:pointer;">
                                <div>
                                    <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/profile.svg" alt="account.svg">
                                    <span>Account</span>
                                </div>
                                <div>
                                    <img style="right:0;" class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/front-arrow.svg" alt="front-arrow.svg">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?>logout">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/logout.svg" alt="logout.svg">
                                <span>Log Out</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(!$session): ?>
                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?>login">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/login.svg" alt="login.svg">
                                <span>Login</span>
                            </a>
                        </li>
                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?>register">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/register.svg" alt="register.svg">
                                <span>Register</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </div>

                <?php if($session): ?>
                    <div id="responsive-menu-profilesection">
                        <li>
                            <a class="transition" id="back-account-responsive-link" style="cursor:pointer;">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/back-arrow.svg" alt="back-arrow.svg">
                                <span>Account</span>
                            </a>
                        </li>

                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?><?= $session ? 'profile' : 'login'; ?>">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/profile.svg" alt="profile.svg">
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?><?= $session ? 'profile' : 'login'; ?>">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/heart.svg" alt="likes.svg">
                                <span>Likes</span>
                            </a>
                        </li>

                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?><?= $session ? 'profile' : 'login'; ?>">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/star.svg" alt="profile.svg">
                                <span>Favorites</span>
                            </a>
                        </li>
                        <li>
                            <a class="transition" href="<?= $_ENV['BASE_URL'] ?><?= $session ? 'profile/settings' : 'login'; ?>">
                                <img class="link-icon" src="<?= $_ENV['BASE_URL'] ?>img/icons/gearsettings.svg" alt="profile.svg">
                                <span>Settings</span>
                            </a>
                        </li>
                    </div>
                <?php endif; ?>
            </ul>
        </nav>
    </header>