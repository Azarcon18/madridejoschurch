<?php require_once('../config.php'); ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Sample Blog 123 | <?php echo $_settings->info('short_name') ?></title>
    <meta name="description" content="Sample Content Description only">
    <meta name="keywords" content="Sample only, Church, Blog, Article">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Sample Blog 123" />
    <meta property="og:description" content="Sample Content Description only" />
    <meta property="og:image" content="http://localhost/church_management/uploads/blog_uploads/banners/4_banner.jpg" />
    <meta property="og:url" content="http://localhost/church_management/pages/sample_blog_123.php" />
    <?php require_once('../inc/page_header.php') ?>
    <style>
        body, p, h2, span {
            color: black;
        }
    </style>
</head>
<body>
    <?php include(base_app.'inc/body_block.php') ?>
    <h2>Sample Blog 123</h2>
    <input name="blog_id" value="a87ff679a2f3e71d9181a67b7542122c" type="hidden">
    <hr>
    <small><span class='text-muted'><i class='fa fa-calendar-day'></i> Published: Sep 16,2021 04:58 PM</span></small>
    <center><img src="http://localhost/church_management/uploads/blog_uploads/banners/4_banner.jpg" class="img-thumbnail img-banner" alt="http://localhost/church_management/pages/sample_blog_123.php" /></center>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non ultrices tortor. Sed at ligula non lectus tempor bibendum a nec ante. Maecenas iaculis vitae nisi eu dictum. Duis sit amet enim arcu. Etiam blandit vulputate magna, non lobortis velit pharetra vel. Morbi sollicitudin lorem sed augue suscipit, eu commodo tortor vulputate. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent eleifend interdum est, at gravida erat molestie in. Vestibulum et consectetur dui, ac luctus arcu. Curabitur et viverra elit. Cras ac eleifend ipsum, ac suscipit leo. Vivamus porttitor ac risus eu ultricies. Morbi malesuada mi vel luctus sagittis. Ut vestibulum porttitor est, id rutrum libero. Mauris at lacus vehicula, aliquam purus quis, pharetra lorem.</p>
    <p style="text-align: center; "><img src="http://localhost/church_management/uploads/blog_uploads/xyCJ2eOgO9/1631782650_churh-bg1.jpg" style="width: 50%;"></p>
    <p style="text-align: center; "><br></p>
    <p><br></p>
    <?php include(base_app.'inc/body_block_end.php') ?>
</body>
</html>
