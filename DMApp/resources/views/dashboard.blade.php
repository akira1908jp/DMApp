<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-notification></x-notification>
                    {{-- 本部ユーザー向けダッシュボード --}}
                    @role('approveAsHq')
                    <div style="width: 80%; margin: auto;">
                        <canvas id="budgetChart"></canvas>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const chartDepartmentLabel = [];
                        const chartTotalBudgetData = [];
                        const chartTotalActualData = [];

                        // 部門名と予算を表示
                        @foreach ($documents as $document)

                            chartDepartmentLabel.push({{ Illuminate\Support\Js::from($document['department_name']) }});
                            chartTotalBudgetData.push({{ Illuminate\Support\Js::from($document['total_budget']) }});

                        @endforeach
                        // 実績額を部門ごとに表示
                        @foreach ($actuals as $actual)
                            chartTotalActualData.push({{ Illuminate\Support\Js::from($actual->total_actual) }});
                        @endforeach


                        const ctx = document.getElementById('budgetChart').getContext('2d');

                        const data = {
                            labels: chartDepartmentLabel,
                            datasets: [
                                {
                                    label: '予算',
                                    data: chartTotalBudgetData,
                                    backgroundColor: 'rgba(200, 200, 200, 0.5)', // 控えめなグレー
                                    borderColor: 'rgba(200, 200, 200, 1)',
                                    borderWidth: 1
                                },

                                {
                                    label: '実績',
                                    data: chartTotalActualData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.7)', // 目立つ青
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }
                            ]
                        };

                        const config = {
                            type: 'bar',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: '部門予算 vs 実績'
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: '金額'
                                        }
                                    }
                                }
                            }
                        };

                        new Chart(ctx, config);
                    </script>
                </div>
            </div>
        </div>
    </div>
    @endrole
</x-app-layout>