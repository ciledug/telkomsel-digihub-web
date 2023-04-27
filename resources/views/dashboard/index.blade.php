@include('layouts.include_page_header')
@include('layouts.include_sidebar')

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard Overview</h1>
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
      <div class="col-lg-8">
        <div class="row">
          
          <!-- total calls -->
          <div class="col-xxl-6 col-xl-6 col-md-6">
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
                <h5 class="card-title">Today's API Calls <!-- <span>| Today</span> --></h5>

                <div class="d-flex align-items-center">
                  <!--
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  -->

                  <div class="ps-3">
                    <h6>{{ number_format($total_success_calls + $total_failed_calls, 0, ',', '.') }}</h6>
                    <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- apis used -->
          <div class="col-xxl-6 col-xl-6 col-md-6">
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
                <h5 class="card-title">Today's API Used <!-- <span>| Today</span> --></h5>

                <div class="d-flex align-items-center">
                  <!--
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  -->

                  <div class="ps-3">
                    <h6>{{ number_format(count($used_apis_list), 0, ',', '.') }}</h6>
                    <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- success rate -->
          <div class="col-xxl-4 col-xl-6 col-md-4">
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
                <h5 class="card-title">Today's Success Rate <!-- <span>| This Month</span> --></h5>

                <div class="d-flex align-items-center">
                  <!--
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  -->
                  <div class="ps-3">
                    <h6>{{ number_format($total_success_rate, 2, ',', '.') }} %</h6>
                    <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- success calls -->
          <div class="col-xxl-4 col-xl-6 col-md-4">
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
                <h5 class="card-title">Today's Success Calls <!-- <span>| This Year</span> --></h5>

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
          <div class="col-xxl-4 col-xl-6 col-md-4">
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
                <h5 class="card-title">Today's Failed Calls <!-- <span>| This Year</span> --></h5>

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
          
          <!-- 10 recent api calls -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <!--
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
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
                <h5 class="card-title">Today's 10 Recent API Calls <!-- <span>| Today</span> --></h5>
                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                  
                  <div class="dataTable-container">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col" data-sortable="" style="width: 15.601%;">
                            <span class="dataTable-sorter">Date</span>
                          </th>
                          <!--
                          <th scope="col" data-sortable="" style="width: 22.5064%;">
                            <span class="dataTable-sorter">Transaction ID</span>
                          </th>
                          -->
                          <th scope="col" data-sortable="" style="width: 26.3427%;">
                            <span class="dataTable-sorter">Product</span>
                          </th>
                          <th scope="col" data-sortable="" style="width: 21.4834%;">
                            <span class="dataTable-sorter">Status</span>
                          </th>
                        </tr>
                      </thead>
                  
                      <tbody>
                        @foreach($last_requests_list AS $keyApiCalls => $valApiCalls)
                        <tr>
                          <td scope="row">{{ $valApiCalls->created_at }}</td>
                          <!-- <td>{{ $valApiCalls->transaction_id }}</td> -->
                          <td>{{ $valApiCalls->product_name }}</td>

                          @if ($valApiCalls->status_code === '00000')
                          <td><span class="badge bg-success">{{ $valApiCalls->status_description }}</span></td>
                          @else
                          <td><span class="badge bg-danger">{{ $valApiCalls->status_description or 'Failed' }}</span></td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- End Left side columns -->
      
      <!-- Right side columns -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body pb-0">
            <h5 class="card-title">Live Broadcast Call <span>| Today</span></h5>
            <div id="chart-total-calls" style="min-height:400px;"></div>
          </div>
        </div>
      </div>
      <!-- End Right side columns -->

    </div>
  </section>
</main>

@push('javascript')
<script src="{{ url('vendor/echarts/echarts.min.js') }}"></script>
<script type="text/javascript">
  var dataTableContainer = '';
  var callsChart = '';

  $(document).ready(function() {
    // prepareTableContainer();
    prepareChart('chart-total-calls');
  });

  /*
  function prepareTableContainer() {
    dataTableContainer = $('#table-running-campaign-list-container').DataTable({
      processing: true,
      lengthMenu: [1, 10, 15, 20, 50, 100],
      pageLength: 10,
      responsive: true,
      columns: [
        { data: null },
        { data: 'name' },
        { data: 'progress' },
      ],
      columnDefs: [
        {
          targets: 0,
          orderable: false,
          render: function(data, type, row, meta) {
            console.log('hai');
            return ++meta.row + '.';
          }
        },
        {
          targets: 2,
          className: 'dt-body-right',
        }
      ],
    });
  };
  */

  function prepareChart(chartContainer) {
    callsChart = echarts.init(document.getElementById(chartContainer));
    callsChart.setOption({
      tooltip: {
        trigger: 'item'
      },
      legend: {
        top: '5%',
        left: 'center'
      },
      series: [{
        type: 'pie',
        radius: ['40%', '70%'],
        avoidLabelOverlap: false,
        label: {
          show: false,
          position: 'center'
        },
        emphasis: {
          label: {
            show: true,
            fontSize: '18',
            fontWeight: 'bold'
          }
        },
        labelLine: {
          show: false
        },
        data: [
          { 
            value: @php if ($total_failed_calls > 0) echo $total_failed_calls; else echo 'null'; @endphp,
            name: 'Failed Calls'
          },
          {
            value: @php if ($total_success_calls > 0) echo $total_success_calls; else echo 'null'; @endphp,
            name: 'Success Calls',
            color: 'rgba(255, 0, 0, 0.5)',
          },
        ],
        color: [
          '#dc3545',
          '#20c997',
        ],
      }],
    });
  };
</script>
@endpush

@include('layouts.include_page_footer')
@include('layouts.include_js')