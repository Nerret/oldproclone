<?php
require_once '../../includes/config.php';
require_once DIR_BASE . 'includes/objCon.php';
spl_autoload_register(function ($class) {
    include DIR_BASE . 'classes/' . strtolower($class) . '.php';
});

$handle = new t2revent($objCon);
$ids = $handle->findAllPkey();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link href="../../style/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <link href="../../style/main.css" rel="stylesheet" type="text/css"/>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,600' rel='stylesheet' type='text/css'>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <title>T2R Admin</title>
    </head>
    <body id="admin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <form action="action.php" method="POST">
                            <table class="table table-hover table-responsive">
                                <tr>
                                    <th>Event name</th>
                                    <th>Venue hold</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Pop</th>
                                    <th>Description</th>
                                </tr>
                                <tbody>
                                    <?php
                                    foreach ($ids as $id) {
                                        $new = new t2revent($objCon, $id);
                                        ?>
                                        <tr>
                                            <td><input type="text" name="name[<?php echo $id; ?>]" value="<?php echo $new->getTitle(); ?>"/></td>
                                            <td><input type="text" name="antal[<?php echo $id; ?>]" value="<?php echo $new->getAntal(); ?>"/></td>
                                            <td><input type="text" name="dato[<?php echo $id; ?>]" value="<?php echo $new->getDato(); ?>"/></td>
                                            <td><input type="text" name="tid[<?php echo $id; ?>]" value="<?php echo $new->getTid(); ?>"/></td>
                                            <td><input type="text" name="loc[<?php echo $id; ?>]" value="<?php echo $new->getLocation(); ?>"/></td>
                                            <td><input type="text" id="typetd" name="type[<?php echo $id; ?>]" value="<?php echo $new->getEventtype(); ?>"/></td>
                                            <td><input type="text" id="poptd" name="pop[<?php echo $id; ?>]" value="<?php echo $new->getPop(); ?>"/></td>
                                            <td><textarea name="sum[<?php echo $id; ?>]" value="<?php echo $new->getSum(); ?>"><?php echo $new->getSum(); ?></textarea></td>
                                    <input type="hidden" name="id" value="<?php echo $new->getId(); ?>"/>
                                    <td><button id="updatebtn" type="submit" name="upbtn" value="<?php echo $id; ?>" class="btn btn-warning">Update</button></td>
                                    <td><button id="delbtn" type="submit" name="delbtn" value="<?php echo $id; ?>" class="btn btn-danger">Delete</button></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </form> 
                    </div>
                </div>
                <div class="col-md-3">
                    <h1 id="ch1">Create event</h1>
                    <form action="createvent.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Event title</label>
                            <input type="text" class="form-control" id="eventtitle" placeholder="Event title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Number of guests</label>
                            <input type="text" class="form-control" id="noguests" placeholder="No. guests" name="guests">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Date</label>
                            <input type="text" class="form-control" id="datepicker" placeholder="Date" name="dato">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Time of day</label>
                            <input type="text" class="form-control" id="time" placeholder="Time of day" name="tod">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Location</label>
                            <input type="text" class="form-control" id="location" placeholder="Location" name="loc">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Summery of event</label>
                            <textarea class="form-control" id="exampleInputPassword1" placeholder="Summery of event" name="sum"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Thumb file</label>
                            <input type="file" name="upload" id="fileupload">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <script src="//code.jquery.com/jquery-1.10.2.js"></script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <script>
                $(function () {
                    $("#datepicker").datepicker();
                });
            </script>
        </div>
    </body>
</html>
