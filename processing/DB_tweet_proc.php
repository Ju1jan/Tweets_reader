<?php
include_once('/../config/db_config.php');


class DB_tweet_proc { //TODO: class name??

    function __construct($db_config) {
        //p($db_config); //TODO: $db_config == true!!??
        $connect_link = mysql_connect("127.0.0.1", 'root'/*$db_config['user_name']*/, "") or die("Can't connect" . mysql_error());
        mysql_select_db("tweets_base") or die("Can't select" . mysql_error());
    }

    function base_save_mes($user_id, $user_name, $tweet, $created_date) {

        $created_date = date('d.m.Y G:i:s', strtotime($created_date));

        $response_save = mysql_query("
        INSERT INTO  `tweets` (`id`, `friend_id`, `friend_name`, `message`, `tweet_time`)
        VALUES (NULL, '$user_id' , '$user_name' ,  '$tweet', '$created_date')
    ") or die(mysql_error());
    }

    function base_read_mes($user_id = '', $user_name = '', $created_time = '') {//TODO: how return?
        switch (!empty($user_id) || !empty($user_name) || !empty($created_time)) {

            case isset($user_id):
                $request = mysql_query("
                        SELECT * FROM `tweets` WHERE `friend_id` = '$user_id'
                    ");
                while ($base_date = mysql_fetch_array($request));
                break;

            case isset($user_name):
                $request = mysql_query("
                        SELECT * FROM `tweets` WHERE `friend_name` = '$user_name'
                    ");
                while ($base_date = mysql_fetch_array($request));
                break;

            case isset($created_time):
                $request = mysql_query("
                        SELECT * FROM `tweets` WHERE `friend_id` = '$created_time'
                    ");
                while ($base_date = mysql_fetch_array($request));
                break;

            default:
                $request = mysql_query("
                            SELECT * FROM `tweets` WHERE 1;
                      ") or die(mysql_error());
                while ($base_date = mysql_fetch_array($request));

        }
        return $request;
    }

    function base_delete_mes($user_id = '', $user_name = '', $created_time = '') {

        switch (!empty($user_id) || !empty($user_name) || !empty($created_time)) {

            case isset($user_id):
                $request = mysql_query("
                        DELETE FROM `tweets` WHERE `friend_id` = '$user_id'
                    ");
                break;

            case isset($user_name):
                $request = mysql_query("
                        DELETE FROM `tweets` WHERE `friend_name` = '$user_name'
                    ");
                break;

            case isset($created_time):
                $request = mysql_query("
                        DELETE FROM `tweets` WHERE `friend_id` = '$created_time'
                    ");
                break;

            default:
                $request = false;
        }
        return $request;
    }


    function __destruct() { //:TODO: how?
        //mysql_close($connect_link) or die(mysql_error());
    }
}
