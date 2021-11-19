<div class="col-lg-4">
    <div class="card bg-dark">
        <div class="card-header bg-transparent text-white border-light">
            {{ __('Invoices Summary') }}
        </div>
        <div class="card-body">
            <canvas id="invoices-summary-chart" height="240"></canvas>
        </div>
    </div>
</div>
<script type="text/javascript">
var ctx = document.getElementById("invoices-summary-chart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Paid", "Due", "Overdue"],
        datasets: [{
            backgroundColor: ['#15ca20', '#ff9700', '#fd3550'],
            data: [
                {{ \App\Payments\Helper\Data::getTotalPaidAmount() }},
                {{ \App\Payments\Helper\Data::getTotalDueAmount() }},
                {{ \App\Payments\Helper\Data::getTotalOverdueAmount() }}
            ],
            borderWidth: [0, 0, 0]
        }]
    },
    options: {
        cutoutPercentage: 85,
        legend: {
            position: 'bottom',
            display: true,
            labels: {
                fontColor: '#eee',
                boxWidth:8
            }
        },
        tooltips:{
            displayColors:false,
        }
    }
});
</script>