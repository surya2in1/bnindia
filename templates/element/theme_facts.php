<?php
use Cake\Routing\Router;
?>
<section id="facts" class="facts-area dark-bg">
  <div class="container">
    <div class="facts-wrapper">
        <div class="row">
          <div class="col-md-3 col-sm-6 ts-facts">
              <div class="ts-facts-img">
                <img loading="lazy" src="theme/images/icon-image/groups.png" alt="facts-img" width="50" height="50">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count=<?= $total_groups; ?>><?= $total_groups; ?></span></h2>
                <h3 class="ts-facts-title">Total Groups</h3>
              </div>
          </div><!-- Col end -->

          <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-sm-0">
              <div class="ts-facts-img">
                <img loading="lazy" src="theme/images/icon-image/members.png" alt="facts-img" width="50" height="50">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count=<?= $total_members; ?>><?= $total_members; ?></span></h2>
                <h3 class="ts-facts-title">Total Members</h3>
              </div>
          </div><!-- Col end -->

          <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-md-0">
              <div class="ts-facts-img">
                <img loading="lazy" src="theme/images/icon-image/auctions.png" alt="facts-img" width="50" height="50">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count=<?= $total_auctions; ?>><?= $total_auctions; ?></span></h2>
                <h3 class="ts-facts-title">Total Auctions</h3>
              </div>
          </div><!-- Col end -->

          <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-md-0">
              <div class="ts-facts-img">
                <img loading="lazy" src="theme/images/icon-image/payments.png" alt="facts-img" width="80" height="50">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count=<?= $total_payments; ?>><?= $total_payments; ?></span></h2>
                <h3 class="ts-facts-title">Total Payments</h3>
              </div>
          </div><!-- Col end -->

        </div> <!-- Facts end -->
    </div>
    <!--/ Content row end -->
  </div>
  <!--/ Container end -->
</section><!-- Facts end -->
