<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Little Ezra | Lev's Delight Farm</title>
    <link type="text/css" rel="stylesheet" href="css/main.css" />

    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
    <!-- jQuery Templates - BEGIN -->
    <script id="previewTmpl" type="text/x-jquery-tmpl">
        <div id="ib-img-preview" class="ib-preview">
            <img src="${src}" alt="" class="ib-preview-img"/>
            <span class="ib-preview-descr" style="display:none;">${description}</span>
            <div class="ib-nav" style="display:none;">
                <span class="ib-nav-prev">Previous</span>
                <span class="ib-nav-next">Next</span>
            </div>
            <span class="ib-close" style="display:none;">X</span>
            <div class="ib-loading-large" style="display:none;">Loading...</div>
        </div>		
    </script>
    <script id="contentTmpl" type="text/x-jquery-tmpl">	
        <div id="ib-content-preview" class="ib-content-preview">
            <div class="ib-teaser" style="display:none;">{{html teaser}}</div>
            <div class="ib-content-full" style="display:none;">{{html content}}</div>
            <span class="ib-close" style="display:none;">Close Preview</span>
        </div>
    </script>	

<!-- jQuery Templates - END -->
</head>


<?php
// Turn on all error reporting and connect to the database once.
error_reporting(E_ALL);
require_once('../connect.php');
error_log("Ezras Page has been loaded");
?>

<body>
    
    <header>
    <div id="logo">
        <img class="titleText" src="images/LittleEzra.png" />
        <img class="titlePicture" src="images/ezra-sleeping.jpg" />
    </div>
    </header>

    <!-- Other Image Gallery Ideas -->

    <!-- Responsive Image Gallery with Thumbnail Carousel - Probably what we will go with -->
    <!-- http://tympanus.net/codrops/2011/09/20/responsive-image-gallery/ -->

    <!-- Picachoose -->
    <!-- http://www.pikachoose.com/ -->

    <?php
        //Query for Pictures of Ezra
        $ezraShowQuery = "SELECT * FROM ezraShows WHERE isActive = 1 ORDER BY timestamp DESC";
        $ezraShowStatement = $dbh->query($ezraShowQuery);
    ?>


    <!-- Draggable Image Boxes Grid - BEGIN -->
    <!-- http://tympanus.net/codrops/2011/10/07/draggable-image-boxes-grid/ -->
    <div id="ib-main-wrapper" class="ib-main-wrapper">
        <div class="ib-main">

            <h2 class="monthHeader">March and April 2013</h2>
            <?php foreach($ezraShowStatement as $row) { ?>
                <a href="#">
                    <img src="<?php echo $row['thumbLocation']?>" data-largesrc="<?php echo $row['largeLocation']?>" alt="<?php echo $row['desc']?>" />
                    <span><?php echo $row['desc'] ?></span>
                </a>
            <?php } ?>
            
            <a href="#">
                <img src="images/dancing-boy.jpg" data-largesrc="images/dancing-boy.jpg" alt="Dancing Boy" />
                <span>Dancing Boy</span>
            </a>


    <!-- Draggable Image Boxes Grid - END -->
    <!-- JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="js/jquery.kinetic.js"></script>
    <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
    <script src="js/main.js"></script>


</body>
</html>
