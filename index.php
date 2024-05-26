<?php

use src\Semej\Semej;
use src\Sanitizer\Sanitizer;

require_once 'classes/Message.php';
require_once 'classes/Helper.php';
require_once 'src/Sanitizer.php';

$_message = new Message();
$ip = Sanitizer::sanitizeInput($_SERVER['REMOTE_ADDR']);
$lastMessage =  $_message->getMessage($ip);
$lastMessages = $_message->getMessages($ip);

if(isset($_POST['save_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // get form and request data
    $user_agent = Sanitizer::sanitizeInput($_SERVER['HTTP_USER_AGENT']);
    $message = Sanitizer::sanitizeInput($_POST['message']); 
    $_message->add($ip, $user_agent, $message);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple Saver</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
        <body>
            <div class="container">
                <header>
                    <h1 class="text-center">Simple Saver</h1>
                </header>
                <main>
            <?php Semej::show(); ?>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="text">Text:</label>
                    <textarea placeholder="type something..." name="message" id="text" cols="30" rows="10" class="form-control"><?= $lastMessage; ?></textarea>
                </div>
                <div class="form-group mt-3">
                    <input name="save_btn" type="submit" value="Save" class="form-control btn btn-dark">
                </div>
            </form>
            <hr>
            <h5>last 10 Messages.</h5>
            <small>
                IP: <?= $ip; ?>
            </small>
            <table class="table table-responsive table-stripped table-info table-bordered">
                <thead>
                    <tr>
                        <th>Browser</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($lastMessages as $message):
                    ?>
                    <tr>
                        <td><?= Helper::getBrowser($message['user_agent']); ?></td>
                        <td><?= $message['message']; ?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
                </main>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </body>
</html>