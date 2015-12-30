<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.shared.head')
</head>
<body>

<div class="main-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid main-content">
            <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
                @yield('content')
            </div>
        </div>
    </main>
</div>

@include('layouts.shared.footer')
</body>
</html>
