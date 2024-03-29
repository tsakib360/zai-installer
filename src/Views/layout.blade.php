<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('files/favicon.png') }}" type="image/x-icon">
    <title>@yield('title') | {{__('Zai-Installer')}} </title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('stavfiles/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stavfiles/assets/style.css') }}">
</head>
<body>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-8">
                    <div class="breadcrumb-text">
                        <a class="brand-logo" href="javascript:void(0)"><img src="{{ asset('stavfiles/assets/images/logo.png') }}" alt="logo" /></a>
                        <h2>{{__('Zai Installer - A Laravel Web Installer')}}</h2>
                        <p>{{ \Carbon\Carbon::parse(now())->format('l, j F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pre-installation-area">
        <div class="container">
            <div class="section-wrap">
                <div class="section-wrap-header">
                    <div class="progres-stype">
                        <div class="single-stype {{ Route::is('ZaiInstaller::pre-install') ? 'active' : 'finished' }}">
                            <span>{{__('Pre-Installation')}}</span>
                        </div>
                        <div class="single-stype {{ Route::is('ZaiInstaller::pre-install') ? '' : 'active' }}">
                            <span>{{__('Configuration')}}</span>
                        </div>
                        <div class="single-stype">
                            <span>{{__('Finish')}}</span>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('stavfiles/assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
