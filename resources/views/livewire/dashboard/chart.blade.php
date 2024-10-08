<div>
    <div class="mt-6"
         x-data="{
            values : [{{ collect($this->chart)->map(fn (int $value) => $value)->join(',') }}],
            labels : [{{ collect($this->chart)->keys()->map(fn (string $date, int $value) => "'$date'")->join(',') }}],
            async init() {
                let chart = new ApexCharts(this.$refs.chart, this.options)

                await chart.render()

                this.$watch('$wire.chart', (newChart) => {
                    this.$nextTick(() => {
                        this.updateChartData(newChart);
                        chart.updateOptions(this.options).then(r => {});
                    });
                });
            },
            updateChartData(chartData) {
                if (typeof chartData === 'object' && chartData !== null) {
                    this.values = Object.values(chartData);
                    this.labels = Object.keys(chartData);
                } else {
                    console.error('Invalid chart data:', chartData);
                }
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
                        name: 'Assinaturas',
                        data: this.values
                    }]
                }
            }
        }" wire:init="load">
        <x-ui.card wire:loading>
            <x-ui.loading.preloader />
        </x-ui.card>
        <x-ui.card wire:loading.remove>
            <p class="text-xl text-primary font-semibold">Assinaturas</p>
            <div x-ref="chart"></div>
        </x-ui.card>
    </div>
</div>
