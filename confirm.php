<?php
session_start();

if(!isset($_SESSION['join'])) {
	header('Location: input.php');
	exit();
}

if(!empty($_POST)) {	
	header('Location: sendMail.php');
	exit();
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
    
    <form action="" method="POST">
    <input type="hidden" name="action" value="submit">
    <dl>
		<dt>送信先</dt>
		<dd>
			<?php print(htmlspecialchars($_SESSION['join']['dest'], ENT_QUOTES)); ?>
        </dd>
		<dt>タイトル</dt>
		<dd>
			<?php print(htmlspecialchars($_SESSION['join']['subject'], ENT_QUOTES)); ?>
        </dd>
		<dt>本文</dt>
		<dd>
		    <?php print(htmlspecialchars($_SESSION['join']['body'], ENT_QUOTES)); ?> 
		</dd>
		<dt>添付データ</dt>
		<dd>
			<?php if($_SESSION['file'] !== ''): ?>
                <?php print_r($_SESSION['file']['name']); ?>
			<?php endif; ?>
		</dd>
	</dl>
    <div><a href="input.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="送信する" /></div>

    </form>    
</body>
</html>