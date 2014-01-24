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

    <div class="container">

        <header class="header">Hello! (^_^)/ </header>

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
                    <p><?  oAuth_twitter_reader();  ?></p>
                </div>
             </article>
        </div>

    </div>


</body>
</html>