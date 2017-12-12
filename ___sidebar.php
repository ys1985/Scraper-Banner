<div id="sidenav-wrapper">
  <nav id="category-nav">
    <div class="scroller">
      <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a></h1>
      <?php
        search_form_sidenav();
      ?>

      <?php $users = get_users( array('orderby'=>ID,'order'=>ASC) ); ?>
      <div class="authors">
      <?php foreach($users as $user) {
      $uid = $user->ID; ?>

      <form method="post" id="searchform" name="form1" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="hidden" name="author" value="<?php echo $uid ?>">
        <div class="author-profile">
        	<span class="author-thumbanil"><?php echo get_avatar( $uid ,40 ); ?></span>
          <span class="author-link"><a href="javascript:form1[<?php echo $uid -1 ?>].submit()"><?php echo $user->display_name ; ?></a></span>
        </div>
      </form>
      <?php } ?>
    </form>
    </div>
    <div id="sp-ico-menu">
      <div class="inner"><span></span><span></span></div>
    </div>
  </nav>
  <!-- /category-nav -->

</div>
