<?php
require_once('print_p.php');

//require_once('../Libs/twitteroauth.php');
//require_once('../config/config.php');
/** Include path **/
//ini_set('include_path', ini_get('include_path').';../Classes/');

/** PHPExcel */
include 'c:/WebServers/home/test1.ru/www/Twitter_reader/libs/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include 'c:/WebServers/home/test1.ru/www/Twitter_reader/libs/PHPExcel/Writer/Excel2007.php';


function oAuth_twitter_reader()
{
    svEx();
    $config = include_once('/../config/filter_config.php');

    $oauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);          //инициализируем класс с ключами доступа

    $response = $oauth->get('friends/ids'); //получаем id друзей

    if (hasError($response, 'ids'))
    {
        echo getErroMes($response);
        return false;
    }

    $userIds = $response->ids;

    foreach ($userIds as $user_id)
    {
        $tweets = $oauth->get('statuses/user_timeline', array('user_id' => $user_id)); //получаем последние сообщения пользователя по id
        $response_friend_list = $oauth->get("users/show", array('id' => $user_id));

        if (isset($response_friend_list->name)){
            $user_name = $response_friend_list->name;
        }else{
            $user_name = $user_id;
        }

        //ignore_Filter($tweets, $config);
        //save_Mess($tweets, $config);

        echo "<div class='user_block'>";

        echo "<p> <span> User id: $user_id  User name: $user_name </span> </p>";

        if (!empty($tweets))
        {
            foreach ($tweets as $tweet_key) //выводим сообщения из массива по ключу
            {
                ignore_Filter($tweet_key->text, $config);
                print "<p> <span> $user_name : </span> $tweet_key->text </p>";
                save_Mess($user_name, $tweet_key->text, $config);


            }
        }
        else
        {
            print("No tweets or no internet");
        }

        echo("</div>");
    }

}

function ignore_Filter(&$tweet, $config)
{
    $ignore_words = $config['ignoreWords'];

    foreach ($ignore_words['IgnoreWithWord'] as $word)
    {
        if (is_numeric(strpos($tweet, $word)))
        {
            $tweet = "Цензура!";
        }
    }
}

function save_Mess($user_name, $tweet, $config)
{
    $save_words = $config['saveWords'];

        foreach ($save_words['SaveWithWord'] as $word)
        {
            if (is_numeric(strpos($tweet, $word)))
            {
                file_put_contents("save.txt", $user_name . ": " .  $tweet . PHP_EOL, FILE_APPEND);

            }
        }
}

function hasError($response, $field_key)
{
    if (!empty($response->errors) || empty($response->{$field_key}))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getErrorMes($response)
{
    foreach ($response->errors as $error)
    {
        return ("Error: " . $error->message . " Code is: " . $error->code);
    }
}

function svEx(){
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
}