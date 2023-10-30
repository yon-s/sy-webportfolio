<?php get_header(); ?>
<div class="wrapper<?php if(is_page('thanks')){echo '--not-pb';}?>">
  <main class="main">
    <div class="content">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en"><?php echo sy_page_title()['title'];?></h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle"><?php echo sy_page_title()['subtitle'];?></p>
      </div>
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content();?> 
      <?php endwhile; endif; ?>
    </div>    
  </main>  
</div>
<?php get_footer(); ?>