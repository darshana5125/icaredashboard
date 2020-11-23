<?php include($_SERVER['DOCUMENT_ROOT'] . '/icaredashboard/ums/inc/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mask ticket title</title>
    <link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <?php
                $table = "";
                $table .= '<table class="table">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Mask Article Body</th>
                    
                    </tr>
                </thead>
                <tbody>';



                //require __DIR__ . '/../vendor/autoload.php';
                //require __DIR__ . '/../vendor/autoload.php';
                require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

                use Pachico\Magoo\Magoo;

                $magoo = new Magoo();
                $magoo->pushCreditCardMask('*');

                //$mySensitiveString = 'This is my credit card number: 4815 4506 0005 9152 sdfk sfsfk';

                $query = "select id,a_body as body from article";
                $query_run = mysqli_query($connection, $query);
                $body = "";
                $count = 0;

                while ($result = mysqli_fetch_array($query_run)) {
                    $id = $result['id'];
                    //$tn = $result['tn'];
                    $body =  mysqli_real_escape_string($connection,$result['body']);
                    $regex = '/(?:\d[ \t-]*?){13,19}/m';
                    $matches = [];
                    preg_match_all($regex, $body, $matches);
                    if (!empty($matches[0])) {
                        $maskbody = $magoo->getMasked($body . PHP_EOL);
                        //echo $count."     ". $masktitle.'<br>';
                        //$count++;
                        $update_query = "update article set a_body='" . $maskbody . "' where id=" . $id;
                        if (mysqli_query($connection, $update_query)) {
                            $count++;
                            //echo $count." ".$masktitle." ".$tn.'<br>';
                            $table .= '<tr>
            <td>' . $count . '</td>
            <td>' . $maskbody . '</td>
            
            </tr>';
                        } else {
                            echo "Error updating record: " . mysqli_error($connection);
                        }
                    }
                }
                //echo $count." records masked";
                $table .= '</tbody></table>';
                ?>
                <div style="margin-top:20px;" class="alert alert-success">
                    <?php echo $count . " records masked."; ?>
                </div>
                <?php echo $table;
                ?>
            </div>
        </div>
    </div>
</body>
</html>