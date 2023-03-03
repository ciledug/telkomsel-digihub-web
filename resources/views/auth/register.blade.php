@include('layouts.include_header_body')

<main>
  <div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                  <p class="text-center small">Enter your personal details to create account</p>
                </div>

                <form id="form-register" class="row g-3 needs-validation" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                  {{ csrf_field() }}

                  <div class="col-12">
                    <label for="register-name" class="form-label">Your Name</label>
                    <input type="text" name="name" class="form-control" id="register-name" minlength="5" maxlength="50" required>
                  </div>

                  <div class="col-12">
                    <label for="register-email" class="form-label">Your Email</label>
                    <input type="email" name="email" class="form-control" id="register-email" minlength="10" maxlength="50" required>
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">
                      {{ $errors->first('email')}}
                    </div>
                    @endif
                  </div>

                  <div class="col-12">
                    <label for="register-username" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="text" name="username" class="form-control" id="register-username" minlength="6" maxlength="15" required>
                      @if ($errors->has('username'))
                      <div class="invalid-feedback">
                        {{ $errors->first('username')}}
                      </div>
                      @endif
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="register-password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="register-password" minlength="6" maxlength="15" required>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">
                      {{ $errors->first('password')}}
                    </div>
                    @endif
                  </div>

                  <div class="col-12">
                    <label for="register-confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="register-confirm-password" minlength="6" maxlength="15" required>
                  </div>

                  <!--
                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                      <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                      <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                  </div>
                  -->

                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit" id="btn-submit-register">Create Account</button>
                  </div>

                  <div class="col-12 text-center">
                    <p class="small mb-0"><a href="{{ url('login') }}">Log in</a></p>
                  </div>
                </form>

              </div>
            </div>

            <div class="credits">
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
              {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>

@push('javascript')
<script type="text/javascript">
  $(document).ready(function() {
    $('#form-register').submit(function() {

    });
  });
</script>
@endpush

@include('layouts.include_js')