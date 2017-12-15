<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<title>Scraper-BannerArchive</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/font-awesome-4.7.0/font-awesome.css">
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/velocity.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/iscroll.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/imagesloaded.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/common.js"></script>

<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

  <div id="contents-slide-wrap">

    <header id="header">
      <div class="inner-l">
        <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri() ?>/assets/images/bdg-logo.svg" alt=""></a></h1>
        <p class="archive-toggle-menu">Archives</a>
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
              <p><a href="<?php echo esc_url( home_url( '/wp-login.php' ) ); ?>">Login</p>
          <?php endif;?>
        </div>
      </div>
      <div class="archive-toggle-menu-wrap">
        <p class="title ft-bold">Authors</p>
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
    </header>
    <!-- header  -->
