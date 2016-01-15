<!DOCTYPE html>
<html lang="en" ng-app="atypical.app">
<head>
    @include('layouts.shared.head')
</head>
<body>
    <div class="mdl-layout__container">
        <div class="mdl-layout mdl-js-layout">
            <header class="mdl-layout__header ">
                @include('layouts.shared.header')
            </header>
            <div class="mdl-layout__drawer">
                @include('layouts.shared.nav')
            </div>
            <main class="mdl-layout__content">
                @yield('content')
            </main>
        </div>
        @include('layouts.shared.footer')
        @yield('bodyend')
    </div>
</body>
</html>
