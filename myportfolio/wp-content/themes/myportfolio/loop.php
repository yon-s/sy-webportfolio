<?php
global $taxonomyCatWork;
$catTerms=get_the_terms($post->ID,$taxonomyCatWork);
if($catTerms){  
  $cat = get_the_terms($post->ID,$taxonomyCatWork);
	$cat_name = $cat[0]->name;
  $cat_slug = $cat[0]->slug;
	$cat_link = get_term_link($cat_slug,$taxonomyCatWork);
}elseif(get_the_category()){
	$cat = get_the_category();
	$cat_name = $cat[0]->cat_name;
  $cat_id   = $cat[0]->cat_ID;
	$cat_link = get_category_link($cat_id);
}
?>
<article class="loop__list-item">
  <div class="loop__top">     
  <p class="loop__time"><?php the_time('Y/m/d'); ?></p>
  <?php if($catTerms||get_the_category()): ?>
        <div class="loop__tag-item"><a href="<?php echo $cat_link;?>" class="loop__cat-link"><?php echo $cat_name;?></a></div><!-- end-tag-->
  <?php endif;?>       
  </div>
  <div class="loop__content">
     <p class="loop__ttl"><a href="<?php the_permalink(); ?>" class="loop__ttl-link"><?php the_title(); ?></a></p>
     <a href="<?php the_permalink(); ?>" class="loop__link"><svg xmlns="http://www.w3.org/2000/svg" width="30.772" height="9.77" viewBox="0 0 30.772 9.77"><path id="パス_837" data-name="パス 837" d="M1937,7567.163l9.646,8h-28" transform="translate(-1918.646 -7566.394)" fill="none" stroke="#4977b1" stroke-width="2"/></svg>
    </a>
  </div>
</article>  
