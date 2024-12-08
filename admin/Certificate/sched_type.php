<?php
// Include your config file and set the timezone
require_once('../config.php');
date_default_timezone_set('Asia/Manila');

// Check for success flash message
if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Dashboard</h3>
    </div>
    <div class="card-body">
        

        <div class="container-fluid mt-4">
            <h4>Confirmed Requests for <?php echo date('F Y'); ?></h4>
            <?php
            // Define the date range for the current month
            $startOfMonth = date('Y-m-01');
            $endOfMonth = date('Y-m-t');

            // Prepare the query for appointment requests
            $stmt = $conn->prepare("
                SELECT 
                    ar.id,
                    st.sched_type,
                    ar.date_created,
                    ar.schedule AS schedule_date,
                    ar.fullname AS full_name,
                    ar.remarks,
                    ar.status
                FROM 
                    schedule_type st
                LEFT JOIN 
                    appointment_schedules ar ON st.id = ar.sched_type_id
                WHERE 
                    DATE(ar.schedule) BETWEEN ? AND ?
                    AND ar.status = 1
                ORDER BY 
                    ar.date_created ASC
            ");

            // Bind parameters for appointment requests
            $stmt->bind_param("ss", $startOfMonth, $endOfMonth);

            // Execute the query
            $stmt->execute();

            // Get the result for appointment requests
            $result = $stmt->get_result();

            // Initialize row counter
            $i = 1;
            ?>

            <h5>Burrial Requests</h5>
            <table class="table table-bordered table-hover table-striped text-sm">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="10%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Schedule Type</th>
                        <th>Date Created</th>
                        <th>Schedule Date</th>
                        <th>Full Name</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo $row['sched_type']; ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_created'])); ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['schedule_date'])); ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['remarks']; ?></td>
                            <td class="text-center">
                                <span class="badge badge-success">Confirmed</span>
                            </td>
                            <td>
                                <div class="card-tools">
                                    <a href="?page=Certificate/print_report&id=<?php echo $row['id']; ?>&type=Appointment"
                                        class="btn btn-flat btn-primary" target="_self">
                                        <span class="fas fa-print"></span> Print
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php
            // Close the statement for appointment requests
            $stmt->close();
            ?>

            <?php
            // Prepare the query for baptism requests
            $stmt = $conn->prepare("
                SELECT 
                    br.id,
                    st.sched_type,
                    br.date_created,
                    br.date_of_baptism AS schedule_date,
                    br.child_fullname AS full_name,
                    br.birthplace,
                    br.birthdate,
                    br.father,
                    br.mother,
                    br.address,
                    br.minister,
                    br.sponsors,
                    br.book_no,
                    br.page,
                    br.volume,
                    br.status
                FROM 
                    schedule_type st
                LEFT JOIN 
                    baptism_schedule br ON st.id = br.sched_type_id
                WHERE 
                    DATE(br.date_of_baptism) BETWEEN ? AND ?
                    AND br.status = 1
                ORDER BY 
                    br.date_created ASC
            ");

            // Bind parameters for baptism requests
            $stmt->bind_param("ss", $startOfMonth, $endOfMonth);

            // Execute the query for baptism requests
            $stmt->execute();

            // Get the result for baptism requests
            $result = $stmt->get_result();

            // Initialize row counter for baptism table
            $j = 1;
            ?>

            <h5>Baptism Requests</h5>
            <table class="table table-bordered table-hover table-striped text-sm">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="10%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="5%">
                    <col width="5%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Schedule Type</th>
                        <th>Date Created</th>
                        <th>Schedule Date</th>
                        <th>Full Name</th>
                        <th>Father</th>
                        <th>Mother</th>
                        <th>Minister</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $j++; ?></td>
                            <td><?php echo $row['sched_type']; ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_created'])); ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['schedule_date'])); ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['father']; ?></td>
                            <td><?php echo $row['mother']; ?></td>
                            <td><?php echo $row['minister']; ?></td>
                            <td class="text-center">
                                <span class="badge badge-success">Confirmed</span>
                            </td>
                            <td>
                                <div class="card-tools">
                                    <a href="?page=Certificate/print_baptism&id=<?php echo $row['id']; ?>"
                                        class="btn btn-flat btn-primary" target="_self">
                                        <span class="fas fa-print"></span> Print
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php
            // Close the statement for appointment requests
            $stmt->close();
            ?>

            <?php
            // Prepare the query for wedding requests
            $stmt = $conn->prepare("
    SELECT 
        ws.id,
        st.sched_type,
        ws.date_created,
        ws.date_of_marriage AS schedule_date,
        ws.husband_fname,
        ws.husband_mname,
        ws.husband_lname,
        ws.wife_fname,
        ws.wife_mname,
        ws.wife_lname,
        ws.place_of_marriage1,
        ws.date_of_marriage,
        ws.time_of_marriage,
        ws.status
    FROM 
        schedule_type st
    LEFT JOIN 
        wedding_schedules ws ON st.id = ws.sched_type_id
    WHERE 
        DATE(ws.date_of_marriage) BETWEEN ? AND ?
        AND ws.status = 1
    ORDER BY 
        ws.date_created ASC
");

            // Bind parameters for wedding requests
            $stmt->bind_param("ss", $startOfMonth, $endOfMonth);

            // Execute the query for wedding requests
            $stmt->execute();

            // Get the result for wedding requests
            $result = $stmt->get_result();

            // Initialize row counter for wedding table
            $j = 1;
            ?>

            <?php
            // Prepare the query for wedding requests
            $stmt = $conn->prepare("
    SELECT 
        ws.id,
        st.sched_type,
        ws.date_created,
        ws.date_of_marriage AS schedule_date,
        ws.husband_fname,
        ws.husband_mname,
        ws.husband_lname,
        ws.wife_fname,
        ws.wife_mname,
        ws.wife_lname,
        ws.place_of_marriage1,
        ws.date_of_marriage,
        ws.time_of_marriage,
        ws.status
    FROM 
        schedule_type st
    LEFT JOIN 
        wedding_schedules ws ON st.id = ws.sched_type_id
    WHERE 
        DATE(ws.date_of_marriage) BETWEEN ? AND ?
        AND ws.status = 1
    ORDER BY 
        ws.date_created ASC
");

            // Bind parameters for wedding requests
            $stmt->bind_param("ss", $startOfMonth, $endOfMonth);

            // Execute the query for wedding requests
            $stmt->execute();

            // Get the result for wedding requests
            $result = $stmt->get_result();

            // Initialize row counter for wedding table
            $j = 1;

            if ($result->num_rows > 0) {
                ?>

                <h5>Wedding Requests</h5>
                <table class="table table-bordered table-hover table-striped text-sm">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="10%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Schedule Type</th>
                            <th>Husband Fullname</th>
                            <th>Wife Fullname</th>
                            <th>Place of Marriage</th>
                            <th>Date & Time of Marriage</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?php echo $j++; ?></td>
                                <td><?php echo $row['sched_type']; ?></td>
                                <td><?php echo $row['husband_fname'] . ' ' . $row['husband_mname'] . ' ' . $row['husband_lname']; ?>
                                </td>
                                <td><?php echo $row['wife_fname'] . ' ' . $row['wife_mname'] . ' ' . $row['wife_lname']; ?></td>
                                <td><?php echo $row['place_of_marriage1']; ?></td>
                                <td><?php echo date("M d, Y", strtotime($row['date_of_marriage'])) . ' ' . date("h:i A", strtotime($row['time_of_marriage'])); ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">Confirmed</span>
                                </td>
                                <td>
                                    <div class="card-tools">
                                        <a href="?page=Certificate/print_wedding&id=<?php echo $row['id']; ?>"
                                            class="btn btn-flat btn-primary" target="_self">
                                            <span class="fas fa-print"></span> Print
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php
            } else {
                // Display a message if there are no wedding requests
                echo "<p>No wedding requests found for the current month.</p>";
            }

            // Close the statement for wedding requests
            $stmt->close();
            ?>




        </div>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script>
    function fetchPieChartData() {
        fetch('get_piechart.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const labels = data.data.map(item => item.label);
                    const series = data.data.map(item => item.total);

                    const pie_chart_options = {
                        series: series,
                        chart: {
                            type: "donut",
                            height: 350
                        },
                        labels: labels,
                        dataLabels: {
                            enabled: true,
                        },
                        colors: [
                            "#0d6efd", "#20c997", "#ffc107", "#d63384", "#6f42c1", "#adb5bd",
                        ],
                        title: {
                            text: "Total Requests by Type",
                            align: 'center'
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
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

    function fetchMonthlyRequests() {
        fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const dates = [];
                    const totals = [];
                    const currentDate = new Date();
                    const month = currentDate.toLocaleString('default', { month: 'long' });
                    const year = currentDate.getFullYear();
                    const daysInMonth = new Date(year, currentDate.getMonth() + 1, 0).getDate();

                    for (let day = 1; day <= daysInMonth; day++) {
                        const dateStr = `${year}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                        const request = data.data.find(r => r.date === dateStr);
                        dates.push(day);
                        totals.push(request ? request.total : 0);
                    }

                    const options = {
                        series: [{
                            name: 'Requests',
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
                                text: 'No. of Requests'
                            }
                        },
                        title: {
                            text: `Daily Requests for ${month} ${year}`,
                            align: 'center'
                        },
                        markers: {
                            size: 4,
                            hover: {
                                size: 6
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " requests"
                                }
                            }
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#monthly-requests-chart"), options);
                    chart.render();
                } else {
                    console.error('Error fetching monthly requests:', data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching monthly requests:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchPieChartData();
        fetchMonthlyRequests();
    });
</script>