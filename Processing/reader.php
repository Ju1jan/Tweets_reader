<?php

//require_once('../Libs/twitteroauth.php');
//require_once('../config/config.php');

function oAuth_twitter_reader()
{
    $oauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);          //инициализируем класс с ключами доступа

    $response = $oauth->get('friends/ids');

    /*print '<pre>';
    print_r($response);
    print '</pre>';*/

    if (!empty($response->errors)){
        foreach ($response->errors as $val)
        {
            //var_dump($val);
            echo("Error: " . $val->message . " Code is: " . $val->code);
        }
    }
    else{
        //var_dump($response);
        foreach ($response->ids as $val) {
            echo("<p>"."User id: ".$val."</p>");
            $tweets = $oauth->get('statuses/user_timeline', array('user_id' => $val));  //получаем последние сообщения пользователя по id

            foreach($tweets as $tweet_key)                                                //выводим сообщения
            {
                print_r("<p>".$tweet_key->text."</p>");
            }
        }
    }
}
?>