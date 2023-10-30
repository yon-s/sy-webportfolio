<?php get_header(); ?>
<div class="wrapper">
  <main class="main">
  <?php breadcrumb(); ?>
    <div class="content">
      <header class="ttl-group">
        <h1 class="ttl-group__txt-en"><?php echo sy_page_title()['title'];?></h1>
          <p class="ttl-group__txt-ja--min" role="doc-subtitle"><span class="search__keyword">
            <?php if($wp_query->found_posts > 0){ 
              echo $wp_query->found_posts;?>件</span><?php echo sy_page_title()['subtitle']; 
            }else{
              echo '見つかりませんでした。';
            }
            ?>
          </p>
      </header>
      <div class="loop">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('loop'); ?>
          <?php endwhile; ?>
        <?php else : ?>
          <div class="not-found">
          <p class="not-found__txt">申し訳ございません。お探しのページは見つかりませんでした。<br>移動もしくは削除された可能性があります。<br>よろしければサイト内検索でお求めのページをお探しください。</p>
        </div>
        <?php endif;?>
          <?php if (function_exists('sy_posts_pagination')) {
            sy_posts_pagination($additional_loop->max_num_pages);
          }
          ?>
        <div class="not-found__search-outer--right">
          <p class="search__search-txt">再検索する</p>
          <?php get_search_form() ?>
        </div>  
        <div class="clear"></div>
        <div class="content__button-outer--center">
            <a href="/"><button class="content__button-submit--large" type="button">
            トップに戻る
              <span class="btn__icon--right"><svg xmlns="http://www.w3.org/2000/svg" width="30.772" height="9.77" viewBox="0 0 30.772 9.77" class="responsive-img"><path id="click" data-name="click" d="M1937,7567.163l9.646,8h-28" transform="translate(-1918.646 -7566.394)" fill="none" stroke="#4977b1" stroke-width="2"/></svg></span>
            </button></a>
        </div>
      </div>
    </div>
  </main>
</div>  
<?php get_footer(); ?>