<?php
require_once 'includes/config.php';
require_once DIR_BASE . 'includes/objCon.php';
spl_autoload_register(function ($class) {
    include DIR_BASE . 'classes/' . strtolower($class) . '.php';
});

$handle = new t2revent($objCon);
$ids = $handle->findAllPkey("WHERE pop = 1 LIMIT 3");
$ids2 = $handle->findAllPkey();
?>
<!DOCTYPE html>
<html>
    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link href="style/bootstrap.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <link href="style/main.css" rel="stylesheet" type="text/css"/>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,600' rel='stylesheet' type='text/css'>
        <title>Ticket To Ride</title>
    </head>
    <body id="body">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <p class="modal-dato"></p>
                        <p class="modal-notickets"></p>
                        <p class="modal-tod"></p>
                        <p class="modal-loc"></p>
                        <p class="modal-sum"></p>
                        <p class="modal-eventtype"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <h1 id="firsth1">Upcomming fan favorites</h1>
            <div id="main">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <?php
                    foreach ($ids as $id) {
                        $new = new t2revent($objCon, $id);
                        ?>
                        <div class="col-lg-2 thumb">
                            <a href="#"><img class="indeximgs" src="imgs/<?php echo $new->getImage(); ?>" alt=""/></a>
                            <div class="<?php echo $new->getEventtype(); ?>"></div>
                        </div>
                        <div class="col-lg-1"></div>
                    <?php } ?>
                    <div class="col-lg-2"></div>
                </div>
                <?php #include 'includes/navbar.php';  ?>
            </div>
            <a href="#jump"><button id="indexbtn" type="button" class="btn btn-default btn-lg">All Events</button></a>
            <div id="bottomcontent">
                <div class="row">
                    <?php
                    foreach ($ids2 as $id) {
                        $loophandle = new t2revent($objCon, $id);
                        ?>
                        <div class="col-lg-1"></div>
                        <div id="jump" class="col-lg-2 buybox">
                            <a href="#event" class="buttonModal" data-id="<?php echo $loophandle->getId(); ?>" data-toggle="modal" data-target="#myModal"><img class="test" class="" src="imgs/<?php echo $loophandle->getImage(); ?>" alt=""/></a>
                            <div class="row">
                                <div class="col-lg-12 buttonbox jump-box" data-parentid="<?php echo $loophandle->getId(); ?>">
                                    <p class="hidden jump-title"><?php echo $loophandle->getTitle(); ?></p>
                                    <p class="hidden jump-notickets">Number of tickets: <?php echo $loophandle->getAntal(); ?></p>
                                    <p class="hidden jump-loc">Location: <?php echo $loophandle->getLocation(); ?></p>
                                    <p class="hidden jump-sum">Summery: <?php echo $loophandle->getSum(); ?></p>
                                    <p class="hidden jump-eventtype">Event type: <?php echo $loophandle->getEventtype(); ?></p>
                                    <p class="hidden jump-tod">Time of day: <?php echo $loophandle->getTid(); ?></p>
                                    <p class="hidden jump-dato">Date: <?php echo $loophandle->getDato(); ?></p>
                                    <input class="bottominput" type="number" min="1" name="not" placeholder="No. tickets"/>
                                    <a href="#"><button class="bottombtn" type="button" class="btn btn-default btn-lg"><p class="btntxt">Buy</p></button></a>
                                </div>
                            </div>
                            <div class="<?php echo $loophandle->getEventtype(); ?> bottomcolor"></div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div id="filler"></div>
        </div>
        <script src="includes/jquery-2.2.4.min.js" type="text/javascript"></script>
        <script src="js/modal.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('a[href^="#"]').on('click', function (e) {
                    e.preventDefault();

                    var target = this.hash;
                    var $target = $(target);

                    $('html, body').stop().animate({
                        'scrollTop': $target.offset().top
                    }, 900, 'swing', function () {
                        window.location.hash = target;
                    });
                });
            });
        </script>
    </body>
</html>