@extends('layouts.layout', [
    'title' => 'Производительность индеков'
])

@section('content')
    <h1>Производительность индеков</h1>

    <p>
        Для тестирования производительности индексов был использован инструмент <a href="https://k6.io/">k6</a>.
        <br>
        Тесты проводились в 10 потоков, в течении 10 секунд.
        <br>
        Конфигурация MySql по дефолту.
        <br>
        Сервер с одним ядром 2.8 ГГц и 2 ГБ ОЗУ.
    </p>

    <h2>Первый тест</h2>
    <p>
        Первый тест для сравнения, только вывод последних пользователей без поиска
    </p>

    <h2>Второй тест</h2>
    <p>
        Поиск по имени и фамилии без индексов
    </p>

    <h2>Третий тест</h2>
    <p>
        Поиск по имени и фамилии с одним индексом по имени
    </p>

    <h2>Четвертый тест</h2>
    <p>
        Поиск по имени и фамилии с двумя индексами, один по имени, другой по фамилии
    </p>

    <canvas id="latency"></canvas>

    <canvas id="throughput"></canvas>

    <h2>Выводы</h2>

    <ul>
        <li>Одного индекса для поиска через OR недостаточно, индекс полностью игнорируется</li>
        <li>Поиск с двумя индексами работает почти так же быстро, как просто вывод пользователей</li>
    </ul>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>

    <script>
        window.addEventListener('load', function () {
            Promise.all([
                fetch('{{ asset('storage/performance/base.json') }}').then(resp => resp.json()),
                fetch('{{ asset('storage/performance/search-1.json') }}').then(resp => resp.json()),
                fetch('{{ asset('storage/performance/search-2.json') }}').then(resp => resp.json()),
                fetch('{{ asset('storage/performance/search-3.json') }}').then(resp => resp.json()),
            ]).then(response => {
                let testBase = response[0],
                    testSearch1 = response[1],
                    testSearch2 = response[2],
                    testSearch3 = response[3];

                let latencyData = {
                        min: [],
                        avg: [],
                        max: [],
                    },
                    throughputData = {
                        rate: [],
                        count: [],
                    };

                response.forEach(fileData => {
                    latencyData.min.push(Math.round(fileData.metrics.http_req_duration.min * 100) / 100);
                    latencyData.avg.push(Math.round(fileData.metrics.http_req_duration.avg * 100) / 100);
                    latencyData.max.push(Math.round(fileData.metrics.http_req_duration.max * 100) / 100);

                    throughputData.rate.push(Math.round(fileData.metrics.iterations.rate * 100) / 100);
                    throughputData.count.push(Math.round(fileData.metrics.iterations.count * 100) / 100);
                })


                new Chart(document.getElementById('latency'), {
                    type: 'bar',
                    data: {
                        labels: ['Первый тест', 'Второй тест', 'Третий тест', 'Четвертый тест'],
                        datasets: [
                            {
                                label: 'min',
                                backgroundColor: 'rgb(75, 192, 192)',
                                data: latencyData.min,
                            },
                            {
                                label: 'avg',
                                backgroundColor: 'rgb(54, 162, 235)',
                                data: latencyData.avg,
                            },
                            {
                                label: 'max',
                                backgroundColor: 'rgb(255, 99, 132)',
                                data: latencyData.max,
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'latency (ms)'
                        }
                    }
                });

                new Chart(document.getElementById('throughput'), {
                    type: 'bar',
                    data: {
                        labels: ['Первый тест', 'Второй тест', 'Третий тест', 'Четвертый тест'],
                        datasets: [
                            {
                                label: 'rate',
                                backgroundColor: 'rgb(54, 162, 235)',
                                data: throughputData.rate
                            },
                            {
                                label: 'count',
                                backgroundColor: 'rgb(75, 192, 192)',
                                data: throughputData.count
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'throughput'
                        }
                    }
                });
            });
        });
    </script>

@endsection
