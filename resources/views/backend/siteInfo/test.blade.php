<div class="container">
    <ul>
        @foreach ($infoSites as $infoSite)
            <li>{{ $infoSite->site_code }}</li>
        @endforeach
    </ul>
</div>
{!! $infoSites->render() !!}