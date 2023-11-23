<?php
//////////////////////////////////////////////////
//Original sanitize_callback
//////////////////////////////////////////////////
// CheckBox
function sy_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
// radio/select
function sy_sanitize_select( $input, $setting ) {
	$input = sanitize_key( $input );
		$choices = $setting->manager->get_control($setting->id)->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
// number limit
function sy_sanitize_number_range( $number, $setting ) {
	$number = absint( $number );//整数
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}
// uploader
function sy_sanitize_image( $image, $setting ) {
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon'
	);
	$file = wp_check_filetype( $image, $mimes );
	return ( $file['ext'] ? $image : $setting->default );
}
//////////////////////////////////////////////////
//外観>カスタマイズに項目追加
//////////////////////////////////////////////////	
//SNS・OGP設定画面
function sy_social_cutomizer( $wp_customize ) {
  // セクション
  $wp_customize->add_section( 'sy_social_section', array(
    'title'     => 'SNS・OGP設定',
    'priority'  => 1,
  ));
  //OGP画像 セッティング
  $wp_customize->add_setting('sy_social_image_ogp', array(
    'type' => 'theme_mod',
    'transport' => 'postMessage',
    'sanitize_callback' => 'sy_sanitize_image',
  ));
  //OGP画像 コントロール
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'sy_social_image_ogp', array(
    'section' => 'sy_social_section',
    'settings' => 'sy_social_image_ogp',
    'label' => '■[OGP]画像の設定',
    'description' => '投稿にアイキャッチ画像が登録されていない時に表示する画像<br>
（縦600 × 横1200px以上の画像を登録してください）',
  )));
  // TwitterCard セッティング
  $wp_customize->add_setting( 'sy_social_TwitterCard', array(
    'default'   => 'summary',
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'sy_sanitize_select',
  ));
  // TwitterCard コントロール
  $wp_customize->add_control( 'sy_social_TwitterCard', array(
    'section'   => 'sy_social_section',
    'settings'  => 'sy_social_TwitterCard',
    'label'     => '■[OGP]Twitter Cardの種類を選択',
    'description' => 'Twitterで記事がシェアされた時のカードデザインを選択',
    'type'      => 'select',
    'choices'   => array(
        'summary' => 'Summaryカード(default)',
        'summary_large_image' => 'Summary with Large Imageカード',
    ),
  ));
	// FacebookAPPID セッティング
  $wp_customize->add_setting( 'sy_sns_twitter', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));
  // FacebookAPPID コントロール
  $wp_customize->add_control( 'sy_sns_twitter', array(
    'section'   => 'sy_social_section',
    'settings'  => 'sy_sns_twitter',
    'label'     => '■TwitterのID',
    'description' => 'TwitterのIDを記入(※＠以降)',
    'type'      => 'text',
  ));
  // FacebookAPPID セッティング
  $wp_customize->add_setting( 'sy_social_FBAppId', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));
  // FacebookAPPID コントロール
  $wp_customize->add_control( 'sy_social_FBAppId', array(
    'section'   => 'sy_social_section',
    'settings'  => 'sy_social_FBAppId',
    'label'     => '■[OGP]FacebookのAPPID',
    'description' => 'FacebookのApp IDを記入',
    'type'      => 'text',
  ));
  // Facebook publisher セッティング
  $wp_customize->add_setting( 'sy_social_FBpublisher', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));
  // Facebook publisher コントロール
  $wp_customize->add_control( 'sy_social_FBpublisher', array(
    'section'   => 'sy_social_section',
    'settings'  => 'sy_social_FBpublisher',
    'label'     => '■[OGP]FacebookのページURL',
    'description' => 'FacebookのページURL入力',
    'type'      => 'url',
  ));
  // Facebookadmins ID セッティング
  $wp_customize->add_setting( 'sy_social_FBAdmins', array(
    'type' => 'option',
    'transport' => 'postMessage',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
  ));
  // Facebookadmins ID コントロール
  $wp_customize->add_control( 'sy_social_FBAdmins', array(
    'section'   => 'sy_social_section',
    'settings'  => 'sy_social_FBAdmins',
    'label'     => '■[OGP]Facebookのadmins ID',
    'description' => 'URLの「&type」の前にあるランダムな数字を記入',
    'type'      => 'text',
  ));
}
add_action( 'customize_register', 'sy_social_cutomizer' );
//セットした画像のURLを取得
function get_sy_image_ogp() { return esc_url(get_theme_mod('sy_social_image_ogp'));}

//////////////////////////////////////////////////
//一覧情報取得
//////////////////////////////////////////////////
// すべての固定ページ情報の取得
function page_list(){
  $page_list = get_posts( 'numberposts=-1&order=ASC&post_type=page' ); 
  return $page_list;
} 
function cat_lists(){
  //すべてのカテゴリー一覧
  $catParent = array(
    'parent' => 0,
    'orderby' => 'trem_order',
    'order' => 'DESC',
  );
  $categorys = get_categories( $catParent );
  return $categorys;
}	

//////////////////////////////////////////////////
//外観>カスタマイズに項目追加
//////////////////////////////////////////////////	
//SEO設定画面
function sy_seo_cutomizer( $wp_customize ) {
	$sy_seo_section_desc = '';
	$wp_customize->add_section( 'sy_seo_section', array(
		'title'     => 'SEO設定',
		'priority'  => 1,
		'description' => $sy_seo_section_desc,
	));
	if ( get_option( 'show_on_front' ) != 'page' ) {//TOPページ固定(page.php)以外
	// TOPページ
	//<title> 
		//セッティング
		$wp_customize->add_setting( 'sy_seo_titleTop', array(
			'default'   => get_bloginfo( 'description' ) .sy_title_separator() .get_bloginfo( 'name' ),
			'type' => 'option',
			'transport' => 'postMessage',//即時反映
			'sanitize_callback' => 'sanitize_text_field',//サニタイズ
		));
		//コントロール
		$wp_customize->add_control(
			'sy_seo_titleTop', array(
				'section'   => 'sy_seo_section',
				'settings'  => 'sy_seo_titleTop',
				'label' => '■TOPページの&lt;title&gt;',
				'description' => 'TOPページの&lt;title&gt;を入力<br>(未入力の場合は「設定」→「一般」の【キャッチフレーズ │ サイトのタイトル】が表示されます)',
				'type'      => 'text',
		));
		//サイト名
			//セッティング
			$wp_customize->add_setting( 
				'sy_seo_titleTopName', array(
					'type' => 'option',
					'sanitize_callback' => 'sy_sanitize_checkbox',
			));
			//コントロール
			$wp_customize->add_control( 'sy_seo_titleTopName', array(
				'section'   => 'sy_seo_section',
				'settings'  => 'sy_seo_titleTopName',
				'label'     => '「'.sy_title_separator().' '.get_bloginfo( 'name' ).'」を表示する',
				'type'      => 'checkbox',
			));
		//<meta description>
			//セッティング
			$wp_customize->add_setting('sy_seo_descriptionTop', array(
				'default'   => get_bloginfo( 'description' ),
				'type' => 'option',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			));
			//コントロール
			$wp_customize->add_control( 
				'sy_seo_descriptionTop', array(
				'section'   => 'sy_seo_section',
				'settings'  => 'sy_seo_descriptionTop',
				'label' => '■TOPページの&lt;meta description&gt;',
				'description' => 'TOPページの&lt;meta  description&gt;を入力',
				'type'      => 'textarea',
			)); 
	}
	// CSS非同期読み込み 
		//セッティング
		$wp_customize->add_setting( 
			'sy_seo_cssLoad', array(
				'default'   => 'value1',
				'type' => 'option',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sy_sanitize_select',
			));
		//コントロール
		$wp_customize->add_setting(
			'sy_seo_cssLoad', array(
				'section' => 'sy_seo_section',
				'setting' => 'sy_seo_cssLoad',
				'label' => '■CSS非同期読込設定',
				'description' => 'CSSの非同期読み込みを有効化するか選択<br>
				（CSS非同期読み込みを有効化するとページの読み込み速度が向上する代わりに、一瞬デザインが崩れて見えることがあります。※有効にするとfooterに一行JavaScript記述）<br>
				<br>
				※無効にする場合は下記のチェック項目をすべてOFFにしてください。',
				'type'      => 'select',
				'choices'   => array(
					'value1' => '無効(default)',
					'value2' => '有効',
				),
		));
	//メインCSS
		//セッティング
		$wp_customize->add_setting(
			'sy_seo_cssLoad-main', array(
				'type' => 'option',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sy_sanitize_checkbox',
			)
		);
		//コントロール
		$wp_customize->add_control(
			'sy_seo_cssLoad-main',array(
				'section'   => 'sy_seo_section',
				'settings'  => 'sy_seo_cssLoad-main',
				'label'     => 'メインCSS(style.css)を非同期読み込みする',
				'type'      => 'checkbox',
			)
		);
	// AdobeフォントCSS 
		//セッティング
		$wp_customize->add_setting( 'sy_seo_cssLoad-adobe', array(
			'type' => 'option',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sy_sanitize_checkbox',
		));
		//コントロール
		$wp_customize->add_control( 'sy_seo_cssLoad-adobe', array(
			'section'   => 'sy_seo_section',
			'settings'  => 'sy_seo_cssLoad-lato',
			'label'     => 'AdobeフォントCSSを非同期読み込みする',
			'type'      => 'checkbox',
		));
}
add_action( 'customize_register', 'sy_seo_cutomizer' );
//headerカスタマイズ
	function sy_header_cutomizer( $wp_customize ) {
	$wp_customize->add_section( 'sy_header_section', array(
		'title'     => 'headerの表示設定',
		'priority'  => 1,
		'description' =>  'headerの表示設定',
	));
		//固定ページリンク
	//セッティング
	$wp_customize->add_setting(
		'sy_header_class',array(
			'type' => 'option',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	//コントロール
	$wp_customize->add_control(
		'sy_header_class',array(
			'title'     => '固定ページ',
			'section'   => 'sy_header_section',
			'settings'  => 'sy_header_class',
			'label' => '固定ページのクラス名',
			'description' => 'liのclass(この部分)__list-item',
			'type'      => 'text',
		)
	);  
	foreach ( page_list() as $page_item ) {
		//セッティング
		$wp_customize->add_setting( 'sy_'.get_option('sy_header_class').'-link-id'.get_the_title($page_item->ID), array(
			'type' => 'option',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sy_sanitize_checkbox',
		));
		//コントロール
		$wp_customize->add_control( 'sy_'.get_option('sy_header_class').'-link-id'.get_the_title($page_item->ID), array(
			'section'   => 'sy_header_section',
			'settings'  => 'sy_'.get_option('sy_header_class').'-link-id'.get_the_title($page_item->ID),
			'label'     => '['.get_the_title($page_item->ID).']を'.get_option('sy_header_class').'のリンクに表示しない。',
			'type'      => 'checkbox',
		));
	}
}
add_action( 'customize_register', 'sy_header_cutomizer' );
//loopカスタマイズ	
function sy_loop_cutomizer( $wp_customize ) {
	$wp_customize->add_section( 'sy_loop_section', array(
		'title'     => 'loopの表示設定',
		'priority'  => 1,
		'description' =>  'loopの表示設定',
	));
	//表示しないカテゴリー
	foreach(cat_lists() as $category){
		//セッティング
		$wp_customize->add_setting( 'sy_loop_cat_'.$category->cat_ID, array(
			'type' => 'option',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sy_sanitize_checkbox',
		));
		//コントロール
		$wp_customize->add_control( 'sy_loop_cat_'.$category->cat_ID, array(
			'section'   => 'sy_loop_section',
			'settings'  => 'sy_loop_cat_'.$category->cat_ID,
			'label'     => '['.$category->name.']を表示しない。',
			'type'      => 'checkbox',
		));
	}	
}
add_action( 'customize_register', 'sy_loop_cutomizer' );

//////////////////////////////////////////////////
//ページタイトル表示
//////////////////////////////////////////////////
function sy_page_title() {
	global $work,$taxonomyCatWork,$taxonomyTagWork;
	if ( is_post_type_archive($work) ){
		$title = 'WORK' ;
		$subtitle = '制作実績一覧';
	}elseif ( is_category() || is_tax($taxonomyCatWork) ) {
		$title = 'GATEGORY';
		$subtitle = '<span class="search__txt">'.single_cat_title( '', false ).'</span>を表示中';
	} elseif ( is_tag()|| is_tax($taxonomyTagWork)) {
		$title = 'TAG';
		$subtitle = '<span class="search__txt">'.single_tag_title( '', false ).'</span>を表示中';
	} elseif ( is_author() ) {
		$title = 'AUTHOR';
		$subtitle = get_the_author();
	} elseif ( is_year() ) {
		$title = 'YEAR';
		$subtitle = get_the_date('Y年');
	} elseif ( is_month() ) {
		$title = 'MONTH';
		$subtitle = get_the_date('Y年n月') ;
	} elseif ( is_day() ) {
		$title = 'DAY';
		$subtitle = get_the_date('Y年n月j日') ;
  } elseif ( is_search() ) {
		$title = '<span class="search__txt">'.get_search_query().'</span>についての記事が';
		$subtitle = '見つかりました。';
	} elseif ( is_404() ) {
		$title = '404 Not Found' ;
		$subtitle = 'ページが見つかりません';
	}elseif(is_page()){
		if(is_page(array('confirm','thanks',))){
			$title  = 'Contact';
		}else{
			$title  = 'Page';
		}
		$subtitle  = get_the_title();
	}
	$titles = ['title' => $title, 'subtitle' => $subtitle];
  return $titles;
}	

//////////////////////////////////////////////////
//wp_head　<title>タグの設定
//////////////////////////////////////////////////
// wp_headで<title>を出力する
function setup_theme() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'setup_theme' );

// <title>の区切り線を｜に変更する
function sy_title_separator(){
	$sep = '│';
	return $sep;
}
add_filter( 'document_title_separator', 'sy_title_separator' );
// <title>の設定
function sy_document_title( $title ) {
	global $work,$taxonomyCatWork,$taxonomyTagWork;
	if ( is_home() || is_front_page() ) {
		if ( get_option('sy_seo_titleTop') && !get_option('sy_seo_titleTopName') ) {
			$title = get_option('sy_seo_titleTop');
		}elseif ( get_option('sy_seo_titleTop') && get_option('sy_seo_titleTopName') ) {
			$title = get_option('sy_seo_titleTop') .sy_title_separator() .get_bloginfo( 'name' );		
		}else {
			$title = get_bloginfo( 'description' ) .sy_title_separator() .get_bloginfo( 'name' );
		}
	}elseif (is_tax() || is_category() || is_tag() || is_author() || is_year() || is_month() || is_day() || is_search() || is_404() ) {
		if(is_search()){
			$mainTitle = get_search_query().'についての記事が';
		}else{
			$mainTitle = sy_page_title()['title'];
		}
		if(is_category() || is_tax($taxonomyCatWork)){
			$subtitle =  '['.single_cat_title( '', false ).']';
		}elseif(is_tag() || is_tax(array($taxonomyTagWork))){
			$subtitle = '['.single_tag_title( '', false ).']';
		}elseif(sy_page_title()['subtitle']){
			$subtitle = sy_page_title()['subtitle'];
		}
		$title = $mainTitle.$subtitle .sy_title_separator() .get_bloginfo( 'name' );
	}elseif(is_post_type_archive($work)){
		$title = sy_page_title()['subtitle'].sy_title_separator() .get_bloginfo( 'name' );
	}elseif (is_singular() && get_post_meta(get_the_ID(), 'title', true) && get_post_meta(get_the_ID(), 'titleName', true) ) {
		$title = get_post_meta(get_the_ID(), 'title', true) .sy_title_separator() .get_bloginfo( 'name' );
	}elseif (is_singular() && get_post_meta(get_the_ID(), 'title', true) && !get_post_meta(get_the_ID(), 'titleName', true) ) {
		$title = get_post_meta(get_the_ID(), 'title', true);
	}
return $title;
}
add_filter( 'pre_get_document_title', 'sy_document_title' );
//meta Description 設定
function syMetaDescription(){
	global $work,$taxonomyCatWork,$taxonomyTagWork;
	$blogname = get_bloginfo( 'name' );
	$syMetaDescription = '';
	if ( is_home() || is_front_page() ) {
		$syMetaDescription = get_bloginfo( 'description' );
	}elseif(is_page(array('confirm','thanks',))){
		$syMetaDescription = $blogname.'の'.'送信内容確認ページです。';
	}elseif(is_post_type_archive($work)){
		$syMetaDescription = $blogname.'の'.'制作実績一覧ページです。';
	}
	elseif (is_tax() || is_category() || is_tag() || is_author() || is_year() || is_month() || is_day() || is_search() || is_404() ) {
		if(is_search()){
			global $wp_query;
			if($wp_query->found_posts > 0){ 
				$syMetaDescriptionIssearch = $wp_query->found_posts;?>件</span><?php echo sy_page_title()['subtitle']; 
			}else{
				$syMetaDescriptionIssearch = '見つかりませんでした。';
			}
			$syMetaDescription = $blogname.'内には'.get_search_query().'についての記事が'.$syMetaDescriptionIssearch;
		}
		if(is_category() || is_tax($taxonomyCatWork)){
			$syMetaDescription = $blogname.'の'.single_cat_title( '', false ).'カテゴリーページです。';
		}elseif(is_tag() || is_tax($taxonomyTagWork)){
			$syMetaDescription = $blogname.'の'.single_tag_title( '', false ).'タグのページです。';
		}elseif ( is_author() ) {
			$syMetaDescription = $blogname.'内の'.get_the_author().'が作成した記事一覧です。';
		}elseif ( is_year()|| is_month() || is_day()) {
			$syMetaDescription = $blogname.'の'.sy_page_title()['subtitle'].'に作成された記事';
		}elseif ( is_404() ){
			$syMetaDescription = 'お探しのページは見つかりません';
		}elseif(sy_page_title()['subtitle']){
			$syMetaDescription = $blogname.'の'.sy_page_title()['subtitle'];
		}
	}else{
		$syMetaDescription = $blogname.'の'.get_the_title().'ページです。';
	}
	return $syMetaDescription;
}
//OGP設定
function setting_ogp(){
	global $post,$work,$taxonomyCatWork,$taxonomyTagWork;
	$postID = $post->ID;
  echo '<meta property="og:site_name" content="'.get_option('blogname').'" />'."\n";
  //投稿(post)、カスタム投稿タイプ、固定ページ、添付ファイルのシングルページ
  if(is_singular()){
    echo '<meta property="og:type" content="article" />'."\n";
  }else{
    echo '<meta property="og:type" content="website" />'."\n";
  }
  //投稿(post)、カスタム投稿タイプ、固定ページ、添付ファイルのシングルページ
  if (is_single()){
    //ページタイトル
    echo '<meta property="og:title" content="'.get_the_title().'" />'."\n";
    if(have_posts()){while ( have_posts() ) { the_post();
      //ページの説明文
			echo '<meta property="og:description" content="'.syMetaDescription().'" />'."\n";
		}}
    //ページURL
    echo '<meta property="og:url" content="'.get_the_permalink().'" />'."\n";
  //TOPページ
  }elseif (is_home() || is_front_page()){
    //ページタイトル
    echo '<meta property="og:title" content="'.get_bloginfo('name').'" />'."\n";
    //ページの説明文
    echo '<meta property="og:description" content="'.get_bloginfo('description').'" />'."\n";
    //ページURL
    echo '<meta property="og:url" content="'.get_home_url().'" />'."\n";
  }else{
    //ページタイトル
    echo '<meta property="og:title" content="'.wp_get_document_title().'" />'."\n";
    //ページの説明文
		echo '<meta property="og:description" content="'.syMetaDescription().'" />'."\n";
    if(is_year()){//年別アーカイブ
      echo '<meta property="og:url" content="'.get_year_link('').'" />'."\n";
    }elseif(is_month()){//月別アーカイブ
			echo '<meta property="og:url" content="'.get_month_link('', '').'" />'."\n";
		}elseif(is_day()){//日別アーカイブ
			echo '<meta property="og:url" content="'.get_day_link('', '', '').'" />'."\n";
		}elseif(is_author()){//作成者アーカイブページ
			echo '<meta property="og:url" content="'.get_author_posts_url(get_the_author_meta( 'ID' )).'" />'."\n";
		}elseif(is_search()){//検索結果ページ
			echo '<meta property="og:url" content="'.get_search_link().'" />'."\n";
		}elseif(is_category()){//カテゴリーページ
			$cat = get_the_category();
			$cat_id = $cat[0]->cat_ID;
			echo '<meta property="og:url" content="'.get_category_link($cat_id).'" />'."\n";
		}elseif(is_tax($taxonomyCatWork)){
			$cat = get_the_terms($postID,$taxonomyCatWork);
  		$catSlug = $cat[0]->slug;
			$catLink = get_term_link($catSlug,$taxonomyCatWork);
			echo '<meta property="og:url" content="'.$catLink.'" />'."\n";
		}elseif(is_tag()){//タグページ
			$tag = get_the_tags();
			$tag_id = $tag[0]->term_id;
			echo '<meta property="og:url" content="'.get_tag_link($tag_id).'" />'."\n";
		}elseif(is_tax($taxonomyTagWork)){
			$tag = get_the_terms($postID,$taxonomyTagWork);
  		$tagSlug = $tag[0]->slug;
			$tagLink = get_term_link($tagSlug,$taxonomyTagWork);
			echo '<meta property="og:url" content="'.$tagLink.'" />'."\n";
		}elseif(is_post_type_archive('work')){
			echo '<meta property="og:url" content="'.get_post_type_archive_link($work).'" />'."\n";
		}else{//その他
			echo '<meta property="og:url" content="'.get_home_url().'" />'."\n";
		}
  }
  //画像
  if (is_singular()){  //投稿(post)、カスタム投稿タイプ、固定ページ、添付ファイルのシングルページ
    if (has_post_thumbnail()){//投稿にサムネイルがある場合
      $image_id = get_post_thumbnail_id();//thumbnail ID
      $image = wp_get_attachment_image_src( $image_id, 'icatch');//thumbnail src
      echo '<meta property="og:image" content="'.$image[0].'" />'."\n";
    }else{//何も無い場合
			echo '<meta property="og:image" content="'.get_option('siteurl').'/wp-content/themes/myportfolio/img/ogp/site_thumbnail.jpg" />'."\n";
		}
  }else{//その他
    echo '<meta property="og:image" content="'.get_option('siteurl').'/wp-content/themes/myportfolio/img/ogp/site_thumbnail.jpg" />'."\n";
  }
	if ( get_option('sy_social_TwitterCard')) {
		echo '<meta name="twitter:card" content="'.get_option('sy_social_TwitterCard').'" />'."\n";
	}
  if ( get_option('sy_sns_twitter')) {
		echo '<meta name="twitter:site" content="@'.get_option('sy_sns_twitter').'" />'."\n";
	}
	
	if ( get_option('sy_social_FBAppId')) {
		echo '<meta property="fb:app_id" content="'.get_option('sy_social_FBAppId').'" />'."\n";
	}
	if ( get_option('sy_social_FBpublisher')) {
		echo '<meta property="article:publisher" content="'.get_option('sy_social_FBpublisher').'" />'."\n";
	}
	
	if ( get_option('sy_social_FBAdmins')) {
		echo '<meta property="fb:admins" content="'.get_option('sy_social_FBAdmins').'" />'."\n";
	}
}
//wp_headにオリジナル項目追加
function sy_head() {
  if ( get_option('sy_seo_cssLoad') == "value2" && get_option('sy_seo_cssLoad-main')) {
    echo '<link class="css-async" rel href="'.get_template_directory_uri().'/css/normalize.css">'."\n";
		echo '<link class="css-async" rel href="'.get_stylesheet_uri().'">'."\n";
		echo '<link class="css-async" rel href="'.get_template_directory_uri().'/css/style.css">'."\n";
	}else{
    echo '<link rel="stylesheet" rel href="'.get_template_directory_uri().'/css/normalize.css">'."\n";
		echo '<link rel="stylesheet" href="'.get_stylesheet_uri().'">'."\n";
    echo '<link rel="stylesheet" rel href="'.get_template_directory_uri().'/css/style.css">'."\n";
	}
  echo '<link rel="stylesheet" href="https://use.typekit.net/gjf3dgf.css">'."\n";
	//meta description
	echo '<meta name="description" content="'.syMetaDescription().'">';
  //IE最新表示
  echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'."\n";
  //viewport
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">'."\n";
  //dns-prefetch
  echo '<link rel="dns-prefetch" href="//www.google.com">'."\n";
	echo '<link rel="dns-prefetch" href="//www.google-analytics.com">'."\n";
	echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">'."\n";
	echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">'."\n";
	echo '<link rel="dns-prefetch" href="//pagead2.googlesyndication.com">'."\n";
	echo '<link rel="dns-prefetch" href="//googleads.g.doubleclick.net">'."\n";
	echo '<link rel="dns-prefetch" href="//www.gstatic.com">'."\n";
  if (is_single()){
		wp_enqueue_script("comment-reply");//コメントの返信フォーム設定
  }
	setting_ogp();
}
add_action('wp_head', 'sy_head');
//////////////////////////////////////////////////
//オリジナル関数
//////////////////////////////////////////////////
//WordPressのバージョンを非表示に
remove_action('wp_head','wp_generator');
//////////////////////////////////////////////////
//画像設定
//////////////////////////////////////////////////
//-scaled画像作らない
add_filter( 'big_image_size_threshold', '__return_false' );
//thumbnail
add_theme_support('post-thumbnails');
//画像アップロード時にデフォルトのリサイズ機能使わない
add_filter( 'intermediate_image_sizes_advanced', 'hack_intermediate_image_sizes_advanced' );
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
function hack_intermediate_image_sizes_advanced( $sizes ) {
	 $sizes = array();  # 空にする
    return $sizes;
}
//upload ディレクトリ
function wpUploadDir(){
	$uploadServerPath = wp_upload_dir()['basedir'];
	$uploadUrlPath = wp_upload_dir()['baseurl'];
	return [$uploadServerPath,$uploadUrlPath];
}
//preview用画像サイズ追加
add_image_size('preview',240,0,true);
//srcset(デバイスピクセル分のイメージルート)作る関数
function createSrcset($imgRoot){
	$srcset = '';//srcsetが入る変数
	global $imgDevicePixel,$imgDevicePixelNameFormat;
	$ext = pathinfo($imgRoot, PATHINFO_EXTENSION);//拡張子
	$serverRoot = $_SERVER['DOCUMENT_ROOT'];//サーバールート
	$urlRoot = empty($_SERVER['HTTPS']) ? 'http://' : 'https://' . $_SERVER['HTTP_HOST'];//URLルート
	for($i = 0; $i < $imgDevicePixel; $i++){
		$fileName = str_replace('.'.$ext,'',$imgRoot);//拡張子外したやつ
		if(0 < $i){
			$fileName = $fileName;
			$imgPlusName = sprintf($imgDevicePixelNameFormat, $i+1);//@%dx
			preg_match("/(@)(.*)/is", $imgPlusName, $pixcel);//%dx
			$pixcel = ' '.$pixcel[2];  
		}
		$plusFile = $fileName.$imgPlusName.'.'.$ext;//変更したファイル名
		$fileRootServer = str_replace($urlRoot,$serverRoot,$plusFile);//サーバールートに変換（ファイルが有るか確認するため）
		if(0 < $i) $plusFile = ', '.$plusFile;
		if(file_exists($fileRootServer)) $srcset .= $plusFile.$pixcel;
	}
	return 'srcset="'.$srcset.'"';
 }
 //source mediaつくる関数
 function sourceMedia($maxWidths,$defaultFileName,$alt){
	$ext = '.'.pathinfo($defaultFileName, PATHINFO_EXTENSION);//拡張子
	$fileName = str_replace($ext,'',$defaultFileName);//拡張子外したやつ
	$sourceMediaAll = '';//すべてのsource media
	foreach($maxWidths as $maxWidth){
		$sourceMedia = '<source media="(max-width: '.$maxWidth.'px)" %s>';
		$sprintf = createSrcset($fileName.'_'.$maxWidth.$ext);
		$sourceMediaAll .= sprintf($sourceMedia,$sprintf);
	}
	$picture = '<picture>'.$sourceMediaAll.'<img src="'.$defaultFileName.'" '.createSrcset($defaultFileName).' class="responsive-img" alt="'.$alt.'"/> </picture>';
	return $picture;
}
//エンコードした画像名返す
function imgUrl($attachment_id){
	$imgMetadata = wp_get_attachment_metadata( $attachment_id  );
	wpUploadDir()[0] = wp_upload_dir()['basedir'];
	//upload ディクレトリ以降の画像ディレクトリ取得
	$imgDirectory = $imgMetadata['file'];
	if(!$imgDirectory) return;
	//画像データが入っているサーバー内の絶対パス
	$file = path_join(wpUploadDir()[0],$imgDirectory);
	$_filenameArr = explode( '.', $file );
	$imgUrl = urlencode($_filenameArr[2]);
	return $imgUrl;
}
//////////////////////////////////////////////////
//データベース
//////////////////////////////////////////////////
//データベースを扱えるように
require_once( dirname(dirname(dirname(dirname( __FILE__ )))) . '/wp-load.php' );
//////////////////////////////////////////////////
//画像のデータベース
//////////////////////////////////////////////////
function imgUseDatabase($allImgLists,$postId,$sizeName,$postImageId){
	//画像データをデータベースに登録する準備
	foreach($allImgLists as $key => $imgRoot){
		$devicePixelKye = array_keys($imgRoot);
		$imgRootCount = count($imgRoot);
		for($i = 0; $i < $imgRootCount; $i++){
			$fileRootUrl = $imgRoot[$devicePixelKye[$i]];
			$fileRootServer = str_replace(wpUploadDir()[1],wpUploadDir()[0],$fileRootUrl);
			if(file_exists($fileRootServer)){
				//ファイルあったらエンコード
				$allImgLists[$key][$devicePixelKye[$i]] = urlencode($fileRootUrl);
			}else{
				//ファイルなかったら削除
				unset($allImgLists[$key][$devicePixelKye[$i]]);
			}
		}
	}
	//データベースにウィンドウサイズとデバイスピクセル、ファイルルートが入った配列を追加もしくは更新
	//データベース使う
	global $wpdb;
	//データベースに画像データがあるか確認
	$tablename =  $wpdb->prefix . "img_datas";
	$allImgListsJsonEncode = json_encode($allImgLists);
	$query = $wpdb->prepare( 
		"
		SELECT * 
		FROM $tablename
		WHERE 
		post_id = %d AND 
		img_name LIKE %s
		",
		$postId,
		'%' . $sizeName . '%'
	);
	$results = $wpdb->get_results( $query );
	//データベースからの返り値データ
	$resultsDateFirest = $results[0];
	$results[0] = (array) $resultsDateFirest;
	//img_name $sizeNameのデータなかったら追加あったら更新
	if(!$resultsDateFirest&&!is_null($allImgLists)){
		$wpdb->insert(
			$tablename,
			array(
				'id' => $postImageId,
				'post_id' => $postId,
				'img_name' => $sizeName,
				'img_data' => $allImgListsJsonEncode,
			),
			array(
				'%d',
				'%d',
				'%s',
				'%s'
			)
		);
	}elseif($results[0]['img_data'] === $allImgListsJsonEncode){
	}elseif(!is_null($allImgLists)){
		$wpdb->update(
			$tablename,
			array(
				'id' => $postImageId,
				'img_data' => $allImgListsJsonEncode,
			),
			array(
				'post_id' => $postId,
				'img_name' => $sizeName,
			),
			array(
				'%d',
				'%s'
			),
			array(
				'%d',
				'%s'
			)
		);
	}
} 

//////////////////////////////////////////////////
//picure タグ用リサイズ
//////////////////////////////////////////////////
//リサイズするウィンドウサイズと画像サイズ設定配列
$resizeImgs = [
	'thumbnail' => [
		'width' => [
			1023 => 152,
			'srcset' => 275,
		],
		'height' => [
			1023 => null,
			'srcset' => null,
		],
		'crop' => false,
	],
	'screen_pc' => [
		'width' => [
			1023 => 239,
			'srcset' => 576,
		],
		'height' => [
			1023 => 150,
			'srcset' => 360,
		],
		'crop' => true,
	],
	'screen_tab' => [
		'width' => [
			1023 => 117,
			'srcset' => 281,
		],
		'height' => [
			1023 => 168,
			'srcset' => 403,
		],
		'crop' => true,
	],
	'screen_sp' => [
		'width' => [
			1023 => 57,
			'srcset' => 132,
		],
		'height' => [
			1023 => 124,
			'srcset' => 286,
		],
		'crop' => true,
	],
	'detail_pc' => [
		'width' => [
			414 => 370,
			1365 => 464,
			'srcset' => 608,
		],
		'heught' => [
			414 => null,
			1365 => null,
			'srcset' => null,
		],
		'crop' => false,
	],
	'detail_tab' => [
		'width' => [
			414 => 370,
			'srcset' => 464,
		],
		'height' => [
			414 => null,
			'srcset' => null,
		],
		'crop' => false,
	],
	'detail_sp' => [
		'width' => [
			'srcset' => 240,
		],
		'height' => [
			'srcset' => null,
		],
		'crop' => false,
	],
	'detail_img-not-txt' => [
			'width' => [
				414 => 370,
				767 => 686,
				1023 => 914,
				'srcset' => 1280, 
			],
			'height' => [
				414 => null,
				767 => null,
				1023 => null,
				'srcset' => null,
		],
		'crop' => false,
	],
	'mockup_banner' => [
		'width' => [
			'srcset' => 300,
		],
		'height' => [
			'srcset' => null,
		],
		'crop' => false,
	],
];
//指定のキー順にソートする関数(ソートするデータ,ソートする順のキー)
function sortByKeys($sorterDatas, $sorterKeys){
	$sorter = array_flip($sorterKeys);
	uksort($sorterDatas, function($a, $b) use ($sorter) {
		$aSortOrder = isset($sorter[$a]) ? $sorter[$a] : -1;
		$bSortOrder = isset($sorter[$b]) ? $sorter[$b] : -1;
		return $aSortOrder - $bSortOrder;
	});
	return $sorterDatas;
}
//デバイスピクセル対応用の関数
function addImageSizeRoop($sizeName, $imageSizeXs, $imageSizeYs,$breakPointDatas, bool $resizeCrop, int $createImgLoopCount, int $createImgLoopAdditional,$countOfMediaQuery,$imgDevicePixelNameFormat){
	global $imgDevicePixel;
	$count = $imgDevicePixel;//最初に作るデバイスピクセル（対応する中で一番の大きい解像度）
	$heightIndex = 0;//高さのindex
	//add_image_size()作成
	if (!function_exists('createAddImageSize')) {
		function createAddImageSize($value, $count,$heightIndex,$sizeName,$imageSizeYs,$breakPointDatas,$resizeCrop,$imgDevicePixelNameFormat) {
			//倍数の画像場合は倍に
			$imgDevicePixelNameFormat = sprintf($imgDevicePixelNameFormat, $count);
			 //end イメージ名ごとにループ	 
			$imgMagnificationName = $count > 1 ? $imgDevicePixelNameFormat: '';
			$imageNameX = $count > 1 ? $sizeName.'_'.$breakPointDatas[$heightIndex].$imgMagnificationName : $sizeName.'_'.$breakPointDatas[$heightIndex];
			$imageSizeXsX = $count > 1 ? $value * $count : $value;	
			if($count > 1){//倍数の画像
				$imageSizeYsX = $imageSizeYs[$heightIndex] ? $imageSizeYs[$heightIndex]*$count : 0;//高さがある場合高さを倍に 
			}elseif($count === 1){//１倍の画像
				$imageSizeYsX = $imageSizeYs[$heightIndex] ? $imageSizeYs[$heightIndex] : 0;//高さがある場合高さを倍に 
			}
			$returuImgDatas = [$imageNameX,['width'=>$imageSizeXsX,'height'=>$imageSizeYsX,'crop'=>$resizeCrop]];//[画像名,['widht'=>横幅,'height'=>高さ,'crop'=>切り抜き設定]]
			return $returuImgDatas;
		}
	}
	$array_filled = array_fill(0, $createImgLoopCount, $imageSizeXs);
	array_walk_recursive($array_filled, function($value) use (&$count,&$heightIndex,$sizeName,$imageSizeYs,$breakPointDatas,$resizeCrop,$countOfMediaQuery,&$imgDatas,$imgDevicePixelNameFormat) {
		$returuImgDatas = createAddImageSize($value, $count, $heightIndex, $sizeName,$imageSizeYs,$breakPointDatas,$resizeCrop,$imgDevicePixelNameFormat);
		$heightIndex ++;
		if($heightIndex % $countOfMediaQuery === 0){
			$count--;
			$heightIndex = 0;
		}
		$imgDatas[$returuImgDatas[0]] = $returuImgDatas[1];
	});
	if($createImgLoopAdditional > 0){
		for($i = 0; $i < $createImgLoopAdditional; $i++){
			$returuImgDatas = createAddImageSize($imageSizeXs[$i], $count,$i,$sizeName,$imageSizeYs,$breakPointDatas,$resizeCrop,$imgDevicePixelNameFormat);
			$imgDatas[$returuImgDatas[0]] = $returuImgDatas[1];
		}
	}	
	return $imgDatas;
}
/*リサイズする画像のファイルルートリストを作る関数
(画像id,使う画像のデータ,アップロードファイル出力するか,metaデータ出力するか,$crateImgLists(作成する画像のリスト)作るか),upload ディクレトリ以降の画像ディレクトリ出力すか*/
function createAllImgLists($postImageId,$imgDatas,$createFile=false,$createImgMetadata =false,$createCrateImgLists = false,$outputUploadPath = false){
	//画像のデータ取得
	$imgMetadata = wp_get_attachment_metadata( $postImageId );
	//upload ディクレトリ以降の画像ディレクトリ取得
	$imgDirectory = $imgMetadata['file'];
	if(!$imgDirectory) return;
	//画像データが入っているサーバー内の絶対パス
	$file = path_join(wpUploadDir()[0],$imgDirectory);
	//画像のデータ必要な部分取得
	//ファイル名取得(拡張子付き)
	$name = $imgDirectory;
	//拡張子を取得
	$_filenameArr = explode( '.', $name );
	$ext = $_filenameArr[1];
	//ファイル名取得(拡張子なし)
	$name = $_filenameArr[0];
	/*空配列に(イメージサイズをすべて初期化)
	画像のメタデータを残さず上書きしてしまいたいから
	他のプラグインによって追加されたメタデータに邪魔されたくないから*/
	$imgMetadata = array();
	//画像の幅と高さ取得
	$imagesize = getimagesize($file);
	$width = $imagesize[0];
	$height = $imagesize[1];
	//縦横比を維持した縮小サイズを設定（小サイズの画像を表示するための高さ/幅）
	list($uwidth, $uheight) = wp_constrain_dimensions($width, $height, 254, 0);
	$imgMetadata['hwstring_small'] = "height='$uheight' width='$uwidth'";
	//uploadディレクトリからの相対パスを設定
	$imgMetadata['file'] = $imgDirectory;
	$connectTxt = '-'; //画像名とadd_image_sizeの画像名をつなぐ接続の文字
	//画像名のリスト
	$imageSizeNames = array_keys($imgDatas);//add_image_sizeの画像名
	//画像未作成のリスト
	$crateImgLists = array();
	//画像あるか確認
	foreach($imageSizeNames as $imageSizeName){
		//リサイズした画像の後ろにつける名前
		$connectImageSizeName = $connectTxt.$imageSizeName;
		//リサイズした画像を再リサイズしなようにする設定
		//画像のフルパス
		$fileFullRoot = '%s/'.$name.$connectImageSizeName.'.'.$ext;
		$fileFullRootServer =  sprintf($fileFullRoot, wpUploadDir()[0]);
		$fileFullRootUrl = sprintf($fileFullRoot, wpUploadDir()[1]);
		//すべての画像リストに追加
		preg_match('/(@)(.*)/', $imageSizeName, $devicePixel);
		preg_match('/_([^_@]+)@/', $imageSizeName, $windowWidth);
		//デバイスサイズが無い画像＝1xの標準なのでsrcsetに追加
		if(!$windowWidth) $windowWidth[1] = 'srcset';
		$allImgLists[$windowWidth[1]][$devicePixel[2]] =  $fileFullRootUrl;
		//画像がなければ画像作成リストに追加
		if(!file_exists($fileFullRootServer) && $createCrateImgLists) $crateImgLists[$imageSizeName]= $fileFullRootServer;
	}
	$fileRoot = $createFile ? $file : '';
	$imgMetadata = $createImgMetadata ? $imgMetadata : '';
	$filePathOfupload = $outputUploadPath ? $imgDirectory : ''; 
	return [$allImgLists,$width,$height,$fileRoot,$imgMetadata,$crateImgLists,$filePathOfupload];
}
/*画像リサイズ
(横幅,高さ,切り抜き設定,リサイズ後の名前,アップロードファイルのある場所,サイズ名)*/
function hack_image_make_intermediate_size( $width, $height, $crop = false, $fileRoot, $file ,$size = "") {
	//横幅もしくは高さがある場合
	if ( !$width || !$height ) return;
	//コアファイルを触らずにサムネイルのクオリティ値を変える
	$resized_img = wp_get_image_editor( $file );
	$destfilename = $file;
	if ( ! is_wp_error( $resized_img) ) {
		$destfilename = $fileRoot;
		$resized_img->set_quality( 90 );
		$resized_img->resize( $width, $height, $crop );
		// リサイズして保存
		$resized_img->save( $destfilename );
	}
	$resized_file = $destfilename;
	//渡された変数が WordPress Error であるかチェックします
	if ( !is_wp_error( $resized_file ) && $resized_file && $info = getimagesize( $resized_file ) ) {
		//他のプラグインなどでimage_make_intermediate_sizeにフィルタがかけてあるなら、ちゃんとそれを通す
		$resized_file = apply_filters('image_make_intermediate_size', $resized_file);
		return array(
			'file' => wp_basename( $resized_file ),//ベース名（パスの最後にある名前の部分）を取得する
			'width' => $info[0],
			'height' => $info[1],
			'size' => $size
		);
	}	
}
$imgDevicePixel = 3;//対応するデバイスピクセル比
$imgDevicePixelNameFormat = '@%dx';//2x 3xの画像の名前
//リサイズ
function resizeImg($postId,$postImageId,$sizeName){
	global $resizeImgs,$imgDevicePixel,$imgDevicePixelNameFormat;
	$sizeData = $resizeImgs[$sizeName];
	if(!$sizeData)return;
	//各ウィンドウサイズのadd_image_sizeを作る関数(プラグインにする際はsrcsetのほかに設定した枚数分-1のウィンドウサイズが設定できるように)
	$numberOfImagesCreated = 4;//一箇所に設定する画像の最大枚数
	$resizeImgsWidthDatas = $sizeData['width'];
	$resizeImgsHeightDatas = $sizeData['height'];
	$resizeCrop = $sizeData['crop'];//切り抜き設定
	//width部分
	arsort($resizeImgsWidthDatas);//値が大きい順にソート
	$resizeImgsWidths = array_keys($resizeImgsWidthDatas);	//キー取得
	//$resizeImgsすべてのwidthの配列をつくる
	//heigtをwidthの値が大きい順にソート
	$resizeImgsHeightDatas = sortByKeys($resizeImgsHeightDatas, $resizeImgsWidths);	
	$createImgLoopCount = 0;//イメージ作成のためのループ回数
	$createImgLoopAdditional = 0;//イメージ作成のための追加分
	$countOfMediaQuery = count($resizeImgsWidthDatas);//メディアクエリの数
	//最大作成可能枚数
	$MaxCanCreated = $countOfMediaQuery * $imgDevicePixel;
	//作られない画像がある場合エラー表示
	if($countOfMediaQuery > $numberOfImagesCreated){
		trigger_error('$windowSizeWidthDatasの配列の個数を$numberOfImagesCreated以下にしてください。作成できない画像があります。',E_USER_ERROR);//エラー
	}
	//一箇所に設定する画像の最大枚数が最大作成可能枚数より多く設定されていた場合
	if($numberOfImagesCreated > $MaxCanCreated){
		$numberOfImagesCreated = $MaxCanCreated;//一箇所に設定する画像の最大枚数を最大作成可能枚数に修正
	}//$createImgLoopCount代入
	if($numberOfImagesCreated < $imgDevicePixel){//一箇所に設定する画像の最大枚数が対応するデバイスピクセル比より少なく設定されていた場合
		$createImgLoopCount = $numberOfImagesCreated;//一箇所に設定する画像の最大枚数を代入
}elseif($numberOfImagesCreated / $countOfMediaQuery){//それ以外
		$createImgLoopCount = floor($numberOfImagesCreated / $countOfMediaQuery);//割った数(切り捨て)を代入
	}
	//$createImgLoopAdditional代入
	if($numberOfImagesCreated % $countOfMediaQuery !== 0){
		$createImgLoopAdditional = $numberOfImagesCreated % $countOfMediaQuery;//追加分=余りを代入
	}
	//breakpoint部分
	$breakPointDatas = array_values($resizeImgsWidths);
	//width部分キー削除
	$resizeImgsWidthDatas = array_values($resizeImgsWidthDatas);
	//height部分キー削除
	$resizeImgsHeightDatas = array_values($resizeImgsHeightDatas);
	//デバイスピクセル対応
	$imgDatas = addImageSizeRoop($sizeName,$resizeImgsWidthDatas,$resizeImgsHeightDatas,$breakPointDatas,$resizeCrop,$createImgLoopCount,$createImgLoopAdditional,$countOfMediaQuery,$imgDevicePixelNameFormat);	//(イメージの名前, 横幅,　高さ, ブレイクポイント,切り抜き設定, ループ回数, 追加分作成分,メディアクエリ,デバイスピクセルの名前フォーマット)
	//リサイズ画像のファイルルートリストを作る
	$createAllImgLists = createAllImgLists($postImageId,$imgDatas,true,true,true,true);
	$crateImgLists = $createAllImgLists[5];
	$crateImgListNames = array_keys($crateImgLists);
	$allImgLists = $createAllImgLists[0];
	$width = $createAllImgLists[1];
	$height = $createAllImgLists[2];
	$metadata = $createAllImgLists[4];	
	imgUseDatabase($allImgLists,$postId,$sizeName,$postImageId);
	//ない画像があればつくっていく
	if(!$crateImgLists)return;
	foreach($crateImgListNames as $crateImgListName){
		$imgDatasWidth = intval( $imgDatas[$crateImgListName]['width'] );
		$imgDatasHeighth = intval( $imgDatas[$crateImgListName]['height'] );
		$imgDatasCrop = $imgDatas[$crateImgListName]['crop'];
		$fileFullRoot = $crateImgLists[$crateImgListName];
		//アップロード画像が指定サイズ以下ならリサイズしない
		if($width < $imgDatasWidth || $height < $imgDatasHeighth) continue;
		//['widht'=>横幅,'height'=>高さ,'crop'=>切り抜き設定]追加
		$sizes[$crateImgListName] = array( 'width' => '', 'height' => '', 'crop' => FALSE );
		//画像のメタデータに追加するデータを作成
		//ファイルのルートパス
		$sizes[$crateImgListName]['root'] = $fileFullRoot ? $fileFullRoot : null;
		$sizes[$crateImgListName]['width'] = $imgDatasWidth ? $imgDatasWidth : get_option( "{$crateImgListName}_size_w" );
		//height
		$sizes[$crateImgListName]['height'] = $imgDatasHeighth ? $imgDatasHeighth : 'auto';
		//crop
		$sizes[$crateImgListName]['crop'] = isset($imgDatasCrop) ? intval($imgDatasCrop) : get_option( "{$crateImgListName}_crop" );
	}
	if(!$sizes) return;
	//メタデータに追加していく
	foreach ($sizes as $size => $size_data ) {
	//アップロード画像は、リサイズ設定が追加されたときのためにリネームせず取っておく
	//リサイズ
	$resized = hack_image_make_intermediate_size($size_data['width'], $size_data['height'], $size_data['crop'],$size_data['root'], $createAllImgLists[3], $size);
	if ( $resized ){
		$metadata['sizes'][$size] = $resized;//メタデータのsizesに追加
	}
	//require_once ABSPATH . '/wp-admin/includes/image.php';
	$image_meta = wp_read_image_metadata( $createAllImgLists[3] );//画像ファイルの拡張メタデータ
	//画像ファイルの拡張メタデータがあれば拡張メタデータ追加
	if ( $image_meta ){
		$metadata['image_meta'] = $image_meta;
	}
	}
	wp_update_attachment_metadata( $postImageId, $metadata );//画像にメタデータ生成
	imgUseDatabase($allImgLists,$postId,$sizeName,$postImageId);
}
//新規投稿・更新サムネイル画像リサイズ
function crateResizeThumbnail($postId){
	$post_thumbnail_id = get_post_thumbnail_id( $postId );
	//アイキャッチ分
	resizeImg($postId,$post_thumbnail_id,'thumbnail');
	//カスタムフィールド分 ここ問題
}
add_action( 'post_updated', 'crateResizeThumbnail' );
//カスタムフィールド追加時リサイズ
function crateResizeFields($postId){
	$fields = get_fields($postId);
	foreach($fields as $key => $value){
		if(!$value) continue;
		$data = get_field_object($key,$postId);
		$type = $data['type'];
		if($type !== 'group') continue;
		foreach($value as $child_key => $child_value){
			if(!is_int($child_value)) continue;
			resizeImg($postId,$child_value,$child_key);
		}
	}
}
add_action( 'acf/save_post', 'crateResizeFields' );
//画像が削除されたらデータベースのデータも削除
function imgDelete($attachment_id ){
	$imgUrl = imgUrl($attachment_id);
	global $wpdb;
	$tablename =  $wpdb->prefix . "img_datas";
	$wpdb->query("DELETE FROM ".$tablename." WHERE img_data LIKE '%".$imgUrl."%'");
	return $attachment_id;
}
add_action( 'delete_attachment', 'imgDelete' );
//投稿が削除されたらデータベースのデータも削除
function deletePost($postId){
	global $wpdb;
	$tablename =  $wpdb->prefix . "img_datas";
	$wpdb->query("DELETE FROM ".$tablename." WHERE post_id = ".$postId);
}
add_action('before_delete_post', 'deletePost');
//pictureタグを作る
function picture($imgId,$sizeName){
	//alt
	$alt = get_post_meta( $imgId, '_wp_attachment_image_alt', true );
	if($alt) $alt = 'alt="'.$alt.'"';
	//データベースからデータ引っ張ってくる
	global $wpdb;
	//データベースに画像データがあるか確認
	$tablename =  $wpdb->prefix . "img_datas";
	$query = $wpdb->prepare( 
		"
		SELECT * 
		FROM $tablename
		WHERE 
		id = %d AND 
		img_name LIKE %s
		",
		$imgId,
		'%' . $sizeName . '%'
	);
	$results = $wpdb->get_results( $query );
	//データベースからの返り値データ
	$resultsDateFirest = $results[0];
	if($resultsDateFirest){//データがあったらpictureタグをつくる
		//連想オブジェクトに変換
		$resultsDateFirest->img_data = json_decode($resultsDateFirest->img_data, true);
		//配列に変換(foreach使うため)
		$resultsDateFirestArrays = (array) $resultsDateFirest;
		//Pictureタグで使う画像データを取得
		$imgUsePicturetags = $resultsDateFirestArrays['img_data'];
		$sourceMedia = '';//source mediaの部分
		global $imgDevicePixel;
		//3xからになっているので順番逆に
		$imgUsePicturetags = array_reverse($imgUsePicturetags, true);
		foreach($imgUsePicturetags as $windowSize => $imgUsePicturetag){
			$srcset = '';//source mediaの$srcset部分
			$src  = '';//src部分
			if($windowSize && $windowSize !== 'srcset'){
				$sourceMedia .= '<source media="(max-width:'.$windowSize.'px)" srcset="%s">';//source media部分
				//Pictureタグを使うかどうかをtrueに
				$usePicturetag = true;
			}elseif($windowSize === 'srcset') $sourceMedia .= ' <img src="%s" srcset="%s" class="responsive-img" '.$alt.'/>';//srcset部分responsive-img classつけている。
			//3xからになっているので順番逆に
			$imgUsePicturetag = array_reverse($imgUsePicturetag);
			$srcset .= $src;
			foreach($imgUsePicturetag as $pixcel => $imgRoot){
				//対応するデバイスピクセル分画像なければ1xを一番小さい画像で対応
				if(count($imgUsePicturetag) < $imgDevicePixel || $imgRoot === reset($imgUsePicturetag)) $src = urldecode(reset($imgUsePicturetag));
				$srcset .=	urldecode($imgRoot).' '.$pixcel;
				//,とスペーズつける
				if($imgRoot !== end($imgUsePicturetag)) $srcset .= ', ';
			}
			if($windowSize !== 'srcset') $sourceMedia = sprintf($sourceMedia, $srcset);
			elseif($windowSize === 'srcset') $sourceMedia = sprintf($sourceMedia, $src, $srcset); 
			
		}
		$Picturetag = '<picture>%s</picture>';
		//Pictureタグを使うかどうかがtrueならPictureタグで挟む
		if($usePicturetag)$sourceMedia = sprintf($Picturetag, $sourceMedia);
	}elseif(!$resultsDateFirest){
		$imgUrl = wp_get_attachment_url($imgId);
		$sourceMedia = '<img src="'.$imgUrl.'" class="responsive-img" '.$alt.'/>';
	}
	return $sourceMedia;
}
//////////////////////////////////////////////////
//カテゴリー関係
//////////////////////////////////////////////////
// 制作一覧カテゴリー一覧
function workCats(){
	global $taxonomyCatWork;
	foreach (get_terms($taxonomyCatWork) as $term) {
		$workCats[] = $term->slug;
	}
	return $workCats;
}
function workCatsList($class){
	global $taxonomyCatWork;
	$work_cats = get_terms($taxonomyCatWork);
	foreach($work_cats as $cat){
		if ($cat === reset($work_cats)){
			echo '<div id="'.$class.'-cat-list" class="'.$class.'__cat-list">';
			$workAriaHidden = 'true';
		}else{
			$workAriaHidden = 'false';
		}
		echo '<button class="'.$class.'__cat-item" aria-controls="work__list-'.$cat->slug.'" aria-expanded="'.$workAriaHidden.'" type="button">
			'.$cat->name.'
		</button>';
		if ($cat === end($work_cats)){
			echo '</div>';
		}
	}
}
function postCat($postID,$taxonomy){
	$catTerms = get_the_terms($postID,$taxonomy);
	return $catTerms;
}
// ループ用カテゴリー一覧
function loop_query($postType='post',$numberOfPosts,$orderby=null,$catSlug=null,$taxonomy=null,$field=null,$terms=null){ 
	global $post;
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	$loop_query_condi = array(
		'post_type' => $postType,
		'order' => 'DESC',
		'orderby' => $orderby,
		'category_name' => $catSlug,
		'posts_per_page' => $numberOfPosts,
		'paged' => $paged,
		'post__not_in' => array($post->ID),
		'tax_query' => array(                      //タクソノミーに関する指定はこの中にすべて
			array(
				'taxonomy' => $taxonomy,
				'field'    => $field,
				'terms'    => $terms,
			),
			)
	);
	return $loop_query_condi;
}
//////////////////////////////////////////////////
//ページネーション関係
//////////////////////////////////////////////////
//1ページに表示する数
function change_posts_per_page($query) {
	//管理画面やメインクエリに干渉しないために必須
		if( is_admin() || ! $query->is_main_query() ){
				return;
		}
	//検索ページ  カテゴリーページ
	if ( $query->is_search() || $query->is_category()  ) {
			$query->set( 'posts_per_page', '5' );
			return;
	}
}
add_action( 'pre_get_posts', 'change_posts_per_page' );
//ページネーション関数
function sy_posts_pagination($pages = '', $range = 5){
	$showitems = ($range * 2)+1;//表示するページ数（５ページを表示）

	global $paged;//現在のページ
	if(empty($paged)) $paged = 1;//デフォルトのページ

	if($pages == ''&&$pages == 0)
	{
			global $wp_query;
			$pages = $wp_query->max_num_pages;//全ページ数を取得
			if(!$pages)//全ページ数が空の場合は、１とする
			{
					$pages = 1;
			}
	}
	if(1 != $pages)//全ページが１でない場合はページネーションを表示する
	{
	echo '<ul class="pagination">';
	//Prev：現在のページ値が１より大きい場合は表示
		if($paged > 1) echo '<li class="pagination__list"><a href="'.get_pagenum_link($paged - 1).'"  class="pagination__prev"><img src="'.get_template_directory_uri().'/img/archive/pagination__prev.svg" class="pagination__icon" /></a></li>';

			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
						//三項演算子での条件分岐
						echo ($paged == $i)? '<li class="pagination__list"><a href="'.get_pagenum_link($i).'" class="pagination__item--active">'.$i.'</a></li>':'<li class="pagination__list"><a href="'.get_pagenum_link($i).'"  class="pagination__item">'.$i.'</a></li>';
				}
			}
		//Next：総ページ数より現在のページ値が小さい場合は表示
		if ($paged < $pages) echo '<li class="pagination__list"><a href="'.get_pagenum_link($paged + 1).'" class="pagination__next"><img src="'.get_template_directory_uri().'/img/archive/pagination__next.svg" class="pagination__icon" /></a></li>';
		echo '</ul><div class="clear"></div>';
	}
}
//////////////////////////////////////////////////
//カスタムフィールド関係
//////////////////////////////////////////////////
//カテゴリーWEB関係モックアップ画像に関する関数（引数はカスタムフィールドmockup）
function customFieldWeb($mockupField){
	$mockupFieldKeys = array_keys($mockupField);//カスタムフィールドからキー取得
		foreach($mockupFieldKeys as $index => $mockupFieldKey){
			//画像あれば表示するキーデバイス名、値カスタムフィールドmockupの子フィールド配列作成
			if($mockupField[$mockupFieldKey]){
				preg_match("/(_)(.*)/is", $mockupFieldKey, $deviceName);
				$mockupFieldKeys[$deviceName[2]] = $mockupFieldKey;
				unset($mockupFieldKeys[$index]);
			}
			if($mockupFieldKey)unset($mockupFieldKeys[$index]);//画像がない部分削除
		};
		$deviceNames = array_keys($mockupFieldKeys);//デバイス名だけの配列作成
		$res = ['mockupFieldKeys'=>$mockupFieldKeys,'deviceNames'=>$deviceNames];//[キーデバイス名、値カスタムフィールドmockupの子フィールド,デバイス名]
		return $res;
}
//////////////////////////////////////////////////
//ファイル同士の通信関係
//////////////////////////////////////////////////
//パラメータを受け取る
function add_query_vars_filter( $vars ){
	$vars[] = "work_cat";
	return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );
//ajax
function my_ajax() {
	if(is_single()){
		wp_enqueue_script( 'ajax-script', get_template_directory_uri().'/js/slider.js', null, '1.0.9', false );
		wp_localize_script('ajax-script','my_ajax_date',array(
			'ajax_url' => esc_url(admin_url( 'admin-ajax.php')),
			'nonce' => wp_create_nonce( 'my-ajax-nonce' ),
			'action' => 'my-ajax-nonce',
			'post_id' => get_the_ID(),
		));
	}
}
add_action( 'wp_enqueue_scripts', 'my_ajax', 1 );
//single.php id="detail-img-list"部分
function detailImgDatas() {
	if(check_ajax_referer('my-ajax-nonce', '_nonce', false)){ 
		$detailImgDatas = array();//画像データが入る配列
		$post_id = filter_input( INPUT_POST , 'post_id' );//投稿ID取得
		$mockupField = get_field('mockup',$post_id);
		$deviceNames = customFieldWeb($mockupField)['deviceNames'];//デバイス名取得
		$detailImgField = get_field('detail__img',$post_id);
		foreach($deviceNames as $deviceName){
			//picture関数を使ってイメージを作成(ただしモックアップ似画像があるものだけ)
			if($deviceNames) $detailImg = picture($detailImgField['detail_'.$deviceName],'detail_'.$deviceName);
			//画像があったらエスケープしたものを$detailImgDatasに追加
			if($detailImg) $detailImgDatas[$deviceName] = htmlspecialchars((string)$detailImg, ENT_QUOTES|ENT_HTML5, "UTF-8");
		}
		echo(json_encode($detailImgDatas));
		die();
	} 
}
add_action('wp_ajax_my-ajax-nonce', 'detailImgDatas');	
add_action('wp_ajax_nopriv_my-ajax-nonce', 'detailImgDatas');

//////////////////////////////////////////////////
//パンくずリスト
//////////////////////////////////////////////////
//パンくずリスト表示関数
if ( ! function_exists( 'breadcrumb' ) ) {
  function breadcrumb() {

    // トップページでは何も出力しないように
    if ( is_front_page() ) return false;

    //そのページのWPオブジェクトを取得
    $wp_obj = get_queried_object();
		if(is_single()){
			$pageName = '--single';
		}
    echo  //id名などは任意で
      '<ul id="breadcrumb" class="breadcrumb'.$pageName.'">'.
        '<li class="breadcrumb__list">'.
          '<a href="'. esc_url( home_url() ) .'" class="breadcrumb__link'.$pageName.'"><span>ホーム</span></a>'.
        '&gt;&#160;</li>';

    if ( is_attachment() ) {

      /**
       * 添付ファイルページ ( $wp_obj : WP_Post )
       * ※ 添付ファイルページでは is_single() も true になるので先に分岐
       */
      $post_title = apply_filters( 'the_title', $wp_obj->post_title );
      echo '<li class="breadcrumb__list"><span>'. esc_html( $post_title ) .'</span>&gt;&#160;</li>';

    } elseif ( is_single() ) {

      /**
       * 投稿ページ ( $wp_obj : WP_Post )
       */
      $post_id    = $wp_obj->ID;
      $post_type  = $wp_obj->post_type;
      $post_title = apply_filters( 'the_title', $wp_obj->post_title );

      // カスタム投稿タイプかどうか
      if ( $post_type !== 'post' ) {

        $the_tax = "";  //そのサイトに合わせて投稿タイプごとに分岐させて明示的に指定してもよい

        // 投稿タイプに紐づいたタクソノミーを取得 (投稿フォーマットは除く)
        $tax_array = get_object_taxonomies( $post_type, 'names');
        foreach ($tax_array as $tax_name) {
            if ( $tax_name !== 'post_format' ) {
                $the_tax = $tax_name;
                break;
            }
        }

        $post_type_link = esc_url( get_post_type_archive_link( $post_type ) );
        $post_type_label = esc_html( get_post_type_object( $post_type )->label );

        //カスタム投稿タイプ名の表示
        echo '<li class="breadcrumb__list">'.
              '<a href="'. $post_type_link .'" class="breadcrumb__link'.$pageName.'">'.
                '<span>'. $post_type_label .'</span>'.
              '</a>'.
            '&gt;&#160;</li>';

        } else {

          $the_tax = 'category';  //通常の投稿の場合、カテゴリーを表示

        }

        // 投稿に紐づくタームを全て取得
        $terms = get_the_terms( $post_id, $the_tax );

        // タクソノミーが紐づいていれば表示
        if ( $terms !== false ) {

          $child_terms  = array();  // 子を持たないタームだけを集める配列
          $parents_list = array();  // 子を持つタームだけを集める配列

          //全タームの親IDを取得
          foreach ( $terms as $term ) {
            if ( $term->parent !== 0 ) {
              $parents_list[] = $term->parent;
            }
          }

          //親リストに含まれないタームのみ取得
          foreach ( $terms as $term ) {
            if ( ! in_array( $term->term_id, $parents_list ) ) {
              $child_terms[] = $term;
            }
          }

          // 最下層のターム配列から一つだけ取得
          $term = $child_terms[0];

          if ( $term->parent !== 0 ) {

            // 親タームのIDリストを取得
            $parent_array = array_reverse( get_ancestors( $term->term_id, $the_tax ) );

            foreach ( $parent_array as $parent_id ) {
              $parent_term = get_term( $parent_id, $the_tax );
              $parent_link = esc_url( get_term_link( $parent_id, $the_tax ) );
              $parent_name = esc_html( $parent_term->name );
              echo '<li class="breadcrumb__list">'.
                    '<a href="'. $parent_link .'" class="breadcrumb__link'.$pageName.'">'.
                      '<span>'. $parent_name .'</span>'.
                    '</a>'.
                  '&gt;&#160;</li>';
            }
          }

          $term_link = esc_url( get_term_link( $term->term_id, $the_tax ) );
          $term_name = esc_html( $term->name );
          // 最下層のタームを表示
          echo '<li class="breadcrumb__list">'.
                '<a href="'. $term_link .'" class="breadcrumb__link'.$pageName.'">'.
                  '<span>'. $term_name .'</span>'.
                '</a>'.
              '&gt;&#160;</li>';
        }

        // 投稿自身の表示
        echo '<li class="breadcrumb__list"><span>'. esc_html( strip_tags( $post_title ) ) .'</span></li>';

    } elseif ( is_page() || is_home() ) {

      /**
       * 固定ページ ( $wp_obj : WP_Post )
       */
      $page_id    = $wp_obj->ID;
      $page_title = apply_filters( 'the_title', $wp_obj->post_title );

      // 親ページがあれば順番に表示
      if ( $wp_obj->post_parent !== 0 ) {
        $parent_array = array_reverse( get_post_ancestors( $page_id ) );
        foreach( $parent_array as $parent_id ) {
          $parent_link = esc_url( get_permalink( $parent_id ) );
          $parent_name = esc_html( get_the_title( $parent_id ) );
          echo '<li class="breadcrumb__list">'.
                '<a href="'. $parent_link .'" class="breadcrumb__link'.$pageName.'">'.
                  '<span>'. $parent_name .'</span>'.
                '</a>'.
              '&gt;&#160;</li>';
        }
      }
      // 投稿自身の表示
      echo '<li class="breadcrumb__list"><span>'. esc_html( strip_tags( $page_title ) ) .'</span></li>';

    } elseif ( is_post_type_archive() ) {

      /**
       * 投稿タイプアーカイブページ ( $wp_obj : WP_Post_Type )
       */
      echo '<li class="breadcrumb__list"><span>'. esc_html( $wp_obj->label ) .'</span></li>';

    } elseif ( is_date() ) {

      /**
       * 日付アーカイブ ( $wp_obj : null )
       */
      $year  = get_query_var('year');
      $month = get_query_var('monthnum');
      $day   = get_query_var('day');

      if ( $day !== 0 ) {
        //日別アーカイブ
        echo '<li class="breadcrumb__list">'.
              '<a href="'. esc_url( get_year_link( $year ) ) .'" class="breadcrumb__link'.$pageName.'"><span>'. esc_html( $year ) .'年</span></a>'.
            '&gt;&#160;</li>'.
            '<li class="breadcrumb__list">'.
              '<a href="'. esc_url( get_month_link( $year, $month ) ) . '" class="breadcrumb__link'.$pageName.'"><span>'. esc_html( $month ) .'月</span></a>'.
            '&gt;&#160;</li>'.
            '<li class="breadcrumb__list">'.
              '<span>'. esc_html( $day ) .'日</span>'.
            '</li>';

      } elseif ( $month !== 0 ) {
        //月別アーカイブ
        echo '<li class="breadcrumb__list">'.
              '<a href="'. esc_url( get_year_link( $year ) ) .'" class="breadcrumb__link'.$pageName.'"><span>'. esc_html( $year ) .'年</span></a>'.
            '&gt;&#160;</li>'.
            '<li class="breadcrumb__list">'.
              '<span>'. esc_html( $month ) .'月</span>'.
            '</li>';

      } else {
        //年別アーカイブ
        echo '<li class="breadcrumb__list"><span>'. esc_html( $year ) .'年</span></li>';

      }

    } elseif ( is_author() ) {

      /**
       * 投稿者アーカイブ ( $wp_obj : WP_User )
       */
      echo '<li class="breadcrumb__list"><span>'. esc_html( $wp_obj->display_name ) .' の執筆記事</span></li>';

    } elseif ( is_archive() ) {

      /**
       * タームアーカイブ ( $wp_obj : WP_Term )
       */
      $term_id   = $wp_obj->term_id;
      $term_name = $wp_obj->name;
      $tax_name  = $wp_obj->taxonomy;

      /* ここでタクソノミーに紐づくカスタム投稿タイプを出力しても良いでしょう。 */

      // 親ページがあれば順番に表示
      if ( $wp_obj->parent !== 0 ) {

        $parent_array = array_reverse( get_ancestors( $term_id, $tax_name ) );
        foreach( $parent_array as $parent_id ) {
          $parent_term = get_term( $parent_id, $tax_name );
          $parent_link = esc_url( get_term_link( $parent_id, $tax_name ) );
          $parent_name = esc_html( $parent_term->name );
          echo '<li class="breadcrumb__list">'.
                '<a href="'. $parent_link .'" class="breadcrumb__link'.$pageName.'">'.
                  '<span>'. $parent_name .'</span>'.
                '</a>'.
              '&gt;&#160;</li>';
        }
      }

      // ターム自身の表示
      echo '<li class="breadcrumb__list">'.
            '<span>'. esc_html( $term_name ) .'</span>'.
          '&gt;&#160;</li>';


    } elseif ( is_search() ) {

      /**
       * 検索結果ページ
       */
      echo '<li><span>「'. esc_html( get_search_query() ) .'」で検索した結果</span></li>';

    
    } elseif ( is_404() ) {

      /**
       * 404ページ
       */
      echo '<li><span>お探しの記事は見つかりませんでした。</span></li>';

    } else {

      /**
       * その他のページ（無いと思うけど一応）
       */
      echo '<li><span>'. esc_html( get_the_title() ) .'</span></li>';

    }

    echo '</ul>';  // 冒頭に合わせた閉じタグ

  }
}
//////////////////////////////////////////////////
//検索結果
//////////////////////////////////////////////////
//投稿ページだけ表示
function SearchFilter($query) {
	if ( !is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set( 'post_type', 'post' );
	}
}
add_action( 'pre_get_posts','SearchFilter' );
//////////////////////////////////////////////////
//カスタム投稿
//////////////////////////////////////////////////
//制作実績
$work = 'work';
$taxonomyCatWork = $work.'cat';
$taxonomyTagWork = $work.'tag';
add_action( 'init', 'post_type_work' );
function post_type_work() {
	global $work,$taxonomyCatWork,$taxonomyTagWork;
  register_post_type( // カスタム投稿タイプの追加関数
    $work, 
    array(
      'label' => '制作実績',
      'public' => true, 
      'has_archive' => true, 
      'menu_position' => 5, 
      'show_in_rest' => false, 
      'supports' => array( 
        'title',
        'editor', 
        'thumbnail', 
        'revisions', 
      ),
    )
  );
	register_taxonomy( // カスタムタクソノミーの追加関数
    $taxonomyCatWork, // カテゴリーの名前（半角英数字の小文字）
    $work,     
    array(      
			'label' => '制作実績のカテゴリー', 
      'public' => true,      
			'hierarchical' => true, 
			'has_archive' => true,
			'show_in_rest' => false, 
			'rewrite' => array( 'slug' => 'work' ), //変更後のスラッグ
    )
  );
	register_taxonomy(
		$taxonomyTagWork, 
		$work, 
		array(
			'label' => '制作実績のタグ',
			'public' => true, 
			'hierarchical' => false,
			'update_count_callback' => '_update_post_term_count',
		)
	);
}
add_filter('post_type_link', 'generateCustomPostLink', 1, 2);
add_filter('rewrite_rules_array', 'addRewriteRules');
function generateCustomPostLink($link, $post){
	if ( 'work' === $post->post_type ) {
		$term = wp_get_post_terms( $post->ID, 'workcat' );
		if(!empty($term)){
			return home_url( '/work/' .$term[0]->slug. '/' .$post->post_name );
		}else{
			//タームが指定されていない場合(お好みで)
			return home_url( '/work/other/' .$post->post_name );
		}
	}else {
		return $link;
	}
}
function addRewriteRules($rules){
	$newRules = array(
		//アーカイブページ送り
		'work/page/([0-9]+)/?$' => 'index.php?post_type=work&paged=$matches[1]',
		'work/([^/]+)/page/([0-9]+)/?$' => 'index.php?workcat=$matches[1]&paged=$matches[2]',
		//カスタム投稿アーカイブページ
		'work(?:/([0-9]+))?/?$' => 'index.php?post_type=work&paged=$matches[1]',
		//タクソノミーアーカイブページ
		'work/([^/]+)/?$' => 'index.php?workcat=$matches[1]&paged=$matches[2]',
		//個別記事
		'work/[^/]+/([^/]+)/?$' => 'index.php?post_type=work&name=$matches[1]',
		//アーカイブ
		'work/([^/]+)(?:/([0-9]+))?/?$' => 'index.php?my_category=$matches[1]&paged=$matches[2]',
	);
	return $newRules + $rules;
}
//サイト内検索の設定
function filter_search($query)
{
	global $work;
  if ($query->is_search() && $query->is_main_query() && !is_admin()) {

    // 検索に含めるもの(記事、ページ、カスタム投稿)
    $post_array = array('post', 'page', $work);

    // 検索に含めたくないもの（例えばお問い合わせの確認、完了画面とか）
    $page_ID_contact_confirm = get_page_by_path('contact/confirm')->ID;
    $page_ID_contact_completion = get_page_by_path('contact/completion')->ID;

    $not_in_array = array($page_ID_contact_confirm,$page_ID_contact_completion);

    $query->set('post_type', $post_array);
    $query->set('post__not_in', $not_in_array);
  }
}
add_filter('pre_get_posts', 'filter_search');


// 検索
function custom_search($search, $wp_query)
{
  global $wpdb;
	
  if (!$wp_query->is_search) return $search;
  if (!isset($wp_query->query_vars)) return $search;

  $search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
  if (count($search_words) > 0) {
    $search = '';

    foreach ($search_words as $word) {
      if (!empty($word)) {
        $search_word = '%' . esc_sql($word) . '%';
        $search .= " AND (
          {$wpdb->posts}.post_title LIKE '{$search_word}'
          OR {$wpdb->posts}.post_content LIKE '{$search_word}'
          OR {$wpdb->posts}.ID IN (
             SELECT distinct r.object_id
             FROM {$wpdb->term_relationships} AS r
             INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
             INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
             WHERE t.name LIKE '{$search_word}'
             OR t.slug LIKE '{$search_word}'
             OR tt.description LIKE '{$search_word}'
            )
         OR {$wpdb->posts}.ID IN (
            SELECT distinct post_id
            FROM {$wpdb->postmeta}
            WHERE {$wpdb->postmeta}.meta_key IN ('カスタムフィールド１','カスタムフィールド２') AND meta_value LIKE '{$search_word}'
            )
         )";

        // 最初     タイトルにキーワードが含まれているかどうか
        // 1番目OR  コンテンツにキーワードが含まれているかどうか
        // 2番目OR  タグ、カテゴリー、タームにキーワードが含まれているかどうか
                // →   post.ID に紐づけられている term_relationships と紐づけられている terms, term_taxonomy の terms.name, terms.slug, term_taxonomy.description に検索キーワードがあるかどうか
        // 3番目OR  カスタムフィールドにキーワードが含まれているかどうか
                // →   post.ID に紐づけられている postmeta の meta_key が指定のカスタムフィールドである meta_value に検索キーワードがあるかどうか

      }
    }
  }
  return $search;
}
add_filter('posts_search', 'custom_search', 10, 2);
?>
