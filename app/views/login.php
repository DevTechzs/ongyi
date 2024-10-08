<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>Ongyi Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-bg-fill galaxy-border-none">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p class="text-muted">Sign in to continue to Ongyi.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="" id="login-form">

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter username" autocomplete="off">
                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                    </div>
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5 password-input" id="Password" name="Password" placeholder="Enter password" autocomplete="off">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                                                </div>

                                            </form>
                                        </div>


                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer galaxy-border-none">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Ongyi by 2 Brothers
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/common.min.js"></script>
    <!-- Extra page Js -->
    <script src="assets/js/pages/examples/pages.js"></script>
    <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/md5.js"></script>
    <script src="assets/js/CallService.js"></script>
    <script src="assets/js/loader/loadingoverlay.js"></script>

    <!-- password-addon init -->
    <script src="assets/js/pages/password-addon.init.js"></script>
    <script>
        $('#Password').on('keypress', function(e) {
            if (e.which == 13) {
                AuthCall();
            }
        });

        $(document).on('keypress', 'input', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
                console.log($next.length);
                if (!$next.length) {
                    $next = $('[tabIndex=1]');
                }
                $next.focus();
            }
        });

        $("#login-form").on('submit', function(e) {
            debugger;
            e.preventDefault();
            AuthCall();
        });


        function AuthCall() {
            debugger;

            try {

                var json = new Object();
                json.Username = $("#Username")[0].value;
                json.Password = $("#Password")[0].value;
                var svcdta = new Object();
                svcdta.Module = "Auth";
                svcdta.Page_key = "Login";
                svcdta.JSON = json;

                Authenticate(svcdta);
            } catch (ex) {
                console.log(ex.stack);
                alert(ex.stack);
            }

        }

        var ipaddress;
        $(document).ready(function() {
            sessionStorage.clear();
            localStorage.clear();

            $("#Username")[0].focus();
        });
        var msgToDisplay;



        function clearForm() {
            $("#Username")[0].value = "";
            $("#Password")[0].value = "";
            $("#Username")[0].focus();
        }

        function Authenticate(svcdta) {

            $.LoadingOverlay("show");
            svcdta.MSC = $.md5(new Date().getDate().toString().padStart(2, "0"));
            var data = JSON.stringify(svcdta);
            $.ajax({
                data: data,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                async: false,
                url: "index.php",
                success: function showData(arg) {
                    onSuccess(arg);
                },
                error: function err(arg) {
                    $.LoadingOverlay("hide");

                    console.log(JSON.stringify(arg));

                    if (arg.status == 404)
                        alert(arg.statusText);
                    else if (arg.status == 0) {
                        alert(arg.statusText);
                    } else {

                    }
                }
            });
        }


        //on success call
        function onSuccess(rc) {

            $.LoadingOverlay("hide");
            console.log(JSON.stringify(rc));

            if (rc.return_code) // data was recieved successfully 
            {
                var f = rc.return_data;
                sessionStorage.setItem("OcktedHR_user", f.username);
                sessionStorage.setItem("OcktedHR_session", f.sessionkey);
                window.open(f["nextPage"], '_self');
            } else //data was recieved successfully but was returned by service with error code
            {
                try {
                    alert(rc.return_data);
                    clearForm();
                } catch (ex) {
                    alert(ex.stack);
                }
            }
            //Hideloadingpanle();

        }
    </script>
</body>

</html>