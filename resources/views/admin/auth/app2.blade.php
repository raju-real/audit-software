<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>

<body>

    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image"> --}}
                    <img src="{{ asset('assets/common/images/itoring-vector-illustration-data-analysis-concept-design-isolated_929545-1064.jpg') }}"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <x-alert-message></x-alert-message>
                    <form action="{{ route('admin-login') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <h5 class="text-primary">
                                Welcome to {{ siteSettings()['company_name'] ?? 'Company Name' }}
                            </h5>
                            {{-- <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-linkedin-in"></i>
                            </button> --}}
                        </div>
                          <p class="lead fw-normal mb-0 me-3">Sign in to continue.</p>
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0">
                                {{-- Or --}}
                            </p>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="email" name="email" id="form3Example3"
                                class="form-control form-control-lg {{ hasError('email') }}"
                                placeholder="Enter a valid email address" value="{{ old('email') }}" />
                            <label class="form-label" for="form3Example3">Email {!! starSign() !!}</label>
                        </div>
                        <div class="form-outline mb-3">
                            <input type="password" name="password" id="form3Example4"
                                class="form-control form-control-lg {{ hasError('password') }}"
                                placeholder="Enter password" />
                            <label class="form-label" for="form3Example4">Password {!! starSign() !!}</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check mb-0">
                                <input name="remember" {{ old('remember') ? 'checked' : '' }}
                                    class="form-check-input me-2" type="checkbox" id="form2Example3" />
                                <label class="form-check-label" for="form2Example3">
                                    Remember me
                                </label>
                            </div>
                            {{-- <a href="#!" class="text-body">Forgot password?</a> --}}
                        </div>
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            {{-- <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#!"
                                    class="link-danger">Register</a></p> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div {{-- d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary --}}
            class="text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <div class="text-white mb-3 mb-md-0 text-center">
                Copyright © {{ date('Y', strtotime(now())) }}. {{ siteSettings()['company_name'] ?? 'Company Name' }} All
                rights reserved.
            </div>
            {{-- <div>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#!" class="text-white">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div> --}}
        </div>
    </section>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
</body>

</html>
