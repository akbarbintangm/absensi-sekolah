<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
    @include(backpack_view('inc.head'))

    <style>
        .auth-background {
            background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=628&q=80');

            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

    </style>
</head>

<body>

    <div class="row h-100">
        <div class="col-6 auth-background">
        </div>
        <div class="col-12 col-lg-6" style="background: white">
            <div class="app flex-row align-items-center">
                @yield('header')
                <div class="container">
                    @yield('content')
                </div>
                <footer class="app-footer sticky-footer">
                    @include('backpack::inc.footer')
                </footer>
            </div>
        </div>
    </div>


    @yield('before_scripts')
    @stack('before_scripts')

    @include(backpack_view('inc.scripts'))

    @yield('after_scripts')
    @stack('after_scripts')

</body>

</html>
