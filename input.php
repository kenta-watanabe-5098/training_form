<?php
session_start();

if(!empty($_POST)) {
    if($_POST['dest'] === '') {
        $error['dest'] = 'blank';
    }

    if($_POST['subject'] === '') {
        $error['subject'] = 'blank';
    }

    if($_POST['body'] === '') {
        $error['body'] = 'blank';
    }

    $fileName = $_FILES['file']['name'];
	if(empty($fileName)) {
			$error['file'] = 'empty';
	}

    if(empty($error)) {
        $file = "テスト" . date('YmdHis') . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . $file);

        $_SESSION['join'] = $_POST;
        $_SESSION['file'] = $_FILES['file'];

        header('Location: confirm.php');
        exit();
    }
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mail:form</title>
    <link rel="stylesheet" href="/training_form/css/style.css">
</head>
<body>
    <h1>メールフォーム</h1>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="item">
            <p>送信先</p>
            <input type="email" name="dest" size="35" value="<?php if(isset($error) || isset($_POST['dest'])) {print(htmlspecialchars($_POST['dest'], ENT_QUOTES));} ?>"><br/>
            <?php if(isset($error['dest']) && $error['dest'] === 'blank') : ?>
                <p class="error">※正しく入力ください</p>
            <?php endif; ?>
        </div>  
        <div class="item">
            <p class="caption">タイトル</p>
            <input type="text" name="subject" size="20" value="<?php if(isset($error) || isset($_POST['subject'])) {print(htmlspecialchars($_POST['subject'], ENT_QUOTES));} ?>"><br/>
            <?php if(isset($error['subject']) && $error['subject'] === 'blank') : ?>
                <p class="error">※正しく入力ください</p>
            <?php endif; ?>
        </div>

        <div class="item">
            <p class="caption">本文</p>
            <textarea name="body" cols="50" rows="10" placeholder="こちらに記入ください"><?php if(isset($error) || isset($_POST['body'])) {print(htmlspecialchars($_POST['body'], ENT_QUOTES));} ?></textarea><br/>
            <?php if(isset($error['body']) && $error['body'] === 'blank') : ?>
                <p class="error">※入力は必須です</p>
            <?php endif; ?>
        </div>

        <div class="item">
            <p class="caption">ファイル</p>
            <input type="file" name="file"><br/><br/>
            <?php if(isset($error['file']) && $error['file'] === 'empty') : ?>
                <p class="error">※添付は必須です</p>
            <?php endif; ?>
            <?php if(!isset($error) && empty($error) && isset($_POST['dest'])): ?>
				<p class="error">※ファイルを指定してください</p>
			<?php endif; ?>
        </div>

        <div class="item">
            <input type="submit" value="確認画面へ">
        </div>
    </form>
    
</body>
</html>