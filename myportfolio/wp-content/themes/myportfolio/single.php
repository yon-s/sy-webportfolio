<?php 
global $work,$taxonomyCatWork,$taxonomyTagWork;
//category
$cat = get_the_terms($post->ID,$taxonomyCatWork);
if($cat){  
	$cat_name = $cat[0]->name;
  $cat_slug = $cat[0]->slug;
	$cat_link = get_term_link($cat_slug,$taxonomyCatWork);
}
//tag
$tagsTerms = get_the_terms($post->ID,$taxonomyTagWork);
if($tagsTerms){
  $tags = $tags[0]->name;
}
function deviceName($mockupKey){
  if($mockupKey === 'pc'){ echo 'パソコン';}elseif($mockupKey === 'tab'){ echo 'タブレット';}elseif($mockupKey === 'sp'){echo 'スマートフォン';};
}
?>
<?php get_header(); ?>
<div class="wrapper">
  <main class="main">
    <div class="single">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="single__top">
          <div class="single__lead">
            <?php if($cat_name) : ?>
              <div class="single__lead-top">
                  <a href="<?php echo $cat_link; ?>" class="single__lead-top-link"><?php echo $cat_name; ?></a>
              </div>
            <?php endif;?>
              <div class="single__lead-bottom">
                <h1 class="single__ttl"><?php the_title(); ?></h1>  
              </div>
          </div>
          <div class="single__info-outer">
            <?php breadcrumb(); ?>
            <div class="mockup">
              <?php
              $mockupField = get_field('mockup');//モックアップのカスタムフィールド
              $mockupFieldKeys = array_keys($mockupField);//カスタムフィールドからキー取得
              ?>  
              <?php //カテゴリーweb
              if($cat_slug === 'web'):?>
                <?php
                $mockupFieldKeys = customFieldWeb($mockupField)['mockupFieldKeys'];
                $deviceNames = customFieldWeb($mockupField)['deviceNames'];
                ?>
                <?php
                //デバイスアイコン部分 
                foreach($deviceNames as $deviceName):?>
                  <?php if($deviceName === reset($deviceNames)):?>
                    <div class="mockup__list-outer" id="mockup-list-outer">
                      <p class="mockup__display">表示中のデザイン</p>
                      <ul class="mockup__list">
                  <?php endif;?>   
                        <li class="mockup__item sliderbtn">
                          <div class="mockup__icon--<?php echo $deviceName; if($deviceName === reset($deviceNames)){echo ' active';}?> ">
                            <picture>
                              <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>_1023.png, <?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>_1023@3x.png 3x">
                              <?php if($deviceName !== 'sp'):?>
                                <source media="(max-width: 1365px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>_1365.png, <?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>_1365@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>_1365@3x.png 3x">
                              <?php endif;?>
                              <img srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>.png, <?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/mockup_icon_<?php echo $deviceName;?>.jpg" alt="<?php deviceName($deviceName);?>のアイコン" class="responsive-img"/>
                            </picture>
                          </div>
                          <p class="mockup__txt"><?php deviceName($deviceName);?></p>
                        </li>
                  <?php if($deviceName === end($deviceNames)):?>      
                      </ul>
                    </div>
                  <?php endif;?>
                <?php endforeach;
                // end デバイスアイコン部分 ?> 
                <?php //完成画像画面部分?> 
                <div class="mockup__img-outer" data-slider-type="wide">
                  <div class="mockup__img-list">
                    <?php foreach($mockupFieldKeys as $deviceName => $mockupFieldKey):?>
                      <div class="mockup__list-item" data-slider="swipe">
                        <div class="mockup__device--<?php echo $deviceName;?>">
                          <picture data-slider="swipe">
                            <?php if($deviceName === 'pc'):?>
                              <source media="(max-width: 375px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>_375.png, <?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>_375@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>_375@3x.png 3x">
                            <?php endif;?>
                            <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>_1023.png, <?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>_1023@3x.png 3x">
                            <img srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>.png, <?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/mockup_bg_<?php echo $deviceName;?>.png" alt="<?php deviceName($deviceName);?>の画像" class="responsive-img"/>
                          </picture>
                          <div class="mockup__screen--<?php echo $deviceName;?>">
                            <?php echo picture($mockupField[$mockupFieldKey],$mockupFieldKey);?>
                          </div>
                        </div>
                      </div>
                    <?php endforeach;?>
                  </div> 
                  <div class="mockup__nav-outer" data-slider="swipe">
                    <div id="mockup-prev" class="mockup__nav--before sliderbtn">
                      <picture>
                        <source media="(max-width: 1365px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_before_1365.png, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_before_1365@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_before_1365@3x.png 3x">
                        <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_before_1023.png, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_before_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_before_1023@3x.png 3x">
                        <img srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_before.png, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_before@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_before@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_before.png" alt="戻るボタン" class="responsive-img"/>
                      </picture>
                    </div>
                    <div id="mockup-next" class="mockup__nav--next sliderbtn">
                      <picture>
                        <source media="(max-width: 1365px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_next_1365.png, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_next_1365@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_next_1365@3x.png 3x">
                        <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_next_1023.png, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_next_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_next_1023@3x.png 3x">
                        <img srcset="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_next.png, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_next@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/mockup_nav_next@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/mockup_nav_next.png" alt="進むボタン" class="responsive-img"/>
                      </picture>
                    </div>
                  </div>
                </div>
                <?php // end 完成画像画面部分?>
              <?php else: //カテゴリーbanner?>
                <?php if(get_field('mockup_banner')): ?>
                  <div class="mockup__banner">
                    <?php echo picture(get_field('mockup_banner'),'mockup_banner');?>
                  </div>
                <?php endif;?>
              <?php endif;?>  
            </div>
            <div class="info fade-in--down" id="info">
              <div class="info__box-outer">
                <div class="info__box">
                  <h3 class="info__ttl">制作日</h3>
                  <div class="info__content">
                    <p class="info__txt"><?php if(get_field('work_day')){ echo get_field('work_day');}else{ echo '-';} ?></p>
                  </div>
                </div>  
              </div>
              <div class="info__box-outer">
                <div class="info__box">
                  <h3 class="info__ttl">制作期間</h3>
                  <div class="info__content">
                      <p class="info__txt"><?php echo get_field('work_production'); ?></p>
                    </div>
                  </div>  
                </div>
                <div class="info__box-outer">  
                  <div class="info__box"> 
                    <h3 class="info__ttl">内容</h3>
                    <div class="info__content">
                      <?php $work_matters = get_field('work_matter');?>
                      <?php if($work_matters): ?>
                        <ul class="info__list-flex">
                          <?php foreach($work_matters as $work_matter):?>
                            <li class="info__item-flex"><?php echo $work_matter;?></li>
                          <?php endforeach;?>
                        </ul>
                      <?php endif;?>
                    </div>
                  </div>
                </div>
                <?php 
                function softName($soft){//ソフト名表示
                  switch ($soft) {
                    case 'ai':
                        echo 'Illustrator';
                        break;
                    case 'ps':
                        echo 'Photoshop';
                        break;
                    case 'xd':
                        echo 'XD';
                        break;
                    case 'lr':
                        echo 'Lightroom';
                        break;
                    case 'vs':
                        echo 'Visual Studio Code';
                        break;
                    case 'html':
                        echo 'HTML・CSS';
                        break;
                    case 'jquery':
                        echo 'jQuery';
                        break;
                    case 'php':
                        echo 'PHP';
                        break;
                    case 'sass':
                        echo 'sass';
                        break;
                    case 'php':
                        echo 'PHP';
                        break;
                    case 'javascript':
                        echo 'JavaScript';
                        break;
                  }
                }
                ?>
                <div class="info__box-outer">
                  <div class="info__box">
                    <h3 class="info__ttl">使用ソフト</h3>
                    <div class="info__content">
                      <?php $work_soft_designs = get_field('work_soft')['work_soft_design'];?>
                      <?php if($work_soft_designs):?>
                        <p class="info__use">デザイン</p>
                        <ul class="info__list-col">
                          <?php foreach($work_soft_designs as $work_soft_design):?>
                          <li class="info__item-icon">
                            <div class="info__soft-icon">
                              <picture>
                                <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_design;?>_1023.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_design;?>_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_design;?>_1023@3x.png 3x">
                                <img srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_design;?>.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_design;?>@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_design;?>@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_design;?>.png" alt="<?php softName($work_soft_design).'のアイコン';?>" class="responsive-img"/>
                              </picture>
                            </div>
                            <p class="info__txt"><?php softName($work_soft_design);?></p>
                          </li>
                          <?php endforeach;?>
                        </ul>
                      <?php endif;?>
                      <?php $work_soft_photos = get_field('work_soft')['work_soft_photo'];?>
                      <?php if($work_soft_photos):?>
                        <p class="info__use">画像編集</p>
                        <ul class="info__list-col">
                          <?php foreach($work_soft_photos as $work_soft_photo):?>
                            <li class="info__item-icon">
                              <div class="info__soft-icon">
                                <picture>
                                  <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_photo;?>_1023.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_photo;?>_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_photo;?>_1023@3x.png 3x">
                                  <img srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_photo;?>.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_photo;?>@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_photo;?>@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_photo;?>.png" alt="<?php softName($work_soft_photo).'のアイコン';?>" class="responsive-img"/>
                                </picture>
                              </div>
                              <p class="info__txt"><?php softName($work_soft_photo);?></p>
                            </li>
                          <?php endforeach;?>
                        </ul>
                      <?php endif;?>
                      <?php $work_soft_comps = get_field('work_soft')['work_soft_comp'];?>
                      <?php if($work_soft_comps):?>
                        <p class="info__use">カンプ</p>
                        <ul class="info__list-col">
                          <?php foreach($work_soft_comps as $work_soft_comp):?>
                          <li class="info__item-icon">
                            <div class="info__soft-icon">
                              <picture>
                                <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_comp;?>_1023.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_comp;?>_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_comp;?>_1023@3x.png 3x">
                                <img srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_comp;?>.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_comp;?>@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_comp;?>@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_comp;?>.png" alt="<?php softName($work_soft_comp).'のアイコン';?>" class="responsive-img"/>
                              </picture>
                            </div>
                            <p class="info__txt"><?php softName($work_soft_comp);?></p>
                            <?php if(get_field('xd_link')):?>
                              <a href="<?php echo get_field('xd_link');?>" class="info__txt-link"  target="_blank" rel="noopener noreferrer">プロトタイプを見る</a>
                             <?php endif; ?> 
                          </li>
                          <?php endforeach;?>
                        </ul>
                      <?php endif;?>                
                      <?php $work_soft_codings = get_field('work_soft')['work_soft_coding'];?>
                      <?php if($work_soft_codings):?>
                        <p class="info__use">コーディング</p>
                        <ul class="info__list-col">
                          <?php foreach($work_soft_codings as $work_soft_coding):?>
                          <li class="info__item-icon">
                            <div class="info__soft-icon">
                              <picture>
                                <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_coding;?>_1023.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_coding;?>_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_coding;?>_1023@3x.png 3x">
                                <img srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_coding;?>.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_coding;?>@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_coding;?>@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $work_soft_coding;?>.png" alt="<?php softName($work_soft_coding).'のアイコン';?>" class="responsive-img"/>
                              </picture>
                            </div>
                            <p class="info__txt"><?php softName($work_soft_coding);?></p>
                          </li>
                          <?php endforeach;?>
                        </ul>
                      <?php endif;?>    
                    </div>             
                  </div>  
                </div>
              <?php $detailImgInput = get_field('detail_img_input');?>  
              <?php if($cat_slug === 'web')://webの場合だけ表示?>
                <?php $working_languages = get_field('working_language');?>
                <?php if($working_languages):?>
                  <div class="info__box-outer">
                    <div class="info__box">
                      <h3 class="info__ttl">使用言語・ライブラリー</h3>
                      <div class="info__content">
                        <ul class="info__list-col">
                          <?php foreach($working_languages as $working_language):?>
                            <li class="info__item-icon">
                              <div class="info__soft-icon<?php if($working_language === 'php'){echo '--'.$working_language;}?>">
                                <picture>
                                  <source media="(max-width: 1023px)" srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $working_language;?>_1023.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $working_language;?>_1023@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $working_language;?>_1023@3x.png 3x">
                                  <img srcset="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $working_language;?>.png, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $working_language;?>@2x.png 2x, <?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $working_language;?>@3x.png 3x" src="<?php echo get_template_directory_uri()?>/img/work/info_soft_<?php echo $working_language;?>.png" alt="<?php softName($working_language).'のアイコン';?>" class="responsive-img"/>
                                </picture>
                              </div>
                              <p class="info__txt"><?php softName($working_language);?></p>
                            </li>
                          <?php endforeach;?>
                        </ul>
                      </div>  
                    </div>
                  </div>
                <?php endif;?>
                <?php if(get_field('work_developer')['work_developer1'] || get_field('work_developer')['work_developer2']):?>
                  <div class="info__box-outer">
                    <div class="info__box">
                      <h3 class="info__ttl">ディベロッパーメント</h3>
                      <div class="info__content">
                        <ul class="info__list">
                          <?php for($work_developer = 0; $work_developer < 3; $work_developer++):?>
                            <?php if(get_field('work_developer')['work_developer'.$work_developer]):?>
                              <li class="info__item-col"><?php  echo get_field('work_developer')['work_developer'.$work_developer];?></li>
                            <?php endif;?>
                          <?php endfor;?>
                        </ul>
                      </div>
                    </div>   
                  </div>  
                <?php endif;?>    
              <?php elseif($cat_slug === 'banner'):?>
              <div class="info__box-outer">
                <div class="info__box">
                  <h3 class="info__ttl">制作の目的</h3>
                  <div class="info__content">
                    <div class="detail__txt"><?php echo get_the_content();?></div>
                  </div>  
                </div>  
              </div>
              <?php $detailtarget = get_field('target');?>
              <?php if($detailtarget):?>
                <div class="info__box-outer">
                  <div class="info__box">
                    <h3 class="info__ttl">ターゲット</h3>
                    <div class="info__content">
                      <div class="detail__txt"><?php echo $detailtarget;?></div>
                    </div>  
                  </div>  
                </div>
              <?php endif;?>
              <?php $detaildesign = get_field('design');?>
              <?php if($detaildesign):?>
              <div class="info__box-outer">
                <div class="info__box">
                  <h3 class="info__ttl">デザイン</h3>
                  <div class="info__content">
                    <div class="detail__txt"><?php echo $detaildesign;?></div>
                  </div>  
                </div>  
              </div>
            <?php endif;?>
          <?php endif;?>               
            </div>
          </div>
        </div>
        <?php if($cat_slug === 'web')://webの場合だけ表示?>
          <div class="detail">
            <div class="detail__box">
              <div class="detail__ttl-group" >
                <h3 class="detail__ttl">サイトキャプチャ</h3>
                <span class="detail__ttl-ubder"></span>
                <p class="detail__ttl-txt"><small class="detail__ttl-caution">サイトにより、右の画像は一部しか表示されていないものがあります。正しい表示はリンク先でご確認下さい。</small></p>
              </div>
              <div class="detail__work-outer">
                <div class="detail__txt-outer">
                  <div class="detail__txt-box">
                    <h4 class="detail__txt-ttl">制作の目的</h4>
                    <div class="detail__txt"><?php echo get_the_content();?></div>
                  </div>
                  <?php $detailSiteUrl = $detailImgInput['site_url'];?>
                  <?php if($detailSiteUrl):?>
                    <div class="detail__txt-box">
                      <h4 class="detail__txt-ttl">サイトURL</h4>
                      <div class="detail__txt"><a href="<?php echo $detailSiteUrl;?>" target="_blank" rel="noopener noreferrer" class="content__link"><?php echo $detailSiteUrl;?></a></div>
                    </div>
                  <?php endif;?>
                  <?php $detailtarget = $detailImgInput['target'];?>
                  <?php if($detailtarget):?>
                    <div class="detail__txt-box">
                      <h4 class="detail__txt-ttl">ターゲット</h4>
                      <div class="detail__txt"><?php echo $detailtarget;?></div>
                    </div>
                  <?php endif;?>
                  <?php $detaildesign = $detailImgInput['design'];?>
                  <?php if($detaildesign):?>
                    <div class="detail__txt-box">
                      <h4 class="detail__txt-ttl">デザイン</h4>
                      <div class="detail__txt"><?php echo $detaildesign;?></div>
                    </div>
                  <?php endif;?>
                  <?php $detaildevelopment = $detailImgInput['development'];?>
                  <?php if($cat_slug === 'web'&&$detaildevelopment):?>
                    <div class="detail__txt-box">
                      <h4 class="detail__txt-ttl">DEVELOPMENT</h4>
                      <div class="detail__txt"><?php echo $detaildevelopment;?></div>
                    </div>
                  <?php endif;?>
                  <?php $detailAchievements = $detailImgInput['achievements'];
                  $detailAchievementsText = $detailAchievements['text'];
                  $detailAchievementsReport = $detailAchievements['report']?>
                  <?php if($cat_slug === 'web'&&$detailAchievementsText):?>
                    <div class="detail__txt-box">
                      <h4 class="detail__txt-ttl">実績</h4>
                      <div class="detail__txt"><?php echo $detailAchievementsText;?>
                      <?php if($detailAchievementsReport):?>
                        <a href="<?php echo $detailAchievementsReport;?>" target="_blank" rel="noopener noreferrer" class="content__link">レポートはこちら</a>
                        <?php endif;?>
                      </div>
                    </div>
                  <?php endif;?>
                </div>
                <div class="detail__img-outer">
                  <div class="detail__img-inner">
                    <div id="detail-img-list" class="detail__img-list">
                      <div class="detail__img--<?php echo $deviceNames[0];?>">
                      <?php
                      echo picture(get_field('detail__img')['detail_'.$deviceNames[0]],'detail_'.$deviceNames[0]);?>
                      </div>
                    </div>
                  </div>  
                </div>  
              </div>  
            </div>
            <?php $detail2ImgInput = get_field('detail2_img_input');
            $detail2ImgInputTitle = $detail2ImgInput['title'];
            $detail2ImgInputImg = $detail2ImgInput['detail_img-not-txt'];?>
            <?php if($detail2ImgInputTitle&&$detail2ImgInputImg):?>
              <?php $detail2ImgInputNotes = $detail2ImgInput['notes'];;?>
              <div class="detail__box">
                <div class="detail__ttl-group" >
                  <h3 class="detail__ttl"><?php echo $detail2ImgInputTitle;?></h3>
                  <span class="detail__ttl-ubder"></span>
                  <?php if($detail2ImgInputNotes):?>
                    <p class="detail__ttl-txt"><small class="detail__ttl-caution"><?php echo $detail2ImgInputNotes;?></small></p>
                  <?php endif;?>  
                </div>
                <div class="detail__work-outer">
                  <div class="detail__img-outer-not-txt">
                    <div class="detail__img-inner">
                      <div class="detail__img-list">
                        <div class="detail__img-not-txt">
                          <?php echo picture($detail2ImgInputImg,'detail_img-not-txt');?>
                        </div>
                      </div>
                    </div>  
                  </div>  
                </div>  
              </div>
            <?php endif;?> 
            </div>   
        <?php endif;?>
      <?php endwhile; endif; ?>
        <aside class="work">
          <div class="work__txt-group">
            <div class="ttl-group">
              <h2 class="ttl-group__txt-en">Work</h2>
              <p class="ttl-group__txt-ja--min" role="doc-subtitle">その他<span class="ttl-work"><?php echo $cat_name; ?></span>の制作物</p>
            </div>
          </div>
          <div class="work__list is-show">
            <?php
            $posts_per_page = 2;
            $loop_query = new WP_Query(loop_query($work,$posts_per_page,'rand','',$taxonomyCatWork,'slug',$cat_slug));?>
            <?php if ($loop_query->have_posts()) : ?>
              <?php while ($loop_query->have_posts()) : $loop_query->the_post(); ?>
                <?php get_template_part('loop-work',null,$cat_slug);?>
              <?php endwhile; ?>
            <?php else: ?>
              <p>投稿が1件も見つかりませんでした。</p>  
            <?php endif;?>
            <?php wp_reset_query();?>
          </div>
        </aside>
    <div class="content__button-outer--center">
<a href="/"><button class="content__button-submit--work" type="button">トップに戻る<span class="btn__icon--right"><svg xmlns="http://www.w3.org/2000/svg" width="30.772" height="9.77" viewBox="0 0 30.772 9.77" class="responsive-img"><path id="click" data-name="click" d="M1937,7567.163l9.646,8h-28" transform="translate(-1918.646 -7566.394)" fill="none" stroke="#4977b1" stroke-width="2"/></svg></span></button></a>
</div>
    </div>    
  </main>  
</div>
<?php get_footer(); ?>