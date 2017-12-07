<?php get_header(); ?>


<div id="bnrthumb-list">
      <?php $args = array(
          'post_type' => 'brands'    //投稿タイプの指定
      );
      if( $posts ) : foreach( $posts as $post) : setup_postdata( $post ); ?>

      <div class="grid-item">
        <a class="thumb_img" href="<?php echo get_the_permalink(); ?>">
          <?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
          <?php the_post_thumbnail(); ?>
          <?php else: // サムネイルを持っていないときの処理 ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" />
          <?php endif; ?>
        </a>
        <div class="body">
    			<p class="thumbnail"><?php echo get_avatar(get_the_author_id() , 40); ?></p>
    			<div class="info">
    				<p class="author ft-bold"><?php echo get_the_author_meta( 'nickname' ); ?> </p>
    				<p class="reactions">
    					<span class="comments"><i class="fa fa-commenting" aria-hidden="true"></i>0</span>
    					<span class="likes"><i class="fa fa-heart" aria-hidden="true"></i>0</span>
    				</p>
    			</div>
    		</div>
      </div>
      <?php endforeach; ?>
      <?php else : //記事が無い場合 ?>
        <div id="no-result">
          <div class="in">
            <img class="illust" src="<?php echo get_template_directory_uri() ?>/assets/images/ghost.svg" alt="">
            <p class="tit"><span class="fa fa-search" aria-hidden="true"></span>No Results</p>
            <p class="word">検索ワード：<?php echo get_search_query(); ?></p>
            <a class="baseBtn" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップに戻る</a>
          </div>
        </div>
      <?php endif;
      wp_reset_postdata(); //クエリのリセット ?>
</div>

  <?php get_sidebar(); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
