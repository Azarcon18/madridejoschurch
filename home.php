<?php 
$qry = $conn->query("SELECT * FROM `daily_verses` where `display_date` = '".date('Y-m-d')."' ");
if($qry->num_rows > 0){
    foreach($qry->fetch_array() as $k => $v){
        if(!is_numeric($k))
            $dv[$k] = $v;
    }
}
?>

<style>
    #main-header:before {
        background-image: url("<?php echo validate_image((isset($dv['image_path']) && !empty($dv['image_path'])) ? $dv['image_path'] : $_settings->info('cover')) ?>");
        background-size: cover;
        background-position: center;
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -1;
    }
    #main-header {
        height: 83vh;
        font-family: 'Brush Script MT', 'Brush Script Std', cursive;
        text-shadow: 5px 5px #9e73734d;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        color: #fff;
        text-align: center;
    }
    .recent-blog-img {
        transition: transform 0.3s ease-in-out;
        width: 100%;
        height: auto;
    }
    .recent-blog-img:hover {
        transform: scale(1.1);
    }
    .truncate-1 {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    @media (max-width: 768px) {
        #main-header {
            height: 60vh;
        }
    }
</style>

<!-- Header-->
<header class="bg-dark py-5 d-flex align-items-center" id="main-header">
    <div class="container px-4 px-lg-5 my-5 w-100">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo isset($dv['verse']) ? '"' . $dv['verse'] . '"' : $_settings->info('home_quote') ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo isset($dv['verse_from']) ? $dv['verse_from'] : "" ?></p>
        </div>
    </div>
</header>

<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
       <div class="row gx-4 gx-lg-5">
           <div class="col-md-8 mb-4">
               <h2><b>Welcome to <?php echo $_settings->info('name') ?></b></h2>
               <hr>
               <?php include('welcome_content.html') ?>
           </div>
           <div class="col-md-4 border-start">
               <h4><b>Recent Blogs</b></h4>
               <hr>
               <?php 
                $qry_blogs = $conn->query("SELECT * FROM `blogs` WHERE `status` = 1 ORDER BY unix_timestamp(`date_created`) DESC LIMIT 10");
                while($row = $qry_blogs->fetch_assoc()):
               ?>
               <a href="<?php echo base_url . $row['blog_url'] ?>" class="w-100 d-flex text-decoration-none bg-light bg-gradient rounded-1 border-light border mb-3 p-2">
                   <div class="me-3">
                       <img src="<?php echo validate_image($row['banner_path']) ?>" alt="Blog Image" class="img-thumbnail recent-blog-img">
                   </div>
                   <div class="flex-grow-1">
                       <p class="truncate-1 fw-bold mb-1"><?php echo $row['title'] ?></p>
                       <small class="truncate-1 text-muted"><?php echo $row['meta_description'] ?></small>
                   </div>
               </a>
               <?php endwhile; ?>
               <?php if($qry_blogs->num_rows <= 0): ?>
                   <div class="text-center"><small><i>No data listed yet.</i></small></div>
               <?php endif; ?>
           </div>
       </div>
    </div>
</section>
