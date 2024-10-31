    var ctx = document.getElementById('donutChart').getContext('2d');
    var donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Envoie', 'Créditer', 'Retrait 2'],
            datasets: [{
                data: [40, 30, 30], // Adjust these values for the chart
                backgroundColor: ['#00a9ff', '#d1d5db', '#83d1d4'],
                borderWidth: 1
            }]
        },
        options: {
            cutoutPercentage: 70, // Creates a donut shape
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false // Hides default legend as we have our custom one
            }
        }
    });

    const ctxTransaction = document.getElementById('transactionChart').getContext('2d');
    const transactionChart = new Chart(ctxTransaction, {
        type: 'pie', // Type de graphique, modifiable
        data: {
            labels: {!! json_encode($months) !!}, // Utilisez {!! ... !!} au lieu de @json
            datasets: [{
                label: 'Total des Transactions',
                data: {!! json_encode($totals) !!}, // Utilisez {!! ... !!} au lieu de @json
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Bilan des Transactions par Mois'
                }
            }
        }
    });
