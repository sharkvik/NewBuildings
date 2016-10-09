<?
header("Content-type: text/html; charset=utf-8");
header("cache-control: private, max-age = 3600");
?>
<!DOCTYPE html>
<html>
    <head>
        <title><? echo $pageTitle; ?></title>
        <link href="<? echo CSS.'?'.filemtime( SITE_ROOT.CSS );?>" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?
            Logger::Show();
            include $content;
        ?>
    </body>
</html>