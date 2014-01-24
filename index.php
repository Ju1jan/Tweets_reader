<!DOCTYPE html>
<html>
<?
require_once('libs/twitteroauth.php');
require_once('config/config.php');
require_once('processing/reader.php');
?>
<head>
    <title>Twitter reader</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>

    <header class="header"><p>Hello! (^_^)/ </p></header>

    <div class="container">

        <aside class="left_column">
            <ul class="menu_head">
                <li><a href="">Menu</a>
                    <ul>
                        <li><a href="">One</a></li>
                        <li><a href="">Two</a></li>
                        <li><a href="">Three</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        <div class="right_column">
            <article>
                <div class="content">
                    <? oAuth_twitter_reader();  ?>
                </div>
             </article>
        </div>

    </div>


</body>
</html>