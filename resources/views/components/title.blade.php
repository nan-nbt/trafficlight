<title>
    @if (Request::segment(3) != null)
        {{ config('app.name', 'Traffic Light System')." - ".Request::segment(3) }}
    @else
        {{ config('app.name', 'Traffic Light System') }}
    @endif
</title>
