<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/bootstrap-select-1.13.14/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}" >
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/DataTables/datatables.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('vendors/user-friendly-time-picker/css/timepicker.min.css') }}" >

    @yield('css')

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script>
        const rootPath = "{{ url('/') }}";
    </script>
</head>
<body>
    <div id="app">
        @includeIf('partials.nav')

        <main class="py-4">
            <div class="container">
                @include('flash::message')
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @yield("content")
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-select-1.13.14/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="{{ asset('vendors/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery_chained-2.x/jquery.chained.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery_chained-2.x/jquery.chained.remote.min.js') }}"></script>
    <script src="{{ asset('vendors/user-friendly-time-picker/js/timepicker.min.js') }}"></script>
    @yield('script')
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        $('#flash-overlay-modal').modal();
    </script>
</body>
</html>
