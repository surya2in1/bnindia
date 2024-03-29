<?php use Cake\Routing\Router;
use Cake\Core\Configure;
 ?>
<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                        <div class="kt-aside__brand-logo">
                            <a href="<?php echo Router::url('/dashboard', true); ?>">
                                <!-- <img alt="Logo" src="<?php echo Router::url('/', true); ?>assets/media/logos/logo-light.png" /> -->
                                
                                <!--<img alt="Logo" src="<?php echo Router::url('/', true); ?>assets/media/logos/bn2.png" />-->
                               <!--  <img alt="Logo" src="http://staging.bnindia.co.in/css/logos/logo11.png" style="
                                    width: 101px;
                                    height: 63px;
                                "> -->
                                 <img alt="Logo" src="<?php echo Router::url('/', true); ?>/css/logos/logo11.png" style="
                                    width: 101px;
                                    height: 63px;
                                ">
                            </a>
                        </div>
                        <div class="kt-aside__brand-tools">
                            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
                                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
                                            <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
                                        </g>
                                    </svg></span>
                                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero" />
                                            <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) " />
                                        </g>
                                    </svg></span>
                            </button>
                        </div>
                </div>

                <!-- begin:: Aside Menu -->
                <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
                        <ul class="kt-menu__nav ">
                            <li class="kt-menu__item  <?php if($this->request->getParam('controller') == 'Dashboard') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                <a href="<?php echo Router::url('/dashboard', true); ?>" class="kt-menu__link ">
                                    <span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                                    <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg></span><span class="kt-menu__link-text">Dashboard</span></a></li>
                                <li class="kt-menu__section ">
                                    <h4 class="kt-menu__section-text">Modules</h4>
                                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                                </li>
                                <?php if($list_of_all_users_side_menu == '1111'){?>  
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'AllUsers') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                        </span><span class="kt-menu__link-text">AllUsers</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'AllUsers' && $this->request->getParam('action') == 'createadminform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Create Admin</span>',
                                                    array('controller'=>'AllUsers','action'=>'createadminform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li> 
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'AllUsers' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Users</span>',
                                                    array('controller'=>'AllUsers','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <?php } ?>
                                <?php if($groups_side_menu == '1111'){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'Groups') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                        </span><span class="kt-menu__link-text">Groups</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Groups' && $this->request->getParam('action') == 'groupform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Create Group</span>',
                                                    array('controller'=>'Groups','action'=>'groupform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Groups' && $this->request->getParam('action') == 'addGroupMembers') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add member in group</span>',
                                                    array('controller'=>'Groups','action'=>'addGroupMembers'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Groups' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Groups</span>',
                                                    array('controller'=>'Groups','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>

                                <!-- Add agetns start---> 
                                <?php if($agent_side_menu == '1111'){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'Users') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                        </span><span class="kt-menu__link-text">Agents</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Agents' && $this->request->getParam('action') == 'agentform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Agent</span>',
                                                    array('controller'=>'Agents','action'=>'agentform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>

                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Agents' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Agents</span>',
                                                    array('controller'=>'Agents','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                <?php }?>

                                <!-- add agent end-->
                                <?php if(in_array($member_side_menu, Configure::read('role_all_access'))){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'Users') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                        </span><span class="kt-menu__link-text">Members</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <?php if(in_array($member_side_menu, Configure::read('role_create_access'))){?>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'memberform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Member</span>',
                                                    array('controller'=>'Users','action'=>'memberform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <?php }?>
                                            <?php if(in_array($member_side_menu, Configure::read('role_admin_access'))){?>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'transferMembers') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Transfer Members</span>',
                                                    array('controller'=>'Users','action'=>'transferMembers'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <?php }?>
                                            <?php if(in_array($member_side_menu, Configure::read('role_admin_access'))){?>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'members') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Members</span>',
                                                    array('controller'=>'Users','action'=>'members'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                                
                                <!-- Add Branch head start---> 
                                <?php if($branch_head_side_menu == '1111'){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'BranchHeads') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                        </span><span class="kt-menu__link-text">Branch Heads</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'BranchHeads' && $this->request->getParam('action') == 'branchheadform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Branch Head</span>',
                                                    array('controller'=>'BranchHeads','action'=>'branchheadform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>

                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'BranchHeads' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Branch Heads</span>',
                                                    array('controller'=>'BranchHeads','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                                <!-- add Branch head end-->

                                <!-- Add assistent head start---> 
                                <?php if($assistent_head_side_menu == '1111'){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'AssistentHeads') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                        </span><span class="kt-menu__link-text">Assistent Heads</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'AssistentHeads' && $this->request->getParam('action') == 'assistentheadform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Assistent</span>',
                                                    array('controller'=>'AssistentHeads','action'=>'assistentheadform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>

                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'AssistentHeads' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Assistent Heads</span>',
                                                    array('controller'=>'AssistentHeads','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                                <!-- add assistent head end-->

                                <!-- Add cashier head start---> 
                                <?php if($cashier_side_menu == '1111'){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'Cashiers') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                        </span><span class="kt-menu__link-text">Cashiers</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Cashiers' && $this->request->getParam('action') == 'cashierform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Cashier</span>',
                                                    array('controller'=>'Cashiers','action'=>'cashierform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>

                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Cashiers' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Cashiers</span>',
                                                    array('controller'=>'Cashiers','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                                <!-- add cashier head end-->

                                <?php if($auctions_side_menu == '1111'){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'Auctions') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"> -->
                                            <i class="fa fa-gavel" aria-hidden="true"></i>

                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                        </span><span class="kt-menu__link-text">Auctions</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Auctions' && $this->request->getParam('action') == 'auctionform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Auction</span>',
                                                    array('controller'=>'Auctions','action'=>'auctionform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Auctions' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List Auctions</span>',
                                                    array('controller'=>'Auctions','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                                <?php if(in_array($payments_side_menu, Configure::read('role_all_access'))){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'Payments'  || $this->request->getParam('controller') == 'PaymentVouchers'  || $this->request->getParam('controller') == 'OtherPayments') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon"> 
                                            <i class="fas fa-receipt" aria-hidden="true"></i>

                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                        </span><span class="kt-menu__link-text">Payments</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <?php if(in_array($payments_side_menu, Configure::read('role_create_access'))){?>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Payments' && $this->request->getParam('action') == 'paymentform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Receipt</span>',
                                                    array('controller'=>'Payments','action'=>'paymentform'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <?php } ?>
                                            
                                            <?php if(in_array($payments_side_menu, Configure::read('role_admin_access'))){?>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Payments' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List of Receipts</span>',
                                                    array('controller'=>'Payments','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                             <?php } ?>
                                            <!--<li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Payments' && $this->request->getParam('action') == 'paymentvoucher') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">-->
                                                <?php 
                                                // echo  $this->Html->link(
                                                //      '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                //         <span></span>
                                                //     </i>
                                                //     <span class="kt-menu__link-text">Add Payment</span>',
                                                //     array('controller'=>'Payments','action'=>'paymentvoucher'),
                                                //     ['class' => 'kt-menu__link','escape'=>false]
                                                // ); 
                                                ?>
                                            <!--</li>-->
                                            
                                            
                                            <!----------------------------------------------------------------------------------------->
                                            <?php if(in_array($payments_side_menu, Configure::read('role_admin_access'))){?>
                                            <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'PaymentVouchers' || $this->request->getParam('controller') == 'OtherPayments') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Add Payment</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                                                </a>
                                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                    <ul class="kt-menu__subnav kt-menu__item--active">
                                                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                                        <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'PaymentVouchers' && $this->request->getParam('action') == 'paymentvoucherform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                            <?php echo  $this->Html->link(
                                                                 '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="kt-menu__link-text">Subscriber Payment</span>',
                                                                array('controller'=>'PaymentVouchers','action'=>'paymentvoucherform'),
                                                                ['class' => 'kt-menu__link','escape'=>false]
                                                            ); ?>
                                                        </li>
                                                        
                                                        <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'OtherPayments' && $this->request->getParam('action') == 'otherpaymentform') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                            <?php echo  $this->Html->link(
                                                                 '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                    <span></span>
                                                                </i>
                                                                <span class="kt-menu__link-text">Other Payment</span>',
                                                                array('controller'=>'OtherPayments','action'=>'otherpaymentform'),
                                                                ['class' => 'kt-menu__link','escape'=>false]
                                                            ); ?>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </li>
                                            <?php } ?>
                                            <!------------------------------------------------------------------------------------------>
                                            <?php if(in_array($payments_side_menu, Configure::read('role_admin_access'))){?>

                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'PaymentVouchers' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List of Payments</span>',
                                                    array('controller'=>'PaymentVouchers','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <?php } ?>

                                            <?php if(in_array($payments_side_menu, Configure::read('role_admin_access'))){?>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'OtherPayments' && $this->request->getParam('action') == 'index') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">List of Other Payments</span>',
                                                    array('controller'=>'OtherPayments','action'=>'index'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>

                                <?php if($reports_side_menu == '1111'){?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php if($this->request->getParam('controller') == 'Reports') { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon"> 
                                            <i class="flaticon2-files-and-folders" aria-hidden="true"></i>

                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                        </span><span class="kt-menu__link-text">Reports</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'receiptStatement') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Receipt Statement</span>',
                                                    array('controller'=>'Reports','action'=>'receiptStatement'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li> 
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'instalmentDetails') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Instalment Details</span>',
                                                    array('controller'=>'Reports','action'=>'instalmentDetails'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'subscribersDetails') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Subscribers Details</span>',
                                                    array('controller'=>'Reports','action'=>'subscribersDetails'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'auctionsDetails') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Auction Report</span>',
                                                    array('controller'=>'Reports','action'=>'auctionsDetails'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'groupsDetails') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                <?php echo  $this->Html->link(
                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="kt-menu__link-text">Group List</span>',
                                                    array('controller'=>'Reports','action'=>'groupsDetails'),
                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                ); ?>
                                            </li>
                                            <?php if($current_role != Configure::read('ROLE_MEMBER') && $current_role != Configure::read('ROLE_AGENT')){  ?>
                                                <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'vacuntMembersDetailsPdf') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                    <?php echo  $this->Html->link(
                                                         '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Vacant Member Report</span>',
                                                        array('controller'=>'Reports','action'=>'vacuntMembersDetailsPdf'),
                                                        ['class' => 'kt-menu__link','escape'=>false]
                                                    ); ?>
                                                </li>

                                                <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'formanCommissionDetails') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                    <?php echo  $this->Html->link(
                                                         '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Forman Commission/GST Received Report</span>',
                                                        array('controller'=>'Reports','action'=>'formanCommissionDetails'),
                                                        ['class' => 'kt-menu__link','escape'=>false]
                                                    ); ?>
                                                </li>
                                                <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'prizedPaymentSubscriberDetails') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                    <?php echo  $this->Html->link(
                                                         '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Prized Payment Subscriber Report</span>',
                                                        array('controller'=>'Reports','action'=>'prizedPaymentSubscriberDetails'),
                                                        ['class' => 'kt-menu__link','escape'=>false]
                                                    ); ?>
                                                </li>
                                                <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'transferedSubscriberDetails') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                    <?php echo  $this->Html->link(
                                                         '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Transfered Subscriber List</span>',
                                                        array('controller'=>'Reports','action'=>'transferedSubscriberDetails'),
                                                        ['class' => 'kt-menu__link','escape'=>false]
                                                    ); ?>
                                                </li>

                                                <!-- goverment report start -->
                                                <li class="kt-menu__item  kt-menu__item--submenu <?php if(($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'subscribersLists') || ($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'dayBook')) { ?> kt-menu__item--open<?php } ?>" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Goverment Reports</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                                                    </a>
                                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                        <ul class="kt-menu__subnav kt-menu__item--active">
                                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Skins</span></span></li>
                                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'subscribersLists') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                                <?php echo  $this->Html->link(
                                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="kt-menu__link-text">Register Of Subscriber</span>',
                                                                    array('controller'=>'Reports','action'=>'subscribersLists'),
                                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                                ); ?>
                                                            </li>

                                                            
                                                            <li class="kt-menu__item <?php if($this->request->getParam('controller') == 'Reports' && $this->request->getParam('action') == 'dayBook') { ?> kt-menu__item--active<?php } ?>" aria-haspopup="true">
                                                                <?php echo  $this->Html->link(
                                                                     '<i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="kt-menu__link-text">Day Book</span>',
                                                                    array('controller'=>'Reports','action'=>'dayBook'),
                                                                    ['class' => 'kt-menu__link','escape'=>false]
                                                                ); ?>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </li>
                                           <?php } ?>
                                            <!-- goverment report end --> 

                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                        </ul><!--kt-menu__nav ul close-->
                    </div><!--kt_aside_menu close-->
                </div><!--kt_aside_menu_wrapper close-->