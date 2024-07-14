<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Salary Calculator</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .result {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Monthly Salary Calculator</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="month">Select month:</label>
            <select id="month" name="month" class="form-control" required>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
        </div>
        <div class="form-group">
            <label for="currency">Select currency for hourly rate:</label>
            <select id="currency" name="currency" class="form-control" required>
                <option value="EUR">Euro (EUR)</option>
                <option value="CZK">Czech Koruna (CZK)</option>
                <option value="MKD">Macedonian Denar (MKD)</option>
                <option value="USD">US Dollar (USD)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="hourly_rate">Enter hourly rate:</label>
            <input type="number" id="hourly_rate" name="hourly_rate" class="form-control" min="0.01" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Calculate Salary</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Input values
        $month = $_POST['month'];
        $currency = $_POST['currency'];
        $hourly_rate = $_POST['hourly_rate'];

        // Constants
        $workdays_per_week = 5;
        $workhours_per_day = 8;
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($month)), date('Y'));

        // Calculate workdays and non-workdays
        $workdays_count = 0;
        for ($day = 1; $day <= $days_in_month; $day++) {
            $current_day = date('N', strtotime(date('Y-m', strtotime($month)) . '-' . $day));
            if ($current_day >= 1 && $current_day <= 5) {
                $workdays_count++;
            }
        }
        $non_workdays_count = $days_in_month - $workdays_count;

        // Calculations
        $gross_salary = $hourly_rate * $workhours_per_day * $workdays_count;
        $pension_contribution = $gross_salary * 0.18; // 18% for pension contribution
        $health_contribution = $gross_salary * 0.07; // 7% for health contribution
        $net_salary = $gross_salary - $pension_contribution - $health_contribution;

        // Display results
        echo '<div class="result">';
        echo '<h3 class="text-center">Results for ' . $month . '</h3>';
        echo '<p><b>Gross Salary:</b> ' . number_format($gross_salary, 2, '.', ',') . ' ' . $currency . '</p>';
        echo '<p><b>Pension Contribution:</b> ' . number_format($pension_contribution, 2, '.', ',') . ' ' . $currency . '</p>';
        echo '<p><b>Health Contribution:</b> ' . number_format($health_contribution, 2, '.', ',') . ' ' . $currency . '</p>';
        echo '<p><b>Net Salary:</b> ' . number_format($net_salary, 2, '.', ',') . ' ' . $currency . '</p>';
        echo '<p><b>Workdays in ' . $month . ':</b> ' . $workdays_count . '</p>';
        echo '<p><b>Non-Workdays in ' . $month . ':</b> ' . $non_workdays_count . '</p>';
        echo '</div>';
    }
    ?>

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
