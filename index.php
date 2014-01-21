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
            <p><a href="index.php">First</a> </p>
            <p><a href="index.php">Second</a> </p>
        </aside>

        <div class="right_column">
            <article>
                <textarea class="content">
                    <p><?  oAuth_twitter_reader();  ?></p>
                </textarea>
             </article>
        </div>

    </div>


</body>
</html>