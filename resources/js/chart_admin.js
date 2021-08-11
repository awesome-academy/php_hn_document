let ctx = document.getElementById('myLineChart').getContext('2d');
let ctx1 = document.getElementById('myBarChart').getContext('2d');
let download = JSON.parse($("#downloadMonth").val());
let upload = JSON.parse($("#uploadMonth").val());
let coin = JSON.parse($("#coin").val());
let myLineChart = new Chart(ctx, {
    data: {
        labels: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ],
        datasets: [{
            type: 'line',
            label: 'coin',
            data: coin['2021'],
            backgroundColor: [
                '#d7c134',
            ],
        }]
    },
});
let myBarChart = new Chart(ctx1, {
    data: {
        labels: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ],
        datasets: [{
            type: 'bar',
            label: 'downloads',
            data: download['2021'],
            backgroundColor: [
                '#ff4d68',
            ],
        }, {
            type: 'bar',
            label: 'uploads',
            data: upload['2021'],
            backgroundColor: [
                '#3fc589',
            ],
        }]
    },
});

$('.btn-bar').click(function (e) {
    let value = $(this).data('remote');
    myBarChart.data.datasets[0].data = download[value];
    myBarChart.data.datasets[1].data = upload[value];
    myBarChart.update();
});

$('.btn-line').click(function (e) {
    let value = $(this).data('remote');
    myLineChart.data.datasets[0].data = coin[value];
    myLineChart.update();
});
