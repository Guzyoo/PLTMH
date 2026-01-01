<div wire:poll.3s class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-slate-900">Grafik Tegangan & Arus</h2>
        
        <select wire:model.live="filter" class="text-sm border-slate-200 border rounded-lg px-3 py-1.5 bg-slate-50 text-slate-600 focus:outline-none focus:border-blue-500">
            <option value="hour">1 Jam Terakhir</option>
            <option value="24hours">24 Jam Terakhir</option>
            <option value="7days">7 Hari Terakhir</option>
        </select>
    </div>

    {{-- Container Chart dengan wire:ignore --}}
    <div wire:ignore class="w-full h-80 relative">
        <canvas id="myChart"></canvas>
    </div>

</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
<script>
    let myChart = null;

    // Ambil Data Awal Langsung dari PHP (Tanpa nunggu event)
    // Ini kunci supaya grafik langsung muncul!
    const initialData = @json($chartData);

    Livewire.hook('element.init', () => {
        initChart(initialData);
    });

    function initChart(data) {
        const ctx = document.getElementById('myChart');
        
        // Cek apakah canvas ada & chart belum dibuat
        if(!ctx || myChart) return;

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels, // Pakai data awal
                datasets: [
                    {
                        label: 'Tegangan (V)',
                        data: data.voltages, // Pakai data awal
                        borderColor: 'rgb(234, 179, 8)',
                        backgroundColor: 'rgba(234, 179, 8, 0.1)',
                        yAxisID: 'y',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 2
                    },
                    {
                        label: 'Arus (A)',
                        data: data.currents, // Pakai data awal
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        yAxisID: 'y1',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, 
                animation: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: {
                        ticks: { maxTicksLimit: 8, maxRotation: 0 },
                        grid: { display: false }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Voltage (V)' },
                        suggestedMin: 180,
                        suggestedMax: 250
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Current (A)' },
                        grid: { drawOnChartArea: false },
                        suggestedMin: 0,
                        suggestedMax: 5
                    },
                }
            }
        });
    }

    // Listener untuk Update Data (Polling & Filter)
    Livewire.on('update-chart', (event) => {
        if (!myChart) return;

        // event[0] karena Livewire kirim array, atau event langsung jika dikirim sbg object
        // Kita handle dua kemungkinan biar aman
        const data = Array.isArray(event) ? event[0] : event;

        myChart.data.labels = data.labels;
        myChart.data.datasets[0].data = data.voltages;
        myChart.data.datasets[1].data = data.currents;
        myChart.update();
    });
</script>
@endscript