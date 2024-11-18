<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Add any other stylesheets here -->
</head>
<body>
    <h3 class="text-dark">Dashboard</h3>
    <div class="row">

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-color">
                <span class="info-box-icon bg-primary elevation-1 animate__animated animate__bounceIn">
                    <i class="fas fa-user-plus"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Registered Users</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $registered_users = $conn->query("SELECT count(*) as total FROM registered_users ")->fetch_assoc()['total'];
                            echo number_format($registered_users);
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box bg-color">
        <span class="info-box-icon bg-primary elevation-1 animate__animated animate__bounceIn">
            <i class="fas fa-donate"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Total Donations</span>
            <span class="info-box-number text-right">
                <?php 
                    // Query to count the total number of donations (donors)
                    $donor_count = $conn->query("SELECT COUNT(*) as total_donors FROM donations")->fetch_assoc()['total_donors'];

                    // Query to sum the total amount of donations
                    $total_donation = $conn->query("SELECT SUM(amount) as total_amount FROM donations")->fetch_assoc()['total_amount'];
                    $total_donation = $total_donation ? $total_donation : 0;  // Default to 0 if no donations

                    // Display the donor count and the total donation amount
                    echo "Amount: ₱" . number_format($total_donation, 2);
                ?>
            
                        
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-color">
                <span class="info-box-icon bg-primary elevation-1 animate__animated animate__fadeIn">
                    <i class="fas fa-certificate"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Death Certificate</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $appointment = $conn->query("SELECT count(id) as total FROM appointment_request WHERE status = 1")->fetch_assoc()['total'];
                            echo number_format($appointment);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-light elevation-1 animate__animated animate__zoomIn">
                    <i class="fas fa-quote-left"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Daily Verses</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $verses = $conn->query("SELECT count(id) as total FROM daily_verses ")->fetch_assoc()['total'];
                            echo number_format($verses);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1 animate__animated animate__fadeInLeft">
                    <i class="fas fa-blog"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Published Blogs/Posts</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $blogs = $conn->query("SELECT id FROM `blogs` where status = '1' ")->num_rows;
                            echo number_format($blogs);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1 animate__animated animate__bounceInRight">
                    <i class="fas fa-calendar-day"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Upcoming Events</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $event = $conn->query("SELECT id FROM `events` where date(schedule) >= '".date('Y-m-d')."' ")->num_rows;
                            echo number_format($event);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1 animate__animated animate__zoomInRight">
                    <i class="fas fa-calendar-check"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Appointment</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $appointment = $conn->query("SELECT count(id) as total FROM appointment_request ")->fetch_assoc()['total'];
                            echo number_format($appointment);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1 animate__animated animate__fadeInRight">
                    <i class="fas fa-check-circle"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Confirmed Appointment</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $appointment = $conn->query("SELECT count(id) as total FROM appointment_request WHERE status= 1")->fetch_assoc()['total'];
                            echo number_format($appointment);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1 animate__animated animate__fadeInUp">
                    <i class="fas fa-hourglass-half"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending Appointment</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $appointment = $conn->query("SELECT count(id) as total FROM appointment_request WHERE status= 0")->fetch_assoc()['total'];
                            echo number_format($appointment);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1 animate__animated animate__fadeInDown">
                    <i class="fas fa-times-circle"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Declined Appointment</span>
                    <span class="info-box-number text-right">
                        <?php 
                            $appointment = $conn->query("SELECT count(id) as total FROM appointment_request WHERE status= 2")->fetch_assoc()['total'];
                            echo number_format($appointment);
                        ?>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card bg-light" style="height: 500px;">
                <div class="card-header">
                    <h3 class="card-title">Total Appointment Requests by Type</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div id="pie-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card bg-light" style="height: 500px;">
                <div class="card-header">
                    <h3 class="card-title">Daily Appointment Requests</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative mb-4">
                        <div id="monthly-appointments-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
 crossorigin="anonymous"></script>
<script>
function fetchPieChartData() {
    fetch('get_piechart.php')
    .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const labels = data.data.map(item => item.label);
                const series = data.data.map(item => item.total);

                const pie_chart_options = {
                    series: series,
                    chart: {
                        type: "donut",
                    },
                    labels: labels,
                    dataLabels: {
                        enabled: false,
                    },
                    colors: [
                        "#0d6efd",
                        "#20c997",
                        "#ffc107",
                        "#d63384",
                        "#6f42c1",
                        "#adb5bd",
                    ],
                };

                const pie_chart = new ApexCharts(
                    document.querySelector("#pie-chart"),
                    pie_chart_options,
                );
                pie_chart.render();
            } else {
                console.error('Error fetching pie chart data:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching pie chart data:', error);
        });
}

fetchPieChartData();
//line chart
function fetchMonthlyAppointments() {
    fetch('fetch_data.php') // Adjust the path to your PHP script
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Prepare data for ApexCharts
                const dates = [];
                const totals = [];
                const currentDate = new Date();
                const month = currentDate.toLocaleString('default', { month: 'long' });
                const year = currentDate.getFullYear();
                const daysInMonth = new Date(year, currentDate.getMonth() + 1, 0).getDate();

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr = `${year}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const appointment = data.data.find(a => a.date === dateStr);
                    dates.push(day);
                    totals.push(appointment ? appointment.total : 0);
                }

                // Initialize ApexCharts
                const options = {
                    series: [{
                        name: 'Appointment Requests',
                        data: totals
                    }],
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    xaxis: {
                        categories: dates,
                        title: {
                            text: 'Day of the Month'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Appointment Requests'
                        }
                    },
                    title: {
                        text: `Daily Appointment Requests for ${month} ${year}`,
                        align: 'center'
                    }
                };

                const chart = new ApexCharts(document.querySelector("#monthly-appointments-chart"), options);
                chart.render();
            } else {
                console.error('Error fetching monthly appointments:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching monthly appointments:', error);
        });
}

// Fetch the monthly appointments data when the page loads
document.addEventListener('DOMContentLoaded', fetchMonthlyAppointments);

</script>

