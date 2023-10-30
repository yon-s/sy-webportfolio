<?php get_header(); ?>
<div class="wrapper">
  <main class="main">
    <div class="content">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en"><?php echo sy_page_title()['title'];?></h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle"><?php echo sy_page_title()['subtitle'];?></p>
      </div>
      <div class="loop">
        <?php
        //category 
        if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php get_template_part('loop');?>
        <?php endwhile; endif; wp_reset_query();?>
        <?php
        if (function_exists('sy_posts_pagination')) {
          sy_posts_pagination($wp_query->max_num_pages);
        }
        ?>
        <div class="clear"></div>
        <div class="content__button-outer--center">
          <a href="/">
            <button class="content__button-submit--large" type="button">
            トップに戻る
            <span class="btn__icon--right"><svg xmlns="http://www.w3.org/2000/svg" width="30.772" height="9.77" viewBox="0 0 30.772 9.77" class="responsive-img"><path id="click" data-name="click" d="M1937,7567.163l9.646,8h-28" transform="translate(-1918.646 -7566.394)" fill="none" stroke="#4977b1" stroke-width="2"/></svg></span></button>
          </a>
        </div>
      </div>  
    </div>    
  </main>  
</div>
<?php get_footer(); ?>