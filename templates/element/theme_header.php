<?php
use Cake\Routing\Router;
?>
<!-- Header start -->
<header id="header" class="header-one">
  <div class="bg-white">
    <div class="container">
      <div class="logo-area">
          <div class="row align-items-center">
            <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                <a class="d-block" href="<?php echo Router::url('/', true); ?>">
                  <!-- <img loading="lazy" src="theme/images/logo.png" alt="Constra"> -->
                   <img loading="lazy" src="css/logos/logo11.png" alt="BNIndia" style="width: 116px;
    height: 100px;">
                </a>
            </div><!-- logo end -->
  
            <div class="col-lg-9 header-right">
                <ul class="top-info-box">
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">Call Us</p>
                          <p class="info-box-subtitle"><a href="tel:(+9) 847-291-4353">(+9) 847-291-4353</a></p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">Email Us</p>
                          <p class="info-box-subtitle"><a href="mailto:info@bbcf.in">info@bbcf.in</a></p>
                      </div>
                    </div>
                  </li>
                  <li class="last">
                    <div class="info-box last">
                      <div class="info-box-content">
                          <p class="info-box-title">Global Certificate</p>
                          <p class="info-box-subtitle">ISO 9001:2008</p>
                      </div>
                    </div>
                  </li>
                  <li class="header-get-a-quote">
                    <a class="btn btn-primary" href="<?php echo Router::url('/contact', true); ?>">Get A Quote</a>
                  </li>
                </ul><!-- Ul end -->
            </div><!-- header right end -->
          </div><!-- logo area end -->
  
      </div><!-- Row end -->
    </div><!-- Container end -->
  </div>

  <div class="site-navigation">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
              <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div id="navbar-collapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav mr-auto">
                      <!-- <li class="nav-item dropdown active">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Home <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li class="active"><a href="index.html">Home One</a></li>
                            <li><a href="index-2.html">Home Two</a></li>
                          </ul>
                      </li> -->

                      <li class="nav-item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'index') { ?> active <?php } ?>"><a class="nav-link" href="<?php echo Router::url('/', true); ?>">Home</a></li>

                      <li class="nav-item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'aboutus') { ?> active <?php } ?>"><a class="nav-link" href="<?php echo Router::url('/about-us', true); ?>">About Us</a></li>
              
                      <li class="nav-item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'chitfund') { ?> active <?php } ?>"><a class="nav-link" href="<?php echo Router::url('/chitfund', true); ?>">Chit Act</a></li>

                      <li class="nav-item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'services') { ?> active <?php } ?>"><a class="nav-link" href="<?php echo Router::url('/services', true); ?>">Services</a></li>

                      <!-- <li class="nav-item"><a class="nav-link" href="<?php echo Router::url('/agent', true); ?>">Agent</a></li>

                      <li class="nav-item"><a class="nav-link" href="<?php echo Router::url('/general-information', true); ?>">General Info</a></li>

                      <li class="nav-item"><a class="nav-link" href="<?php echo Router::url('/branches', true); ?>">Branches</a></li>

                      <li class="nav-item"><a class="nav-link" href="<?php echo Router::url('/chitgroup', true); ?>">Chit Group</a></li> -->
              
                      <li class="nav-item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'contact') { ?> active <?php } ?>"><a class="nav-link" href="<?php echo Router::url('/contact', true); ?>">Contact</a></li>
                    </ul>
                </div>
              </nav>
          </div>
          <!--/ Col end -->
        </div>
        <!--/ Row end -->

    </div>
    <!--/ Container end -->

  </div>
  <!--/ Navigation end -->
</header>
<!--/ Header end -->