<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.shared.head')
</head>
<body>

<div class="main-layout mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <main class="mdl-layout__content">
        <div class="main-content">
            @yield('content')
        </div>
    </main>
</div>

@include('layouts.shared.footer')
</body>
</html>
