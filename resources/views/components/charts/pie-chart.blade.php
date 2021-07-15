@props(['id', 'title' => '', 'chart', 'height' => '400px', 'colors' => ['#aef', '#eda', '#fcd', '#bfe', '#abc', '#ccb', '#dfd'], 'params' => []])

<div id="{{ $id }}" style="height: {{ $height }}"></div>

@once
    @push('after-scripts')
        <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
        <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    @endpush
@endonce

@push('after-scripts')
<script>
    var queryParams = new URLSearchParams(@json($params));

    window[@json($id)] = new Chartisan({
        el: '#' + @json($id),
        url: '@chart($chart)',
        loader: {
            color: '#071c30',
            size: [30, 30],
            type: 'bar',
            textColor: '#000',
            text: 'Chargement des données...',
        },
        error: {
            color: '#071c30',
            size: [30, 30],
            text: 'Oh oh! Une erreur est survenue...',
            textColor: '#000',
            type: 'general',
        },
        hooks: new ChartisanHooks()
            .pieColors(@json($colors))
            .datasets('pie')
            .responsive()
            .legend({ position: 'bottom' })
    });

    window.addEventListener(`update-chart-${@json($chart)}`, function (event) {
        var defaultParams = @json($params);
        var queryParams = new URLSearchParams({ ...defaultParams, year: event.detail.year });

        console.log(event.detail.chart)
        window[event.detail.chart].update({
            url: '@chart($chart)' + `?${queryParams}`
        })
    })
</script>
@endpush
