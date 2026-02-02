@extends('layouts.app')

@section('title', 'پنل مدیریت')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <h2 class="mb-4"><i class="bi bi-graph-up"></i> پنل مدیریت - گزارش آماری</h2>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-people" style="font-size: 3rem; color: #667eea;"></i>
                        <h3 class="mt-3">{{ $totalUsers }}</h3>
                        <p class="text-muted mb-0">کل کاربران</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-journal-text" style="font-size: 3rem; color: #764ba2;"></i>
                        <h3 class="mt-3">{{ $totalNotes }}</h3>
                        <p class="text-muted mb-0">کل یادداشت‌ها</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-person-check" style="font-size: 3rem; color: #f093fb;"></i>
                        <h3 class="mt-3">{{ $usersWithNotes }}</h3>
                        <p class="text-muted mb-0">کاربران فعال</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-bar-chart"></i> یادداشت‌های ایجاد شده (30 روز گذشته)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="notesChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-person-plus"></i> کاربران ثبت‌نام شده (30 روز گذشته)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="usersChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribution Chart -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-pie-chart"></i> توزیع یادداشت‌ها بر اساس تعداد</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="distributionChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-trophy"></i> برترین کاربران</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رتبه</th>
                                        <th>نام کاربر</th>
                                        <th>ایمیل</th>
                                        <th>تعداد یادداشت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topUsers as $index => $user)
                                        <tr>
                                            <td>
                                                @if($index == 0)
                                                    <i class="bi bi-trophy-fill text-warning"></i> 1
                                                @elseif($index == 1)
                                                    <i class="bi bi-trophy-fill text-secondary"></i> 2
                                                @elseif($index == 2)
                                                    <i class="bi bi-trophy-fill text-danger"></i> 3
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><span class="badge bg-primary">{{ $user->notes_count }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Notes Chart
const notesCtx = document.getElementById('notesChart').getContext('2d');
const notesChart = new Chart(notesCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($notesPerDay->pluck('date')) !!},
        datasets: [{
            label: 'تعداد یادداشت',
            data: {!! json_encode($notesPerDay->pluck('count')) !!},
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Users Chart
const usersCtx = document.getElementById('usersChart').getContext('2d');
const usersChart = new Chart(usersCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($usersPerDay->pluck('date')) !!},
        datasets: [{
            label: 'تعداد کاربر',
            data: {!! json_encode($usersPerDay->pluck('count')) !!},
            backgroundColor: 'rgba(40, 167, 69, 0.8)',
            borderColor: 'rgb(40, 167, 69)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Distribution Chart
const distCtx = document.getElementById('distributionChart').getContext('2d');
const distributionChart = new Chart(distCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($notesDistribution->pluck('range')) !!},
        datasets: [{
            data: {!! json_encode($notesDistribution->pluck('count')) !!},
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(118, 75, 162, 0.8)',
                'rgba(240, 147, 251, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
@endsection

