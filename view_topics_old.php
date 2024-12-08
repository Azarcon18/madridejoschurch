<?php 
$title = "All Book Categories";
$sub_title = "";
$activeTopicId = isset($_GET['t']) ? md5($_GET['t']) : ''; // Get the current topic ID
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .category-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 0.5rem;
        }

        .category-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .active-topic {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-dark py-5" id="main-header">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder"><?php echo $title; ?></h1>
            </div>
        </div>
    </header>

    <!-- Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-2 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-3 justify-content-center">
                <?php 
                    // Assuming $conn is already defined and connected to the database
                    $categories = $conn->query("SELECT * FROM `topics` WHERE status = 1 ORDER BY name ASC");
                    while($row = $categories->fetch_assoc()):
                        foreach($row as $k => $v){
                            $row[$k] = trim(stripslashes($v));
                        }
                        $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                        $isActive = md5($row['id']) === $activeTopicId ? 'active-topic' : '';
                ?>
                <div class="col mb-6 mb-2 text-light">
                    <a href="./?p=articles&t=<?php echo md5($row['id']); ?>" class="card category-item text-decoration-none <?php echo $isActive; ?>" style="background-color: #21252970;">
                        <div class="card-body p-4 text-center text-dark">
                            <div class="">
                                <!-- Product name -->
                                <h5 class="fw-bolder border-bottom border-primary"><?php echo $row['name']; ?></h5>
                            </div>
                            <p class="m-0 truncate"><?php echo $row['description']; ?></p>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
