<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<title>Scraper-BannerArchive</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/font-awesome-4.7.0/font-awesome.css">
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/libs.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/script.min.js"></script>


<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

  <div id="contents-slide-wrap">

    <header id="header">
      <div class="inner-l">
        <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri() ?>/assets/images/bdg-logo.svg" alt=""></a></h1>
        <p class="archive-toggle-menu">Archives</p>
        <div id="ico-menu">
          <div class="inner">
            <span></span>
            <span></span>
          </div>
        </div>
      </div>
      <div class="inner-r">
        <div class="search-input">
          <form method="get" id="brandsSearch" action="<?php echo home_url('/'); ?>">
            <input class="search_all" type="text" name="s" id="brandsSearch" value="<?php the_search_query(); ?>" placeholder="検索したいキーワードを入力してください" />
            <input type="hidden" name="post_type" value="brands">
          </form>
        </div>
        <div class="login">
          <?php if (is_user_logged_in()) : ?>
            <a href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>"><?php $user = wp_get_current_user(); echo get_avatar($user -> ID , 30) ?><span class="balloon">Dashboard</span></a>
          <?php else :?>
              <p><a href="<?php echo esc_url( home_url( '/wp-login.php' ) ); ?>">Login</a></p>
          <?php endif;?>
        </div>
      </div>

      <div class="archive-toggle-menu-wrap">
        <div class="in_wrap">
        <p class="archive_ttl">20分バナーアーカイブ</p>
        <?php // 年別アーカイブリストを表示
        $year=NULL; // 年の初期化
        $month=NULL;
        $args = array( // クエリの作成
        'post_type' => 'twentyminutesbnr', // 投稿タイプの指定
        'orderby' => 'date', // 日付順で表示
        'posts_per_page' => -1 // すべての投稿を表示
        );
        $the_query = new WP_Query($args); if($the_query->have_posts()){ // 投稿があれば表示
        echo '<ul class="year">';
        while ($the_query->have_posts()): $the_query->the_post(); // ループの開始
        if ($year != get_the_date('Y')){ // 同じ年でなければ表示
          $year = get_the_date('Y'); // 年の取得
          $month = get_the_date('n');
        echo '<li><a href="'.home_url( '/', 'http' ).'twentyminutesbnr/'.$year.'">'.$year.'年</a></li>'; // 年別アーカイブリストの表示
        }
        endwhile; // ループの終了
        echo '</ul>';
        wp_reset_postdata(); // クエリのリセット
        }
        ?>
        </div>
        <div class="in_wrap">
        <p class="archive_ttl">Authors</p>
        <ul class="author-profile">
          <?php $users = get_users( array('orderby'=>ID,'order'=>ASC) );?>
          <?php foreach ($users as $user) : ?>
            <?php if($user->ID != "1") :?>
              <li>
                <a href="<?php echo get_bloginfo("url") . "/author/" . $user->user_nicename ?>"><?php echo get_avatar( $user->ID ); ?></a>
                <span class="balloon"><?php echo $user->display_name ?></span>
              </li>
            <?php endif;?>
          <?php endforeach; ?>
        </ul>
      </div>
      </div>
    </header>
    <!-- header  -->
