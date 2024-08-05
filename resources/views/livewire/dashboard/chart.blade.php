<div>
    <div class="mt-6"
         x-data="{
            values: [],
            labels: [],
            async init() {
                this.updateChartData(@json($this->chart));
                let chart = new ApexCharts(this.$refs.chart, this.options);
                await chart.render();

                this.$watch('$wire.chart', (newChart) => {
                    this.updateChartData(newChart);
                    chart.updateOptions(this.options).then(r => {});
                });
            },
            updateChartData(chartData) {
                this.values = Object.values(chartData);
                this.labels = Object.keys(chartData);
            },
            get options () {
                return {
                    colors: ['#e63f66'],
                    chart: {
                        type: 'line',
                        width: '100%',
                        height: 450,
                        background: '#fff',
                        foreColor: '#e63f66',
                        colors: '#e63f66',
                        toolbar: {
                            show: false
                        }
                    },
                    tooltip: {
                        marker: false,
                        y: {
                            formatter(number) {
                                return number
                            }
                        },
                        theme: 'light'
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: { categories: this.labels },
                    series: [{
                        name: '{{ __('Subscriptions') }}',
                        data: this.values
                    }]
                }
            }
        }" wire:init="load">
        <x-ui.card wire:loading>
            <x-ui.loading.preloader />
        </x-ui.card>
        <x-ui.card wire:loading.remove>
            <p class="text-xl text-primary font-semibold">@lang('Subscriptions')</p>
            <div x-ref="chart"></div>
        </x-ui.card>
    </div>
</div>
