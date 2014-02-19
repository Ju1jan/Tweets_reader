<?php
require_once('print_p.php');
require_once('DB_tweet_proc.php');

//require_once('../Libs/twitteroauth.php');
//require_once('../config/config.php');

/** PHPExcel */
include __DIR__ . '/../libs/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include __DIR__ . '/../libs/PHPExcel/Writer/Excel2007.php';


function oAuth_twitter_reader() {
    //svEx(); save to excel

    $filter_config = include_once(__DIR__ . '/../config/filter_config.php');
    $db_config = include_once(__DIR__ . '/../config/db_config.php');
    $db_proc_class = new DB_tweet_proc();
    $oauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, OAUTH_TOKEN, OAUTH_SECRET); //инициализируем класс с ключами доступа

    $response = $oauth->get('friends/ids'); //получаем id друзей

    if (hasError($response, 'ids')) {
        echo getErrorMes($response);
        return false;
    }

    $userIds = $response->ids;

    foreach ($userIds as $user_id) {
        $tweets = $oauth->get('statuses/user_timeline', array('user_id' => $user_id)); //получаем последние сообщения пользователя по id
        $response_friend_list = $oauth->get("users/show", array('id' => $user_id));

        if (isset($response_friend_list->name)) {
            $user_name = $response_friend_list->name;
        }
        else {
            $user_name = $user_id;
        }

        echo "<div class='user_block'>";

        echo "<p> <span> User id: $user_id  User name: $user_name </span> </p>";

        if (!empty($tweets)) {
            foreach ($tweets as $tweet_key) {                       //выводим сообщения из массива по ключу

                $db_proc_class->base_save_mes($user_id, $user_name, $tweet_key->text, $tweet_key->created_at); //ok

                //saveToBase($db_config, $user_name, $tweet_key->text, $user_id, $tweet_key->created_at);
                //ignore_Filter($tweet_key->text, $filter_config);
                //$messages = $db_proc_class->base_read_mes($user_id);


                print "<p> <span> $user_name : </span> $tweet_key->text </p>";
                //save_Mess_to_file($user_name, $tweet_key->text, $filter_config);
            }
        }
        else {
            print("No tweets or no internet");
        }
        echo("</div>");
    }
}

function ignore_Filter(&$tweet, $config) {
    $ignore_words = $config['ignoreWords'];

    foreach ($ignore_words['IgnoreWithWord'] as $word) {
        if (is_numeric(strpos($tweet, $word))) {
            $tweet = "Цензура!";
        }
    }
}

function save_Mess_to_file($user_name, $tweet, $config) {
    $save_words = $config['saveWords'];

    foreach ($save_words['SaveWithWord'] as $word) {
        if (is_numeric(strpos($tweet, $word))) {
            file_put_contents("save.txt", $user_name . ": " . $tweet . PHP_EOL, FILE_APPEND);
        }
    }
}

function hasError($response, $field_key) {
    if (!empty($response->errors) || empty($response->{$field_key})) {
        return true;
    }
    else {
        return false;
    }
}

function getErrorMes($response) {
    foreach ($response->errors as $error) {
        return ("Error: " . $error->message . " Code is: " . $error->code);
    }
}

function saveToBase($db_config, $user_name, $tweet, $user_id, $created_date) {
    mysql_connect("127.0.0.1", $db_config['user_name'], "") or die("Can't connect" . mysql_error());
    mysql_select_db("tweets_base") or die("Can't select" . mysql_error());
    $created_date = date('d.m.Y G:i:s', strtotime($created_date));

    $response_save = mysql_query("
        INSERT INTO  `tweets` (`id`, `friend_id`, `friend_name`, `message`, `tweet_time`)
        VALUES (NULL, '$user_id' , '$user_name' ,  '$tweet', '$created_date')
    ") or die(mysql_error());
}

//TODO: класс для работы с базой(подключение в конструкторе, отключение в деструкторе, метод добавления, чтения, удаления, обновления) привязка к таблице
//структура: скрипт чтения из тветтера и записи в бд, скрипт чтения из базы и вывода, класс для бд, отладочный и релизный хтмли
function svEx() {
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
}