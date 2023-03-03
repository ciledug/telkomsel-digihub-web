@include('layouts.include_page_header')
@include('layouts.include_sidebar')

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Transaction History</h1>
    <!--
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
    -->
  </div>
  
  <section class="section dashboard">
    <div class="row">
      
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- total calls -->
          <div class="col-xxl-3 col-xl-6 col-md-6">
            <div class="card info-card sales-card">

              <!--
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>
              -->

              <div class="card-body">
                <h5 class="card-title">Total API Calls <!-- <span>| Today</span> --></h5>

                <div class="d-flex align-items-center">
                  <!--
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  -->

                  <div class="ps-3">
                    <h6>{{ number_format($total_api_calls, 0, ',', '.') }}</h6>
                    <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- success rate -->
          <div class="col-xxl-3 col-xl-6 col-md-6">
            <div class="card info-card revenue-card">

              <!--
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>
              -->

              <div class="card-body">
                <h5 class="card-title">Total Success Rate <!-- <span>| This Month</span> --></h5>

                <div class="d-flex align-items-center">
                  <!--
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  -->
                  <div class="ps-3">
                    <h6>{{ $total_success_rate }} %</h6>
                    <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- success calls -->
          <div class="col-xxl-3 col-xl-6 col-md-6">
            <div class="card info-card customers-card">
              <!--
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>
              -->

              <div class="card-body">
                <h5 class="card-title">Total Success Calls <!-- <span>| This Year</span> --></h5>

                <div class="d-flex align-items-center">
                  <!--
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  -->
                  <div class="ps-3">
                    <h6>{{ number_format($total_success_calls, 0, ',', '.') }}</h6>
                    <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease --></span>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- failed calls -->
          <div class="col-xxl-3 col-xl-6 col-md-6">
            <div class="card info-card customers-card">
              <!--
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>
              -->

              <div class="card-body">
                <h5 class="card-title">Total Failed Calls <!-- <span>| This Year</span> --></h5>

                <div class="d-flex align-items-center">
                  <!--
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  -->
                  <div class="ps-3">
                    <h6>{{ number_format($total_failed_calls, 0, ',', '.') }}</h6>
                    <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease --></span>
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <h5 class="card-title"><!-- 5 Recent API Calls <span>| Today</span> --></h5>
                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                  
                  <div class="dataTable-container">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col" data-sortable="" style="width: 15.601%;">
                            <span class="dataTable-sorter">Date / Month</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Total Calls</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">API Used</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Total Success Calls</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Total Failed Calls</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Totall Bill</span>
                          </th>
                        </tr>
                      </thead>
                  
                      <tbody>
                        @foreach($api_requests AS $keyApiCalls => $valApiCalls)
                        <tr>
                          <td>{{ Carbon\Carbon::parse($valApiCalls->created_at)->format('Y-m-d') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls->total_calls, 0, ',', '.') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls->api_used, 0, ',', '.') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls->success_calls, 0, ',', '.') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls->failed_calls, 0, ',', '.') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls->total_bill, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                    {{ $api_requests->links() }}

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!-- End Left side columns -->

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