<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md mb0">
        <div class="navbar-header tac" data-logobg="skin6" style="border-bottom: 1px solid #edf2f9;">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-close ti-menu"></i></a>
            <a href="<?php echo base_url()?>" style="line-height: 79px;">
                <img src="<?php echo base_url()?>assets/images/logo.png" style="width: 80px;"/>
            </a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                        id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        <span class="badge badge-primary notify-no rounded-circle">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                        <ul class="list-style-none">
                            <li>
                                <div class="message-center notifications position-relative">
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="btn btn-danger rounded-circle btn-circle"><i
                                                data-feather="airplay" class="text-white"></i></div>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                            <span class="font-12 text-nowrap d-block text-muted">Just see
                                                the my new
                                                admin!</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-success text-white rounded-circle btn-circle"><i
                                                data-feather="calendar" class="text-white"></i></span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h6 class="message-title mb-0 mt-1">Event today</h6>
                                            <span
                                                class="font-12 text-nowrap d-block text-muted text-truncate">Just
                                                a reminder that you have event</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:10 AM</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-info rounded-circle btn-circle"><i
                                                data-feather="settings" class="text-white"></i></span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h6 class="message-title mb-0 mt-1">Settings</h6>
                                            <span
                                                class="font-12 text-nowrap d-block text-muted text-truncate">You
                                                can customize this template
                                                as you want</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:08 AM</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-primary rounded-circle btn-circle"><i
                                                data-feather="box" class="text-white"></i></span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h6 class="message-title mb-0 mt-1">Pavan kumar</h6> <span
                                                class="font-12 text-nowrap d-block text-muted">Just
                                                see the my admin!</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:02 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);">
                                    <strong>Check all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
            </ul>
            <ul class="navbar-nav float-right">
                <!-- <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <form>
                            <div class="customize-input">
                                <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                    type="search" placeholder="Search" aria-label="Search">
                                <i class="form-control-icon" data-feather="search"></i>
                            </div>
                        </form>
                    </a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-2 d-none d-lg-inline-block">
                            <span class="text-dark"><?php echo $this->login_lib->getInfo('mem_name')?></span> 
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="javascript:$('#accountSetModal').modal();" style="margin-top:.5rem">
                            <i data-feather="settings" class="svg-icon mr-2 ml-1"></i>
                            계정 설정
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('logout')?>" style="margin-top:.5rem">
                            <i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                            로그 아웃
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav mt10 pt0">
            <ul id="sidebarnav">
                <?php if (!empty($build->headerNav)) { ?>
                    <?php foreach ($build->headerNav as $key => $item) { ?>
                        <li class="sidebar-item <?php echo $this->uri->segment(1) == $item['url'] ? 'selected':''?>"> 
                            <a class="sidebar-link sidebar-link <?php echo $this->uri->segment(1) == $item['url'] ? 'active':''?>" href="<?php echo base_url($item['url'])?>" aria-expanded="false">
                                <i class="<?php echo $item['icon']?> mt5"></i>
                                <span class="hide-menu"><?php echo $item['title']?></span>
                            </a>
                        </li>
                        <li class="list-divider mb10"></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>

<div id="accountSetModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">계정 설정</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="accountSetForm" method="post" onkeydown="return enterFormSubmit(event, 'submitBtn')">
                    <div class="form-group">
                        <label>아이디</label>
                        <input type="text" class="form-control" value="<?php echo $this->login_lib->getInfo('mem_userid')?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>회원명(업체명)</label>
                        <input type="text" class="form-control" name="mem_name" value="<?php echo $this->login_lib->getInfo('mem_name')?>">
                    </div>
                    <div class="form-group">
                        <label>비밀번호</label>
                        <input type="password" class="form-control" name="mem_password">
                        <small>※ 계정 수정 시 비밀번호 입력 시에만 수정됩니다.</small>
                    </div>
                </form>
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-outline-primary" id="submitBtn" button-type="submit" submit-url="<?php echo base_url('accountSet')?>" form-id="accountSetForm">등록</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>