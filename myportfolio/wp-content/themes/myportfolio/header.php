<!DOCTYPE html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="<?php bloginfo('charset'); ?>">
<script src="//code.jquery.com/jquery-1.12.1.min.js"></script>
<script src="https://kit.fontawesome.com/802f629b11.js" crossorigin="anonymous"></script>
<script type="module" src="<?php echo get_template_directory_uri() ?>/js/header.js"></script>
<?php if(is_front_page()):?>
  <script type="module" src="<?php echo get_template_directory_uri() ?>/js/index.js"></script>
  <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/contact.js"></script>
<?php elseif(is_single()):?>
  <script type="module" src="<?php echo get_template_directory_uri() ?>/js/single.js"></script>  
<?php endif;?>
<!--adobe font-->
<link rel="stylesheet" href="https://use.typekit.net/elw7zom.css">
<link rel="icon" href="<?php echo get_template_directory_uri() ?>/img/ogp/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/img/ogp/favicon.svg">
<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/img/ogp/favicon.svg" sizes="192x192">
<script>
  (function(d) {
    var config = {
      kitId: 'sid7kgk',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5PN8NTZ');</script>
<!-- End Google Tag Manager -->
<?php wp_head(); ?>
</head>
<body>
<noscript>
  <p class="not-js">
  このサイトではJavaScriptを使用しています。コンテンツを正しく表示するためにJavaScriptを有効にしてください。
  </p>
</noscript>
<header class="header">
  <?php if(is_single()){$titleMarkup = 'p';}else {$titleMarkup = 'h1';}?>
    <<?php echo $titleMarkup;?> class="header__site-ttl">
      <a href="/" class="header__ttl-link">SHUICHI<br>YONEHARA</a>
    </<?php echo $titleMarkup;?>>
  <button type="button" id="header__menu" class="header__menu-outerr" aria-controls="menu" aria-expanded="false">
    <span class="header__menu-line">
      <span class="header__menu-u-visuallyHidden">
        メニューを開閉する
      </span>
    </span>
   <span id="header__menu-txt" class="header__menu-txt">menu</span>
  </button>
  <nav id="menu" class="menu" aria-hidden="true">
    <ul class="menu__list">
      <?php if(!is_front_page()){$page_link = '/';}?>
      <li class="menu__list-item">
        <a href="<?php echo $page_link;?>#work" class="menu__item-link" aria-controls="menu" aria-expanded="false">
          <span class="menu__item-en">Work</span>
          <span class="menu__item-ja" role="doc-subtitle">制作物</span>
          <span class="menu__item-icon"><img src="<?php echo get_template_directory_uri()?>/img/nav/menu__item-icon.svg" width="14px" height="7px" class="responsive-img"/></span>
        </a>
      </li>
      <li class="menu__list-item">
        <a href="<?php echo $page_link;?>#seo" class="menu__item-link" aria-controls="menu" aria-expanded="false">
          <span class="menu__item-en">Seo</span>
          <span class="menu__item-ja" role="doc-subtitle">検索上位を獲得した実績</span>
          <span class="menu__item-icon"><img src="<?php echo get_template_directory_uri()?>/img/nav/menu__item-icon.svg" width="14px" height="7px" class="responsive-img"/></span>
        </a>
      </li>
      <li class="menu__list-item">
        <a href="<?php echo $page_link;?>#about" class="menu__item-link" aria-controls="menu" aria-expanded="false">
          <span class="menu__item-en">About</span>
          <span class="menu__item-ja" role="doc-subtitle">私について</span>
          <span class="menu__item-icon"><img src="<?php echo get_template_directory_uri()?>/img/nav/menu__item-icon.svg" width="14px" height="7px" class="responsive-img"/></span>
        </a>
      </li>
      <li class="menu__list-item">
        <a href="<?php echo $page_link;?>#skill" class="menu__item-link" aria-controls="menu" aria-expanded="false">
          <span class="menu__item-en">Skill</span>
          <span class="menu__item-ja" role="doc-subtitle">スキル</span>
          <span class="menu__item-icon"><img src="<?php echo get_template_directory_uri()?>/img/nav/menu__item-icon.svg" width="14px" height="7px" class="responsive-img"/></span>
        </a>
      </li>
      <li class="menu__list-item">
        <a href="<?php echo $page_link;?>#contact" class="menu__item-link" aria-controls="menu" aria-expanded="false">
          <span class="menu__item-en">Contact</span>
          <span class="menu__item-ja" role="doc-subtitle">お問い合わせ</span>
          <span class="menu__item-icon"><img src="<?php echo get_template_directory_uri()?>/img/nav/menu__item-icon.svg" width="14px" height="7px" class="responsive-img"/></span>
        </a>
      </li>
    </ul>
  </nav>
</header>
</body>
</html>