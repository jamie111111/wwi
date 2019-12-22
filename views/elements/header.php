<?php
$productsInCart = countProductsInCart();
$cartBadge = '';
if ($productsInCart > 0) {
    $cartBadge = "<span>" . $productsInCart . "</span>";
}
$loginButtonName = '';
$loginData = GetLoginData($connection);
$emailBtn = isset($_SESSION['login']) ? $_SESSION['login'] : '';
// unset($_SESSION['login']);
if ($emailBtn) {
    $loginButtonName = 'Ingelogd';
} else {
    $loginButtonName = 'Inloggen';
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
                    <form class="login-button-form" action="/login" method="POST">
                        <button class="btn-primary" type="submit"><span class="fa fa-user"></span><span> ' . $loginButtonName . '</span></button>
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
