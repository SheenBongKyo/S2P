<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background:url(<?php echo base_url()?>assets/theme/images/big/auth-bg.jpg) no-repeat center center;">
    <div class="auth-box row" style="max-width: 992px; width: 992px;">
        <div class="col-lg-6 modal-bg-img" style="background-image: url(<?php echo base_url()?>assets/images/login-left.jpg);">
        </div>
        <div class="col-lg-6 bg-white">
            <div class="p-3 pt30 pb30">
                <div class="text-center">
                    <img src="<?php echo base_url()?>assets/theme/images/big/icon.png" alt="wrapkit">
                </div>
                <h2 class="mt-3 text-center fs30">로그인</h2>
                <p class="text-center fs15">발급받은 아이디와 비밀번호로<br/>로그인을 해주세요.</p>
                <form id="loginForm" method="POST" class="mt-4" onkeydown="return enterFormSubmit(event, 'submitBtn')">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark fs15" for="mem_userid">아이디</label>
                                <input class="form-control fs15" id="mem_userid" name="mem_userid" type="text" placeholder="아이디를 입력해주세요.">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark fs15" for="mem_password">비밀번호</label>
                                <input class="form-control fs15" id="mem_password" name="mem_password" type="password" placeholder="비밀번호를 입력해주세요.">
                            </div>
                        </div>
                        <div class="col-lg-12 text-center fs15 mt20">
                            <button type="button" class="btn btn-block btn-dark" id="submitBtn" button-type="submit" form-id="loginForm">LOGIN</button>
                        </div>
                        <!-- <div class="col-lg-12 text-center mt-5">
                            Don't have an account? <a href="#" class="text-danger">Sign Up</a>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>