<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.shared.head')
</head>
<body>

<div class="main-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <header class="main-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        @include('layouts.shared.header')
    </header>
    <div class="main-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        @include('layouts.shared.drawer')
        @include('layouts.shared.nav')
    </div>
    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="main-content">
            @yield('content')
        </div>
    </main>
</div>

@include('layouts.shared.footer')
</body>
</html>
