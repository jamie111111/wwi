<?php
$productsInCart = countProductsInCart();
$cartBadge = '';
if ($productsInCart > 0) {
    $cartBadge = "<span>" . $productsInCart . "</span>";
}

$username = '';
$loginBtn = isset($_SESSION['logged_in']) ? $loginBtn = 'Uitloggen' : 'Inloggen';

if (isset($_POST['header-login-submit']) && $loginBtn == 'Inloggen') {
    ReDirectUserTo('/login');
} else if (isset($_POST['header-login-submit']) && $loginBtn == 'Uitloggen') {
    session_unset();
    session_destroy();
    ReDirectUserTo('/homepage');
}

$headerTop = '
    <div class="header-top">
        <div class="content-container">
            <ul>
                <li>
                    <a href="/homepage">
                        <img src="/assets/images/logo.png" alt="logo" />
                    </a>
                </li>
                <li class="search">
                    <form action="/search" method="GET">
                        <div class="input-search-container">
                            <input class="input-search" type="search" placeholder="Zoek artikel..." name="query" />
                            <button class="input-submit" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </li>
                <li>
                    <form action="/login"  class="login-button-form"  method="POST">
                        <button name="header-login-submit"  class="btn-primary" type="submit"><span class="fa fa-user"></span><span> ' . $loginBtn . '</span></button>
                        
                       
                    </form>
                </li>
                <li>
                    <a class="cart" href="/cart">
                        <img src="/assets/images/shopping-cart.png" alt="shopping-cart" />
                        ' . $cartBadge . '
                    </a>
                </li>
            </ul>
        </div>
    </div>
';
$headerBottom = '
    <div class="header-bottom">
        <div class="content-container">
            <div class="header-bottom-left">
                <ul>
                    <li>
                        <a href="/homepage">Homepagina</a>
                    </li>
                    <li>
                        <a href="/about">Over ons</a>
                    </li>
                </ul>
            </div>
            <div class="welkom"> 
                <li>
                <a href="#"> ' . $username . '</a>
                </li>
            </div>
            <div class="header-bottom-right">
                <ul>
                    <li>
                        <a href="/orderstatus">Bestelstatus</a>
                    </li>
                    <li>
                        <a href="/klantenservice">Klantenservice</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
';
$header = '
    <div class="header">
        ' . $headerTop . '
        ' . $headerBottom . '
    </div>
';
