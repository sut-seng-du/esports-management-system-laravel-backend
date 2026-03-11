<style>

.card {
    padding: 10px;

}
.card-in-chart{
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 20px;
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.02);
}
.card-in-chart:hover {
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}
.chart-title {
    font-weight: 700;
    font-size: 16px;
    color: #333;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

 .matrix-chart {
    position: relative;
    width: 100%;
    height: 420px;
 }

 @media (max-width: 767px) {
    .matrix-chart {
        height: 320px;
    }
 }

</style>

<div class="container-fluid dashboard-charts-container">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Daily Total Incomes</div>
                <canvas id="barChart1"></canvas>
                <div class="text-center mt-3">
                    <button onclick="displayPrevious1()" class="btn btn-sm btn-info rounded-pill px-3"> <i class="icon-chevron-left"></i></button>
                    <button onclick="displayNext1()"  class="btn btn-sm btn-info rounded-pill px-3"> <i class="icon-chevron-right"></i> </button>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Daily Member Incomes</div>
                <canvas id="barChart2"></canvas>
                <div class="text-center mt-3">
                    <button onclick="displayPrevious2()" class="btn btn-sm btn-danger rounded-pill px-3"> <i class="icon-chevron-left"></i> </button>
                    <button onclick="displayNext2()"  class="btn btn-sm btn-danger rounded-pill px-3"> <i class="icon-chevron-right"></i> </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Weekly Total Incomes</div>
                <canvas id="barChartWeekly1"></canvas>
                <div class="text-center mt-3">
                    <button onclick="displayPreviousWeekly1()" class="btn btn-sm btn-info rounded-pill px-3">
                        <i class="icon-chevron-left"></i>
                    </button>
                    <button onclick="displayNextWeekly1()" class="btn btn-sm btn-info rounded-pill px-3">
                        <i class="icon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Weekly Member Incomes</div>
                <canvas id="barChartWeekly2"></canvas>
                <div class="text-center mt-3">
                    <button onclick="displayPreviousWeekly2()" class="btn btn-sm btn-danger rounded-pill px-3">
                        <i class="icon-chevron-left"></i>
                    </button>
                    <button onclick="displayNextWeekly2()" class="btn btn-sm btn-danger rounded-pill px-3">
                        <i class="icon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Inventory Drink Proportion</div>
                <div class="matrix-chart">
                    <canvas id="pieChart1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Inventory Food Proportion</div>
                <div class="matrix-chart">
                    <canvas id="pieChartFood"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Weekly Drink Orders</div>
                <div class="matrix-chart">
                    <canvas id="barChart3"></canvas>
                </div>
                <div class="text-center mt-3">
                    <button onclick="displayPreviousOrders()" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="icon-chevron-left"></i>
                    </button>
                    <button onclick="displayNextOrders()" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="icon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <div class="card-in-chart">
                <div class="chart-title text-center">Weekly Outcomes</div>
                <div class="matrix-chart">
                    <canvas id="barChartOutcomes"></canvas>
                </div>
                <div class="text-center mt-3">
                    <button onclick="displayPreviousOutcomes()" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="icon-chevron-left"></i>
                    </button>
                    <button onclick="displayNextOutcomes()" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="icon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    //BarChart1
    var dates = {!! $dates !!};
    var amounts1 = {!! $totals !!};

    var startIdx = dates.length - 7; // Start index for the initial displayed data
    var endIdx = dates.length - 1; // End index for the initial displayed data

    var displayedDates = dates.slice(startIdx, endIdx + 1);
    var displayedData1 = amounts1.slice(startIdx, endIdx + 1);


    var ctx1 = document.getElementById('barChart1').getContext('2d');
    var barChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: displayedDates,
            datasets: [{
                label: 'Daily Total',
                data: displayedData1,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }],
        },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                    },
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    callbacks: {
                        label: function (context) {
                            var label = context.label || '';
                            var value = context.parsed.y || 0;
                            return label + ': ' + value;
                        }
                    }
                }
            },
        });

        function displayPrevious1() {
            startIdx -= 7;
            endIdx -= 7;
            updateChart1();
        }

        function displayNext1() {
            startIdx += 7;
            endIdx += 7;
            updateChart1();
        }

        function displayPrevious2() {
            startIdx -= 7;
            endIdx -= 7;
            updateChart2();
        }

        function displayNext2() {
            startIdx += 7;
            endIdx += 7;
            updateChart2();
        }

        function updateChart1() {
            var newDates = dates.slice(startIdx, endIdx + 1);
            var newData1 = amounts1.slice(startIdx, endIdx + 1);

            barChart1.data.labels = newDates;
            barChart1.data.datasets[0].data = newData1;
            barChart1.update();
        }
        function updateChart2() {
            var newDates = dates.slice(startIdx, endIdx + 1);
            var newData2 = amounts2.slice(startIdx, endIdx + 1);

            barChart2.data.labels = newDates;
            barChart2.data.datasets[0].data = newData2;
            barChart2.update();
        }

    //Barchart2
    // Fetch data for the second bar chart

    var amounts2 = {!! $amounts !!};
    var displayedData2 = amounts2.slice(startIdx, endIdx + 1);


    // Create another bar chart using Chart.js
    var ctx2 = document.getElementById('barChart2').getContext('2d');
    var barChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: displayedDates,
            datasets: [{
                label: 'Daily Member Amount',
                data: displayedData2,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                },
            },
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function (context) {
                        var label = context.label || '';
                        var value = context.parsed.y || 0;
                        return label + ': ' + value;
                    }
                }
            }
        },
    });

    // Weekly BarChart1 & 2 - Total / Member Amount (4 weeks window with navigation)
    var weekLabels = {!! $weekLabels !!};
    var weeklyTotals = {!! $weeklyTotalValues !!};
    var weeklyAmounts = {!! $weeklyAmountValues !!};

    var weekWindowSize = 4;
    var weekStartIdx = Math.max(weekLabels.length - weekWindowSize, 0);
    var weekEndIdx = weekLabels.length - 1;

    function getDisplayedWeekData() {
        var labels = weekLabels.slice(weekStartIdx, weekEndIdx + 1);
        var totals = weeklyTotals.slice(weekStartIdx, weekEndIdx + 1);
        var amounts = weeklyAmounts.slice(weekStartIdx, weekEndIdx + 1);

        return { labels: labels, totals: totals, amounts: amounts };
    }

    var weeklyDisplay = getDisplayedWeekData();

    var ctxWeekly1 = document.getElementById('barChartWeekly1').getContext('2d');
    var barChartWeekly1 = new Chart(ctxWeekly1, {
        type: 'bar',
        data: {
            labels: weeklyDisplay.labels,
            datasets: [{
                label: 'Weekly Total',
                data: weeklyDisplay.totals,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                },
            },
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function (context) {
                        var label = context.label || '';
                        var value = context.parsed.y || 0;
                        return label + ': ' + value;
                    }
                }
            }
        },
    });

    var ctxWeekly2 = document.getElementById('barChartWeekly2').getContext('2d');
    var barChartWeekly2 = new Chart(ctxWeekly2, {
        type: 'bar',
        data: {
            labels: weeklyDisplay.labels,
            datasets: [{
                label: 'Weekly Member Amount',
                data: weeklyDisplay.amounts,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                },
            },
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function (context) {
                        var label = context.label || '';
                        var value = context.parsed.y || 0;
                        return label + ': ' + value;
                    }
                }
            }
        },
    });

    function updateWeeklyCharts() {
        var data = getDisplayedWeekData();

        barChartWeekly1.data.labels = data.labels;
        barChartWeekly1.data.datasets[0].data = data.totals;
        barChartWeekly1.update();

        barChartWeekly2.data.labels = data.labels;
        barChartWeekly2.data.datasets[0].data = data.amounts;
        barChartWeekly2.update();
    }

    function displayPreviousWeekly1() {
        if (weekStartIdx - weekWindowSize >= 0) {
            weekStartIdx -= weekWindowSize;
            weekEndIdx -= weekWindowSize;
            updateWeeklyCharts();
        }
    }

    function displayNextWeekly1() {
        if (weekEndIdx + weekWindowSize < weekLabels.length) {
            weekStartIdx += weekWindowSize;
            weekEndIdx += weekWindowSize;
            updateWeeklyCharts();
        }
    }

    // Keep both weekly charts in sync when using the second chart's buttons
    function displayPreviousWeekly2() {
        displayPreviousWeekly1();
    }

    function displayNextWeekly2() {
        displayNextWeekly1();
    }

    //Piechart1 (Now Horizontal Bar)
    // Fetch item names and quantities from the inventories data
    var inventories = {!! $inventories !!};

    // Extract labels (item names) and data (quantities) from the inventories array
    var labels = inventories.map(item => item.item_name);
    var data = inventories.map(item => item.qty);

    // Create a new bar chart using Chart.js
    var ctx3 = document.getElementById('pieChart1').getContext('2d');
    var pieChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Qty in Stock',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 5,
            }],
        },
        options: {
            indexAxis: 'y', // This makes it a horizontal bar chart
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        },
    });

    // Food Proportion Chart (Horizontal Bar)
    var foodInventories = {!! $foodInventories !!};
    var foodLabels = foodInventories.map(item => item.item_name);
    var foodData = foodInventories.map(item => item.qty);

    var ctxFood = document.getElementById('pieChartFood').getContext('2d');
    var pieChartFood = new Chart(ctxFood, {
        type: 'bar',
        data: {
            labels: foodLabels,
            datasets: [{
                label: 'Qty in Stock',
                data: foodData,
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1,
                borderRadius: 5,
            }],
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        },
    });

    //barchart3 - Weekly order counts with navigation
    var invAndRec =  @json($inventoriesAll);
    var weeklyOrders = @json($weeklyOrders);

    // Ensure we use the same number of weeks as weekLabels
    var maxWeeksOrders = Math.min(weekLabels.length, weeklyOrders.length);
    var currentOrderWeekIdx = maxWeeksOrders > 0 ? maxWeeksOrders - 1 : 0; // start at latest week

    function computeWeeklyOrderCounts(weekIdx) {
        var weekData = weeklyOrders[weekIdx] || {};
        var ordersConcat = weekData.orders_concat || '';

        var counts = {};
        invAndRec.forEach(function (item) {
            var count = 0;
            if (ordersConcat !== null && ordersConcat !== '') {
                count = (ordersConcat.split(item).length - 1);
            }
            counts[item] = count;
        });

        return counts;
    }

    function getOrderChartData() {
        var counts = computeWeeklyOrderCounts(currentOrderWeekIdx);
        var labels = [];
        var data = [];

        // Only include products that have count > 0 in the current week
        invAndRec.forEach(function (item) {
            var value = counts[item] || 0;
            if (value > 0) {
                labels.push(item);
                data.push(value);
            }
        });

        return {
            labels: labels,
            data: data
        };
    }

    var orderChartData = getOrderChartData();

    var ctx4 = document.getElementById('barChart3').getContext('2d');
    var barChart3 = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: orderChartData.labels,
            datasets: [{
                label: 'Weekly Drink Order Count - ' + (weekLabels[currentOrderWeekIdx] || ''),
                data: orderChartData.data,
                backgroundColor:'#87bc45',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                },
            },
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function (context) {
                        var label = context.label || '';
                        var value = context.parsed.y || 0;
                        return label + ': ' + value;
                    }
                }
            }
        },
    });

    function updateOrderChart() {
        var newData = getOrderChartData();

        barChart3.data.labels = newData.labels;
        barChart3.data.datasets[0].data = newData.data;
        barChart3.data.datasets[0].label = 'Weekly Drink Order Count - ' + (weekLabels[currentOrderWeekIdx] || '');
        barChart3.update();
    }

    function displayPreviousOrders() {
        if (currentOrderWeekIdx - 1 >= 0) {
            currentOrderWeekIdx -= 1;
            updateOrderChart();
        }
    }

    function displayNextOrders() {
        if (currentOrderWeekIdx + 1 < maxWeeksOrders) {
            currentOrderWeekIdx += 1;
            updateOrderChart();
        }
    }

    // Weekly outcomes (last month) with navigation
    var outcomeWeekLabels = {!! $outcomeWeekLabels !!};
    var weeklyOutcomeValues = {!! $weeklyOutcomeValues !!};

    var outcomeWindowSize = 4;
    var outcomeStartIdx = Math.max(outcomeWeekLabels.length - outcomeWindowSize, 0);
    var outcomeEndIdx = outcomeWeekLabels.length - 1;

    function getDisplayedOutcomeData() {
        var labels = outcomeWeekLabels.slice(outcomeStartIdx, outcomeEndIdx + 1);
        var values = weeklyOutcomeValues.slice(outcomeStartIdx, outcomeEndIdx + 1);

        return { labels: labels, values: values };
    }

    function getOutcomeLabelText(display) {
        if (!display || !display.labels || display.labels.length === 0) {
            return 'Weekly Outcomes (Last Month)';
        }

        return 'Weekly Outcomes (Last Month) - ' + display.labels[0] + ' to ' + display.labels[display.labels.length - 1];
    }

    var outcomeDisplay = getDisplayedOutcomeData();

    var ctxOutcomes = document.getElementById('barChartOutcomes').getContext('2d');
    var barChartOutcomes = new Chart(ctxOutcomes, {
        type: 'bar',
        data: {
            labels: outcomeDisplay.labels,
            datasets: [{
                label: getOutcomeLabelText(outcomeDisplay),
                data: outcomeDisplay.values,
                backgroundColor: 'rgba(54, 162, 235, 0.35)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                },
            },
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function (context) {
                        var label = context.label || '';
                        var value = context.parsed.y || 0;
                        return label + ': ' + value;
                    }
                }
            }
        }
    });

    function updateOutcomeChart() {
        var display = getDisplayedOutcomeData();

        barChartOutcomes.data.labels = display.labels;
        barChartOutcomes.data.datasets[0].data = display.values;
        barChartOutcomes.data.datasets[0].label = getOutcomeLabelText(display);
        barChartOutcomes.update();
    }

    function displayPreviousOutcomes() {
        if (outcomeStartIdx - outcomeWindowSize >= 0) {
            outcomeStartIdx -= outcomeWindowSize;
            outcomeEndIdx -= outcomeWindowSize;
            updateOutcomeChart();
        }
    }

    function displayNextOutcomes() {
        if (outcomeEndIdx + outcomeWindowSize < outcomeWeekLabels.length) {
            outcomeStartIdx += outcomeWindowSize;
            outcomeEndIdx += outcomeWindowSize;
            updateOutcomeChart();
        }
    }



</script>
