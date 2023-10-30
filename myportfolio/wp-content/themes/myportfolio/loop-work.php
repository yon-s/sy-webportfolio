<?php 
//tag
$tags = get_the_terms($post->ID,'worktag');
if($tags){
  $tags_name = $tags[0]->name;
}
?>
<article class="work__list-item<?php if( is_home() || is_front_page() ){echo ' fade-in--left';}?>"<?php if( is_home() || is_front_page() ){echo '  data-fade-in="scroll"';}?>>
  <div class="work__thumbnail">
    <a href="<?php the_permalink(); ?>">
      <?php if(has_post_thumbnail()):?> 
        <?php echo picture(get_post_thumbnail_id( get_the_ID() ),'thumbnail');?>
      <?php else: ?>
        <picture>
        <source media="(max-width: 767px)" srcset="<?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_767.jpg, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_767@2x.jpg 2x, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_767@3x.jpg 3x">
        <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_1023.jpg, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_1023@2x.jpg 2x, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_1023@3x.jpg 3x">
        <source media="(max-width: 1365px)" srcset="<?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_1365.jpg, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_1365@2x.jpg 2x, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>_1365@3x.jpg 3x">
        <img srcset="<?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>.jpg, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>@2x.jpg 2x, <?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>@3x.jpg 3x" src="<?php echo get_template_directory_uri()?>/img/archive/work__notimg-thumbnail-<?php echo $args;?>.jpg" class="responsive-img" width="220" $height="381" alt=""></picture>
      <?php endif;?>
    </a>
  </div>
  <div class="work__info<?php echo '--'.$args?>">
    <div class="work__info-txt">
      <?php if($tags_name):?>
        <p class="work__kind"><?php echo $tags_name;?></p>
      <?php endif;?>
      <?php if(get_the_title()):?>
        <p class="work__name"><?php the_title(); ?></p>
      <?php endif;?>
    </div>  
    <?php if(get_the_permalink()):?>
      <a href="<?php the_permalink(); ?>" class="work__link">
        more
      </a>
    <?php endif;?>
  </div>  
</article>