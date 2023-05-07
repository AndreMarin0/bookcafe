<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Book Collections graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
    
</head>
<body>
    <h1>Book Collections graph</h1>
    
    <div style="width: 700px; height: 700px;">
        <canvas id="myChart"></canvas>
    </div>
    
      <script>
        const ctx = document.getElementById('myChart').getContext('2d');
    
        // Group the books by genre and count the number of books in each group
        const genres = {!! json_encode($collections->groupBy('genre.Genre')->map->count()) !!};
    
        // Create an array of labels and data from the grouped data
        const labels = Object.keys(genres);
        const data = Object.values(genres);
    
        const backgroundColor = [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
        ];
    
        const chartData = {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColor
            }]
        };
    
        const chartConfig = {
            type: 'pie',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Books by Genre',
                        color: '#000000'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.formattedValue || '';
                                var percentage = context.chart.data.datasets[0].data[context.dataIndex];
                                percentage = '(' + ((percentage / data.reduce((a, b) => a + b, 0)) * 100).toFixed(2) + '%)';
                                return label + ': ' + value + ' ' + percentage;
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'right',
                        align: 'start',
                        labels: {
                            usePointStyle: true,
                            generateLabels: function(chart) {
                                const labels = chart.data.labels;
                                const datasets = chart.data.datasets;
                                const total = data.reduce((a, b) => a + b, 0);
                                let legendItems = [];
    
                                labels.forEach(function(label, index) {
                                    const backgroundColor = datasets[0].backgroundColor[index];
                                    const value = datasets[0].data[index];
                                    const percentage = ((value / total) * 100).toFixed(2);
    
                                    legendItems.push({
                                        text: label + ' (' + percentage + '%)',
                                        fillStyle: backgroundColor,
                                        hidden: false,
                                        index: index
                                    });
                                });
    
                                return legendItems;
                            }
                        }
                    }
                }
            }
        };
   
    const myChart = new Chart(ctx, chartConfig);   
    </script>

</body>
</html>
