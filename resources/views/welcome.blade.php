<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Info Data Covid-19</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/admin-lte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin-lte/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/admin-lte/plugins/summernote/summernote-bs4.css">
  <!-- Leaflet -->
  <link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet" />
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style type="text/css">
    .custom {
        font-size: 12px;
        font-family: Arial;
    }
    .bottomcustom, .topcustom {
        font-size: 12px;
        font-family: Arial;
        width: 100%;

    }
  </style>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{-- {{ config('app.name', 'Laravel') }} --}}
            Monitoring Covid
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> <small>Data Statistik</small> Covid-19</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="col-lg-12">
         @foreach ($suspect_indo as $datas)  
          <div class="row">
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $datas['positif'] }}</h3>
    
                    <p>POSITIF</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $datas['sembuh'] }}</h3>

                    <p>SEMBUH</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $datas['meninggal'] }}</h3>

                    <p>MENINGGAL</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                </div>
            </div>
          </div>
          @endforeach
          <!-- /.row -->
          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-globe mr-1"></i>
                        Peta Sebaran Kasus Per Provinsi
                      </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div id="mapid" style="width: 100%; height: 400px;"></div>
                        <script>
                           var mymap = L.map('mapid').setView([-0.4690016,117.1550653,17], 5);
                        
                           L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                              maxZoom: 18,
                              attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                                 '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                                 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                              id: 'mapbox/dark-v10',
                           }).addTo(mymap);
                           @foreach ($location_indo['features'] as $value) {
                              L.marker(["{{$value['geometry']['y']}}","{{$value['geometry']['x']}}"]).addTo(mymap)
                              .bindPopup("<b>Provinsi : " + "{{$value['attributes']['Provinsi']}}" + "</b><br>" +
                              "Positif : " + "{{$value['attributes']['Kasus_Posi']}}" + "<br>" +
                              "Sembuh : " + "{{$value['attributes']['Kasus_Semb']}}" + "<br>" +
                              "Meninggal : " + "{{$value['attributes']['Kasus_Meni']}}" + "<br>"
                              );
                           }
                           @endforeach
                        </script>
                    </div><!-- /.card-body -->
                </div>
            </div>
          </div>

          <!-- /.row -->
          <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Grafik Kasus Per Provinsi
                      </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div style="height: 610px; width: 100%">
                            {!! $chart->container() !!}
                            {!! $chart->script() !!}
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-table mr-1"></i>
                        Tabel Data Kasus
                      </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover display compact custom" cellspacing="0" width="100%" id="laravel_datatable">
                            <thead>
                               <tr>
                                  <!--<th>FID</th>-->
                                  <th>Provinsi</th>
                                  <th>Positif</th>
                                  <th>Sembuh</th>
                                  <th>Meninggal</th>
                               </tr>
                            </thead>
                         </table>
                    </div><!-- /.card-body -->
                </div>
            </div>
          </div>
          <!-- /.row -->
                    <!-- /.row -->
          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Grafik Perkembangan Jumlah Kumulatif Kasus
                      </h3>
                    </div>
                    <div class="card-body">
                        <div style="height: 500px; width: 100%">
                            {!! $chart_stat->container() !!}
                            {!! $chart_stat->script() !!}
                        </div>
                    </div><!-- /.card-body -->
                </div>
              </div>
          </div> 
        <div class="row">
          <div class="col-md-12">
            <figure class="highcharts-figure">
              <div id="container2"></div>
            </figure>
          </div>
        </div>   
        <div class="row">
          <div class="col-md-12">
            <figure class="highcharts-figure">
              <div id="container3"></div>
            </figure>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-header">
                    <h3 class="card-title" style="width: 100%">
                      <i class="fas fa-user mr-1"></i>
                      Tabel Contact Person Covid - 19 
                      <button class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#exampleModal">+Tambah Kontak</button>
                    </h3>
                  </div>
                  <div class="card-body">
                      <div>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Provinsi</th>
                              <th scope="col">URL</th>
                              <th scope="col">PHONE</th>
                              <th scope="col">ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($contacts as $contact)
                            <tr>
                              <th scope="row">{{$loop->iteration}}</th>
                              <td>{{$contact->provinsi}}</td>
                              <td>{{$contact->url}}</td>
                              <td>{{$contact->no_telp}}</td>
                              <td style="display: flex"><a href="#" data-toggle="modal" data-record-id="{{ $contact->id }}" data-target="#confirm-delete"><span class="badge bg-red"><i class="fa fa-trash"></i></span></a></td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div><!-- /.card-body -->
              </div>
            </div>
        </div>    
        </div>
        <!-- /.col-md-12 -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kontak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('store-contact') }}" method="POST">
        <div class="modal-body">@csrf
            <div class="form-group">
              <label for="provinsi">Provinsi</label>
              <input type="text" class="form-control" name="provinsi" id="provinsi"  placeholder="Provinsi">
            </div>
            <div class="form-group">
              <label for="provinsi">URL</label>
              <input type="text" class="form-control" name="url" id="url"  placeholder="URL">
            </div>
            <div class="form-group">
              <label for="provinsi">No Telp</label>
              <input type="text" class="form-control" name="telp" id="telp"  placeholder="No Telp">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form action="">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  Are You Sure to Delete This Data?
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-danger btn-ok">Delete</button>
              </div>
          </form>
      </div>
  </div>
</div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/admin-lte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin-lte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin-lte/dist/js/adminlte.min.js"></script>
<!-- ChartJS -->
<script src="/admin-lte/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin-lte/dist/js/adminlte.js"></script>
<!-- DataTables -->
<script src="/admin-lte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin-lte/dist/js/demo.js"></script>
<!-- Summernote -->
<script src="/admin-lte/plugins/summernote/summernote-bs4.min.js"></script>

{{-- START HIGHCHART JS --}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

{{-- END HIGHCHART JS --}}
<script>
  $('#confirm-delete').on('click', '.btn-ok', function(e) {
      var $modalDiv = $(e.delegateTarget);
      var id = $(this).data('recordId');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.post('/deleteContact/' + id).then()
      $modalDiv.addClass('loading');
      setTimeout(function() {
          $modalDiv.modal('hide').removeClass('loading');
          setTimeout(function(){// wait for 5 secs(2)
              location.reload(); // then reload the page.(3)
          }, 1000); 
          
      })
  });
  $('#confirm-delete').on('show.bs.modal', function(e) {
      var data = $(e.relatedTarget).data();
      $('.title', this).text(data.recordTitle);
      $('.btn-ok', this).data('recordId', data.recordId);
  });
</script>

  <script>
    $(document).ready( function () {
     $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('https://immense-chamber-80308.herokuapp.com/coronas-list') }}",
            order: [[ 1 , "desc" ]], 
            columns: [
                     //{ data: 'attributes.FID'},
                     { data: 'attributes.Provinsi' },
                     { data: 'attributes.Kasus_Posi' },
                     { data: 'attributes.Kasus_Semb' },
                     { data: 'attributes.Kasus_Meni'}
                  ],
                "dom": '<"topcustom"fr>t<"bottomcustom"ip>'
    });
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $.ajax({
        type: "GET",
        url: '/provincechart/',
        success: function(response){
          console.log(response)
            // Create the chart
            Highcharts.chart('container2', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '5 Besar Kasus Per Provinsi Terbesar'
                },
                xAxis: {
                    categories: response.data.nama_provinsi,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    },
                    series: {
                        pointWidth: 20
                    }
                },
                series: [
                  {
                    name: 'Jumlah Kasus',
                    data: response.data.jumlah_kasus,
                },
                  {
                    name: 'Jumlah Kematian',
                    data: response.data.jumlah_mati,
                },
                  {
                    name: 'Jumlah Sembuh',
                    data: response.data.jumlah_sembuh,
                },
                ]
            });
        },
        error: function (data) {
                console.log(data);
          }
      });
    $.ajax({
        type: "GET",
        url: '/provinceLowestChart/',
        success: function(response){
          console.log(response)
            // Create the chart
            Highcharts.chart('container3', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '5 Besar Kasus Per Provinsi Terkecil'
                },
                xAxis: {
                    categories: response.data.nama_provinsi,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    },
                    series: {
                        pointWidth: 20
                    }
                },
                series: [
                  {
                    name: 'Jumlah Kasus',
                    data: response.data.jumlah_kasus,
                },
                  {
                    name: 'Jumlah Kematian',
                    data: response.data.jumlah_mati,
                },
                  {
                    name: 'Jumlah Sembuh',
                    data: response.data.jumlah_sembuh,
                },
                ]
            });
        },
        error: function (data) {
                console.log(data);
          }
      });
    });
  </script>
</body>
</html>
