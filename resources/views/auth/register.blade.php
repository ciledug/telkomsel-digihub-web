@include('layouts.include_header_body')

<main>
  <div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
            <p class="text-center small">Enter your personal details to create account</p>
          </div>

          <div class="col-lg-12 col-md-12 d-flex flex-column align-items-center justify-content-center">
            <div class="card mb-3">
              <div class="card-body">
                
                @if ($errors && count($errors) > 0)
                <div class="pt-4 pb-2">
                  <div class="mb-2 text-center invalid-feedback" style="display:block;">
                    @foreach ($errors AS $key => $value)
                      <ul><strong>{{ $value }}</strong></ul>
                    @endforeach
                  </div>
                </div>
                @endif

                <form id="form-register" class="row g-3 needs-validation" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" novalidate>
                  {{ csrf_field() }}

                  @if ($errors && count($errors) > 0)
                  <?php print_r($errors); ?>
                  @endif

                  <!-- company information -->
                  <div class="col-4">
                    <h5 class="card-title">Company Information</h5>
                    
                    <div class="row">
                      <div class="col-12 mb-4">
                        <label for="register-client-id" class="form-label">Client ID *</label>
                        <input type="text" name="register_client_id" class="form-control" id="register-client-id" minlength="4" maxlength="20" required>
                        @if ($errors->has('register_client_id'))
                        <div class="invalid-feedback">
                          {{ $errors->first('register_client_id')}}
                        </div>
                        @endif
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="register-company-name" class="form-label">Company Name *</label>
                        <input type="text" name="register_company_name" class="form-control" id="register-company-name" minlength="5" maxlength="50" required>
                        @if ($errors->has('register_company_name'))
                        <div class="invalid-feedback">
                          {{ $errors->first('register_company_name')}}
                        </div>
                        @endif
                      </div>

                      <div class="col-12 mb-4">
                        <label for="register-legal-entity" class="form-label">Legal Entity</label>
                        <select id="register-legal-entity" name="register_legal_entity" class="form-select">
                          <option selected></option>
                          @foreach($legal_entities AS $key => $value)
                          <option value="{{ $value->id }}">{{ $value->name }}</option>
                          @endforeach
                        </select>
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="register-business-field" class="form-label">Business Field</label>
                        <select id="register-business-field" name="register_business_field" class="form-select">
                          <option selected></option>
                          @foreach ($business_fields AS $key => $value)
                          <option value="{{ $value->id }}">{{ $value->name }}</option>
                          @endforeach
                        </select>
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="input-address" class="form-label">Address</label>
                        <textarea class="form-control" id="register-address" name="register_address" style="height:100px;"></textarea>
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="register-client-id" class="form-label">Company Website</label>
                        <input type="text" name="register_company_website" class="form-control" id="register-company-website" minlength="5" maxlength="50">
                      </div>
                    </div>
                  </div>

                  <!-- contact person -->
                  <div class="col-4">
                    <h5 class="card-title">Contact Person</h5>

                    <div class="row">
                      <div class="col-12 mb-4">
                        <label for="register-full-name" class="form-label">Full Name *</label>
                        <input type="text" name="register_full_name" class="form-control" id="register-full-name" minlength="5" maxlength="50" required>
                        @if ($errors->has('register_full_name'))
                        <div class="invalid-feedback">
                          {{ $errors->first('register_full_name')}}
                        </div>
                        @endif
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="register-email" class="form-label">Email *</label>
                        <input type="email" name="register_email" class="form-control" id="register-email" minlength="10" maxlength="50" required>
                        @if ($errors->has('register_email'))
                        <div class="invalid-feedback">
                          {{ $errors->first('register_email')}}
                        </div>
                        @endif
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="register-phone" class="form-label">Phone *</label>
                        <input type="tel" name="register_phone" class="form-control" id="register-phone" minlength="10" maxlength="15" required>
                        @if ($errors->has('register_phone'))
                        <div class="invalid-feedback">
                          {{ $errors->first('register_phone')}}
                        </div>
                        @endif
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="register-position" class="form-label">Position *</label>
                        <select id="register-position" name="register_position" class="form-select" required>
                          <option selected=""></option>
                          @foreach ($job_positions AS $key => $value)
                          <option value="{{ $value->id }}">{{ $value->name }}</option>
                          @endforeach
                        </select>
                        @if ($errors->has('register_position'))
                        <div class="invalid-feedback">
                          {{ $errors->first('register_position')}}
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- login account info -->
                  <div class="col-4">
                    <h5 class="card-title">Login Account Info</h5>

                    <div class="row">
                      <div class="col-12 mb-4">
                        <label for="register-company-email" class="form-label">Email *</label>
                        <input type="email" name="register_company_email" class="form-control" id="register-company-email" minlength="5" maxlength="50" required>
                        @if ($errors->has('register_company_email'))
                        <div class="invalid-feedback">
                          {{ $errors->first('register_company_email')}}
                        </div>
                        @endif
                      </div>

                      <div class="col-12 mb-4">
                        <label for="register-password" class="form-label">Password *</label>
                        <input type="password" name="password" class="form-control" id="register-password" minlength="6" maxlength="15" required>
                        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                          {{ $errors->first('password')}}
                        </div>
                        @endif
                      </div>
    
                      <div class="col-12 mb-4">
                        <label for="register-confirm-password" class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-control" id="register-confirm-password" minlength="6" maxlength="15" required>
                      </div>
                    </div>
                  </div>

                  {{--
                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                      <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                      <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                  </div>
                  --}}

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
  // $(document).ready(function() {
  //   $('#form-register').submit(function() {
  //   });
  // });
</script>
@endpush

@include('layouts.include_js')