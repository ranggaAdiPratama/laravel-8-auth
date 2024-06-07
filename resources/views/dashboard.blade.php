@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">content_copy</i>
            </div>
            <p class="card-category">Total Order Today</p>
            <h3 class="card-title">
              <span id="total_order"></span>
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons text-danger">warning</i>
              <a href="#pablo">Success.</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">store</i>
            </div>
            <p class="card-category">Total Drivers REG</p>
            <h3 class="card-title"><span id="total_reg"></span></h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">date_range</i> Last 24 Hours
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="material-icons">info_outline</i>
            </div>
            <p class="card-category">Total Drivers EXP</p>
            <h3 class="card-title"><span id="total_exp"></span></h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">date_range</i> Last 24 Hours
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="fa fa-twitter"></i>
            </div>
            <p class="card-category">Total Users Online</p>
            <h3 class="card-title"><span id="total_user"></span></h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">update</i> Just Updated
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
                <div class="card card-chart">
                  <div class="card-header card-header-info" data-header-animation="true">
                    <div class="ct-chart" id="completedTasksChart"></div>
                  </div>
                  <div class="card-body">
                    <div class="card-actions">
                      <button type="button" class="btn btn-danger btn-link fix-broken-card">
                        <i class="material-icons">build</i> Fix Header!
                      </button>
                      <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                        <i class="material-icons">refresh</i>
                      </button>
                      <!-- <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                        <i class="material-icons">edit</i>
                      </button> -->
                    </div>
                    <h4 class="card-title">Statistik Jumlah Orderan Selama 6 Hari</h4>
                    <p class="card-category">Data dalam jumlah adalah total orderan per hari. </p>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">updated at</i> 2 minutes ago
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card card-chart">
                  <div class="card-header card-header-rose" data-header-animation="true">
                    <div class="ct-chart" id="websiteViewsChart"></div>
                  </div>
                  <div class="card-body">
                    <div class="card-actions">
                      <button type="button" class="btn btn-danger btn-link fix-broken-card">
                        <i class="material-icons">build</i> Fix Header!
                      </button>
                      <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                        <i class="material-icons">refresh</i>
                      </button>
                      <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                        <i class="material-icons">edit</i>
                      </button>
                    </div>
                    <h4 class="card-title">Website Views</h4>
                    <p class="card-category">Last Campaign Performance</p>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">access_time</i> campaign sent 2 days ago
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card card-chart">
                  <div class="card-header card-header-success" data-header-animation="true">
                    <div class="ct-chart" id="dailySalesChart"></div>
                  </div>
                  <div class="card-body">
                    <div class="card-actions">
                      <button type="button" class="btn btn-danger btn-link fix-broken-card">
                        <i class="material-icons">build</i> Fix Header!
                      </button>
                      <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                        <i class="material-icons">refresh</i>
                      </button>
                      <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                        <i class="material-icons">edit</i>
                      </button>
                    </div>
                    <h4 class="card-title">Daily Sales</h4>
                    <p class="card-category">
                      <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">access_time</i> updated 4 minutes ago
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
    
  </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    var dataCompletedTasksChart = {
        labels: ['Minggu','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        series: [
          [parseInt("{{$orderINaWeek[0]->Minggu}}"), parseInt("{{$orderINaWeek[0]->Senin}}"), 
            parseInt("{{$orderINaWeek[0]->Selasa}}"), parseInt("{{$orderINaWeek[0]->Rabu}}"), 
            parseInt("{{$orderINaWeek[0]->Kamis}}"), parseInt("{{$orderINaWeek[0]->Jumat}}"),  
            parseInt("{{$orderINaWeek[0]->Sabtu}}")]
        ]
      };
    const dataChartCompletedTask = new Array("{{$orderINaWeek[0]->MaxValues}}", dataCompletedTasksChart);
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts(dataChartCompletedTask);
    doAjax();
    var interval = 60000; // 1000 = 1 second, 3000 = 3 seconds
    function doAjax() {
      $.ajax({
        type: 'GET',
        url: "{{route('counter')}}",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
          // console.log(data);
          $('#total_order').text(data.total_order);
          $('#total_reg').text(data.total_reg);
          $('#total_exp').text(data.total_exp);
          $('#total_user').text(data.total_user);
          // $('#hidden').val(data); // first set the value     
        },
        complete: function(data) {
          // Schedule the next
          setTimeout(doAjax, interval);
        }
      });
    }
    // setTimeout(doAjax, interval);
  });
</script>
@endpush