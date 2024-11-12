<!-- Header-->
<header class="bg-dark py-5 d-flex align-items-center" id="main-header">
    <div class="container px-4 px-lg-5 my-5 w-100">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">About Us</h1>
            <p class="lead fw-normal text-white-50 mb-0"></p>
        </div>
    </div>
</header>
<!-- Section-->

<section class="py-5">
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-8">
                    <?php include "about.html" ?>
                </div>
                <div class="col-lg-4 border-left py-5">
                    <h4><b>Reach as @</b></h4>
                    <div class="d-flex w-100">
                        <div class="col-1"><span class="fa fa-phone-square"></span></div>
                        <div class="col-auto flex-grow-1"><?php echo $_settings->info('contact') ?></div>
                    </div>
                    <div class="d-flex w-100">
                        <div class="col-1"><span class="fa fa-envelope-square"></span></div>
                        <div class="col-auto flex-grow-1"><?php echo $_settings->info('email') ?></div>
                    </div>
                    <div class="d-flex w-100">
                        <div class="col-1"><span class="fa fa-map-marked-alt"></span></div>
                        <div class="col-auto flex-grow-1"><?php echo $_settings->info('address') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>