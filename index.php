<?php
    include 'framework/packagesLoader.php';
    using( DOMAIN.'.domain.User' );


    $pageTitle = "ПИА Новостройки | Главная";
    $content = SITE_ROOT."/root.php";

    include( SITE_ROOT."/layout.php");