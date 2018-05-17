<?php
//twitteroauth.phpをインクルードします。
require_once("./twitteroauth.php");
 
//Consumer keyの値を格納
$consumerKey = "";
//Consumer secretの値を格納
$consumerSecret = "";
//Access Tokenの値を格納
$accessToken = "";
//Access Token Secretの値を格納
$accessTokenSecret = "";

//OAuthオブジェクトを生成する
$twitterOAuth = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);

$param = array(
    "q"=>"JustinBieber",
    "count"=>100,
    "result_type"=>"recent");
$json = $twitterOAuth->OAuthRequest("https://api.twitter.com/1.1/search/tweets.json", "GET", $param);
$result = json_decode($json, true);

$count = 1;
foreach ($result as $value) {
    foreach ($value as $value1) {
        //写真付きtweetのみ対象にする
        if(isset($value1["entities"]["media"]) && $value1["entities"]["media"][0]["type"] == 'photo'){
            $url = $value1["entities"]["media"][0]["media_url"];
            $data = file_get_contents($url);
            $filename = 'JustinPhoto'.$count;
            //写真の拡張子を取得
            $arr = explode('.', $url);
            $extension = end($arr);
            //ディレクトリに写真を保存していく
            file_put_contents(dirname(__FILE__) . '/' . $filename . '.' . $extension , $data);
            $count++;
            //10枚保存したら処理終了
            if($count === 11){
                exit;
            }
        }
    }
}

?>
