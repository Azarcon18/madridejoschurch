<?php 
$title = "Schedule Request";
$sub_title = "";
?>
<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title ?></h1>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <p><i>Select the type of Appointment you desired to create a schedule request.</i></p>
        <hr>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search Here.." aria-label="Search Here.." aria-describedby="basic-addon2" id="search">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gx-2 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-3 justify-content-center" id='sched-type-list'>
            <?php 
                $whereData = "";
                $categories = $conn->query("SELECT * FROM `schedule_type1` where `status` = 1 order by `sched_type1` asc ");
                while($row = $categories->fetch_assoc()):
                    foreach($row as $k=> $v){
                        $row[$k] = trim(stripslashes($v));
                    }
                    $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
            ?>
            <div class="col mb-6 mb-2 text-light item">
                <a href="javascript:void(0)" class="card sched-item text-decoration-none bg-gradient" data-id="<?php echo $row['id'] ?>"  data-name="<?php echo $row['sched_type'] ?>">
                    <div class="card-body p-4">
                        <div class="">
                            <!-- Product name-->
                            <h5 class="fw-bolder border-bottom border-primary"><?php echo $row['sched_type1'] ?></h5>
                        </div>
                        <p class="m-0 truncate"><?php echo $row['description'] ?></p>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
            <center id="noResult" style="display:none"><b><i>No Result</i></b></center>
        </div>
    </div>
</section>
<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p class="mb-0">&copy; <?php echo date("Y"); ?> Your Company Name. All rights reserved.</p>
    </div>
</footer>
<script>
    $(function(){
        $('.sched-item').click(function(){
            var name = $(this).attr('data-name')
            var id = $(this).attr('data-id')
            uni_modal("Create an Appointment Request for "+name,"appointment.php?sched_type_id="+id,"mid-large")
        })
        $('#search').on('input',function(){
            var _txt = $(this).val().toLowerCase()
            $('#sched-type-list .item').each(function(){
                var _contain = $(this).text().toLowerCase().trim()
                if(_contain.includes(_txt) === true){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
            })
            check_result()
        })
    })
    function check_result(){
        if($('#sched-type-list .item:visible').length <= 0){
            if($('#noResult:visible').length <= 0)
            $('#noResult').show('slow');
        }else{
            if($('#noResult:visible').length > 0)
            $('#noResult').hide('slow');
        }
    }
</script>
