<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ admin_url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{!! config('admin.logo-mini', config('admin.name')) !!}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! config('admin.logo', config('admin.name')) !!}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <ul class="nav navbar-nav hidden-sm visible-lg-block">
        {!! Admin::getNavbar()->render('left') !!}
        </ul>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                {!! Admin::getNavbar()->render() !!}

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ Admin::user()->avatar }}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Admin::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ Admin::user()->avatar }}" class="img-circle" alt="User Image">

                            <p>
                                {{ Admin::user()->name }}
                                <small>Member since admin {{ Admin::user()->created_at }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ admin_url('auth/setting') }}" class="btn btn-default btn-flat">{{ trans('admin.setting') }}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ admin_url('auth/logout') }}" class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- <li>
                    <a class="feedback" href="javascript:void(0);" modal="app-admin-actions-feedback">
                        <i class="fa fa-question"></i>
                        <span>反馈</span>
                    </a>
                </li> -->

                <!-- <li>
                    <a href="javascript:void(0);" class="system" modal="app-admin-actions-system">
                        <i class="fa fa-wrench"></i>
                    </a>
                </li> -->

                <li>
                    <a style="margin-top: 2px;" href="{{ admin_url('auth/lock') }}" title="lockscreen">
                        <i style="font-size: 18px" class="fa fa-lock"></i>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0);" class="nav-fullscreen">
                        <i class="fa fa-arrows-alt"></i>
                    </a>
                </li>
                <!-- Control Sidebar Toggle Button -->
                {{--<li>--}}
                    {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </nav>
</header>
<script>
    $(document).ready(function() {
        function launchFullscreen(element) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen();
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullScreen();
            }
        }

        function exitFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }

        $('.nav-fullscreen').click(function () {
            if (document.fullscreenElement) {
                exitFullscreen();
            } else {
                launchFullscreen(document.body)
            }
        });

        $('.feedback').off('click').on('click', function () {
                var data = $(this).data();
                var modalId = $(this).attr('modal');
                Object.assign(data, []);

                $('#' + modalId).modal('show');
                $('#' + modalId + ' form').off('submit').on('submit', function (e) {
                    e.preventDefault();
                    var form = this;
                    var process = new Promise(function (resolve, reject) {
                        Object.assign(data, {
                            _token: $.admin.token,
                            _action: 'App_Admin_Actions_Feedback',
                        });

                        var formData = new FormData(form);
                        for (var key in data) {
                            formData.append(key, data[key]);
                        }

                        $.ajax({
                            method: 'POST',
                            url: 'https://demo.laravel-admin.org/_handle_action_',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                resolve(data);
                                if (data.status === true) {
                                    $('#' + modalId).modal('hide');
                                }
                            },
                            error: function (request) {
                                reject(request);
                            }
                        });
                    });
                    process.then(actionResolver).catch(actionCatcher);
                });
            });
    });
</script>