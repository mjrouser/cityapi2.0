@layout('layouts.common')

@section('content')
<div class="container container-root">
    <div class="hero-unit">
        <h2>Logga in på CityAPI</h2>
        <p>Någon lämplig copy.</p>
        <a class="login-with-facebook" href="{{ $loginUrl }}" onclick="window.open(this.href, null, 'left=' + (screen.width / 2 - 640 / 2) + ',top=' + (screen.height / 3 - 310 / 2) + ',width=640,height=310,toolbar=1,resizable=0'); return false;" ></a>
    </div>
</div>
@endsection
