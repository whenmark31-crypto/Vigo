@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card stat-card text-white h-100" style="background:#e94560">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-people-fill fs-1 flex-shrink-0"></i>
                <div class="overflow-hidden">
                    <div class="fs-2 fw-bold lh-1">{{ $totalUsers }}</div>
                    <div class="opacity-75 small mt-1">Total Users</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card stat-card text-white h-100" style="background:#0f3460">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-motherboard-fill fs-1 flex-shrink-0"></i>
                <div class="overflow-hidden">
                    <div class="fs-2 fw-bold lh-1">{{ $totalParts }}</div>
                    <div class="opacity-75 small mt-1">Total PC Parts</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card stat-card text-white h-100" style="background:#16213e">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-box-seam-fill fs-1 flex-shrink-0"></i>
                <div class="overflow-hidden">
                    <div class="fs-2 fw-bold lh-1">{{ $myParts }}</div>
                    <div class="opacity-75 small mt-1">My PC Parts</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold border-0 pb-0">Parts by Category</div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height:260px">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold border-0 pb-0">Monthly Parts Added ({{ date('Y') }})</div>
            <div class="card-body" style="min-height:260px">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const categoryLabels = @json($categoryData->keys());
const categoryValues = @json($categoryData->values());

new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: categoryLabels,
        datasets: [{ data: categoryValues, backgroundColor: ['#e94560','#0f3460','#16213e','#533483','#2b9348','#f4a261','#e76f51','#4cc9f0','#f72585','#7209b7'] }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
    }
});

const monthlyRaw = @json($monthlyData);
const monthlyValues = months.map((_, i) => monthlyRaw[i+1] || 0);

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{ label: 'Parts Added', data: monthlyValues, backgroundColor: '#e94560', borderRadius: 5 }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endsection
