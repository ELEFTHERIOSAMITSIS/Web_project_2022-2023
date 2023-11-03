<?php
include '../get_from_db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedMonth = isset($_POST['month']) ? $_POST['month'] : date('m');
    $selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);

    $allDates = [];
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $formattedDate = sprintf('%04d-%02d-%02d', $selectedYear, $selectedMonth, $day);
        $allDates[] = $formattedDate;
    }

    $query = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS OFFER_DATE, COUNT(*) AS OFFER_COUNT
              FROM Offers
              WHERE YEAR(created_at) = $selectedYear AND MONTH(created_at) = $selectedMonth
              GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d')
              ORDER BY DATE_FORMAT(created_at, '%Y-%m-%d')";
    $result = mysqli_query($conn, $query);

    $monthName = date('F', mktime(0, 0, 0, $selectedMonth, 1));

    $offerData = [];  
    while ($row = mysqli_fetch_assoc($result)) {
        $offerData[$row['OFFER_DATE']] = intval($row['OFFER_COUNT']);
    }

    foreach ($allDates as $date) {
        if (!isset($offerData[$date])) {
            $offerData[$date] = 0;
        }
    }

    ksort($offerData);

    $chartData = [];
    foreach ($offerData as $date => $count) {
        $chartData[] = [
            'OFFER_DATE' => $date,
            'OFFER_COUNT' => $count
        ];
    }

    $chartDataJSON = json_encode($chartData);
    //var_dump($chartDataJSON); 
}  

?>

<!DOCTYPE html>
<html>
<head>
<title>Offers Chart</title>
    <link rel="stylesheet" type="text/css" href="../css/chart.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<form method="post" action="">
    <label class="label" for="month">Select Month:</label>
    <select class="select" name="month" id="month">
        <?php
        for ($i = 1; $i <= 12; $i++) {
            $monthNameOption = date('F', mktime(0, 0, 0, $i, 1));
            $selected = $i == $selectedMonth ? 'selected' : '';
            echo "<option value='$i' $selected>$monthNameOption</option>";
        }
        ?>
    </select>
    <label class="label" for="year">Select Year:</label>
    <select class="select" name="year" id="year">
        <?php
        $currentYear = date('Y');
        for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
            $selected = $i == $selectedYear ? 'selected' : '';
            echo "<option value='$i' $selected>$i</option>";
        }
        ?>
    </select>  
    <button class="button" type="submit">Show Chart</button>
</form>

<h1 id="chartTitle"></h1>

<div id="box">
    <canvas id="offerChart"></canvas>
</div>

<script>
    var chartData = <?php echo $chartDataJSON; ?>;
    
    var dates = chartData.map(item => item.OFFER_DATE);
    var counts = chartData.map(item => item.OFFER_COUNT);
    
    var formattedDates = dates.map(date => {
    var parts = date.split('-');
    var month = new Date(parts[0], parts[1] - 1, parts[2]).toLocaleString('en', { month: 'short', day: 'numeric' });
    return month; });

    var ctx = document.getElementById('offerChart').getContext('2d'); 
    
    var offerChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: dates,
        datasets: [{
            label: 'Number of Offers',
            data: counts,
            backgroundColor: 'greenyellow', 
            borderColor: 'rgba(0, 0, 0, 1)', 
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Offer Dates',
                    font: {
                        size: 18, 
                        weight: 'bold'
                    },
                    color: 'grey' 
                },
                ticks: {
                    font: {
                        size: 14
                    }
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Offers',
                    font: {
                        size: 18,
                        weight: 'bold' 
                    },
                    color: 'grey'
                },
                ticks: {
                    font: {
                        size: 12 
                    }
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Offers in <?php echo $monthName; ?>',
                font: {
                    size: 23,
                    weight: 'bold' 
                },
                color: 'grey'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Offers: ' + context.parsed.y;
                    }
                }
            }
        }
    }
});
</script>