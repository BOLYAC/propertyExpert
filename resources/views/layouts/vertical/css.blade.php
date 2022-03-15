<!-- Google font-->
<link
    href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&amp;display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap"
      rel="stylesheet">
<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">
<!-- Plugins css start-->
@yield('style_before')
<!-- Plugins css Ends-->
<!-- Font Awesome-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/fontawesome.css')}}">
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/icofont.css')}}">
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/themify.css')}}">
<!-- Flag icon-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/flag-icon.css')}}">
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/feather-icon.css')}}">
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{asset('assets/css/color-1.css')}}" media="screen">
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
<style>
    .digit,
    .dig {
        float: left;
        padding: 10px 30px;
        width: 30px;
        font-size: 1.5rem;
        cursor: pointer;
        font-weight: 600;
    }

    .sub {
        font-size: 0.8rem;
        color: grey;
    }

    .container-calls {
        width: 295px;
        padding: 10px;
        margin: 10px 10px 10px 10px;
        text-align: center;
    }

    #output {
        font-size: 1.5rem;
        height: 60px;
        font-weight: 600;
        color: #1067be;
    }

    #click2call {
        display: inline-block;
        background-color: #66bb6a;
        padding: 4px 30px;
        margin: 10px;
        color: white;
        border-radius: 4px;
        float: left;
        cursor: pointer;
    }

    #endCall {
        display: inline-block;
        background-color: #cc140e;
        padding: 4px 30px;
        margin: 10px;
        color: white;
        border-radius: 4px;
        float: left;
        cursor: pointer;
    }

    .botrow {
        margin: 0 auto;
        width: 100%;
        clear: both;
        text-align: center;
        font-family: 'Exo';
    }

    .digit:active,
    .dig:active {
        background-color: #e6e6e6;
    }

    #click2call:hover {
        background-color: #81c784;
    }

    .dig {
        float: left;
        padding: 10px 20px;
        width: 30px;
        cursor: pointer;
    }

    .customizer-contain .customizer-body {
        max-height: calc(100vh - 100px) !important;
        padding: 10px 0 !important;
        overflow-y: auto!important;
    }
</style>
@yield('style_after')
