@extends('layout.master')
@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">


<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Reports by Month Wise</h5>

            <!-- Bar Chart -->
            <div id="barChart" style="min-height: 400px;" class="echart"></div>

            @php
                $report_chart = json_encode($reportCounts, true);
            @endphp

      <script>
    document.addEventListener("DOMContentLoaded", () => {
        var reportChart = <?php echo $report_chart; ?>;
        var reportData = Object.values(reportChart);

        // Use short month names based on the data
        var monthNames = Object.keys(reportChart).map(monthNumberToShortName);

        function monthNumberToShortName(monthNumber) {
            // You can customize this mapping based on your preferences
            var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return monthNames[parseInt(monthNumber) - 1];
        }

        echarts.init(document.querySelector("#barChart")).setOption({
            xAxis: {
                type: 'category',
                data: monthNames
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: reportData,
                type: 'bar'
            }]
        });
    });
</script>
            <!-- End Bar Chart -->

        </div>
    </div>
</div>

       
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
    
            
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
    
                <div class="filter">
            
                </div>
    
                <div class="card-body">
                  <h5 class="card-title">Reports by User <span></span></h5>
    
                  <table class="table table-borderless ">
                    <thead>
                      <tr>
                        <th scope="col">Employee</th>
                          <th scope="col">Email</th>
                        <th scope="col">Reports</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
           @foreach($usersWithReports as $report)
                      <tr>
                        <th scope="row">{{$report->first_name ?? '---'}} {{$report->last_name ?? ''}}</th>
                        <td>{{$report->email ?? '---'}}</td>
                         <td>{{$report->reports_count ?? '---'}}</td>
                        <td><span class="badge bg-warning">{{$report->status ?? '---'}}</span></td>
                      </tr>
           @endforeach
                    </tbody>
                  </table>
    
                </div>
    
              </div>
            </div><!-- End Recent Sales -->
    
    
          </div>
        </div><!-- End Left side columns -->
    
        <!-- Right side columns -->
        <div class="col-lg-4">
    
          <!-- Website Traffic -->
          <div class="card">
            <!--<div class="filter">-->
            <!--  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>-->
            <!--  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">-->
            <!--    <li class="dropdown-header text-start">-->
            <!--      <h6>Filter</h6>-->
            <!--    </li>-->
    
            <!--    <li><a class="dropdown-item" href="#">Today</a></li>-->
            <!--    <li><a class="dropdown-item" href="#">This Month</a></li>-->
            <!--    <li><a class="dropdown-item" href="#">This Year</a></li>-->
            <!--  </ul>-->
            <!--</div>-->
    
            <div class="card-body pb-0">
              <h5 class="card-title">Reports by Category <span></span></h5>
    
              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
    
           <script>
        document.addEventListener("DOMContentLoaded", () => {
            var reportNatureData = <?php echo json_encode($reportNatureData); ?>;

            echarts.init(document.querySelector("#trafficChart")).setOption({
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    top: '5%',
                    left: 'center'
                },
                series: [{
                    name: 'Report Nature',
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
                    data: Object.entries(reportNatureData).map(([nature, count]) => ({ value: count, name: nature }))
                }]
            });
        });
    </script>
    
            </div>
          </div>
          <!-- End Website Traffic -->
    
      
    
        </div><!-- End Right side columns -->

      </div>
    

  </div>
</section>

</main><!-- End #main -->
@endsection


