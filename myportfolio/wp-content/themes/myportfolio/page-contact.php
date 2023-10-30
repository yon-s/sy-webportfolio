<?php
/*
Template Name: お問い合わせ確認ページ用
*/
?>
<?php 
// pusu form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //入力内容のチェック
   //名前の入力なし
   if(trim($_POST['contactName']) === '') {
    $nameError = '名前が入力されていません';
    $hasError = true;
  }
    $name = trim($_POST['contactName']);
  //メールアドレスの間違い
  if(trim($_POST['email']) === '') {
    $emailError = 'メールアドレスが入力されていません';
    $hasError = true;
  }else if(!preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+.)+[0-9a-z-]+$|', trim($_POST['email']))){
    $emailError = 'メールアドレスが正しくありません';
    $hasError = true;
  }
    $email = trim($_POST['email']);
  //お問い合わせ内容の入力なし
  if(trim($_POST['comments']) === '') {
    $commentError = 'お問い合わせ内容が入力されていません';
    $hasError = true;
  }else {
    if(function_exists('stripslashes')) {
      $comments = stripslashes(trim($_POST['comments']));
    }else{
      $comments = trim($_POST['comments']);
    }
  }
  if($_POST['agree_privacy'] === ''){
    $agreeError = '&#147;プライバシーポリシーに同意する&#148;にチェックをお願いいたします。';
    $hasError = true;
  }else{
    $agree = 'プライバシーポリシーに同意しました。';
  }
}
//push submit
if(!isset($hasError) && isset($_POST['submit'])) {
  //自分にお知らせがあったこと通知
    mb_language("japanese");
    mb_internal_encoding("UTF-8");
    //サイトのメールアドレス
    $siteEmailAddress = get_option('admin_email');
    //件名
    $subject = 'ポートフォリオにお問い合わせがありました。';
    //サイトタイトル
    $title = get_option('blogname');
    //サイトURL
    $url = get_option('home');
    //送信元
    $from = mb_encode_mimeheader($title.'<'.$siteEmailAddress.'>',"UTF-8");
    //本文
    $body = "お問い合わせ内容。 
    \r\n\r\n-------------------------------------------------\r\n
    お名前: $name \r\n
    メールアドレス: $email \r\n
    お問い合わせ内容: $comments \r\n
    $agree \r\n
    -------------------------------------------------
    ";
  //end 自分にお知らせがあったこと通知
  //自動返信用
    //件名
    $subject2 = 'お問い合わせ受付のお知らせ';
    //送信元
    $from2 = mb_encode_mimeheader($title.'<'.$siteEmailAddress.'>',"UTF-8");
    //本文
    $body = "
    $name 様 \r\n
    $title にお問い合わせありがとうございます。\r\n
    改めて担当者よりご連絡をさせていただきますので、\r\n
    今しばらくお待ちください。\r\n
    \r\n
    -------------------------------------------------\r\n
    お問い合わせいただいた内容：$comments \r\n
    $agree \r\n
    -------------------------------------------------
    ";
  //end 自動返信用
   //送信
  $param = '-f'.$siteEmailAddress;
  $header = '';
  $header .= "Content-Type: text/plain \r\n";
  $header .= "Return-Path: " . $title.'<'.$siteEmailAddress.'>'. " \r\n";
  $header .= "Reply-To: " . $siteEmailAddress . " \r\n";
  $header .= "Organization: " . $title . " \r\n";
  $header .= "X-Sender: " . $siteEmailAddress . " \r\n";
  $header .= "X-Priority: 3 \r\n";
  $headerFrom = "From: " . $from ." \r\n";
  $headerSender = "Sender: " . $from ." \r\n";
  mb_send_mail($siteEmailAddress, $subject, $body, $header.$headerFrom.$headerSender,$param);
  $headerFrom = "From: " . $from2 ." \r\n";
  $headerSender = "Sender: " . $from2 ." \r\n";
  mb_send_mail($email, $subject2, $body, $header.$headerFrom.$headerSender,$param);
  //送信完了後
  $emailSent = true;
  header('Location: '.get_option('home').'/top/confirm/thanks');
  exit;
}
?>
<?php get_header();
if(is_front_page()||is_home()){
  $indexContact = ' contact__content';
} ?>
<div class="wrapper--not-pb">
  <main class="main">
    <section class="contact">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en">Contact</h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle">確認画面</p>
      </div>
      <div class="contact__progress-outer<?php echo $indexContact;?>">
        <div class="contact__progress-list">
          <div class="contact__progress--notcomp">入力</div>
          <div class="contact__progress--comp">確認</div>
          <div class="contact__progress--notcomp">完了</div>
        </div>
        <div class="contact__progress-line-outer">  
          <div class="contact__progress-line--notcomp"></div>
          <div class="contact__progress-line--comp"></div> 
        </div>
      </div>
      <div class="contact__form-bg<?php echo $indexContact;?>">
        <form action="/top/confirm" method="post" class="contact__form">
        <input type="hidden" name="contactName" value="<?php echo $name;?>" />
        <input type="hidden" name="email" value="<?php echo $email;?>" />
        <input type="hidden" name="comments" value="<?php echo $comments;?>" />
        <input type="hidden" name="agree_privacy" value="<?php echo $agree;?>" />
          <ul class="contact__table-confirm">
            <li class="contact__input-list">
              <div  class="contact__input-ttl">お名前<span class="contact__required">必須</span></div>
              <div class="contact__input-confirm">
                <?php echo $name;?>
              </div>
                <?php if(isset($nameError)):?>
                  <p class="contact__error">
                    <?=$nameError;?>
                  </p>
                <?php endif;?>
            </li>
            <li class="contact__input-list">
              <div class="contact__input-ttl">メールアドレス<span class="contact__required">必須</span></div> 
              <div class="contact__input-confirm"><?php echo $email;?>     
              </div>
              <?php if(isset($emailError)):?>
              <p class="contact__error">
                    <?=$emailError;?>
              </p>         
              <?php endif;?>   
            </li>
            <li class="contact__input-list">
              <div class="contact__input-ttl">お問い合わせ内容<span class="contact__required">必須</span></div>
              <div class="contact__input-confirm">
                <?php echo $comments;?> 
              </div>
                <?php if(isset($commentError)):?>
                  <p class="contact__error">
                        <?=$commentError;?>
                  </p>         
                <?php endif;?>
            </li>
                </ul>
          <div class="contact__agree">
            <?php if(isset($agree)){ echo $agree;}elseif(isset($agreeError)){?>
              <span class="contact__error">
                    <?=$agreeError;?>
              </span>         
            <?php }?>
          </div>
          <div class="content__button-outer--center">
          <input type="hidden" name="submitted" value="true" />
            <button class="content__back-btn--min" type="button" onclick="history.back(-1)">
              <span class="btn__back-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30.772" height="9.77" viewBox="0 0 30.772 9.77" class="responsive-img"><path id="パス_743" data-name="パス 743" d="M1928.292,7567.164l-9.647,8h28" transform="translate(-1915.873 -7566.394)" fill="none" stroke="#161616" stroke-width="2"/></svg>
              </span>
              修正する
            </button>
            <div>
              <?php if(!isset($hasError)):?>
              <input type="hidden" name="submit" value="true" />
              <button class="content__button-submit--second" type="submit">
                送信
                <span class="btn__icon--right"><svg xmlns="http://www.w3.org/2000/svg" width="30.772" height="9.77" viewBox="0 0 30.772 9.77" class="responsive-img"><path id="click" data-name="click" d="M1937,7567.163l9.646,8h-28" transform="translate(-1918.646 -7566.394)" fill="none" stroke="#4977b1" stroke-width="2"/></svg></span>
              </button>
              <?php endif;?>
            </div>
          </div>
        </form>
      </div>
    </section>    
  </main>  
</div>
<?php get_footer(); ?>