<?php get_header(); ?>

    <div id="twentyminutesbnr-archvie">

      <?php
      if (is_year()) {
          echo $html .= '<h2 class="year-ttl">'.get_the_date('Y').'</h2>';
      } elseif (is_month()) {
          echo $html .= '<h2 class="year-ttl">'.get_the_date('Y.n').'</h2>';
      }
      ?>
      <div id="bnrthumb-list" class="twentyminutesbnr">
      <?php
      $args = array(
        'post_type' => 'twentyminutesbnr' //投稿タイプ名
      );
      $customPosts = query_posts($args);

      if($customPosts) : foreach($customPosts as $key => $post) : setup_postdata( $post ); ?>

      <?php
      $terms = get_the_terms($post->ID, 'bnr_theme');
      foreach($terms as $term) {
        $link = get_term_link($term->slug, $term->taxonomy);
        $str_grep = preg_replace('/(\/twentyminutesbnr)/', '', $link);
      }
      ?>

      <?php if (get_field('author') === "questions"): ?>
        <div class="grid-item">

          <a class="thumb_img" href="<?php echo $str_grep ?>">
            <div class="gradient"></div>
            <div class="meta">
              <?php $terms = get_terms( 'bnr_theme', 'hide_empty=0' ); ?>

              <p class="title"><?php echo get_the_title() ?></p>

              <p class ="date"><?php echo get_the_date(); ?></p>
            </div>
            <?php if ( $image = get_field('winner-img') ): // サムネイルを持っているときの処理 ?>
            <img src="<?php echo $image ?>" alt="" title="" />
            <?php else: // サムネイルを持っていないときの処理 ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/no-image.jpg" alt="no image" title="no image" />
            <?php endif; ?>
          </a>
          <div class="body">
      			<p class="thumbnail"><?php echo get_avatar(get_the_author_id() , 40); ?></p>
      			<div class="info">
      				<p class="author ft-bold"><?php echo get_the_author_meta( 'nickname' ); ?></p>
      				<p class="reactions">
      					<!-- <span class="comments"><i class="fa fa-commenting" aria-hidden="true"></i>0</span> -->
      					<!-- <span class="likes"><i class="fa fa-heart" aria-hidden="true"></i>0</span> -->
      				</p>
      			</div>
      		</div>
        </div>
      <?php endif ?>
      <?php endforeach; ?>
      <?php endif; wp_reset_postdata(); //クエリのリセット ?>
      </div>

    </div>
      <!-- /twentyminutesbnr-archvie -->

    <?php require_once locate_template('sidebar-date.php', true); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
