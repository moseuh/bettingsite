
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$page_title}} | {{$basic->sitename}}</title>

    <link rel="shortcut icon" href="{{asset('public/images/logo/favicon.png')}}">
    <!-- End layout styles -->
    <link rel="stylesheet" href="{{asset('public/admin/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/css/custom.css')}}">
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper content-wrapper-form d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{asset('public/images/logo/footer-logo.png')}}">
                </div>
                
                <h4 class="text-center">{{$page_title}}</h4>

                @include('errors.error')

                @if (session('ok'))
                  <div class="alert alert-success alert-dismissible" >
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{ session('ok') }}
                  </div>
                @endif


                @if (session('alert'))
                  <div class="alert alert-danger alert-dismissible" >
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{ session('alert') }}
                  </div>
                @endif




               @yield('content')
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="{{asset('public/admin/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('public/admin/js/off-canvas.js')}}"></script>
    
    <script src="{{asset('public/admin/js/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('public/admin/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('public/admin/js/misc.js')}}"></script>
    <script src="{{asset('public/admin/js/custom.js')}}"></script>

    @include('partials.notify')

@yield('script')
    <!-- endinject -->
  </body>
</html>