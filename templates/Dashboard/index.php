<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Dashboard</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="flaticon2-search-1"></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
            <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Activity
                        </h3>
                    </div>
                    <!-- <div class="kt-portlet__head-toolbar">
                        <a href="#" class="btn btn-label-light btn-sm btn-bold dropdown-toggle" data-toggle="dropdown">Export</a>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
                            <ul class="kt-nav">
                                <li class="kt-nav__section kt-nav__section--first">
                                    <span class="kt-nav__section-text">Finance</span>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-graph-1"></i>
                                        <span class="kt-nav__link-text">Statistics</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-calendar-4"></i>
                                        <span class="kt-nav__link-text">Events</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-layers-1"></i>
                                        <span class="kt-nav__link-text">Reports</span>
                                    </a>
                                </li>
                                <li class="kt-nav__section">
                                    <span class="kt-nav__section-text">Customers</span>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-calendar-4"></i>
                                        <span class="kt-nav__link-text">Notifications</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-file-1"></i>
                                        <span class="kt-nav__link-text">Files</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-widget17">
                        <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #fd397a">
                            <div class="kt-widget17__chart" style="height:320px;">
                                <canvas id="kt_chart_activities"></canvas>
                            </div>
                        </div>
                        <div class="kt-widget17__stats">
                            <div class="kt-widget17__items">
                                <div class="kt-widget17__item">
                                    <span class="kt-widget17__icon">
                                        <!-- <i class="fa fa-rupee-sign"></i>fa fa-money class="flaticon2-writing" class="flaticon2-sheet" flaticon2-website --> 
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                                            <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                    </span>  
                                    <span class="kt-widget17__subtitle">
                                        Number Of Notes
                                    </span>
                                    <span class="kt-widget17__desc">
                                        <?= isset($total_cash[0]['total_notes']) && ($total_cash[0]['total_notes'] > 0) ? $total_cash[0]['total_notes'] : 0;?> Notes
                                    </span>
                                </div>
                                <div class="kt-widget17__item">
                                    <span class="kt-widget17__icon"> 
                                        <i class="kt-font-brand flaticon2-writing"></i>
                                    </span>
                                    <span class="kt-widget17__subtitle">
                                        No. Of Cheques
                                    </span>
                                    <span class="kt-widget17__desc">
                                        <?= isset($total_cheque_amount[0]['no_of_cheques']) && ($total_cheque_amount[0]['no_of_cheques'] > 0) ? $total_cheque_amount[0]['no_of_cheques'] : 0;?> Cheques
                                    </span>
                                </div>
                            </div>
                            <div class="kt-widget17__items">
                                <div class="kt-widget17__item">
                                    <span class="kt-widget17__icon">
                                        <i class="kt-font-brand flaticon2-website"></i>    
                                    </span>
                                    <span class="kt-widget17__subtitle">
                                        No. Of DD
                                    </span>
                                    <span class="kt-widget17__desc">
                                        <?= isset($total_dd_amount[0]['no_of_dd']) && ($total_dd_amount[0]['no_of_dd'] > 0) ? $total_dd_amount[0]['no_of_dd'] : 0;?> DD
                                    </span>
                                </div>
                                <div class="kt-widget17__item">
                                   <span class="kt-widget17__icon"> 
                                        <i class="kt-font-brand fa fa-rupee-sign"></i>
                                    </span>
                                    <span class="kt-widget17__subtitle">
                                        Total Amount
                                    </span>
                                    <span class="kt-widget17__desc">
                                        <?= isset($total_amount[0]['total_amount']) && ($total_amount[0]['total_amount'] > 0) ? $total_amount[0]['total_amount'] : 0;?>/-
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                <h3 class="kt-portlet__head-title"> 
                    Branch: <?= $branch_name;?>
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <?= $this->Form->create(null,[]); ?>
            <?= $this->Form->end(); ?>
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="group_table">
                <thead>
                    <tr>  
                        <th>Chit Value(Rs.)</th>
                        <th>Duration(Months)</th>
                        <th>Monthly Subscription(Rs.)</th>
                        <th>No. of Inst. Payable</th>
                        <th>Total Amt. Payable(Rs.)</th>
                        <th>Total Dividend(Rs.)</th>
                    </tr>
                </thead>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
</div>
<!-- end:: Content -->
                      