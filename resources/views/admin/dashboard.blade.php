@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-8">
        {{-- Header --}}
        <div>
            <h3 class="text-2xl font-bold mb-2">👋 Selamat Datang, Administrator!</h3>
            <p class="text-slate-500 dark:text-slate-400">
                Ringkasan cepat sistem absensi mahasiswa dan aktivitas terbaru.
            </p>
        </div>

        {{-- Statistik Kartu --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Mahasiswa --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-indigo-600 to-blue-600 text-white p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-indigo-100 uppercase">Total Mahasiswa</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalMahasiswa }}</h4>
                </div>
                <div class="opacity-80">
                    <i class="fas fa-users fa-3x"></i>
                </div>
            </div>

            {{-- Total Dosen --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-green-600 to-emerald-600 text-white p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-emerald-100 uppercase">Total Dosen</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalDosen }}</h4>
                </div>
                <div class="opacity-80">
                    <i class="fas fa-user-tie fa-3x"></i>
                </div>
            </div>

            {{-- Total Mata Kuliah --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-sky-500 to-cyan-500 text-white p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-cyan-100 uppercase">Total Mata Kuliah</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalMataKuliah }}</h4>
                </div>
                <div class="opacity-80">
                    <i class="fas fa-book fa-3x"></i>
                </div>
            </div>

            {{-- Total Absensi Hari Ini --}}
            <div
                class="rounded-xl shadow-sm bg-gradient-to-br from-amber-500 to-yellow-500 text-slate-800 p-5 flex items-center justify-between transition hover:shadow-md">
                <div>
                    <p class="text-sm font-medium text-slate-700 uppercase">Absensi Hari Ini</p>
                    <h4 class="text-3xl font-bold mt-1">{{ $totalAbsensiHariIni }}</h4>
                </div>
                <div class="text-slate-700 opacity-80">
                    <i class="fas fa-check-circle fa-3x"></i>
                </div>
            </div>
        </div>



        {{-- Grafik Statistik --}}
        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4">
                📊 Grafik Total Data
            </h4>
            <div id="dashboardChart"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const seriesData = [
                {{ $totalMahasiswa }},
                {{ $totalDosen }},
                {{ $totalMataKuliah }},
                {{ $totalAbsensiHariIni }}
            ];

            const categories = [
                'Total Mahasiswa',
                'Total Dosen',
                'Total Mata Kuliah',
                'Absensi Hari Ini'
            ];

            const options = {
                chart: {
                    type: 'bar',
                    height: 380,
                    toolbar: {
                        show: false
                    },
                    foreColor: document.documentElement.classList.contains('dark') ?
                        '#cbd5e1' : '#334155',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },

                series: [{
                    name: 'Jumlah',
                    data: seriesData
                }],

                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            fontSize: '13px',
                            fontWeight: 500
                        }
                    }
                },

                yaxis: {
                    labels: {
                        formatter: val => parseInt(val),
                        style: {
                            fontSize: '12px'
                        }
                    }
                },

                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        borderRadius: 10,
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },

                dataLabels: {
                    enabled: true,
                    offsetY: -22,
                    style: {
                        fontSize: '13px',
                        fontWeight: '700',
                        colors: ['#1e293b']
                    },
                    background: {
                        enabled: false,
                        foreColor: '#1e293b',
                        padding: 4,
                        borderRadius: 6,
                        borderWidth: 1,
                        borderColor: '#cbd5e1'
                    }
                },

                tooltip: {
                    theme: 'dark',
                    style: {
                        fontSize: '13px',
                        color: '#fff'
                    },
                    marker: {
                        show: true
                    },
                    fillSeriesColor: false,
                    onDatasetHover: {
                        highlightDataSeries: false
                    }
                },

                colors: [
                    '#6366F1', // indigo
                    '#10B981', // green
                    '#0EA5E9', // sky
                    '#F59E0B' // amber
                ],

                grid: {
                    strokeDashArray: 4,
                    borderColor: document.documentElement.classList.contains('dark') ?
                        '#334155' : '#e2e8f0'
                }
            };

            const chart = new ApexCharts(
                document.querySelector("#dashboardChart"),
                options
            );

            chart.render();
        });
    </script>
@endpush
