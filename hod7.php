<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

if(isset($_POST['submit'])){

	$fulldate=$_POST['date'];

	$year=substr($fulldate,-4);
	$month=substr($fulldate,0,2);
	$day=substr($fulldate, 3,-5);

	$date="'".$year."-".$month."-".$day."'";


 $table_list="";

function a($res){
 $responsible="";
 $res_query="select first_name from users where id=$res"; 
 $res_query_run=mysqli_query($connection,$res_query);
 while ($result=mysqli_fetch_array($res_query_run)) {
  $responsible=$result['first_name'];
 }
 return $responsible;
}

 //number of open tickets for current week(as at last sunday)
$query= "select count(th.ticket_id) as count,substring_index((select name as name
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
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,13,14,30,33) 
                      and t.customer_id not in('phl-ubp') 
                      group by res_name
                      order by count desc";



$query2="select count(th.ticket_id) as count,substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) <= DATE_SUB(".$date.",INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) <= DATE_SUB(".$date.",INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) <= DATE_SUB(".$date.",INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,13,14,30,33) and t.customer_id not in('phl-ubp') 
                      group by res_name
                      order by count desc";


   $query_run=mysqli_query($connection,$query);
   $query2_run=mysqli_query($connection,$query2);

$resp=array();
while ($result_set=mysqli_fetch_array($query_run)) { 

array_push($resp,$result_set['res_name']);

}

while ($result2_set=mysqli_fetch_array($query2_run)) { 

array_push($resp,$result2_set['res_name']);

}
  





 

 


foreach ((array_unique($resp)) as $res_name) {

echo $res_name

    $query_current_ibl="select count(th.ticket_id) as count,substring_index((select name as name
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
                                        ) ), '%', -1)=$res_name and                  
                                        th.state_id  in ('1','4','12','20','23','26','27','28','29','32') and t.customer_id not in('phl-ubp') and t.queue_id not in(41)";
    $query_current_ibl_run=mysqli_query($connection,$query_current_ibl);
     while($result_set_current_ibl=mysqli_fetch_array($query_current_ibl_run)){
      $table_list.='<tr class="data"><td class="res">'.a($res_name).'</td><td class="center">'. $ibl_cur=$result_set_current_ibl['count'].'</td>';
     }   

  

     
     

     
  
  
 }

$table_list.='</tbody></table>';




}

?>
<html lang="en">
<head>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
  <meta charset="UTF-8">
  <title>Document</title>
  <style type="text/css">
<!--
@import url("table.css");
-->
</style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script> 
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" integrity="sha384-7tY7Dc2Q8WQTKGz2Fa0vC4dWQo07N4mJjKvHfIGnxuC4vPqFGFQppd9b3NWpf18/" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js" integrity="sha384-AA9W1Nq9J8i7nsiEg2VYPkZwZRTm69E+g0MYx49M4CNocl4Iug7wguHBZur9xjdK" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js" integrity="sha384-EWzuvK0oOTllvcaNOEob7R0Ci0UQqP5xfC6P9CQ2cUYwHFuckhT9fvDaDY3DD0HL" crossorigin="anonymous"></script>
    <script src="hod/anujular_hod.js"></script>
  <link href="hod.css" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="ums/css/main.css">
</head>
<body>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
  <main>
  
  <form name="hod" method="POST" action="hod6.php">
    
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


		


   

  </main>

   <script type="text/javascript">

   $(document).ready( function(){

  

      var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;


    $('#PM').click(function() {
      

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Thilini " || customerId=="Dilshan" || customerId=="Dinuka" || customerId=="Oshan"  || customerId=="Sanath" || customerId=="Pristly" || customerId=="Tharindu" || customerId=="Dulan" || customerId=="Hareen" || customerId=="Jeewani" || customerId=="Praveen"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
          var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;
  });

    $('#PHL').click(function() {

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Lahiru" || customerId=="Maheshan" ||  customerId=="John Robin C. "){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });

      var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows; 

  });



    $('#Venura').click(function() {

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
         
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Venura"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

    $('#Pubudu').click(function() {

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);

       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Pubudu"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

    $('#Sanjeewa').click(function() {

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Sanjeewa"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

      $('#Prasad').click(function() {

         $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);

       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Prasad"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

      $('#Don').click(function() {

         $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);

       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Don" || customerId=="Ishara"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

      $('#Support').click(function() {

         $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);

       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Roshan"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });


      $('#Chinthaka').click(function() {

         $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Chinthaka"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

      $('#Nimnaz').click(function() {

         $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Nimnaz"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

      $('#Gayanee').click(function() {

         $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);

       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Gayanee"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });


   $('#Uditha').click(function() {

     $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Uditha"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

    $('#All').click(function() {

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });
    //$(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId!=""){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  }); 



var customerId="";
var pm_ibl=0;
var pm_ibl_prv=0;
var pm_ibl_chg=0;
var pm_info=0;
var pm_info_prv=0;
var pm_info_chg=0;
var pm_hold=0;
var pm_hold_prv=0;
var pm_hold_chg=0;
var pm_shd=0;
var pm_shd_prv=0;
var pm_shd_chg=0;
var pm_efe_cur=0;
var pm_efe_prv=0;
var pm_efe_chg=0;


var phl_ibl=0;
var phl_ibl_prv=0;
var phl_ibl_chg=0;
var phl_info=0;
var phl_info_prv=0;
var phl_info_chg=0;
var phl_hold=0;
var phl_hold_prv=0;
var phl_hold_chg=0;
var phl_shd=0;
var phl_shd_prv=0;
var phl_shd_chg=0;
var phl_efe_cur=0;
var phl_efe_prv=0;
var phl_efe_chg=0;

var sup_ibl=0;
var sup_ibl_prv=0;
var sup_ibl_chg=0;
var sup_info=0;
var sup_info_prv=0;
var sup_info_chg=0;
var sup_hold=0;
var sup_hold_prv=0;
var sup_hold_chg=0;
var sup_shd=0;
var sup_shd_prv=0;
var sup_shd_chg=0;
var sup_efe_cur=0;
var sup_efe_prv=0;
var sup_efe_chg=0;

var imp_ibl=0;
var imp_ibl_prv=0;
var imp_ibl_chg=0;
var imp_info=0;
var imp_info_prv=0;
var imp_info_chg=0;
var imp_hold=0;
var imp_hold_prv=0;
var imp_hold_chg=0;
var imp_shd=0;
var imp_shd_prv=0;
var imp_shd_chg=0;
var imp_efe_cur=0;
var imp_efe_prv=0;
var imp_efe_chg=0;




var efe=0;
var ibl_chg=0;
var info_chg=0;
var hold_chg=0;
var shd_chg=0;
var efe_prv=0;
var efe_chg=0;



 $('#myTable tr').each(function() {
    customerId = $(this).find(".res").html(); 
     if(customerId=="Thilini " || customerId=="Dilshan" || customerId=="Dinuka" || customerId=="Oshan"  || customerId=="Sanath" || customerId=="Pristly" || customerId=="Tharindu" || customerId=="Dulan" || customerId=="Hareen" || customerId=="Jeewani" || customerId=="Praveen"){

      pm_ibl+=parseInt($(this).children('td:nth-child(2)').text());  
      pm_ibl_prv+=parseInt($(this).children('td:nth-child(3)').text()); 
      pm_ibl_chg+=parseInt($(this).children('td:nth-child(4)').text()); 
      pm_info+=parseInt($(this).children('td:nth-child(5)').text()); 
      pm_info_prv+=parseInt($(this).children('td:nth-child(6)').text()); 
      pm_info_chg+=parseInt($(this).children('td:nth-child(7)').text()); 
      pm_hold+=parseInt($(this).children('td:nth-child(8)').text()); 
      pm_hold_prv+=parseInt($(this).children('td:nth-child(9)').text()); 
      pm_hold_chg+=parseInt($(this).children('td:nth-child(10)').text()); 
      pm_shd+=parseInt($(this).children('td:nth-child(11)').text()); 
      pm_shd_prv+=parseInt($(this).children('td:nth-child(12)').text()); 
      pm_shd_chg+=parseInt($(this).children('td:nth-child(13)').text()); 
      pm_efe_cur+=parseInt($(this).children('td:nth-child(14)').text()); 
      pm_efe_prv+=parseInt($(this).children('td:nth-child(15)').text());
      pm_efe_chg+=parseInt($(this).children('td:nth-child(16)').text());


      //$('myTable td').attr('id', 'test');
	  $(this).attr('id','test');
      
      $(this).hide();     

     }

     else if(customerId=="Lahiru" || customerId=="Maheshan" || customerId=="John Robin C. "){

      phl_ibl+=parseInt($(this).children('td:nth-child(2)').text());  
      phl_ibl_prv+=parseInt($(this).children('td:nth-child(3)').text()); 
      phl_ibl_chg+=parseInt($(this).children('td:nth-child(4)').text()); 
      phl_info+=parseInt($(this).children('td:nth-child(5)').text()); 
      phl_info_prv+=parseInt($(this).children('td:nth-child(6)').text()); 
      phl_info_chg+=parseInt($(this).children('td:nth-child(7)').text()); 
      phl_hold+=parseInt($(this).children('td:nth-child(8)').text()); 
      phl_hold_prv+=parseInt($(this).children('td:nth-child(9)').text()); 
      phl_hold_chg+=parseInt($(this).children('td:nth-child(10)').text()); 
      phl_shd+=parseInt($(this).children('td:nth-child(11)').text()); 
      phl_shd_prv+=parseInt($(this).children('td:nth-child(12)').text()); 
      phl_shd_chg+=parseInt($(this).children('td:nth-child(13)').text());
      phl_efe_cur+=parseInt($(this).children('td:nth-child(14)').text()); 
      phl_efe_prv+=parseInt($(this).children('td:nth-child(15)').text());
      phl_efe_chg+=parseInt($(this).children('td:nth-child(16)').text());

      $(this).hide();  


     }

     else if(customerId=="Ishara" || customerId=="Don" ){

      imp_ibl+=parseInt($(this).children('td:nth-child(2)').text());  
      imp_ibl_prv+=parseInt($(this).children('td:nth-child(3)').text()); 
      imp_ibl_chg+=parseInt($(this).children('td:nth-child(4)').text()); 
      imp_info+=parseInt($(this).children('td:nth-child(5)').text()); 
      imp_info_prv+=parseInt($(this).children('td:nth-child(6)').text()); 
      imp_info_chg+=parseInt($(this).children('td:nth-child(7)').text()); 
      imp_hold+=parseInt($(this).children('td:nth-child(8)').text()); 
      imp_hold_prv+=parseInt($(this).children('td:nth-child(9)').text()); 
      imp_hold_chg+=parseInt($(this).children('td:nth-child(10)').text()); 
      imp_shd+=parseInt($(this).children('td:nth-child(11)').text()); 
      imp_shd_prv+=parseInt($(this).children('td:nth-child(12)').text()); 
      imp_shd_chg+=parseInt($(this).children('td:nth-child(13)').text());
      imp_efe_cur+=parseInt($(this).children('td:nth-child(14)').text()); 
      imp_efe_prv+=parseInt($(this).children('td:nth-child(15)').text());
      imp_efe_chg+=parseInt($(this).children('td:nth-child(16)').text());

      $(this).hide();  


     }

      


     else if(customerId=="Roshan"){

      sup_ibl+=parseInt($(this).children('td:nth-child(2)').text());  
      sup_ibl_prv+=parseInt($(this).children('td:nth-child(3)').text()); 
      sup_ibl_chg+=parseInt($(this).children('td:nth-child(4)').text()); 
      sup_info+=parseInt($(this).children('td:nth-child(5)').text()); 
      sup_info_prv+=parseInt($(this).children('td:nth-child(6)').text()); 
      sup_info_chg+=parseInt($(this).children('td:nth-child(7)').text()); 
      sup_hold+=parseInt($(this).children('td:nth-child(8)').text()); 
      sup_hold_prv+=parseInt($(this).children('td:nth-child(9)').text());
      sup_hold_chg+=parseInt($(this).children('td:nth-child(10)').text());  
      sup_shd+=parseInt($(this).children('td:nth-child(11)').text()); 
      sup_shd_prv+=parseInt($(this).children('td:nth-child(12)').text()); 
      sup_hold_chg+=parseInt($(this).children('td:nth-child(13)').text()); 
      sup_efe_cur+=parseInt($(this).children('td:nth-child(14)').text()); 
      sup_efe_prv+=parseInt($(this).children('td:nth-child(15)').text());
      sup_efe_chg+=parseInt($(this).children('td:nth-child(16)').text());

      $(this).hide();  


     }

    
      
        
     

 });
 var pm_ibl_chg=pm_ibl-pm_ibl_prv;
 var pm_info_chg=pm_info-pm_info_prv;
 var pm_hold_chg=pm_hold-pm_hold_prv;
 var pm_shd_chg=pm_shd-pm_shd_prv;
 var pm_efe=pm_ibl+pm_info+pm_hold+pm_shd;
 var pm_efe_prv=pm_ibl_prv+pm_info_prv+pm_hold_prv+pm_shd_prv;
 var pm_efe_chg=pm_efe-pm_efe_prv;

 var phl_ibl_chg=phl_ibl-phl_ibl_prv;
 var phl_info_chg=phl_info-phl_info_prv;
 var phl_hold_chg=phl_hold-phl_hold_prv;
 var phl_shd_chg=phl_shd-phl_shd_prv;
 var phl_efe=phl_ibl+phl_info+phl_hold+phl_shd;
 var phl_efe_prv=phl_ibl_prv+phl_info_prv+phl_hold_prv+phl_shd_prv;
 var phl_efe_chg=phl_efe-phl_efe_prv;



 var sup_ibl_chg=sup_ibl-sup_ibl_prv;
 var sup_info_chg=sup_info-sup_info_prv;
 var sup_hold_chg=sup_hold-sup_hold_prv;
 var sup_shd_chg=sup_shd-sup_shd_prv;
 var sup_efe=sup_ibl+sup_info+sup_hold+sup_shd;
 var sup_efe_prv=sup_ibl_prv+sup_info_prv+sup_hold_prv+sup_shd_prv;
 var sup_efe_chg=sup_efe-sup_efe_prv;

 var ibl_tot=0;
 var ibl_tot_prv=0;
 var ibl_tot_chg=0;
 var info_tot=0;
 var info_tot_prv=0;
 var info_tot_chg=0;
 var hold_tot=0;
 var hold_tot_prv=0;
 var hold_tot_chg=0;
 var shd_tot=0;
 var shd_tot_prv=0;
 var shd_tot_chg=0;
 var efe_tot=0;
 var efe_tot_prv=0;
 var efe_tot_chg=0;



$('#myTable tr:last').after('<tr class="grp" id="grp"><td>PM</td>'+'<td class="center">'+pm_ibl+'</td><td class="previous">'+pm_ibl_prv+'</td><td class="change">'+pm_ibl_chg+'</td><td class="center">'+pm_info+'</td><td class="previous">'+pm_info_prv+'</td><td class="change">'+pm_info_chg+'</td><td class="center">'+pm_hold+'</td><td class="previous">'+pm_hold_prv+'</td><td class="change">'+pm_hold_chg+'</td><td class="center">'+pm_shd+'</td><td class="previous">'+pm_shd_prv+'</td><td class="change">'+pm_shd_chg+'</td><td class="center">'+pm_efe_cur+'</td><td class="previous">'+pm_efe_prv+'</td><td class="change">'+pm_efe_chg+'</td></tr>');

$('#myTable tr:last').after('<tr class="grp" id="grp"><td>Don & Ishara</td><td class="center">'+imp_ibl+'</td><td class="previous">'+imp_ibl_prv+'</td><td class="change">'+imp_ibl_chg+'</td><td class="center">'+imp_info+'</td><td class="previous">'+imp_info_prv+'</td><td class="change">'+imp_info_chg+'</td><td class="center">'+imp_hold+'</td><td class="previous">'+imp_hold_prv+'</td><td class="change">'+imp_hold_chg+'</td><td class="center">'+imp_shd+'</td><td class="previous">'+imp_shd_prv+'</td><td class="change">'+imp_shd_chg+'</td><td class="center">'+imp_efe_cur+'</td><td class="previous">'+imp_efe_prv+'</td><td class="change">'+imp_efe_chg+'</td></tr>');



$('#myTable tr:last').after('<tr class="grp" id="grp"><td>PHL</td>'+'<td class="center">'+phl_ibl+'</td><td class="previous">'+phl_ibl_prv+'</td><td class="change">'+phl_ibl_chg+'</td><td class="center">'+phl_info+'</td><td class="previous">'+phl_info_prv+'</td><td class="change">'+phl_info_chg+'</td><td class="center">'+phl_hold+'</td><td class="previous">'+phl_hold_prv+'</td><td class="change">'+phl_hold_chg+'</td><td class="center">'+phl_shd+'</td><td class="previous">'+phl_shd_prv+'</td><td class="change">'+phl_shd_chg+'</td><td class="center">'+phl_efe_cur+'</td><td class="previous">'+phl_efe_prv+'</td><td class="change">'+phl_efe_chg+'</td></tr>');

$('#myTable tr:last').after('<tr class="grp" id="grp"><td>Support</td>'+'<td class="center">'+sup_ibl+'</td><td class="previous">'+sup_ibl_prv+'</td><td class="change">'+sup_ibl_chg+'</td><td class="center">'+sup_info+'</td><td class="previous">'+sup_info_prv+'</td><td class="change">'+sup_info_chg+'</td><td class="center">'+sup_hold+'</td><td class="previous">'+sup_hold_prv+'</td><td class="change">'+sup_hold_chg+'</td><td class="center">'+sup_shd+'</td><td class="previous">'+sup_shd_prv+'</td><td class="change">'+sup_shd_chg+'</td><td class="center">'+sup_efe_cur+'</td><td class="previous">'+sup_efe_prv+'</td><td class="change">'+sup_efe_chg+'</td></tr>');




$('#myTable').append('<thead><tr class="totalColumn"><td>Total</td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td></tr></thead>');

$('#myTable tr').each(function(){
   var $td = $(this); 
   var colTotal = 0;
   
    
    $('#myTable tr:not(.head,.totalColumn,.grp)').each(function(){
        colTotal  += parseInt($(this).children().eq($td.index()).html(),10);
    });
    
    $('#myTable thead tr.totalColumn').children().eq($td.index()).html(colTotal);   
  
});

$('#myTable thead tr.totalColumn').children('td:nth-child(1)').css("text-align", "left");
$('#myTable thead tr.totalColumn').children('td:nth-child(1)').html("Total"); 


 $("#myTable").tablesorter( {sortList: [[13,1]] } ); 


  
    $('#myTable tr td.change').each (function () {
       var $cCell = $(this);
       if (Number ($cCell.text()) <= -1) {
          $cCell.css("color", "green");
          $cCell.css("text-align", "center");
          $cCell.css("background-color", "#FFC371");
       }
       else if(Number ($cCell.text()) >= 1){
            $cCell.css("color", "red");
            $cCell.css("text-align", "center");
            $cCell.css("background-color", "#FFC371");
       }
       else{
        $cCell.css("color", "black");
          $cCell.css("text-align", "center");
          $cCell.css("background-color", "#FFC371");
       }
       
    });


      $('#myTable thead tr td.grand_change').each (function () {
       var $cCell = $(this);
       if (Number ($cCell.text()) <= -1) {
          $cCell.css("color", "green");
          $cCell.css("text-align", "center");
          $cCell.css("font-weight", "bold");
          $cCell.css("background-color", "#FFC371");
          
       }
       else if(Number ($cCell.text()) >= 1){
            $cCell.css("color", "red");
            $cCell.css("text-align", "center");
            $cCell.css("font-weight", "bold");
            $cCell.css("background-color", "#FFC371");

       }
       else{
        $cCell.css("color", "black");
          $cCell.css("text-align", "center");
          $cCell.css("font-weight", "bold");
          $cCell.css("background-color", "#FFC371");
       }
       
    });



      $('#myTable thead tr td.grand_previous').each (function () {
       var $cCell = $(this);
       if (Number ($cCell.text()) <= -1) {
          $cCell.css("color", "green");
          $cCell.css("text-align", "center");
          $cCell.css("font-weight", "bold");
          $cCell.css("background-color", "#8e9eab");
          
       }
       else if(Number ($cCell.text()) >= 1){
            $cCell.css("color", "red");
            $cCell.css("text-align", "center");
            $cCell.css("font-weight", "bold");
            $cCell.css("background-color", "#8e9eab");

       }
       else{
        $cCell.css("color", "black");
          $cCell.css("text-align", "center");
          $cCell.css("font-weight", "bold");
          $cCell.css("background-color", "#8e9eab");
       }
       
    });
    


//--------------------------------------------------------------------------------------------------------------------------------------------------//


// Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(iblchart);
      google.charts.setOnLoadCallback(effectivechart);
      google.charts.setOnLoadCallback(pmchart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function iblchart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'HOD');
        data.addColumn('number', 'CSR');

        $('#myTable tr.data:visible, #myTable tr#grp').each(function() {

        //$('#myTable tr.data').each(function() {

          
        
      
  hod=$(this).children('td:nth-child(1)').text();
  count=parseInt($(this).children('td:nth-child(2)').text());


//alert(test2);


 data.addRows([[hod, count]]);


});
        //data.addRows([[hod2, count2]]);
        
       

        // Set chart options
        var options = {'title':'IBL Pending',
                       'width':600,
                       'height':500};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }




       function effectivechart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'HOD');
        data.addColumn('number', 'CSR');

        $('#myTable tr.data:visible, #myTable tr#grp').each(function() {

        //$('#myTable tr.data').each(function() {

          
        
      
  hod=$(this).children('td:nth-child(1)').text();
  count=parseInt($(this).children('td:nth-child(14)').text());


//alert(test2);


 data.addRows([[hod, count]]);


});
        //data.addRows([[hod2, count2]]);
        
       

        // Set chart options
        var options = {'title':'Effective CSR',
                       'width':600,
                       'height':500};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }


       
      function pmchart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'HOD');
        data.addColumn('number', 'CSR');
		 var id="";

        $('#myTable tr.data:hidden' && '#myTable tr#test').each(function() {

         // myTable tr.data

           //customerId = $(this).find(".res").html(); 
           //customerId=customerId.trim();
		  
     //if(customerId=="Thilini" && id!="Thilini")

     // || customerId=="Dilshan" || customerId=="Dinuka" || customerId=="Oshan"  || customerId=="Sanath" || customerId=="Pristly" || customerId=="Tharindu" || customerId=="Dulan" || customerId=="Hareen" || customerId=="Jeewani")
     //{
		 //id="Thilini";

        //$('#myTable tr.data').each(function() {      
        
      
  hod=$(this).children('td:nth-child(1)').text();
  count=parseInt($(this).children('td:nth-child(2)').text());
//}








//alert(test2);


 data.addRows([[hod, count]]);


});
        //data.addRows([[hod2, count2]]);
        
       

        // Set chart options
        var options = {'title':'PM CSR',
                       'width':600,
                       'height':500};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }





     

}) ;

</script>
<div style="float:left; width:33%;" class="left" id="chart_div"></div>
<div style="float:left; width:33%;" class="left" id="chart_div2"></div>
<div style="float:left; width:33%;" class="left" id="chart_div3"></div>
</body>
</html>








