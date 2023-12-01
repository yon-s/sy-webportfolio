<?php
/*
Template Name: TOPページ用
*/
?>
<?php
 get_header(); ?>
<div class="wrapper--not-pb">
  <div class="main-visual">
    <div class="main-visual__nav">
      <ul class="main-visual__nav-list">
        <?php
          $mainVisualNavLists = [
            [
              'txtEn' => 'Work',
              'txtJa' => '制作物',
            ],
            [
              'txtEn' => 'Seo',
              'txtJa' => '検索上位を<br>獲得した実績',
            ],
            [
              'txtEn' => 'About',
              'txtJa' => '私について',
            ],
            [
              'txtEn' => 'Skill',
              'txtJa' => 'スキル',
            ],
            [
              'txtEn' => 'Contact',
              'txtJa' => 'お問い合わせ',
            ],
          ]
        ?>
        <?php foreach($mainVisualNavLists as $mainVisualNavList):?>        
          <li class="main-visual__nav-item">
            <a href="#<?php echo lcfirst($mainVisualNavList['txtEn']);?>" class="main-visual__nav-link">
              <p class="main-visual__nav-en"><?php echo $mainVisualNavList['txtEn'];?></p>
              <p class="main-visual__nav-ja" role="doc-subtitle"><?php echo $mainVisualNavList['txtJa'];?></p>
              <div class="main-visual__nav-icon"><img src="<?php echo get_template_directory_uri()?>/img/nav/main-visual__nav-icon.svg" width="11px" height="5.5px" class="responsive-img"/></div>
            </a>
          </li>
        <?php endforeach;?>
      </ul>  
    </div>  
    <div class="main-visual__img">
      <div class="main-visual__txt">
        <p class="main-visual__ttl">SHUICHI&nbsp;<br class="br__sp">YONEHARA</p>
        <p class="main-visual__txt-sub">Web Developer / Designer</p>
      </div>  
    </div>  
  </div>
  <main class="main-index">
    <section class="work" id="work">
      <div class="work__txt-group">
        <div class="ttl-group">
          <h2 class="ttl-group__txt-en">Work</h2>
          <p class="ttl-group__txt-ja--min" role="doc-subtitle">制作物</p>
        </div>
        <?php workCatsList('work');?>  
      </div>
      <?php 
      $work_cat_count = 0;
      $workCats = workCats();
      global $work,$taxonomyCatWork;
      foreach($workCats as $workCat):
        	if ($workCat === reset($workCats)){
            $workAriaHidden = 'false';
          }else{
            $workAriaHidden = 'true';
          }?>
        <div class="work__list" id="<?php echo 'work__list-'.$workCat?>" aria-hidden="<?php echo $workAriaHidden;?>">
          <?php $posts_per_page = 20;
          $loop_query = new WP_Query(loop_query($work,$posts_per_page,'','',$taxonomyCatWork,'slug',$workCat));?>
          <?php if ($loop_query->have_posts()) : ?>
            <?php while ($loop_query->have_posts()) : $loop_query->the_post(); ?>
              <?php get_template_part('loop-work',null,$workCat);?>
            <?php endwhile; ?>
          <?php else: ?>
            <p>投稿が1件も見つかりませんでした。</p>  
          <?php endif;?>
          <?php wp_reset_query();?>
        </div>     
      <?php endforeach;?>
    </section>
    <section class="seo" id="seo">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en">Seo</h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle">検索上位を獲得した実績</p>
      </div>    
      <ul class="seo__content">
        <?php 
          $seoWindowWidth = [414,767,1023]; //source mediaのmax-width
          $imgRoot = 'img';
          $seoImgRoot = get_template_directory_uri().'/'.$imgRoot.'/seo/';
          $seoDates =
          [
            [
            'img' => 'uq_mobile_0.jpg',
            'keyword' => 'uqモバイル データ残量 ゼロ',
            'rank' => 1.1,
            'source' => '2022/02/08から過去 3ヶ月のSearch Consoleのデータより'
            ],
            [
            'img' => 'ipad_up_date.jpg',
            'keyword' => 'ipad アップデート 時間',
            'rank' => 1.5,
            'source' => '2022/02/08から過去 3ヶ月のSearch Consoleのデータより'
            ],
            [
            'img' => 'suica_414.jpg',
            'keyword' => 'suicaアプリ wallet どっち',
            'rank' => 2,
            'source' => '2022/02/08から過去 3ヶ月のSearch Consoleのデータより'
            ],
            [
            'img' => 'ipad_click_right_414.jpg',
            'keyword' => 'ipad 右クリック',
            'rank' => 2.7,
            'source' => '2022/02/08から過去 3ヶ月のSearch Consoleのデータより'
            ],
            [
            'img' => 'airscreen_414.jpg',
            'keyword' => 'airscreen iPhone ミラーリングできない',
            'rank' => 2,
            'source' => '2022/02/08から過去 3ヶ月のSearch Consoleのデータより'
            ],
            [
            'img' => 'amazon_iPhone_414.jpg',
            'keyword' => '楽天ポイント amazon iPhone',
            'rank' => 1,
            'source' => '2022/02/08から過去 3ヶ月のSearch Consoleのデータより'
            ],
            [
            'img' => 'iphonese3_seria_414.jpg',
            'keyword' => 'iPhone SE 第3世代 フィルム 100均',
            'rank' => 3.4,
            'source' => '2022/11/03から過去 3ヶ月のSearch Consoleのデータより'
            ],

          ]
        ?>
        <?php foreach($seoDates as $seoDate):?>
          <li class="seo__item">
              <div class="seo__img">
                <?php echo sourceMedia($seoWindowWidth,$seoImgRoot.$seoDate['img'],$seoDate['keyword']);?>
              </div>
              <div class="seo__main-outer">
                <div class="seo__main">
                  <h3 class="seo__results">
                    <span class="seo__keyword"><?php echo $seoDate['keyword'];?></span>
                    <span class="seo__keyword-rank">平均<span class="seo__rank-outer">
                      <span class="seo__rank"><?php echo $seoDate['rank'];?></span>
                      <span class="seo__rank-kurai">位</span></span>
                    </span>
                  </h3>
                  <p class="seo__source"><small><?php echo $seoDate['source'];?></small></p>
              </div>
          </li>
        <?php endforeach;?>
      </ul>
    </section>
    <?php $aboutWindowWidth = [414, 767, 1023, 1365];
      $aboutImgRoot = get_template_directory_uri().'/'.$imgRoot.'/about/';?>
    <section class="about" id="about">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en">About</h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle">私について</p>
      </div>
      <div class="about__content">
        <div class="about__img" id="about__img">
          <?php echo sourceMedia($aboutWindowWidth,$aboutImgRoot.'about__img.jpg','プロフィール画像');?>
        </div>
        <div class="about__info" id="about__info">
          <div class="about__info-inner">
            <div class="about__info-txt">
              <h3 class="txt__ttl">プロフィール</h3>
              <p class="about__txt">2013年福岡デザイン専門学校に入学、2015年から有限会社日向自動車学校IT部に入社。担当は、バナー及びサイト制作（サイト構成、デザイン、コーディング、レスポンシブ対応、構築、解析)。現在ブログメディアサイト「coloring」を個人で運営中。</p>
            </div> 
            <ul class="about__list">
              <?php $abouticonWindowWidth = [1023, 1365];
                $aboutDates = [
                  [
                  'img' => 'about_design.png',
                  'alt' => 'デザイン',
                ],
                [
                  'img' => 'about_coding.png',
                  'alt' => 'コーディング',
                ],
                [
                  'img' => 'about_analytics.png',
                  'alt' => '解析',
                ],
                [
                  'img' => 'about_writing.png',
                  'alt' => 'ライティング',
                ]
                ];
              ?>
              <?php foreach($aboutDates as $aboutDate):?>
                <li class="about__list-item">
                  <div class="about__list-img">
                    <?php echo sourceMedia($abouticonWindowWidth,$aboutImgRoot.$aboutDate['img'],$aboutDate['alt'].'アイコン');?>
                  </div>
                  <p class="about__list-txt"><?php echo $aboutDate['alt'];?></p>
                </li>
              <?php endforeach;?>
            </ul>
            <ul class="about__sns">
              <?php $snss = ['twitter'=>'https://twitter.com/azarashitokkari','teratail'=>'https://teratail.com/users/mumu1354','github'=>'https://github.com/yon-s/'];?>
              <?php foreach($snss as $sns => $link):?>
                <li class="about__sns-list">
                  <a href="<?php echo $link;?>" class="about__sns-link" target="_blank" rel="noopene noopener">
                    <div class="about__sns-icon">
                      <?php $devicePixcels = ['','2x','3x'];?>
                      <img srcset="
                      <?php foreach($devicePixcels as $index => $devicePixcel):?>
                        <?php echo $aboutImgRoot?>about_icon-<?php echo $sns; if($index > 0) echo '@'; echo $devicePixcel;?>.png <?php echo $devicePixcel; if($index < 2) echo ',';?> 
                      <?php endforeach;?>
                      "
                      src="<?php echo $aboutImgRoot.'about_icon-'.$sns;?>.png" alt="<?php echo ucfirst($sns).'アイコン';?>" class="responsive-img">
                    </div>
                    <p class="about__sns-ttl"><?php echo ucfirst($sns);?></p>
                    <div class="about__sns-link-btn"><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                  </a>
                </li>
              <?php endforeach;?>
            </ul>  
          </div>
        </div>
      </div>
    </section>
    <?php 
      $SkillImgRoot = get_template_directory_uri().'/'.$imgRoot.'/skill/';
      $skillDatas = [
        'softPlatform' => [
          'ttl' => 'ソフト・プラットフォーム',
          'list' =>
            [
              [
                'img' => 'vscode.png',
                'name' => 'Visual Studio Code',
                'career' => [['ym' => 4 , 'date' => 'ヶ月']],
                'txt' => 'HTML、CSS、Sass、PHPファイルの作成及び、編集、Gitでの使用'
              ],
              [
                'img' => 'Illustrator.png',
                'name' => 'Illustrator',
                'career' => [['ym' => 7 , 'date' => '年']],
                'txt' => 'バナー及び、サイトのアイコンイラスト制作で使用'
              ],
              [
                'img' => 'photshop.png',
                'name' => 'Photoshoop',
                'career' => [['ym' => 5 , 'date' => '年']],
                'txt' => '画像の加工及び、ローディングアニメーション制作で使用'
              ],
              [
                'img' => 'xd.png',
                'name' => 'XD',
                'career' => [['ym' => 8 , 'date' => 'ヶ月']],
                'txt' => 'サイトカンプ制作で使用'
              ],
              [
                'img' => 'github.png',
                'name' => 'Github',
                'career' => [['ym' => 3 , 'date' => 'ヶ月']],
                'txt' => 'バージョン管理としての使用'
              ],
              [
                'img' => 'wordpress.png',
                'name' => 'WordPress',
                'career' => [['ym' => 3 , 'date' => '年']],
                'txt' => 'オリジナルテーマ作成、動的なサイトを構築'
              ]
            ]
        ],
        'analytics' => [
          'ttl' => '解析・広告ツール',
          'list' =>
            [
              [
                'img' => 'analytics.png',
                'name' => 'Google Analytics',
                'career' => [['ym' => 2 , 'date' => '年']],
                'txt' => 'サイト解析、改善ルーツとして使用'
              ],
              [
                'img' => 'search_console.png',
                'name' => 'Google Search Console',
                'career' => [['ym' => 4 , 'date' => 'ヶ月']],
                'txt' => 'インデックス登録、検索ワード、解析で使用'
              ],
              [
                'img' => 'adSense.png',
                'name' => 'Google AdSense',
                'career' => [['ym' => 10 , 'date' => 'ヶ月']],
                'txt' => '広告ユニットの作成及び設置'
              ],
            ]
        ],
        'library' => [
          'ttl' => '言語・ライブラリー',
          'list' =>
            [
              [
                'img' => 'html_css.png',
                'name' => 'HTML&CSS',
                'career' => [['ym' => 6 , 'date' => '年']],
                'txt' => 'Emmetによるマークアップ及び、スタイリング'
              ],
              [
                'img' => 'scss.png',
                'name' => 'SCSS',
                'career' => [['ym' => 3 , 'date' => 'ヶ月']],
                'txt' => '演算や変数を使用した自作関数制作'
              ],
              [
                'img' => 'php.png',
                'name' => 'php',
                'career' => [['ym' => 8 , 'date' => 'ヶ月']],
                'txt' => 'ループ表示、型や文字変換、取得、データによる表示の切り替え、WordPressのテンプレートファイル制作'
              ],
              [
                'img' => 'javascript.png',
                'name' => 'JavaScript',
                'career' => [['ym' => 1 , 'date' => '年']],
                'txt' => 'ハンバーガーメニューやスライド、スクロールアニメーションで使用'
              ],
            ]
        ]
      ]
    ?>
    <section class="skill" id="skill">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en">Skill</h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle">スキル</p>
      </div>
      <div class="skill__content">
        <?php foreach ($skillDatas as $index => $skillData):?>
          <section class="skill__section">
          <div class="skill__ttl-group--large skill__ttl">
            <h3 class="skill__ttl"><?php echo $skillData['ttl']; ?></h3>
            <span class="skill__ttl-ubder"></span>
          </div>
          <div class="skill__list-outer">
            <ul class="skill__list">
              <?php
              $skillLists = $skillData['list'];
              foreach($skillLists as $skillList):?>
                <li class="skill__list-item">
                  <div class="skill__list-icon">
                    <?php echo sourceMedia([1023],$SkillImgRoot.$skillList['img'],$skillList['name'].'アイコン');?>
                  </div>
                  <p class="skill__name"><?php echo $skillList['name']; ?></p>
                  <p class="skill__career">
                    <?php $careers = $skillList['career'];//年月?>
                    <?php foreach($careers as $career): ?>
                      <span class="skill__career-ym"><?php echo $career['ym']; ?></span><?php echo $career['date']; ?>
                    <?php endforeach;?>
                  </p>
                  <p class="skill__txt"><?php echo $skillList['txt']; ?></p>
                </li>  
              <?php endforeach;?> 
            </ul>
          </div>
        </section>
        <?php endforeach;?>       
        <section class="skill__study">
          <div class="skill__ttl-group--min" id="skill__ttl-study">
            <h3 class="skill__ttl">学習状況</h3>
            <span class="skill__ttl-ubder"></span>
          </div>
          <ul class="skill__study-list">
            <?php $studyLists =[
              [
                'name' => 'UNIXコマンド',
                'dt' => 'ドットインストール',
                'dd' => '自身のサイト制作の作業やプログラミングの勉強で使用中。'
              ],
              [
                'name' => 'Lalavel',
                'dt' => 'ドットインストール',
                'dd' => 'ブログサイト制作を勉強済み'
              ],
              [
                'name' => 'Vue.js',
                'dt' => 'ドットインストール',
                'dd' => 'todoアプリの制作を勉強済み'
              ],
              [
                'name' => 'React',
                'dt' => 'Udemy',
                'dd' => 'todoリストやブログ、PWA作成を勉強済み'
              ],
              [
                'name' => 'Next.js',
                'dt' => 'Udemy',
                'dd' => 'ブログの制作、SSR、SG、ISRを勉強済み'
              ],
              [
                'name' => 'TypeScript',
                'dt' => 'Udemy',
                'dd' => 'Reactの型定義を勉強済み'
              ],
              [
                'name' => 'Ruby on Rails',
                'dt' => 'プロゲートとMENTA',
                'dd' => 'ツイッター型SNSやReactのバックエンドで使用するAPIモードを勉強済み'
              ],
              [
                'name' => 'Vercel',
                'dt' => 'Udemy',
                'dd' => 'Next.jsのデプロイを学習済み。'
              ],
              [
                'name' => 'AWS',
                'dt' => 'MENTA',
                'dd' => 'APIモードのRuby on RailsとReactのデプロイを学習済み(ECS・ECR・CloudFront・S3・RDS・Amplify・ALB・Route 53)'
              ],
              [
                'name' => 'Firebase',
                'dt' => 'Udemy',
                'dd' => 'PWAで作成したReactのtodoリストのバックエンドで学習済み'
              ],
              [
                'name' => 'データベース論理設計',
                'dt' => 'Udemy',
                'dd' => '3層スキーマー,正規化、ER図リレーション、ER図IE表記法、sqlを学習済み'
              ],
              [
                'name' => 'Node.js',
                'dt' => 'プロゲート',
                'dd' => 'ブログアプリの作成を学習済み。データベースMySQL'
              ],
              [
                'name' => 'CI/GitHub Actions',
                'dt' => 'MENTA',
                'dd' => ' JestによるTypeScriptのテスト自動化とブランチ保護を経験済み'
              ],
            ]?>
            <?php foreach($studyLists as $studyList):?>
              <li class="skill__study-list-item">
                <p class="skill__study-name"><?php echo $studyList['name']; ?></p>
                <dl class="skill__study-txt">
                  <dt class="skill__study-dt"><i class="fa-solid fa-square"></i>学習ツール</dt>
                  <dd class="skill__study-dd"><?php echo $studyList['dt']; ?></dd>
                  <dt class="skill__study-dt"><i class="fa-solid fa-square"></i>学習内容</dt>
                  <dd class="skill__study-dd"><?php echo $studyList['dd']; ?></dd>
                </dl>
              </li>
            <?php endforeach;?>
          </ul>  
        </section>    
      </div>  
    </section>
    <section class="contact" id="contact">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en">Contact</h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle">お問い合わせ</p>
      </div>
      <div class="contact__progress-outer" id="contact__progress-outer">
        <div class="contact__progress-list">
          <div class="contact__progress--comp">入力</div>
          <div class="contact__progress--notcomp">確認</div>
          <div class="contact__progress--notcomp">完了</div>
        </div>  
        <div class="contact__progress-line-outer">  
          <div class="contact__progress-line--comp"></div>
          <div class="contact__progress-line--notcomp"></div> 
        </div>
      </div>
        <div class="contact__form-bg" id="contact__form-bg">
          <form action="/top/confirm" method="post" class="contact__form">
            <table class="contact__table">
              <tr class="contact__input-list">
                <th  class="contact__input-ttl">お名前<span class="contact__required">必須</span></th>
                <td class="contact__input-outer">
                  <input type="text" name="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" placeholder="お名前" class="contact__input--txt"/>
                  <?php if(isset($nameError)):?>
                    <span class="contact__error">
                      <?=$nameError;?>
                    </span>
                  <?php endif;?>
                </td>
              </tr>
              <tr class="contact__input-list">
                <th class="contact__input-ttl">メールアドレス<span class="contact__required">必須</span></th> 
                <td class="contact__input-outer"><input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" placeholder="メールアドレス" class="contact__input--txt"/>
                <?php if(isset($emailError)):?>
                <span class="contact__error">
                      <?=$emailError;?>
                </span>         
                <?php endif;?>        
                </td>
              </tr>
              <tr class="contact__input-list">
                <th class="contact__input-ttl">お問い合わせ内容<span class="contact__required">必須</span></th>
                <td class="contact__input-outer">
                  <textarea name="comments" placeholder="お問い合わせ内容" class="contact__input--textarea"><?php if(isset($_POST['comments'])){
                    if(function_exists(('stripslashes'))){
                      echo stripslashes($_POST['comments']);
                    }else{
                      echo $_POST['comments'];
                    }
                  }?></textarea>
                  <?php if(isset($commentError)):?>
                    <span class="contact__error">
                          <?=$commentError;?>
                    </span>         
                  <?php endif;?> 
                </td>
              </tr>
            </table>
            <div class="contact__agree">
            <input type="checkbox" name="agree_privacy" class="contact__agree-checkbox" id="agree" value="プライバシーポリシーに同意する" autocomplete="off" required="required" />
            <label for="agree" class="contact__agree-label"> <span class="content__link" id="privacy-open" aria-controls="privacy" aria-expanded="false">プライバシーポリシー</span>に同意する</label>
            <?php if(isset($agreeError)):?>
              <span class="contact__error">
                    <?=$agreeError;?>
              </span>         
            <?php endif;?>
            </div>
            <div class="content__button-outer--center">
              <input type="hidden" name="submitted" value="true" />
                <button class="content__button-submit--min" id="submit" type="submit">
                  確認画面へ
                  <span class="btn__icon--right"><svg xmlns="http://www.w3.org/2000/svg" width="30.772" height="9.77" viewBox="0 0 30.772 9.77" class="responsive-img"><path id="click" data-name="click" d="M1937,7567.163l9.646,8h-28" transform="translate(-1918.646 -7566.394)" fill="none" stroke="#4977b1" stroke-width="2"/></svg></span>
                </button>
            </div>
          </form>
        </div>
    </section>
</div>
<article class="privacy" id="privacy" aria-hidden="true">
  <div class="privacy__inner">
    <div class="privacy__close-outer">
      <button type="button" id="privacy__close" class="privacy__close-inner" aria-controls="privacy" aria-expanded="false">
        <span class="privacy__close-line">
          <span class="privacy__close-u-visuallyHidden">
            プライバシーポリシーを開閉する
          </span>
        </span>
      <span class="privacy__close-txt">close</span>
      </button>
    </div>
    <div class="privacy__content-group">
      <div class="ttl-group">
        <h2 class="ttl-group__txt-en">Privacy Policy</h2>
        <p class="ttl-group__txt-ja--min" role="doc-subtitle">プライバシーポリシー</p>
      </div>
      <div class="privacy__content">
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">基本方針</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">当サイトは、個人情報の重要性を認識し、個人情報を保護することが社会的責務であると考え、個人情報に関する法令を遵守し、当サイトで取扱う個人情報の取得、利用、管理を適正に行います。</p>
          </div>    
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">適用範囲</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">本プライバシーポリシーは、お客様の個人情報もしくはそれに準ずる情報を取り扱う際に、当サイトが遵守する方針を示したものです。</p>
          </div>    
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">個人情報の利用目的</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">当サイトは、ユーザーからご提供いただく情報をサイトの改善、ユーザーからのお問い合わせ等に対応するために利用します。</p>  
          </div>
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">個人情報の第三者への<br class="br__tab-minw">開示</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">当サイトは、以下を含む正当な理由がある場合を除き、個人情報を第三者に提供することはありません。</p>
            <ul class="privacy__list">
              <li class="privacy__list-item">本人のご了解がある場合</li>
              <li class="privacy__list-item">法令等への協力のため、開示が必要となる場合</li>
              <li class="privacy__list-item">人の生命・身体・財産の保護に必要な場合</li>
              <li class="privacy__list-item">公衆衛生・児童の健全育成に必要な場合</li>
              <li class="privacy__list-item">法令に基づく場合</li>
            </ul>    
          </div>
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">Cookie（クッキー）</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">Cookie（クッキー）は、利用者のサイト閲覧履歴を、利用者のコンピュータに保存しておく仕組みです。</p>
            <p class="privacy__txt">利用者はCookie（クッキー）を無効にすることで収集を拒否することができますので、お使いのブラウザの設定をご確認ください。ただし、Cookie（クッキー）を拒否した場合、当サイトのいくつかのサービス・機能が正しく動作しない場合があります。</p>
          </div>
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">アクセス解析<br class="br__tab-minw" />ツールについて</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">当サイトでは、Googleによるアクセス解析ツール「Googleアナリティクス」を利用しています。</p>
            <p class="privacy__txt">このGoogleアナリティクスはトラフィックデータの収集のためにCookieを使用しています。このトラフィックデータは匿名で収集されており、個人を特定するものではありません。この機能はCookieを無効にすることで収集を拒否することが出来ますので、お使いのブラウザの設定をご確認ください。この規約に関して、詳しくは<a class="content__link" href="https://www.google.com/analytics/terms/jp.html" target="_blank" rel="noopene noopener">ここをクリック</a>してください。</p>
          </div>
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">免責事項</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">当サイトからリンクやバナーなどによって他のサイトに移動された場合、移動先サイトで提供される情報、サービス等について一切の責任を負いません。</p>
            <p class="privacy__txt">当サイトのコンテンツ・情報につきまして、可能な限り正確な情報を掲載するよう努めておりますが、誤情報が入り込んだり、情報が古くなっていることもございます。</p>
            <p class="privacy__txt">当サイトに掲載された内容によって生じた損害等の一切の責任を負いかねますのでご了承ください。</p>
          </div>
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">著作権・肖像権</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">当サイトで掲載しているすべてのコンテンツ（文章、画像、動画、音声、ファイル等）の著作権・肖像権等は当サイト所有者または各権利所有者が保有し、許可なく無断利用（転載、複製、譲渡、二次利用等）することを禁止します。また、コンテンツの内容を変形・変更・加筆修正することも一切認めておりません。</p>
            <p class="privacy__txt">各権利所有者におかれましては、万一掲載内容に問題がございましたら、ご本人様よりお問い合わせください。迅速に対応いたします。</p>
          </div>
        </section>
        <section class="privacy__section">
          <div class="privacy__ttl-group">
            <h3 class="privacy__ttl">プライバシーポリシーの<br />変更について</h3>
            <span class="privacy__ttl-ubder"></span>
          </div>
          <div class="privacy__txt-content">
            <p class="privacy__txt">サイトは、個人情報に関して適用される日本の法令を遵守するとともに、本ポリシーの内容を適宜見直しその改善に努めます。</p>
            <p class="privacy__txt">修正された最新のプライバシーポリシーは常に本ページにて開示されます。</p>
            <p class="privacy__txt">本プライバシーポリシーの変更は、当サイトに掲載された時点で有効になるものとします。</p>
          </div>
        </section>
      </div>
    </div>
  </div>
</article>  
<?php get_footer(); ?>
