<?php

//require_once('../Libs/twitteroauth.php');
//require_once('../config/config.php');

function oAuth_twitter_reader()
{
    $oauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);          //инициализируем класс с ключами доступа

    $friend_id = $oauth->get('friends/ids'); //получаем id всех друзей

    //извлекаем id ользователя
    foreach($friend_id as $key)
    {
        //var_dump($key);
        foreach($key as $id_key => $value){
            echo("<p>"."Message from id:".$value."</p>");

            $tweets = $oauth->get('statuses/user_timeline', array('user_id' => $value));  //получаем последние сообщения пользователя по id

            foreach($tweets as $tweet_key)                                                //выводим сообщения
            {
                print_r("<p>".$tweet_key->text."</p>");
            }
        }
    }
}

//oAuth_twitter_reader();

?>
