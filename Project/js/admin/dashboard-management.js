//TODO: CÒN CHỨC NĂNG IN THỐNG KÊ BÁO CÁO NỮA
//export the area_chart_data (to area chart file)

$(document).ready(function () {
    $.ajax({
        url: '../../php/controller/admin/dashboard-controller.php', 
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            //fetch data to the todo-container card
            $('.pending-box .number-display').text(result.todo_list['Đang chuẩn bị hàng']);
            $('.delivering-box .number-display').text(result.todo_list['Đang giao hàng']);
            $('.canceling-box .number-display').text(result.todo_list['Đã hủy']);
            $('.out-of-stock-box .number-display').text(result.out_of_stock_products);

            //fetch data to the orverview container
            $('.total-year-revenue .number-display').text(result.year_revenue + " đ");
            $('.total-month-revenue .number-display').text(result.month_revenue + " đ");
            $('.total-year-orders .number-display').text(result.year_orders);
            $('.total-month-orders .number-display').text(result.month_orders);

            //fetch data to the revenue by categoies pie chart
            displayPieChart(result.pie_chart_data);
            //fetch data to the best-seller products table
            // Populate the table with fetched data
            var table_body = $('.admin-table table tbody');
            table_body.empty(); 

            (result.data).forEach(function (row) {
                var imageUrl = 'data:image/png;base64,' + row.first_picture;
                table_body.append(`
                   <tr>
                        <td><div class="table-img" style="background-image: url(${imageUrl})"></div></td>
                        <td>${row.product_name}</td>
                        <td>${row.total_quantity}</td>
                        <td>${row.price}</td>
                    </tr>
                `);
            });


            //fetch data to the revenue line chart 
            displayAreaChart(result.area_chart_data);
            
        },
        error: function () {
            console.error('Failed to fetch order counts from the server.');
        }
    });
    

});


/////////AREA CHART
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
function displayPieChart(data){
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: data.category_name,
        datasets: [{
        data: data.revenue,
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#0BDEB4', '#0B3DDE'],
        // hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
    },
        legend: {
        display: false
        },
        cutoutPercentage: 80,
    },
    });
}

/////////AREA CHART
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example
function displayAreaChart(data) {
    // Assume you have the 'getChartData' function available
    // const chartData = getChartData();
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Earnings",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: data,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return '$' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' đ';
            }
          }
        }
      }
    });
  }