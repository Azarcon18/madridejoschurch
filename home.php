<?php 
$qry = $conn->query("SELECT * FROM `daily_verses` where `display_date` = '".date('Y-m-d')."' ");
if($qry->num_rows>0){
    foreach($qry->fetch_array() as $k => $v){
        if(!is_numeric($k))
            $dv[$k] = $v;
    }
}
?>

<style>
    #main-header:before{
        background-image:url("<?php echo validate_image((isset($dv['image_path']) && !empty($dv['image_path']))? $dv['image_path'] : $_settings->info('cover')) ?>");
    }
    #main-header {
        height: 83vh;
        font-family: Brush Script MT, Brush Script Std, cursive;
        text-shadow: 5px 5px #9e73734d;
    }
    .recent-blog-img {
        transition: transform 0.3s ease-in-out;
    }
    .recent-blog-img:hover {
        transform: scale(1.1);
    }
</style>

<!-- Header-->
<header class="bg-dark py-5 d-flex align-items-center" id="main-header">
    <div class="container px-4 px-lg-5 my-5 w-100">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo isset($dv['verse']) ? '"'.$dv['verse'].'"' : $_settings->info('home_quote') ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo isset($dv['verse_from']) ? $dv['verse_from'] : "" ?></p>
        </div>
    </div>
</header>

<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
       <div class="col-12">
           <div class="row">
               <div class="col-md-8">
                   <h2><b>Welcome to <?php echo $_settings->info('name') ?></b></h2>
                   <hr>
                   <?php include('welcome_content.html') ?>
               </div>
               <div class="col-md-4 border-left">
                   <h4><b>Recent Blogs</b></h4>
                   <hr>
                   <?php 
                    $qry_blogs =$conn->query("SELECT * FROM `blogs` where `status` = 1 order by unix_timestamp(`date_created`) desc Limit 10");
                    while($row = $qry_blogs->fetch_assoc()):
                   ?>
                   <a href="<?php echo base_url.$row['blog_url'] ?>" class="w-100 d-flex pl-0 row-cols-2 text-decoration-none bg-light bg-gradient rounded-1 border-light border recent-item mb-1">
                       <div class="col-auto w-25 ml-0 p-0">
                           <img src="<?php echo validate_image($row['banner_path']) ?>" alt="Title" class="img-thumbnail recent-blog-img border-1 rounded-1  ml-1">
                       </div>
                       <div class="col-auto flex-grow-1 w-75">
                           <p class="truncate-1 m-0 "><b><?php echo $row['title'] ?></b></p>
                           <small class="truncate-1"><?php echo $row['meta_description'] ?></small>
                       </div>
                   </a>
                   <?php
                   endwhile;
                    ?>
                    <?php if($qry_blogs->num_rows <=0): ?>
                        <center><small><i>No data listed yet.</i></small></center>
                    <?php endif; ?>
               </div>
           </div>
       </div>
    </div>
</section>
