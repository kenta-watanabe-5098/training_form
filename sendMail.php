<?php
session_start();
if(!isset($_SESSION['join'])) {
	header('Location: input.php');
	exit();
}

$url = "https://hlw9zpstkf.execute-api.ap-northeast-1.amazonaws.com";
$header = ['Content-Type: multipart/form-data','x-api-key : wFRndCxe2ido3kcCvUQa8OFw0W5wfEf7UJRZ1Rfb'];

$post = array();
$post['dest'] = htmlspecialchars($_SESSION['join']['dest'], ENT_QUOTES);
$post['subject'] = htmlspecialchars($_SESSION['join']['subject'], ENT_QUOTES);
$post['body'] = htmlspecialchars($_SESSION['join']['body'], ENT_QUOTES);
$post['attachments'] = [[$_SESSION['file']['name']]] + [[$_SESSION['file']['type'] . ';base64,' . base64_encode(file_get_contents("upload/" . $_SESSION['file']['name']))]];
// headerパラメータ生成;

$data_json = json_encode($post, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
// JSONエンコード;

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_URL, $url . '/production/submit');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

$response = curl_exec($curl);
curl_close($curl);
// cURL実行;

unset($_SESSION['join']);
unset($_SESSION['file']);

if($response && strpos($response, 'RequestId') == false) {
    header ('Location: thanks.html');
} else {
    header ('Location: input.php');
}
//成功　=> 完了ページ;
//失敗　=> フォームへ戻る;
?>