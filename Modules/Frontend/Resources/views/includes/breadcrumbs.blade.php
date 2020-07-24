@php
    /* @var $breadcrumbs Collection */

        use Illuminate\Support\Collection;
        use Illuminate\Support\Facades\Request;

        $json = [
        '@context'        => 'http://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [],
        ];

        foreach ($breadcrumbs as $i => $breadcrumb) {
        $json['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'item'     => [
                '@id'   => $breadcrumb->url ?: Request::fullUrl(),
                'name'  => $breadcrumb->title,
                'image' => $breadcrumb->image ?? null,
            ],
        ];
        }
@endphp

@if (count($breadcrumbs))
    <nav aria-label="breadcrumb" class="nav-breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                @endif

            @endforeach
        </ol>
    </nav>
    @push('scripts')
        <script type="application/ld+json">
            {!!json_encode($json)!!}
        </script>
    @endpush
@endif
