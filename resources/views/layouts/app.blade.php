<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ __('Daeng Kurir Makasar') }}</title>
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dkm.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('dkm.png') }}">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="{{ asset('material2') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <!-- <link href="{{ asset('material2') }}/css/material-kit.css?v=1.2.1" rel="stylesheet" /> -->
  <!-- <link href="{{ asset('material2') }}/css/bootstrap.min.css" rel="stylesheet" /> -->
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ asset('material2') }}/demo/demo.css" rel="stylesheet" />
  <link href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
  <style>
    .scrollable-menu {
      height: auto;
      max-height: 200px;
      overflow-x: hidden;
    }
  </style>
  @stack('css')
</head>

<body class="{{ $class ?? '' }}">
  @auth()
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  @include('layouts.page_templates.auth')
  @endauth
  @guest()
  @include('layouts.page_templates.guest')
  @endguest
  @if (auth()->check())
  <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Sidebar Filters</li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger active-color">
            <div class="badge-colors ml-auto mr-auto">
              <span class="badge filter badge-purple " data-color="purple"></span>
              <span class="badge filter badge-azure" data-color="azure"></span>
              <span class="badge filter badge-green" data-color="green"></span>
              <span class="badge filter badge-warning active" data-color="orange"></span>
              <span class="badge filter badge-danger" data-color="danger"></span>
              <span class="badge filter badge-rose" data-color="rose"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="header-title">Images</li>
        <li class="active">
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="{{ asset('material2') }}/img/sidebar-1.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="{{ asset('material2') }}/img/sidebar-2.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="{{ asset('material2') }}/img/sidebar-3.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="{{ asset('material2') }}/img/sidebar-4.jpg" alt="">
          </a>
        </li>

      </ul>
    </div>
  </div>
  @endif
  <!--   Core JS Files   -->
  <script src="{{ asset('material2') }}/js/core/jquery.min.js"></script>
  <!-- <script src="{{ asset('material2') }}/js/bootstrap.min.js"></script> -->
  <script src="{{ asset('material2') }}/js/core/popper.min.js"></script>
  <script src="{{ asset('material2') }}/js/core/bootstrap-material-design.min.js"></script>
  <script src="{{ asset('material2') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

  <!-- Plugin for the momentJs  -->
  <script src="{{ asset('material2') }}/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="{{ asset('material2') }}/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="{{ asset('material2') }}/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="{{ asset('material2') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="{{ asset('material2') }}/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="{{ asset('material2') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="{{ asset('material2') }}/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="{{ asset('material2') }}/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="{{ asset('material2') }}/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="{{ asset('material2') }}/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="{{ asset('material2') }}/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="{{ asset('material2') }}/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="{{ asset('material2') }}/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE'"></script>
  <!-- Chartist JS -->
  <script src="{{ asset('material2') }}/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('material2') }}/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('material2') }}/js/material-dashboard.js" type="text/javascript"></script>
  <!-- <script src="{{ asset('material2') }}/js/material-kit.js?v=1.2.1" type="text/javascript"></script> -->
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{ asset('material2') }}/demo/demo.js"></script>
  <script src="{{ asset('material') }}/js/settings.js"></script>
  <!-- select COALESCE(count(id),0) as count ,date_sub(now(),INTERVAL 1 WEEK) as date from orders where order_statuses_id = 5 and category_id 
  = 1 AND created_at between date_sub(now(),INTERVAL 1 WEEK) and now() GROUP BY date(created_at) ORDER BY `orders`.`created_at` DESC -->
  <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.min.js" integrity="sha512-i8ERcP8p05PTFQr/s0AZJEtUwLBl18SKlTOZTH0yK5jVU0qL8AIQYbbG5LU+68bdmEqJ6ltBRtCxnmybTbIYpw==" crossorigin="anonymous"></script>  
  <script>
    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }

      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
      return prefix == undefined ? rupiah : rupiah ? rupiah : "";
    }
  </script>
  <script>
    //Notification objects have a close() method. SOME browser automatically close them.
    //Notification Events - click, error, close, show
    if ('Notification' in window) {

      if (Notification.permission === 'granted') {
        // If it's okay let's create a notification
        // doNotify();
        loadDoc()
      } else {
        //notification == denied
        Notification.requestPermission()
          .then(function(result) {
            console.log(result); //granted || denied
            if (Notification.permission == 'granted') {
              // doNotify();
              loadDoc()
            }
          })
          .catch((err) => {
            console.log(err);
          });
      }

    }

    function doNotify() {
      let title = "Hallo Admin !";
      let t = Date.now() + 120000; //2 mins in future
      let options = {
        body: 'Ada Orderan Untuk Admin nih !',
        data: {
          prop1: 123,
          prop2: "Admin"
        },
        lang: 'en-CA',
        icon: 'https://daengkurir.online/wp-content/uploads/2021/08/cropped-dkm-logo.png',
        timestamp: t,
        vibrate: [100, 200, 100]
      }
      let n = new Notification(title, options);

      n.addEventListener('show', function(ev) {
        // console.log('SHOW', ev.currentTarget.data);
      });
      n.addEventListener('close', function(ev) {
        //    console.log('CLOSE', ev.currentTarget.body); 
      });
      n.onclick = (e) => {
        // window.location.href = "https://daengkurir.online/test/admin_dummy/#/orders/express/";
        window.open('https://daengkurir.online/admin2/#/orders/express/', '_blank');
      }
      setTimeout(n.close.bind(n), 5000); //close notification after 3 seconds
    }
    /*************
        Note about actions param - used with webworkers/serviceworkers
        actions: [
           {action: 'mail', title: 'e-mail', icon: './img/envelope-closed-lg.png'},
           {action: 'blastoff', title: 'Blastoff', icon: './img/rocket-lg.png'}]
       *********************/
  </script>
  <script type="text/javascript">
    function loadDoc() {
      setInterval(function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("noti_number").innerHTML = this.responseText;
            document.getElementById("noti_number_count").innerHTML = this.responseText;
            checkCookie();
          }
        };
        xhttp.open("GET", "https://daengkurir.online/test/api/getCountAdminOrder", true);
        xhttp.send();
      }, 1000);
    }
    loadDoc();
  </script>
  <script>
    function setCookie(cname, cvalue, exdays) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      let expires = "expires=" + d.toGMTString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    function playSound() {
      var audio = new Audio('sound.ogg');
      audio.play();
      //    alert('play');
    }

    function checkCookie() {
      let user = getCookie("counting");
      if (user != "") {
        // alert("jmlh order " + user);
        document.getElementById("get_cookie").innerHTML = user;
        let count = document.getElementById("noti_number").innerHTML;
        if (user != count) {
          if (user < count) {
            doNotify();
            playSound();
          }

          setCookie("counting", count, 30);
        }

      } else {
        //  user = prompt("Please enter your name:","");
        let order = document.getElementById("noti_number").innerHTML;
        if (order != "" && order != null) {
          setCookie("counting", order, 30);
        }

      }
    }
  </script>
  @stack('js')
</body>

</html>