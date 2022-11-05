<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Plus Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets')}}/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('assets')}}/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="{{ asset('assets')}}/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('assets')}}/vendors/select2/select2.min.css" />
  <link rel="stylesheet" href="{{asset('assets')}}/vendors/select2-bootstrap-theme/select2-bootstrap.min.css" />
  <link rel="stylesheet" href="{{ asset('assets')}}/vendors/jquery-bar-rating/css-stars.css" />
  <link rel="stylesheet" href="{{ asset('assets')}}/vendors/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{ asset('assets')}}/css/demo_1/style.css" />
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{ asset('assets')}}/images/favicon.png" />

  <link rel="stylesheet" href="{{ asset('assets')}}/css/custom.css" />

  @yield('links')

  @yield('css')
  <style>
    .badge {
      font-size: 12px !important;
      padding: 0.165rem 0.3125rem !important;
    }

    /*loader css*/
    .cover-loader {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .loader,
    .loader:after {
      border-radius: 50%;
      width: 10em;
      height: 10em;
    }

    .loader {
      margin: 60px auto;
      font-size: 4px;
      position: relative;
      text-indent: -9999em;
      border-top: 4px solid #0033c4;
      border-right: 4px solid #0033c4;
      border-bottom: 4px solid #0033c4;
      border-left: 4px solid #ffffff;
      -webkit-transform: translateZ(0);
      -ms-transform: translateZ(0);
      transform: translateZ(0);
      -webkit-animation: load8 1.1s infinite linear;
      animation: load8 1.1s infinite linear;
    }

    .cover-loader-modal {
      display: flex;
      align-items: center;
      justify-content: center;
      height: auto;
    }

    .loader-modal,
    .loader-modal:after {
      border-radius: 50%;
      width: 10em;
      height: 10em;
    }

    .loader-modal {
      margin: 60px auto;
      font-size: 4px;
      position: relative;
      text-indent: -9999em;
      border-top: 4px solid #0033c4;
      border-right: 4px solid #0033c4;
      border-bottom: 4px solid #0033c4;
      border-left: 4px solid #ffffff;
      -webkit-transform: translateZ(0);
      -ms-transform: translateZ(0);
      transform: translateZ(0);
      -webkit-animation: load8 1.1s infinite linear;
      animation: load8 1.1s infinite linear;
    }

    @-webkit-keyframes load8 {
      0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    @keyframes load8 {
      0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }


    .c-text-danger {
      color: red;
      font-size: 12px;
      font-weight: 600;
    }

    .img {
      width: 60px !important;
      height: 50px !important;
      border-radius: 0px !important;
    }
  </style>


@yield('js')
