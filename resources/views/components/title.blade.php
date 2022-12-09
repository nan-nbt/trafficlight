<title>
    @if (Request::segment(0) != null || Request::segment(1) != null || Request::segment(2) != null)
        {{ config('app.name', 'Traffic Light System')." - ".Request::segment(0).Request::segment(2) }}
    @else
        {{ config('app.name', 'Traffic Light System') }}
    @endif
</title>
