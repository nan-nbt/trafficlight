<div>
    <!-- It is never too late to be what you might have been. - George Eliot -->
    <h1>Test Component</h1>
    <h2>Passing data: {{ $name }}</h2>
    <ul>
        @foreach ($section as $sec)
            <li>Section Data: {{ $sec->sec_no }}</li>
        @endforeach
    </ul>
</div>
