<?php

function index(){
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $postdata['secret'] = '6LcdqvorAAAAADRZJnYxtBtdSGJCgjhUeB4jUgYM';
    $postdata['response'] = $_REQUEST['g-recaptcha-response'];
    $res = curl_http($url,$postdata,'post');

    var_dump($res);
}
?>
