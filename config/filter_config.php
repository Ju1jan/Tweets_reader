<?php

    $ignore_words = array('IgnoreWithWord' => array("появились", "блять", "хуй", "торопишь"));  //фильтр для отсеивания сообщений с введенными словами

    $save_words = array('SaveWithWord' => array("пирог", "музыке", "врут", "дар"));  //сообщения с этими словами будут сохраняться
    return array(
        'ignoreWords' => $ignore_words,
        'saveWords' => $save_words,
    );