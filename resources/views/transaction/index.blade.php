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

        @if (!isset($show))
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
                    <h6>{{ number_format($total_success_rate, '2', ',', '.') }} %</h6>
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
        @endif

        <div class="row">
          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <h5 class="card-title"><!-- 5 Recent API Calls <span>| Today</span> --></h5>
                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                  
                  @if (!isset($show))
                  <div class="dataTable-container">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col" data-sortable="" style="width: 15.601%;">
                            <span class="dataTable-sorter">Date / Month</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">API Used</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Total Calls</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Success Calls</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Failed Calls</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Success Rate %</span>
                          </th>
                          <th scope="col" data-sortable="" class="text-end">
                            <span class="dataTable-sorter">Totall Bill</span>
                          </th>
                        </tr>
                      </thead>
                  
                      <tbody>
                        @foreach($api_requests AS $keyApiCalls => $valApiCalls)
                        <tr>
                          <td><a href="{{ route('transactions.show', $valApiCalls['api_date']) }}">{{ $valApiCalls['api_date'] }}</a></td>
                          <td class="text-end">{{ number_format($valApiCalls['count_product_apis'], 0, ',', '.') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls['count_total_calls'], 0, ',', '.') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls['count_success_calls'], 0, ',', '.') }}</td>
                          <td class="text-end">{{ number_format($valApiCalls['count_failed_calls'], 0, ',', '.') }}</td>
                          <td class="text-end">
                            @php
                              $successRate = ($valApiCalls['count_success_calls'] / $valApiCalls['count_total_calls']) * 100;
                              echo number_format($successRate, 0, ',', '.');
                            @endphp
                          </td>
                          <td class="text-end">{{ number_format(0, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                    {{ $api_requests->links() }}
                  </div>
                  @endif


                  <!-- Per date details -->
                  @if (isset($show) && ($show === 'list-per-date'))
                  <div class="dataTable-container">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col" data-sortable="" style="width: 15.601%;">
                            <span class="dataTable-sorter">Date Time</span>
                          </th>
                          <th scope="col" data-sortable="">
                            <span class="dataTable-sorter">Product API</span>
                          </th>
                          <th scope="col" data-sortable="">
                            <span class="dataTable-sorter">Transaction ID</span>
                          </th>
                          <th scope="col" data-sortable="">
                            <span class="dataTable-sorter">Consent ID</span>
                          </th>
                          <th scope="col" data-sortable="">
                            <span class="dataTable-sorter">Status Description</span>
                          </th>
                        </tr>
                      </thead>
                  
                      <tbody>
                        @foreach($transactions_list AS $key => $value)
                        <tr>
                          <td>{{ $value['created_at'] }}</td>
                          <td>{{ $value['api_name'] }}</td>
                          <td>{{ $value['transaction_id'] }}</td>
                          <td>{{ $value['consent_ref'] }}</td>

                          @if ($value->status_code === '00000')
                          <td><span class="badge bg-success">{{ $value['status_description'] }}</span></td>
                          @else
                          <td><span class="badge bg-danger">{{ $value['status_description'] }}</span></td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                    {{ $transactions_list->links() }}
                  </div>
                  @endif

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