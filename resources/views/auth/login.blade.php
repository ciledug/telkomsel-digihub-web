@include('layouts.include_header_body')

<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                            <a class="logo d-flex align-items-center w-auto">
                                <span class="d-none d-lg-block">{{ env('APP_NAME') }}</span>
                            </a>
                        </div>
              
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Login Dalco Account</h5>
                                    <p class="text-center small">Enter your email &amp; password to login</p>

                                    @if ($errors->has('login_invalid'))
                                    <div class="mb-2 text-center invalid-feedback" style="display:block;">
                                        <strong>{{ $errors->first('login_invalid') }}</strong>
                                    </div>
                                    @endif
                                </div>
                  
                                <form id="form-login" class="row g-3 needs-validation" method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="col-12">
                                        <label for="username" class="form-label">Email</label>
                                        <input type="email" id="username" name="username" class="form-control" minlength="6" maxlength="50" value="{{ old('username') }}" required autofocus>
                                        @if ($errors->has('username'))
                                        <div class="invalid-feedback" style="display:block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                    
                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" minlength="6" maxlength="15" required>
                                        @if ($errors->has('password'))
                                        <div class="invalid-feedback" style="display:block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                    
                                    <!--
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="input-login-remember" name="input-login-remember" value="true">
                                            <label class="form-check-label" for="input-login-remember">Remember me</label>
                                        </div>
                                    </div>
                                    -->
                    
                                    <div class="col-12">
                                        <button type="submit" id="btn-login-submit" class="btn btn-primary w-100">Login</button>
                                    </div>

                                    <div class="col-12 text-center">
                                    <p class="small mb-0"><a href="{{ url('register') }}">Create account</a>.</p>
                                    </div>
                                </form>
                            </div>
                        </div>
              
                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                            <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

@include('layouts.include_js')