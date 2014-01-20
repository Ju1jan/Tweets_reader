<?php

require_once('../libs/twitteroauth.php');
require_once('../config/config.php');

function oAuth_twitter_reader()
{
    $oauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);          //инициализируем класс с ключами доступа

    $friend_id = $oauth->get('friends/ids'); //получаем id всех друзей

    //извлекаем id ользователя
    foreach($friend_id as $key)
    {
        foreach($key as $id_key => $value){
            echo("Сообщения пользователя с id:".$value);
            echo("</br>");

            $tweets = $oauth->get('statuses/user_timeline', array('user_id' => $value));  //получаем последние сообщения пользователя по id

            foreach($tweets as $tweet_key)                                                //выводим сообщения
            {
                print_r($tweet_key->text);
                echo("</br>");
            }
        }
    }
    echo ("</br>");

}

oAuth_twitter_reader();

?>
