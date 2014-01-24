<?php
include('print_p.php');
//require_once('../Libs/twitteroauth.php');
//require_once('../config/config.php');

function oAuth_twitter_reader()
{
    $oauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);          //инициализируем класс с ключами доступа

    $response = $oauth->get('friends/ids');

    //var_dump($response_friend_list);
    //var_dump($response);
    /*print '<pre>';
    print_r($response);
    print '</pre>';*/

    //p($response,"user_info", 'v');

    if (!empty($response->errors) || empty($response->ids)){
        if(empty($response->errors)){
            print("No id!");
        }
        else{
            foreach ($response->errors as $val)
            {
                //var_dump($val);
                echo("Error: " . $val->message . " Code is: " . $val->code);
            }
        }
    }
    else{

        foreach ($response->ids as $val) {
            echo("<p>"."User id: ".$val."</p>");
            //$response_friend_list = $oauth->get("users/show", array('id' => $val));
            //p($response_friend_list, 'user_info', 'v');
            $tweets = $oauth->get('statuses/user_timeline', array('user_id' => $val));  //получаем последние сообщения пользователя по id

            if(!empty($tweets)){
                foreach ($tweets as $tweet_key) //выводим сообщения
                {
                    print_r("<p>" . $tweet_key->text . "</p>");
                }
            }
            else{
                print("No tweets or no internet");
            }
        }
    }
}
?>