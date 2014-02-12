<?php
function p($value, $emp = ':', $print = 'v'){
    if(!empty($emp)){
        print ($emp."  :");
    }

    if(!empty($value)){
        print("<pre>");
        switch($print){
            case 'v': var_dump($value);
                break;

            case 'p': print($value);
                break;

            case 'pr': print_r($value);
                break;
        }
        print("</pre>");
    }
}
?>