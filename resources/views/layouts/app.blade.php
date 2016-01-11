<!DOCTYPE html>
<html lang="en" ng-app="atypical.app">
<head>
    @include('layouts.shared.head')
</head>
<body>
    <div class="main-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
        <header class="main-header mdl-layout__header mdl-color-text-">
            @include('layouts.shared.header')
        </header>
        <div class="main-drawer mdl-layout__drawer mdl-color--blue-600 mdl-color-text--white">
            @include('layouts.shared.drawer')
            @include('layouts.shared.nav')
        </div>
        <main class="mdl-layout__content">
            @yield('content')
        </main>
    </div>
    @include('layouts.shared.footer')
    @yield('bodyend')
</body>
</html>
