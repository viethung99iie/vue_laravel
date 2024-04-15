<script setup>

</script>

<template>
    <nav class="navbar">
        <div class="uk-flex uk-flex-middle uk-flex-between">
            <div class="collapse-menu"><i class="bx bx-menu-alt-left" data-v-3b924b02=""></i></div>
            <div class="uk-flex uk-flex-middle">
                <div class="uk-inline">
                    <button class="uk-button uk-button-default language-active p0" type="button">
                        <img src="@/assets/backend/img/language/vn-flag.png" alt="">
                    </button>
                    <div class="language-dropdown" uk-dropdown="mode: click">
                        <div class="language-item">
                            <div class="uk-flex uk-flex-middle">
                                <span class="language-image img-cover"><img src="@/assets/backend/img/language/us_flag.jpg" alt=""></span>
                                <span class="language-text">English</span>
                            </div>
                        </div>
                        <div class="language-item">
                            <div class="uk-flex uk-flex-middle">
                                <span class="language-image img-cover"><img src="@/assets/backend/img/language/us_flag.jpg" alt=""></span>
                                <span class="language-text">English</span>
                            </div>
                        </div>
                        <div class="language-item">
                            <div class="uk-flex uk-flex-middle">
                                <span class="language-image img-cover"><img src="@/assets/backend/img/language/us_flag.jpg" alt=""></span>
                                <span class="language-text">English</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navbar-top-link">
                    <div class="uk-flex uk-flex-middle">
                        <div class="notice">
                            <span class="header-link dropdown-toggle">
                                <i class="bx bx-cart header-link-icon"></i>
                                <span class="badge bg-primary pulse-primary">5</span>
                            </span>
                        </div>
                        <div class="notice">
                            <span class="header-link dropdown-toggle">
                                <i class="bx bx-bell header-link-icon"></i>
                                <span class="badge bg-secondary pulse">5</span>
                            </span>
                        </div>
                        <div class="bell-dropdown" uk-dropdown="mode: click, pos: top-right">
                            <div class="panel-head">
                                <div class="uk-flex uk-flex-middle uk-flex-between">
                                    <div class="bell-heading">Thông báo</div>
                                    <div class="bell-unread">10 Unread</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="bell-item">
                                    <div class="title">Bạn nhận được 1 đơn hàng từ hệ thống</div>
                                    <div class="description">
                                        <div>Mã đơn: ORDER0000123</div>
                                        <div>Địa chỉ: Số 16 NGõ 198 Lê Trọng Tấn...</div>
                                    </div>
                                </div>
                                <div class="bell-item">
                                    <div class="title">Bạn nhận được 1 đơn hàng từ hệ thống</div>
                                    <div class="description">
                                        <div>Mã đơn: ORDER0000123</div>
                                        <div>Địa chỉ: Số 16 NGõ 198 Lê Trọng Tấn...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-profile">
                    <div class="uk-flex uk-flex-middle">
                        <span class="profile-image image img-cover"><img src="@/assets/backend/img/avatar-dep-dang-yeu-nu-5.jpg" alt=""></span>
                        <div class="profile-description">
                            <div class="profile-name">Nguyễn Việt Hưng</div>
                            <div class="profile-role">Super Admin</div>
                        </div>
                    </div>
                    <div class="profile-dropdown" uk-dropdown="mode: click">
                        <div class="profile-item">
                            <div class="uk-flex uk-flex-middle">
                                <span class="icon"><i class="bx bx-user"></i></span>
                                <span class="text">Thông tin cá nhân</span>
                            </div>
                        </div>
                        <div class="profile-item">
                            <div class="uk-flex uk-flex-middle">
                                <span class="icon"><i class="bx bx-envelope"></i></span>
                                <span class="text">Hộp thư</span>
                            </div>
                        </div>
                        <div class="profile-item">
                            <div class="uk-flex uk-flex-middle">
                                <span class="icon"><i class="bx bx-cog"></i></span>
                                <span class="text">Cài đặt tài khoản</span>
                            </div>
                        </div>
                        <div class="profile-item">
                            <div class="uk-flex uk-flex-middle">
                                <span class="icon"><i class="bx bx-exit"></i></span>
                                <span class="text">Đăng xuất</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
	.navbar{
		padding:0 20px;
		background: #fff;
        border-bottom:1px solid #e7eaec;
	}
    .navbar-top-link{
        margin-right:15px;
        margin-left:15px;
    }
	.navbar .bx-menu-alt-left{
		font-size:25px;
	}
	.navbar-top-link .bx-exit{
		font-size:20px;
		margin-right:10px;
		color:#999999;
	}
	.navbar-top-link  a{
		color:#999999;
	}
	.header-link{
		padding:18px;
		display: block;
		position: relative;
	}
	.header-link-icon{
		font-size:20px;
	}
	.header-link .badge{
		position: absolute;
		background: var(--secondary-color);
		color:#fff;
		font-size:11px;
		width:15px;
		height:15px;
		border-radius: 50%;
		top:11px;
		right:11px;
		line-height:15px;
		text-align: center;
	}
    .language-active{
        box-shadow: none;
        border:0;
        padding:0;
        line-height: 0;
    }
    .language-active img{
        width:28px;
        height:28px;
        border-radius: 50%;
    }

    .notice{
        line-height:0;
        cursor: pointer;
    }
    .nav-profile{
        cursor: pointer;
    }
    .nav-profile .profile-image{
        width:32px;
        height: 32px;
        border-radius: 50%;
    }
    .nav-profile .profile-image img{
        border-radius: 50%;
    }
    .nav-profile .profile-image{
        margin-right:10px;
    }
    .nav-profile .profile-name{
        font-weight: 700;
        font-size:12px;
    }
    .nav-profile .profile-role{
        font-size:11px;
        font-weight: 500;
        color:#777
    }
    .language-dropdown{
        border-radius: 8px;
        padding:0;
    }
    .language-dropdown .language-item{
        padding:10px;
        cursor: pointer;
        font-size:12px;
        color:#000;
    }
    .language-dropdown .language-image{
        width:16px;
        height:16px;
        border-radius: 50%;
        margin-right:10px;
    }
    .language-dropdown .language-image img{
        border-radius: 50%;
        vertical-align: auto;
    }
    .language-dropdown .language-item:hover{
        background: rgba(132, 90, 223, 0.05)
    }
    .language-dropdown .language-item:hover .language-text{
        color:var(----primary-bg)
    }
    .profile-dropdown {
        padding:0;
        border-radius: 8px;
    }
    .profile-dropdown .profile-item{
        padding:10px;
    }
    .profile-dropdown .profile-item:hover{
        background: rgba(132, 90, 223, 0.05)
    }
    .profile-item .icon{
        margin-right:10px;
        font-size:18px;
        line-height:0;
    }
    .profile-item .text{
        font-weight: 500;
        font-size:13px;
    }
    .bell-dropdown{
        padding:0;
        border-radius: 8px;
        left:1000px !important;
        top:57px !important;
        width:350px !important;
    }
    .bell-dropdown .panel-head{
        padding:15px;
        border-bottom:1px solid #f3f3f3;
    }
    .bell-dropdown .panel-head .bell-heading{
        color:#000;
        font-size:16px;
        font-weight: 700;
    }

    .bell-dropdown .bell-unread{
        color:var(--secondary-color);
        font-size:11px;
        font-weight: 600;
        background: rgba(35,183,229, 0.2);
        padding:2px 5px;
        border-radius: 5px;
    }
    .bell-item{
        padding:10px;
        border-bottom:1px solid #f3f3f3;
        cursor: pointer;
    }
    .bell-item:hover{
        background: rgba(132, 90, 223, 0.05);
    }
    .bell-item .title{
        font-weight: 600;
        color:#333;
    }

    .bell-item .description{
        color:#999;
        font-size:13px;
    }

</style>
