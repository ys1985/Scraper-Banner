<div id="sidenav-wrapper">
  <nav id="category-nav">
    <div class="scroller">
      <p>20分バナーアーカイブ</p>
      <?php // 年別アーカイブリストを表示
      $year=NULL; // 年の初期化
      $month=NULL;
      $args = array( // クエリの作成
      'post_type' => 'twentyminutesbnr', // 投稿タイプの指定
      'orderby' => 'date', // 日付順で表示
      'posts_per_page' => -1 // すべての投稿を表示
      );
      $the_query = new WP_Query($args); if($the_query->have_posts()){ // 投稿があれば表示
      echo '<ul class="year-list">';
      while ($the_query->have_posts()): $the_query->the_post(); // ループの開始
      if ($year != get_the_date('Y')){ // 同じ年でなければ表示
        $year = get_the_date('Y'); // 年の取得
        $month = get_the_date('n');
        $day = get_the_date('j');
        echo '<li><a href="'.home_url( '/', 'http' ).'twentyminutesbnr/'.$year.'">'.$year.'年</a></li>'; // 年別アーカイブリストの表示
        echo '<li><a href="'.home_url( '/', 'http' ).'twentyminutesbnr/'.$year.'/'.$month.'/'.$day.'">'.$year.'年'.$month.'月'.$day.'日</a></li>'; // 年別アーカイブリストの表示
      }
      endwhile; // ループの終了
      echo '</ul>';
      wp_reset_postdata(); // クエリのリセット
      }
      ?>
    </div>
    <div id="sp-ico-menu">
      <div class="inner"><span></span><span></span></div>
    </div>
  </nav>
  <!-- /category-nav -->

</div>
