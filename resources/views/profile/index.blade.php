@include('layouts.include_page_header')
@include('layouts.include_sidebar')

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Profile</h1>
    <!--
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
    -->
  </div>

  <section class="section profile">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body pt-3">
            
            <!-- Bordered Tabs -->
            <!-- tab titles -->
            <ul class="nav nav-tabs nav-tabs-bordered mb-3" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">Overview</button>
              </li>
              
              {{--
              <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" role="tab" tabindex="-1">Edit Profile</button>
              </li>
              
              <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" aria-selected="false" role="tab" tabindex="-1">Settings</button>
              </li>
              --}}
              
              <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="false" role="tab" tabindex="-1">Change Password</button>
              </li>
            </ul>
            

            <!-- tab contents -->
            <div class="tab-content pt-2">
              @if (session('password_changed_ok'))
              <div id="alert-password-change-success" class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('password_changed_ok') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif

              <!-- Profile Overview -->
              <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                <h5 class="card-title" style="padding:0 0 15px 0;">{{ $profile->company }}</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Client ID</div>
                  <div class="col-lg-9 col-md-8">{{ Auth::user()->username }}</div>
                </div>
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Legal Entity</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->legal_entity }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Business Field</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->business_field }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->address }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Company Website</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->company_site }}</div>
                </div>
                
                
                <h5 class="card-title">Contact Person</h5>
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->contact_person }}</div>
                </div>
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Position</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->cp_position }}</div>
                </div>
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->cp_phone }}</div>
                </div>
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{ $profile->cp_email }}</div>
                </div>
              </div>
              <!-- End Profile Overview -->
              
              {{--
              <!-- Profile Edit Form -->
              <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">
                <form>
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <img src="assets/img/profile-img.jpg" alt="Profile">
                      <div class="pt-2">
                        <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                        <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="fullName" type="text" class="form-control" id="fullName" value="Kevin Anderson">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="company" type="text" class="form-control" id="company" value="Lueilwitz, Wisoky and Leuschke">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="job" type="text" class="form-control" id="Job" value="Web Designer">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="country" type="text" class="form-control" id="Country" value="USA">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Address" value="A108 Adam Street, New York, NY 535022">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="Phone" value="(436) 486-3538 x29071">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Email" value="k.anderson@example.com">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                    </div>
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
              <!-- End Profile Edit Form -->

              <!-- Settings Form -->
              <div class="tab-pane fade pt-3" id="profile-settings" role="tabpanel">
                <form>
                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="changesMade" checked="">
                        <label class="form-check-label" for="changesMade">
                          Changes made to your account
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="newProducts" checked="">
                        <label class="form-check-label" for="newProducts">
                          Information on new products and services
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proOffers">
                        <label class="form-check-label" for="proOffers">
                          Marketing and promo offers
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="securityNotify" checked="" disabled="">
                        <label class="form-check-label" for="securityNotify">
                          Security alerts
                        </label>
                      </div>
                    </div>
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
              <!-- End settings Form -->
              --}}

              <!-- Change Password Form -->
              <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                <form id="form-login" class="row g-3 needs-validation" method="POST" action="{{ route('profile.newpassword') }}" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                  <div class="row mb-3">
                    <label for="profile-old-password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="old_password" type="password" class="form-control" id="profile-old-password" minlength="6" maxlength="15" required>
                      @if ($errors->has('old_password'))
                      <div class="invalid-feedback" style="display:block;">
                        {{ $errors->first('old_password') }}
                      </div>
                      @endif
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="profile-new-password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="profile-new-password" minlength="6" maxlength="15" required>
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="profile-confirm-password" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password_confirmation" type="password" class="form-control" id="profile-confirm-password" minlength="6" maxlength="15" required>
                      @if ($errors->has('password'))
                      <div class="invalid-feedback" style="display:block;">
                        {{ $errors->first('password') }}
                      </div>
                      @endif
                    </div>
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" id="btn-submit-new-password" class="btn btn-primary">Change Password</button>
                  </div>
                </form>
              </div>
              <!-- End Change Password Form -->

            </div>
            <!-- End Bordered Tabs -->
          
          </div>
        </div>
      
      </div>
    </div>
  </section>
</main>

@push('javascript')
<script type="text/javascript">
  $(document).ready(function() {
  });
</script>
@endpush

@include('layouts.include_page_footer')
@include('layouts.include_js')