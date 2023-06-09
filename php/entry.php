<?php
require './dbconnect.php';
session_start();

if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['email'] === '') {
        $error['email'] = 'blank';
    }
    if ($_POST['password'] === '') {
        $error['password'] = 'blank';
    }

    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $member = $db->prepare(
            'SELECT COUNT(*) as cnt FROM members WHERE email=?'
        );
        $member->execute([$_POST['email']]);
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }
    }

    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['join'] = $_POST; // フォームの内容をセッションで保存
        header('Location: check.php'); // check.phpへ移動
        exit();
    }
}
?>

<!DOCTYPE html>
  <html lang="ja">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <title>Final Project</title>
    <link rel="stylesheet" href="/FlowershopWebsite01/css/style.css">
  </head>

<body class="registerBody">
  <header>
    <article>
      <h1><a href="index.html" target="self">N.flower</a></h1>
      <nav>
        <ul>
          <li><a href="index.html" target="_self">Home</a></li>
          <li><a href="about.html" target="_self">About</a></li>
          <li><a href="contact.html" target="_self">Contact</a></li>
          <li><a href="login.html"><img class="loginIcon" src="/FlowerShopWebsite01/img/login.png" alt=""></a></li>
          <li><a href=""><img class="shopping_cartIcon" src="/FlowerShopWebsite01/img/shopping-cart.png" alt=""></a></li>
        </ul>
      </nav>
    </article>
    <!-- <figure></figure> -->
  </header>
  <main class="registerPage">
    <form id="registerForm" method="post" action="#">

      <div class="control">
                <label for="name">Name</label>
                <input id="name" type="text" name="name">
            </div>

            <div class="control">
                <label for="email">Email</label>
                <input id="email" type="email" name="email">
                <?php if (
                    !empty($error['email']) &&
                    $error['email'] === 'blank'
                ): ?>
                    <p class="error">*Enter your email address</p>
                <?php elseif (
                    !empty($error['email']) &&
                    $error['email'] === 'duplicate'
                ): ?>
                    <p class="error">*This email address is already exist</p>
                <?php endif; ?>
            </div>

            <div class="control">
                <label for="password">Password</label>
                <input id="password" type="password" name="password">
                <?php if (
                    !empty($error['password']) &&
                    $error['password'] === 'blank'
                ): ?>
                    <p class="error">*Enter your password</p>
                <?php endif; ?>
            </div>

            <div class="control">
                <button type="submit" class="btn">Confirm</button>
            </div>

    </form>
  </main>
  <footer>&copy;N.flower</footer>
  <script>
    
  </script>
</body>
</html>