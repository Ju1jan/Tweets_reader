<?php
include('print_p.php');
//require_once('../Libs/twitteroauth.php');
//require_once('../config/config.php');

function oAuth_twitter_reader()
{
    $oauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);          //инициализируем класс с ключами доступа

    $response = $oauth->get('friends/ids');

    /*print '<pre>';
    print_r($response);
    print '</pre>';*/

    if (!empty($response->errors) || empty($response->ids)){
        if(empty($response->errors)){
            print("No id!");
        }
        else{
            foreach ($response->errors as $user_id)
            {
                //var_dump($user_id);
                echo("Error: " . $user_id->message . " Code is: " . $user_id->code);
            }
        }
    }
    else{

        foreach ($response->ids as $user_id) {
            $tweets = $oauth->get('statuses/user_timeline', array('user_id' => $user_id));  //получаем последние сообщения пользователя по id

            $response_friend_list = $oauth->get("users/show", array('id' => $user_id));
            $us_name = $response_friend_list->name;
            //p($response_friend_list, "user_info", 'v');
            echo("<div class='user_block'>");
            echo (!empty($us_name)) ? ("<p>"."<span>"."User id: ".$user_id."  User name: ". $us_name. "</span>"."</p>") : ("<p>"."<span>"."User id: ".$user_id." But no name:("."</span"."</p>");
            if(!empty($tweets)){
                foreach ($tweets as $tweet_key) //выводим сообщения
                {
                    print_r("<p>"."<span>". $us_name . ": " . "</span>" . $tweet_key->text . "</p>");
                }
            }
            else{
                print("No tweets or no internet");
            }
            echo("</div>");
        }
    }
}
?>