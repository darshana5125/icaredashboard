<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

if(isset($_POST['submit'])){

	$fulldate=$_POST['date'];

	$year=substr($fulldate,-4);
	$month=substr($fulldate,0,2);
	$day=substr($fulldate, 3,-5);

	echo $date="'".$year."-".$month."-".$day."'";

	 $table_list="";

$table_list.='<table class="hodlist" id="myTable" border="1" style="border-collapse: collapse;">  
<thead><tr><th>Responsible</th><th>Count</th></tr></thead><tbody>';

$prasad="select count(t.tn) as count,substring_index((select name as name
                          from ticket_history
                            where id = (
                            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                            and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                            ) ), '%', -1) as res_name,u2.first_name as responsible
                              from ticket_history th
                              inner join users u2 on u2.id=
                              substring_index((select name as name
                              from ticket_history
                                where id = (
                                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                ) ), '%', -1) 
                                  inner join (
                                  select max(h.id) as max_hist, h.ticket_id
                                  from ticket_history h
                                  inner join ticket ti
                                  on h.ticket_id=ti.id  
                                    where date(h.change_time) <= ".$date." and
                                    date(h.change_time) >= '2014-11-10' 
                                    group by h.ticket_id
                                    ) open_tickets on open_tickets.max_hist = th.id
                                    inner join ticket t on t.id = th.ticket_id
                                    inner join users u1 on t.responsible_user_id=u1.id
                                      where substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1)=56 and                  
                                        th.state_id  in ('1','4','12','20','23','26','27','28','29','32') and t.customer_id not in('phl-ubp') and t.queue_id not in(41) and t.customer_id in ('KHM-VAT','LKA-NDB')";
$prasad_result=mysqli_query($connection,$prasad);
while($result_set_prasad=mysqli_fetch_array($prasad_result)){
	$table_list.='<tr class="data"><td class="res">'.$result_set_prasad['responsible'].'</td><td class="center">'. $result_set_prasad['count'].'</td></tr>';
}


$prasad2="select t.tn as csr,t.customer_id,substring_index((select name as name
                          from ticket_history
                            where id = (
                            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                            and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                            ) ), '%', -1) as res_name,u2.first_name as responsible
                              from ticket_history th
                              inner join users u2 on u2.id=
                              substring_index((select name as name
                              from ticket_history
                                where id = (
                                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                ) ), '%', -1) 
                                  inner join (
                                  select max(h.id) as max_hist, h.ticket_id
                                  from ticket_history h
                                  inner join ticket ti
                                  on h.ticket_id=ti.id  
                                    where date(h.change_time) <= ".$date." and
                                    date(h.change_time) >= '2014-11-10' 
                                    group by h.ticket_id
                                    ) open_tickets on open_tickets.max_hist = th.id
                                    inner join ticket t on t.id = th.ticket_id
                                    inner join users u1 on t.responsible_user_id=u1.id
                                      where substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1)=56 and                  
                                        th.state_id  in ('1','4','12','20','23','26','27','28','29','32') and t.customer_id not in('phl-ubp') and t.queue_id not in(41) and t.customer_id in ('KHM-VAT','LKA-NDB') order by t.customer_id";

    $prasad2_result=mysqli_query($connection,$prasad2);
while($result_set_prasad2=mysqli_fetch_array($prasad2_result)){
	$table_list.='<tr class="data"><td class="res">'. $result_set_prasad2['csr'].'</td><td class="res">'. $result_set_prasad2['customer_id'].'</td></tr>';
}


$sanjeewa="select count(t.tn) as count,substring_index((select name as name
                          from ticket_history
                            where id = (
                            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                            and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                            ) ), '%', -1) as res_name,u2.first_name as responsible
                              from ticket_history th
                              inner join users u2 on u2.id=
                              substring_index((select name as name
                              from ticket_history
                                where id = (
                                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                ) ), '%', -1) 
                                  inner join (
                                  select max(h.id) as max_hist, h.ticket_id
                                  from ticket_history h
                                  inner join ticket ti
                                  on h.ticket_id=ti.id  
                                    where date(h.change_time) <= ".$date." and
                                    date(h.change_time) >= '2014-11-10' 
                                    group by h.ticket_id
                                    ) open_tickets on open_tickets.max_hist = th.id
                                    inner join ticket t on t.id = th.ticket_id
                                    inner join users u1 on t.responsible_user_id=u1.id
                                      where substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1)=48 and                  
                                        th.state_id  in ('1','4','12','20','23','26','27','28','29','32') and t.customer_id not in('phl-ubp') and t.queue_id not in(41) and t.customer_id in ('KHM-VAT','LKA-NDB')";
$sanjeewa_result=mysqli_query($connection,$sanjeewa);
while($result_set_sanjeewa=mysqli_fetch_array($sanjeewa_result)){
	$table_list.='<tr class="data"><td class="res">'.$result_set_sanjeewa['responsible'].'</td><td class="center">'. $result_set_sanjeewa['count'].'</td></tr>';
}


$sanjeewa2="select t.tn as csr,t.customer_id,substring_index((select name as name
                          from ticket_history
                            where id = (
                            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                            and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                            ) ), '%', -1) as res_name,u2.first_name as responsible
                              from ticket_history th
                              inner join users u2 on u2.id=
                              substring_index((select name as name
                              from ticket_history
                                where id = (
                                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                ) ), '%', -1) 
                                  inner join (
                                  select max(h.id) as max_hist, h.ticket_id
                                  from ticket_history h
                                  inner join ticket ti
                                  on h.ticket_id=ti.id  
                                    where date(h.change_time) <= ".$date." and
                                    date(h.change_time) >= '2014-11-10' 
                                    group by h.ticket_id
                                    ) open_tickets on open_tickets.max_hist = th.id
                                    inner join ticket t on t.id = th.ticket_id
                                    inner join users u1 on t.responsible_user_id=u1.id
                                      where substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) <= ".$date." and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1)=48 and                  
                                        th.state_id  in ('1','4','12','20','23','26','27','28','29','32') and t.customer_id not in('phl-ubp') and t.queue_id not in(41) and t.customer_id in ('KHM-VAT','LKA-NDB') order by t.customer_id";

    $sanjeewa2_result=mysqli_query($connection,$sanjeewa2);
while($result_set_sanjeewa2=mysqli_fetch_array($sanjeewa2_result)){
	$table_list.='<tr class="data"><td class="res">'. $result_set_sanjeewa2['csr'].'</td><td class="res">'. $result_set_sanjeewa2['customer_id'].'</td></tr>';
}


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script> 
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" integrity="sha384-7tY7Dc2Q8WQTKGz2Fa0vC4dWQo07N4mJjKvHfIGnxuC4vPqFGFQppd9b3NWpf18/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js" integrity="sha384-AA9W1Nq9J8i7nsiEg2VYPkZwZRTm69E+g0MYx49M4CNocl4Iug7wguHBZur9xjdK" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js" integrity="sha384-EWzuvK0oOTllvcaNOEob7R0Ci0UQqP5xfC6P9CQ2cUYwHFuckhT9fvDaDY3DD0HL" crossorigin="anonymous"></script>
    <script src="hod/anujular_hod.js"></script>
  <link href="hod.css" rel="stylesheet" type="text/css" >

</head>
<body>

<form name="hod" method="POST" action="stat.php">
    
    <div style=" margin: 0 200 auto;"ng-app="myApp" ng-controller="myCntrl">
    Select Date:
        <input type="text" uib-datepicker-popup="{{dateformat}}" ng-model="dt" is-open="showdp" max-date="dtmax" name="date"/>
        <span>
            <button type="button" class="btn btn-default" ng-click="showcalendar($event)">
                <i class="glyphicon glyphicon-calendar"></i>
            </button>
             <button  class="btn btn-primary" name="submit" type="submit">Submit</button>
        </span><br>
    </div>
    <script language="javascript">
        angular.module('myApp', ['ngAnimate', 'ui.bootstrap']);
        angular.module('myApp').controller('myCntrl', function ($scope) {
            $scope.today = function () {
                $scope.dt = new Date();
            };
            $scope.dateformat="MM/dd/yyyy";
            $scope.today();
            $scope.showcalendar = function ($event) {
                $scope.showdp = true;
            };
            $scope.showdp = false;        
            $scope.dtmax = new Date();
        });
    </script>
    </form>

    <?php 
    if(isset($_POST['submit'])){
    echo $table_list; 
    }
    ?>
	
</body>
</html>