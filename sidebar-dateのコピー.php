<div id="sidenav-wrapper">
  <nav id="category-nav">
    <div class="scroller">
      <p>20分バナーアーカイブ</p>
      <?php
        $year_prev = null;
        $months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,
                                            YEAR( post_date ) AS year,
                                            COUNT( id ) as post_count FROM $wpdb->posts
                                            WHERE post_status = 'publish' and post_date <= now( )
                                            and post_type = 'post'
                                            GROUP BY month , year
                                            ORDER BY post_date DESC");
        foreach($months as $month) :
        $year_current = $month->year;
        if ($year_current != $year_prev){
        if ($year_prev != null){?>
            </ul></div>
        <?php } ?>
        <div><h4><a href="<?php bloginfo('url') ?>/twentyminutesbnr/<?php echo $month->year; ?>">
          <?php echo $month->year ?>年
          (<?php echo $month->post_count; ?>)
        </a></h4>
        <ul>
            <?php } ?>
            <li>
                <a href="<?php bloginfo('url') ?>/twentyminutesbnr/<?php echo $month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month+1, 1, $month->year)) ?>">
                  <?php echo date("n", mktime(0, 0, 0, $month->month+1, 1, $month->year)) ?>月
                  (<?php echo $month->post_count; ?>)
                </a>
            </li>
            <?php $year_prev = $year_current;
            endforeach; ?>
        </ul></div>
    </div>
    <div id="sp-ico-menu">
      <div class="inner"><span></span><span></span></div>
    </div>
  </nav>
  <!-- /category-nav -->

</div>
