<?php session_start(); ?>
<?php require_once('ums/inc/connection.php'); ?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>admin-template</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">  
 <link href="dashboard.css" rel="stylesheet" type="text/css">
 <script src="https://use.fontawesome.com/07b0ce5d10.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
    <script language="javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js"></script>
    <script language="javascript" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.14.3.js"></script>

 <!-- google chart -->

  <script type="text/javascript">

 


   
      google.charts.load("current", {packages:["corechart"]});
     google.charts.load('current', {packages:['bar']});
       google.charts.load('current', {'packages':['line']});
 

      //google.charts.setOnLoadCallback(drawChart);
     // google.charts.setOnLoadCallback(drawChart2);
     // google.charts.setOnLoadCallback(drawChart3);

     
     <?php



     if(isset($_POST['submit'])){



  $fulldate=$_POST['date'];

  $year=substr($fulldate,-4);
  $month=substr($fulldate,0,2);
  $day=substr($fulldate, 3,-5);

  $date="'".$year."-".$month."-".$day."'";

     ?>

     $(document).ready(function(){

        $("#pdf").show();
        $("#pdf2").show();
        $("#pdf3").show();
        $("#pdf4").show();
        $("#pdf5").show();
        $("#pdf6").show();
        $("#pdfpm").show();
        $("#pdfpma").show();
        $("#pdf7").show();
        $("#pdf8").show();
        $("#pdf9").show();
        $("#pdf10").show();
        $("#pdf11").show();
        $("#pdf4a").show();
        $("#pdf5a").show();
        $("#pdf6a").show();
        $("#pdf12").show();
        $("#pdf12a").show();
        $("#pdf13").show();
        $("#pdf13a").show();
        $("#pdfpm_cum").show();
        $("#pdfpma_cum").show();

      });

     google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
         <?php
         $result="";

           $query ="select count(t.tn) as count,tp.name as priority,tp.id from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year'
group by tp.name
order by count desc";
$result_set=mysqli_query($connection,$query);

$color3="";
while($result=mysqli_fetch_assoc($result_set)){
 echo "['".$result['priority']."',".$result['count']."],";
}
?>
        ]);


          var options = {
          title: 'CSR by Priority',                 
          titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},         
          //pieSliceText:'label',          
          pieSliceTextStyle: {color:'white',fontName:'Helvetica Neue, Helvetica, and Arial'},
          legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'},  
          is3D:true,    
          //slices: {  0:{offset: 0.2},
            //        1: {offset: 0.3},
              //      4: {offset: 0.3}, }, 
          backgroundColor: 'white',
           //colors: ['#d62d20','#0057e7','#994499','#FF9900','#AAAA11','#6633CC',],
           legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},

        };  

        //save to pdf

    var container = document.getElementById('donutchart');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.PieChart(container);
  var btnSave = document.getElementById('pdf');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false); 

       
        chart.draw(data, options);  
      
    }

    



// bar chart

     
      //$critical=array();




  google.charts.setOnLoadCallback(drawChart2);

     function drawChart2() {

      



 //echo "['".$result['priority']."',".$result['count']."],";

      

        var data = google.visualization.arrayToDataTable([
          ['SLA', 'SLA Met','Within SLA','SLA Not Met'],

       <?php             
              
$all_string="";   

$string="'1 Critical'";

 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and tp.name='1 Critical' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

 if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$string.=",],['2 High'";



 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and tp.name='2 High' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

 if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$string.=",],['3 Medium'"; 


 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and tp.name='3 Medium' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

  if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$string.=",],['4 Low'";
          //$low=array();
 //array_push($low,"'4 Low'");


 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and tp.name='4 Low' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

  if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$all_string=$all_string."[".$string.",],";
//}
 
echo $all_string;


   ?>  

          
        ]);

        var options = {
          
            title: 'CSR by Priority by SLA',
             titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},  
             series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
             hAxis : {textStyle : {fontSize: 12}} ,
             vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
            legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'},
            calc: 'stringify',  
            legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
           
          
        };

         var container = document.getElementById('piechart');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf2');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false); 

       

        chart.draw(data,options);
      }


      
   



 // bar chart
    <?php

         function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

?>
 
google.charts.setOnLoadCallback(drawChart3);
 function drawChart3() {
        var data = google.visualization.arrayToDataTable([


         // ["Element", "Density", { role: "style" }],
          
            <?php

                        
          //$st_array=array();
          $status=array();
          $state="select t.customer_id,ts.name as state from ticket_state ts
                  inner join ticket t
                  on t.ticket_state_id=ts.id
                  where t.customer_id!=''
                  group by ts.name
                  order by ts.name";
          $result_set=mysqli_query($connection,$state);
          array_push($status, "'State'");
          while($result=mysqli_fetch_assoc($result_set)){
            //array_push($st_array, $result['state']);
            array_push($status,",'".$result['state']."'");
          }

          $all_state="";

          foreach ($status as $st) {
            $all_state.= $st;
          }

          echo "[".$all_state.", { role: 'annotation' } ],";

          $query="select t.customer_id from ticket_state ts
                  inner join ticket t
                  on t.ticket_state_id=ts.id
                  where t.customer_id!='' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year'
                  group by t.customer_id
                  order by t.customer_id";
          $cx=""; 
          $all_string2="";      
          $result_set=mysqli_query($connection,$query);
          while($result=mysqli_fetch_assoc($result_set)){
            $cx=$result['customer_id'];

          $query2="select count(t.tn) as count,t.customer_id,ts.name as name from ticket_state ts
                  inner join ticket t
                  on t.ticket_state_id=ts.id
                  where t.customer_id='$cx' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year'
                  group by ts.name
                  order by ts.name";
          $string="'".$cx."'";
          //$actual_status=array();
          $assigned="";
          $aps="";
          $Closed="";
          $cr="";
          $esc="";
          $exp="";
          $fix="";
          $info="";
          $new="";
          $hold="";
          $pc="";
          $ppf="";
          $prs="";
          $psv="";
          $psr="";
          $qa="";
          $tlg="";
          $uo="";

          $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
                if(trim($result2['name'])==trim('Assigned')){
                  $assigned=$result2['count'];                  
                }
                elseif(trim($result2['name'])==trim('Assigned to Pre Sales  ')){
                  $aps=$result2['count'];
                }
                elseif(trim($result2['name'])==trim('Closed')){
                  $Closed=$result2['count'];
                }
                elseif(trim($result2['name'])==trim('CR Processing')){
                  $cr=$result2['count'];

                }
                  elseif(trim($result2['name'])==trim('escalated')){
                  $esc=$result2['count'];

                }
                elseif(trim($result2['name'])==trim('Explanation given')){
                  $exp=$result2['count'];

                }
                elseif(trim($result2['name'])==trim('Fix given for UAT')){
                  $fix=$result2['count'];

                }
                elseif(trim($result2['name'])==trim('Info pending from bank ')){
                  $info=$result2['count'];

                }
                elseif(trim($result2['name'])==trim('new')){
                  $new=$result2['count'];

                }
                elseif(trim($result2['name'])==trim('on hold ')){
                  $hold=$result2['count'];

                }
                elseif(trim($result2['name'])==trim('Pending Closure ')){
                  $pc=$result2['count'];

                }
                 //elseif($result2['name']=='Pending Clarification'){
                  //$pcl=$result2['count'];
                //}
                elseif(trim($result2['name'])==trim('Pending Permanent Fix')){
                  $ppf=$result2['count'];


                }
                   elseif(trim($result2['name'])==trim('Pending Remote Session / Discussion')){
                  $prs=$result2['count'];

                }
                   elseif(trim($result2['name'])==trim('Pending Site visit)')){
                  $psv=$result2['count'];

                }
                   elseif(trim($result2['name'])==trim('Pending SVN Release')){
                  $psr=$result2['count'];

                }

                   elseif(trim($result2['name'])==trim('QA / testing')){
                  $qa=$result2['count'];

                }
                   elseif(trim($result2['name'])==trim('Time Line Given')){
                  $tlg=$result2['count'];

                }
                   elseif(trim($result2['name'])==trim('Under Observation')){
                  $uo=$result2['count'];

                }

              }


                if($assigned!=""){
                  $string.= ",".$assigned;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($aps!=""){
                  $string.= ",".$aps;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($Closed!=""){
                  $string.= ",".$Closed;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($cr!=""){

                  $string.= ",".$cr;
                 }
                 else{

                  $string.= ",0";
                 }

                 if($esc!=""){
                  $string.= ",".$esc;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($exp!=""){
                  $string.= ",".$exp;
                 }
                 else{
                  $string.= ",0";
                 }

                 if($fix!=""){
                  $string.= ",".$fix;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($new!=""){
                  $string.= ",".$new;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($hold!=""){
                  $string.= ",".$hold;
                 }
                 else{
                  $string.= ",0";
                 }


                  if($info!=""){
                  $string.= ",".$info;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($hold!=""){
                  $string.= ",".$hold;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($pc!=""){
                  $string.= ",".$pc;
                 }
                 else{
                  $string.= ",0";
                 }

                  //if($pcl!=""){
                  //$string.= ",".$pcl;
                 //}
                 //else{
                  //$string.= ",0";
                 //}
                  if($ppf!=""){
                  $string.= ",".$ppf;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($psv!=""){
                  $string.= ",".$psv;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($prs!=""){
                  $string.= ",".$prs;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($qa!=""){
                  $string.= ",".$qa;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($tlg!=""){
                  $string.= ",".$tlg;
                 }
                 else{
                  $string.= ",0";
                 }

                  if($uo!=""){
                  $string.= ",".$uo;
                 }
                 else{
                  $string.= ",0";
                 }
                 //search status array to look for select status available
           // if(!in_array($result2['name'], $st_array)){
             // $string.=$result2['count'];
           // }
           // else{
              //$string.="0";
            //}   


           $all_string2=$all_string2."[".$string.",''],";          
          //$num=0;   
          }

       

          

          //$all_string2=$all_string2."['All'".$string2.",''],";

          echo $all_string2;



          ?>  
        
        
      
        ]);

     var options = {
        //legend: { position: 'right',  },
        bar: { groupWidth: '75%' },
        isStacked: true,
         vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
        title: 'CSR by Status',
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
        legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
      };
      //var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));
      var container = document.getElementById('barchart');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf3');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false); 

        chart.draw(data, options);

 }



google.charts.setOnLoadCallback(drawChart4);
 function drawChart4() {


    var data = google.visualization.arrayToDataTable([
      ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],
 <?php 

  $query="select t.customer_id from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and s.sla_state!='' and t.customer_id!=''
group by t.customer_id
order by t.customer_id";
$cx="";
$all_string="";
$result_set=mysqli_query($connection,$query);
while($result=mysqli_fetch_assoc($result_set)){
$cx=$result['customer_id'];


$query2="select count(t.tn) as count,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and t.customer_id='$cx'
group by s.sla_state
order by s.sla_state";

$string="'".$cx."'";
$sla="";
$met="";
$not="";
$within="";
$elements=array();
$result_set2=mysqli_query($connection,$query2);
$num_row=mysqli_num_rows($result_set2);
while($result2=mysqli_fetch_assoc($result_set2)) {
  
  //$string.= ",".$result2['count'];
  if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
    $met=$result2['count'];
    //array_push($elements, "1");
    //$sla.=",'SLA Met'";
  }

   if($result2['sla_state']=="2"){
     // $string.= ",".$result2['count'];
      $within=$result2['count'];
     // array_push($elements, "2");
  //  $sla.=",'Within SLA'";
  }

    if($result2['sla_state']=="3"){
     // $string.= ",".$result2['count'];
      $not=$result2['count'];
      //array_push($elements, "3");
   // $sla.=",'SLA Not Met'";
  
  }
  
 }

 if($met!=""){
  $string.= ",".$met;
 }
 else{
  $string.= ",0";
 }

 if($within!=""){
  $string.= ",".$within;
 }
 else{
  $string.= ",0";
 }

 if($not!=""){
  $string.= ",".$not;
 }
 else{
  $string.= ",0";
 }
   //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
  //echo $sla;
 $all_string=$all_string."[".$string.",''],";
   //$sla="";
}

//echo $all_string;

//echo "[".$string.",''],";

//echo $all_string;

echo $all_string;

//echo "[".$string.",''],";

   ?>
       
       
      ]);

      var options = {
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
        bar: { groupWidth: '75%' },
        isStacked: true,
       
        title: 'CSR by Customer by SLA',
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'},   
      };
     
      var container = document.getElementById('stackchart');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf4');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false); 

      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart'));
        chart.draw(data, options);

 }


 google.charts.setOnLoadCallback(drawChart4a);
 function drawChart4a() {


    var data = google.visualization.arrayToDataTable([
      ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],
 <?php 

  $query="select t.customer_id from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and s.sla_state!='' and t.customer_id!=''
group by t.customer_id
order by t.customer_id";
$cx="";
$all_string="";
$result_set=mysqli_query($connection,$query);
while($result=mysqli_fetch_assoc($result_set)){
$cx=$result['customer_id'];


$query2="select count(t.tn) as count,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and t.customer_id='$cx'
group by s.sla_state
order by s.sla_state";

$string="'".$cx."'";
$sla="";
$met="";
$not="";
$within="";
$elements=array();
$result_set2=mysqli_query($connection,$query2);
$num_row=mysqli_num_rows($result_set2);
while($result2=mysqli_fetch_assoc($result_set2)) {
  
  //$string.= ",".$result2['count'];
  if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
    $met=$result2['count'];
    //array_push($elements, "1");
    //$sla.=",'SLA Met'";
  }

   if($result2['sla_state']=="2"){
     // $string.= ",".$result2['count'];
      $within=$result2['count'];
     // array_push($elements, "2");
  //  $sla.=",'Within SLA'";
  }

    if($result2['sla_state']=="3"){
     // $string.= ",".$result2['count'];
      $not=$result2['count'];
      //array_push($elements, "3");
   // $sla.=",'SLA Not Met'";
  
  }
  
 }

 if($met!=""){
  $string.= ",".$met;
 }
 else{
  $string.= ",0";
 }

 if($within!=""){
  $string.= ",".$within;
 }
 else{
  $string.= ",0";
 }

 if($not!=""){
  $string.= ",".$not;
 }
 else{
  $string.= ",0";
 }
   //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
  //echo $sla;
 $all_string=$all_string."[".$string.",''],";
   //$sla="";
}

//echo $all_string;

//echo "[".$string.",''],";

//echo $all_string;

echo $all_string;

//echo "[".$string.",''],";

   ?>
       
       
      ]);

      var options = {
         vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: 'percent',
       
        title: 'CSR by Customer by SLA %',
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},  
      };
     
      var container = document.getElementById('stackcharta');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf4a');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false); 

      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart'));
        chart.draw(data, options);

 }



 google.charts.setOnLoadCallback(drawChart5);
 function drawChart5() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

      <?php
       $id="";
       $all_string="";
       $query="select s.id,s.name as name from service s
                inner join ticket t
                on t.service_id=s.id
                inner join sla_table st
                on t.tn=st.tn
                where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year'
                group by s.name
                order by s.name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['id'];
          $service=$result['name'];
          $string="'".$service."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,st.sla_state from service s
                    inner join ticket t
                    on t.service_id=s.id 
                    inner join sla_table st
                    on t.tn=st.tn
                    where t.service_id='$id' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and st.sla_state!=''
                    group by st.sla_state
                    order by st.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>
         

           ]);

     var options = {
        bar: { groupWidth: '75%' },
        isStacked: true,
           vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        title: 'CSR by Product by SLA',
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
         series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
        legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
        //width: 900,
      };

    var container = document.getElementById('stackchart3');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf5');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart3'));
        chart.draw(data, options);

 }



 google.charts.setOnLoadCallback(drawChart5a);
 function drawChart5a() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

      <?php
       $id="";
       $all_string="";
       $query="select s.id,s.name as name from service s
                inner join ticket t
                on t.service_id=s.id
                inner join sla_table st
                on t.tn=st.tn
                where MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year'
                group by s.name
                order by s.name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['id'];
          $service=$result['name'];
          $string="'".$service."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,st.sla_state from service s
                    inner join ticket t
                    on t.service_id=s.id 
                    inner join sla_table st
                    on t.tn=st.tn
                    where t.service_id='$id' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and st.sla_state!=''
                    group by st.sla_state
                    order by st.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>
         

           ]);

     var options = {
        bar: { groupWidth: '75%' },
        isStacked: 'percent',
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        title: 'CSR by Product by SLA %',
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
         series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
        legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
        //width: 900,
      };

    var container = document.getElementById('stackchart3a');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf5a');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart3'));
        chart.draw(data, options);

 }



 google.charts.setOnLoadCallback(drawChart6);
 function drawChart6() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

    <?php
       $id="";
       $all_string="";
       $query="select t.responsible_user_id,u.first_name from ticket t 
                inner join users u
                on t.responsible_user_id=u.id
                where MONTH(t.create_time)='10' and YEAR(t.create_time)='2016'
                and t.responsible_user_id in (54,48,56,60,97,49,117,51,42)
                group by t.responsible_user_id
                order by u.first_name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['responsible_user_id'];
          $first_name=$result['first_name'];
          $string="'".$first_name."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,u.first_name,s.sla_state from ticket t 
                    inner join users u
                    on t.responsible_user_id=u.id
                    inner join sla_table s
                    on t.tn=s.tn
                    where t.responsible_user_id='$id' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and s.sla_state!=''
                    group by s.sla_state
                    order by s.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>

           ]);

     var options = {
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: true,
         title:'CSR by Responsible',        
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
         series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}}, 
      };
      //var chart = new google.visualization.ColumnChart(document.getElementById('responsible_sla'));

    var container = document.getElementById('responsible_sla');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf6');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
        chart.draw(data, options);

 }


 google.charts.setOnLoadCallback(drawChart6a);
 function drawChart6a() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

    <?php
       $id="";
       $all_string="";
       $query="select t.responsible_user_id,u.first_name from ticket t 
                inner join users u
                on t.responsible_user_id=u.id
                where MONTH(t.create_time)='10' and YEAR(t.create_time)='2016'
                and t.responsible_user_id in (54,48,56,60,97,49,117,51,42)
                group by t.responsible_user_id
                order by u.first_name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['responsible_user_id'];
          $first_name=$result['first_name'];
          $string="'".$first_name."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,u.first_name,s.sla_state from ticket t 
                    inner join users u
                    on t.responsible_user_id=u.id
                    inner join sla_table s
                    on t.tn=s.tn
                    where t.responsible_user_id='$id' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and s.sla_state!=''
                    group by s.sla_state
                    order by s.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>

           ]);

     var options = {
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: 'percent',
         title:'CSR by Responsible%',        
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}}, 
      };
      //var chart = new google.visualization.ColumnChart(document.getElementById('responsible_sla'));

    var container = document.getElementById('responsible_slaa');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf6a');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
        chart.draw(data, options);

 }

 google.charts.setOnLoadCallback(drawChartpm);
 function drawChartpm() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

    <?php
       $id="";
       $all_string="";
       $query="select t.responsible_user_id,u.first_name from ticket t 
                inner join users u
                on t.responsible_user_id=u.id
                where MONTH(t.create_time)='10' and YEAR(t.create_time)='2016'
                and t.responsible_user_id in (77,63,58,110,20) or u.login='praveen'
                group by t.responsible_user_id
                order by u.first_name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['responsible_user_id'];
          $first_name=$result['first_name'];
          $string="'".$first_name."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,u.first_name,s.sla_state from ticket t 
                    inner join users u
                    on t.responsible_user_id=u.id
                    inner join sla_table s
                    on t.tn=s.tn
                    where t.responsible_user_id='$id' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and s.sla_state!=''
                    group by s.sla_state
                    order by s.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>

           ]);

     var options = {
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: true,
         title:'CSR by PM',        
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
         series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}}, 
      };
      //var chart = new google.visualization.ColumnChart(document.getElementById('responsible_sla'));

    var container = document.getElementById('responsible_sla_pm');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdfpm');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
        chart.draw(data, options);

 }


  google.charts.setOnLoadCallback(drawChart_pma);
 function drawChart_pma() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

    <?php
       $id="";
       $all_string="";
       $query="select t.responsible_user_id,u.first_name from ticket t 
                inner join users u
                on t.responsible_user_id=u.id
                where MONTH(t.create_time)='10' and YEAR(t.create_time)='2016'
                and t.responsible_user_id in (77,63,58,110,20) or u.login='praveen'
                group by t.responsible_user_id
                order by u.first_name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['responsible_user_id'];
          $first_name=$result['first_name'];
          $string="'".$first_name."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,u.first_name,s.sla_state from ticket t 
                    inner join users u
                    on t.responsible_user_id=u.id
                    inner join sla_table s
                    on t.tn=s.tn
                    where t.responsible_user_id='$id' and MONTH(t.create_time)='$month' and YEAR(t.create_time)='$year' and s.sla_state!=''
                    group by s.sla_state
                    order by s.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>

           ]);

     var options = {
         vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: 'percent',
         title:'CSR by PM%',        
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} },
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}}, 
      };
      //var chart = new google.visualization.ColumnChart(document.getElementById('responsible_sla'));

    var container = document.getElementById('responsible_sla_pma');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdfpma');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
        chart.draw(data, options);

 }



 google.charts.setOnLoadCallback(drawChart7);

      function drawChart7() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
         <?php

           $query ="select count(t.tn) as count,tp.name as priority from ticket t
                    inner join ticket_priority tp
                    on t.ticket_priority_id=tp.id
                    where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year))
                    group by tp.name
                    order by count desc";
        $result_set=mysqli_query($connection,$query); 
      while($result=mysqli_fetch_assoc($result_set)){
       echo "['".$result['priority']."',".$result['count']."],";
      }
?>
        ]);

        var options = {
        title:'Cumulative - CSR by Priority',        
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
        //colors: ['#F04886','E7ED8B','#C39BCD','#36D079','#B2B1B2','#1109F7',],  
         //pieSliceText:'label',          
          pieSliceTextStyle: {color:'white',fontName:'Helvetica Neue, Helvetica, and Arial'},
          legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'},  
          is3D:true,
          legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
        //pieHole: 0.4,
        };

        //var chart = new google.visualization.PieChart(document.getElementById('Priority_cumilative'));

    var container = document.getElementById('Priority_cumilative');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.PieChart(container);
  var btnSave = document.getElementById('pdf7');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 

        chart.draw(data, options);
      }



       google.charts.setOnLoadCallback(drawChart8);

     function drawChart8() {

      



 //echo "['".$result['priority']."',".$result['count']."],";

      

        var data = google.visualization.arrayToDataTable([
          ['Year', 'SLA Met', 'Within SLA', 'SLA Not Met'],
 <?php             
              
$all_string="";   

$string="'1 Critical'";

 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and tp.name='1 Critical' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

 if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$string.=",],['2 High'";



 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and tp.name='2 High' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

 if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$string.=",],['3 Medium'"; 


 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and tp.name='3 Medium' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

 if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$string.=",],['4 Low'";
          //$low=array();
 //array_push($low,"'4 Low'");


 $query="select count(t.tn) as count,tp.name as priority,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and tp.name='4 Low' and s.sla_state!=''
group by tp.name,s.sla_state
order by s.sla_state";

$met=$within=$not="";

$result_set=mysqli_query($connection,$query);
 
while($result=mysqli_fetch_assoc($result_set)){
    if($result['sla_state']==1){
  $met=$result['count']; 
}
  if($result['sla_state']==2){
  $within=$result['count']; 
}
  if($result['sla_state']==3){
  $not=$result['count']; 
}  
}

 if($met!=""){
$string.=",".$met;
}else{
 $string.=",0"; 
}
 if($within!=""){
$string.=",".$within;
}else{
 $string.=",0"; 
}
 if($not!=""){
$string.=",".$not;
}else{
 $string.=",0"; 
}

$all_string=$all_string."[".$string.",],";
//}

 


       
echo $all_string;


   ?>      
          
        ]);

        var options = {
          
            title: 'Cumulative - CSR by Priority by SLA',
             titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},  
              series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
            legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'},
            legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
            hAxis : {textStyle : {fontSize: 12}} ,
             vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
          
        };

       // var chart = new google.visualization.ColumnChart(document.getElementById('SLA_cumilative'));

    var container = document.getElementById('SLA_cumilative');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf8');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 

        chart.draw(data,options);
      }



      google.charts.setOnLoadCallback(drawChart9);

      function drawChart9() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
         <?php

           $query ="select count(t.tn) as count,q.name from ticket t 
                    inner join queue q
                    on t.queue_id=q.id 
                    where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year))                                   
                    group by q.id
                    order by count desc";
              $result_set=mysqli_query($connection,$query); 
          while($result=mysqli_fetch_assoc($result_set)){
           echo "['".$result['name']."',".$result['count']."],";
          }
        ?>

        ]);

        var options = {
          title: 'Cumulative - CSR by Queue',
          //pieHole: 0.4,
           titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
           legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10},color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'},
            pieSliceTextStyle: {color:'white',fontName:'Helvetica Neue, Helvetica, and Arial'},
            is3D:true, 
            legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},           
            //slices: {  2:{offset: 0.2},
              //      4: {offset: 0.3},
                //    7: {offset: 0.3},
                  //  9: {offset: 0.4},}, 
        };

        //var chart = new google.visualization.PieChart(document.getElementById('Queue_wise'));

         var container = document.getElementById('Queue_wise');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.PieChart(container);
  var btnSave = document.getElementById('pdf9');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 

        chart.draw(data, options);
      }


         google.charts.setOnLoadCallback(drawChart10);

      function drawChart10() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
         <?php

           /*$query ="select count(t.tn) as count,t.customer_id from ticket t    
                    where MONTH(t.create_time)>'3' and YEAR(t.create_time)='$year'                                                    
                    group by t.customer_id
                    order by count desc";*/

            $query="select count(t.tn) as count,t.customer_id from ticket t    
                    where 
                    if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year))                                                
                    group by t.customer_id
                    order by count desc";
              $result_set=mysqli_query($connection,$query); 
          while($result=mysqli_fetch_assoc($result_set)){
           echo "['".$result['customer_id']."',".$result['count']."],";
          }
        ?>

        ]);

        var options = {
          title: 'Cumulative - CSR by Customer',
          //pieHole: 0.4,
          //legend:{position: 'top',maxLines:4},
           titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
            pieSliceTextStyle: {color:'white',fontName:'Helvetica Neue, Helvetica, and Arial'},
            legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize: 10},  
            is3D:true,
            legend:{position: 'top',maxLines:4,textStyle: {fontSize: 12}},
          backgroundColor: 'white',
            
        };

       // var chart = new google.visualization.PieChart(document.getElementById('Customer'));

         var container = document.getElementById('Customer');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.PieChart(container);
  var btnSave = document.getElementById('pdf10');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 


        chart.draw(data, options);
      }



       google.charts.setOnLoadCallback(drawChart11);

    function drawChart11() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Month');
        <?php  
           $data2="";
      $query="select c.year from calender c
group by c.year";
          $result_set=mysqli_query($connection,$query); 
          $year="";       
          while($result=mysqli_fetch_assoc($result_set)){
            $data2.="data.addColumn('number','".$result['year']."');";
            //$data2.="data.addColumn('number','".$result['year']."');";
            $year=$result['year'];

          }

          $query="select c.year from calender c
group by c.year";
          $result_set=mysqli_query($connection,$query); 
          $year="";       
          while($result=mysqli_fetch_assoc($result_set)){
            $data2.="data.addColumn('number','".$result['year']."');";
            //$data2.="data.addColumn('number','".$result['year']."');";
            $year=$result['year'];

          }
      

      echo $data2.="data.addRows([";

        
        $num=1;
          $string="";
          $string2="";
          $string3="";
          //$month="";
          while($num<13){
          $query="SELECT distinct c.year, c.month, count(t.tn) as count
from calender c
left join ticket t on DATE_FORMAT(DATE_FORMAT(MAKEDATE(c.year, c.month),'%Y-%d-%m'),'%Y-%m') = DATE_FORMAT(t.create_time, '%Y-%m')
where c.month='$num' 
group by c.month, c.year";
          $result_set=mysqli_query($connection,$query);
          //$no="['".$result['month']."',";
          while ($result=mysqli_fetch_assoc($result_set)) {


           $string.= $result['count'].",";
           //$month=$result['month'];
            //$string.="],";



          }

             $query2="SELECT distinct c.year, c.month, count(s.tn) as count
            from calender c
            left join sla_table s on DATE_FORMAT(DATE_FORMAT(MAKEDATE(c.year, c.month),'%Y-%d-%m'),'%Y-%m') 
            = DATE_FORMAT(s.breached_time, '%Y-%m')
            where c.month='$num' 
            group by c.month, c.year";
            $result_set2=mysqli_query($connection,$query2);
            while ($result2=mysqli_fetch_assoc($result_set2)) {
               $string.= $result2['count'].",";
            }

          $string2="[".$num.",".$string;
          $string3.=$string2;

          //$string.=$string;
          $num++; 
          $string3.="],";
            $string="";

        }
        echo $string3."]);";


        ?> 
      

          var options = {

             chartArea: {width: '80%', height: '75%'},
             
        
          title: 'CSRs per Month (Dotted lines indicate breach counts)',
         // subtitle: 'in millions of dollars (USD)'
          titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
          legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},

           series: {
            0: { color: '#4885ed' },
            1: { color: '#3cba54' },
            2: { color: '#f4c20d' },
            3: { color: '#db3236' ,lineDashStyle: [4, 4]},
            4: { color: '#db3236',lineDashStyle: [1, 1] },
            5: { color: '#db3236',lineDashStyle: [5, 1] },
          },
         

        
       // width: 900,
        height: 500,
        vAxis:{minValue: 0,gridlines:{count:6}},

        hAxis: { ticks: [{v:1, f:"Jan"},{v:2, f:"Feb"},{v:3, f:"Mar"},{v:4, f:"Apr"},{v:5, f:"May"},{v:6, f:"Jun"},{v:7, f:"Jul"},{v:8, f:"Aug"},{v:9, f:"Sep"},{v:10, f:"Oct"},{v:11, f:"Nov"},{v:12, f:"Dec"},] },
     
         
      
      };
      //var chart = new google.charts.Line(document.getElementById('linechart'));

          
         var container = document.getElementById('linechart');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.LineChart(container);
  var btnSave = document.getElementById('pdf11');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

    doc.save('chart.pdf');
  }, false); 

    

      chart.draw(data, google.charts.Line.convertOptions(options));
    }



    google.charts.setOnLoadCallback(drawChart12);
 function drawChart12() {


    var data = google.visualization.arrayToDataTable([
      ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],
 <?php 
           
       $fulldate=$_POST['date'];

  $year=substr($fulldate,-4);
  $month=substr($fulldate,0,2);
  $day=substr($fulldate, 3,-5);

  $date="'".$year."-".$month."-".$day."'";

  $query="select t.customer_id from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and s.sla_state!='' and t.customer_id!=''
group by t.customer_id
order by t.customer_id";
$cx="";
$all_string="";
$result_set=mysqli_query($connection,$query);
while($result=mysqli_fetch_assoc($result_set)){
$cx=$result['customer_id'];


$query2="select count(t.tn) as count,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and t.customer_id='$cx'
group by s.sla_state
order by s.sla_state";

$string="'".$cx."'";
$sla="";
$met="";
$not="";
$within="";
$elements=array();
$result_set2=mysqli_query($connection,$query2);
$num_row=mysqli_num_rows($result_set2);
while($result2=mysqli_fetch_assoc($result_set2)) {
  
  //$string.= ",".$result2['count'];
  if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
    $met=$result2['count'];
    //array_push($elements, "1");
    //$sla.=",'SLA Met'";
  }

   if($result2['sla_state']=="2"){
     // $string.= ",".$result2['count'];
      $within=$result2['count'];
     // array_push($elements, "2");
  //  $sla.=",'Within SLA'";
  }

    if($result2['sla_state']=="3"){
     // $string.= ",".$result2['count'];
      $not=$result2['count'];
      //array_push($elements, "3");
   // $sla.=",'SLA Not Met'";
  
  }
  
 }

 if($met!=""){
  $string.= ",".$met;
 }
 else{
  $string.= ",0";
 }

 if($within!=""){
  $string.= ",".$within;
 }
 else{
  $string.= ",0";
 }

 if($not!=""){
  $string.= ",".$not;
 }
 else{
  $string.= ",0";
 }
   //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
  //echo $sla;
 $all_string=$all_string."[".$string.",''],";
   //$sla="";
}

//echo $all_string;

//echo "[".$string.",''],";

//echo $all_string;

echo $all_string;

//echo "[".$string.",''],";

   ?>
       
       
      ]);

      var options = {
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: true,
       
        title: 'Cumulative - CSR by Customer by SLA',
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},  
      };
     
      var container = document.getElementById('stackchartcum');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf12');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false); 

      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart'));
        chart.draw(data, options);

 }



     google.charts.setOnLoadCallback(drawChart12a);
 function drawChart12a() {


    var data = google.visualization.arrayToDataTable([
      ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],
 <?php 

  $query="select t.customer_id from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and s.sla_state!='' and t.customer_id!=''
group by t.customer_id
order by t.customer_id";
$cx="";
$all_string="";
$result_set=mysqli_query($connection,$query);
while($result=mysqli_fetch_assoc($result_set)){
$cx=$result['customer_id'];


$query2="select count(t.tn) as count,s.sla_state from ticket t
inner join ticket_priority tp
on t.ticket_priority_id=tp.id
inner join sla_table s
on t.tn=s.tn
where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and t.customer_id='$cx'
group by s.sla_state
order by s.sla_state";

$string="'".$cx."'";
$sla="";
$met="";
$not="";
$within="";
$elements=array();
$result_set2=mysqli_query($connection,$query2);
$num_row=mysqli_num_rows($result_set2);
while($result2=mysqli_fetch_assoc($result_set2)) {
  
  //$string.= ",".$result2['count'];
  if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
    $met=$result2['count'];
    //array_push($elements, "1");
    //$sla.=",'SLA Met'";
  }

   if($result2['sla_state']=="2"){
     // $string.= ",".$result2['count'];
      $within=$result2['count'];
     // array_push($elements, "2");
  //  $sla.=",'Within SLA'";
  }

    if($result2['sla_state']=="3"){
     // $string.= ",".$result2['count'];
      $not=$result2['count'];
      //array_push($elements, "3");
   // $sla.=",'SLA Not Met'";
  
  }
  
 }

 if($met!=""){
  $string.= ",".$met;
 }
 else{
  $string.= ",0";
 }

 if($within!=""){
  $string.= ",".$within;
 }
 else{
  $string.= ",0";
 }

 if($not!=""){
  $string.= ",".$not;
 }
 else{
  $string.= ",0";
 }
   //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
  //echo $sla;
 $all_string=$all_string."[".$string.",''],";
   //$sla="";
}

//echo $all_string;

//echo "[".$string.",''],";

//echo $all_string;

echo $all_string;

//echo "[".$string.",''],";

   ?>
       
       
      ]);

      var options = {
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: 'percent',
       
        title: 'Cumulative - CSR by Customer by SLA %',
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},  
      };
     
      var container = document.getElementById('stackchartcuma');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf12a');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false); 

      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart'));
        chart.draw(data, options);

 }



 google.charts.setOnLoadCallback(drawChart13);
 function drawChart13() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

      <?php
       $id="";
       $all_string="";
       $query="select s.id,s.name as name from service s
                inner join ticket t
                on t.service_id=s.id
                inner join sla_table st
                on t.tn=st.tn
                where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year))
                group by s.name
                order by s.name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['id'];
          $service=$result['name'];
          $string="'".$service."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,st.sla_state from service s
                    inner join ticket t
                    on t.service_id=s.id 
                    inner join sla_table st
                    on t.tn=st.tn
                    where t.service_id='$id' and if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and st.sla_state!=''
                    group by st.sla_state
                    order by st.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>
         

           ]);

     var options = {
        bar: { groupWidth: '75%' },
        isStacked: true,
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        title: 'Cumulative - CSR by Product by SLA',
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
        legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
        //width: 900,
      };

    var container = document.getElementById('stackchart3cum');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf13');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart3'));
        chart.draw(data, options);

 }


  google.charts.setOnLoadCallback(drawChart13a);
 function drawChart13a() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

      <?php
       $id="";
       $all_string="";
       $query="select s.id,s.name as name from service s
                inner join ticket t
                on t.service_id=s.id
                inner join sla_table st
                on t.tn=st.tn
                where if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year))
                group by s.name
                order by s.name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['id'];
          $service=$result['name'];
          $string="'".$service."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,st.sla_state from service s
                    inner join ticket t
                    on t.service_id=s.id 
                    inner join sla_table st
                    on t.tn=st.tn
                    where t.service_id='$id' and if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and st.sla_state!=''
                    group by st.sla_state
                    order by st.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>
         

           ]);

     var options = {
        bar: { groupWidth: '75%' },
        isStacked: 'percent',
          vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        title: 'Cumulative - CSR by Product by SLA %',
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}},
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false},
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
        legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
        //width: 900,
      };

    var container = document.getElementById('stackchart3cuma');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdf13a');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
      //var chart = new google.visualization.ColumnChart(document.getElementById('stackchart3'));
        chart.draw(data, options);

 }


google.charts.setOnLoadCallback(drawChartpm_cum);
 function drawChartpm_cum() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

    <?php
       $id="";
       $all_string="";
       $query="select t.responsible_user_id,u.first_name from ticket t 
                inner join users u
                on t.responsible_user_id=u.id
                where MONTH(t.create_time)='10' and YEAR(t.create_time)='2016'
                and t.responsible_user_id in (77,63,58,110,20) or u.login='praveen'
                group by t.responsible_user_id
                order by u.first_name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['responsible_user_id'];
          $first_name=$result['first_name'];
          $string="'".$first_name."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,u.first_name,s.sla_state from ticket t 
                    inner join users u
                    on t.responsible_user_id=u.id
                    inner join sla_table s
                    on t.tn=s.tn
                    where t.responsible_user_id='$id' and if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and s.sla_state!=''
                    group by s.sla_state
                    order by s.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>

           ]);

     var options = {
         vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: true,
         title:'CSR by PM',        
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
        series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}}, 
      };
      //var chart = new google.visualization.ColumnChart(document.getElementById('responsible_sla'));

    var container = document.getElementById('responsible_sla_pm_cum');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdfpm_cum');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
        chart.draw(data, options);

 }


  google.charts.setOnLoadCallback(drawChart_pma_cum);
 function drawChart_pma_cum() {
        var data = google.visualization.arrayToDataTable([
             
        ['SLA', 'SLA Met', 'Within SLA', 'SLA Not Met', { role: 'annotation' } ],

    <?php
       $id="";
       $all_string="";
       $query="select t.responsible_user_id,u.first_name from ticket t 
                inner join users u
                on t.responsible_user_id=u.id
                where MONTH(t.create_time)='10' and YEAR(t.create_time)='2016'
                and t.responsible_user_id in (77,63,58,110,20) or u.login='praveen'
                group by t.responsible_user_id
                order by u.first_name";
        $result_set=mysqli_query($connection,$query);
        while ($result=mysqli_fetch_assoc($result_set)) {
          $id=$result['responsible_user_id'];
          $first_name=$result['first_name'];
          $string="'".$first_name."'";
          $met=$within=$not="";
          $query2="select count(t.tn) as count,u.first_name,s.sla_state from ticket t 
                    inner join users u
                    on t.responsible_user_id=u.id
                    inner join sla_table s
                    on t.tn=s.tn
                    where t.responsible_user_id='$id' and if( QUARTER($date)<2,
                   t.create_time between DATE_ADD('$year-04-01', INTERVAL -1 year) and '$year-03-31'                  
                    , t.create_time between '$year-04-01' and  DATE_ADD('$year-03-31', INTERVAL + 1 year)) and s.sla_state!=''
                    group by s.sla_state
                    order by s.sla_state";
        $result_set2=mysqli_query($connection,$query2);
          while($result2=mysqli_fetch_assoc($result_set2)){
              if($result2['sla_state']=="1"){
   // $string.= ",".$result2['count'];
                $met=$result2['count'];
                //array_push($elements, "1");
                //$sla.=",'SLA Met'";
              }

               if($result2['sla_state']=="2"){
                 // $string.= ",".$result2['count'];
                  $within=$result2['count'];
                 // array_push($elements, "2");
              //  $sla.=",'Within SLA'";
              }

                if($result2['sla_state']=="3"){
                 // $string.= ",".$result2['count'];
                  $not=$result2['count'];
                  //array_push($elements, "3");
               // $sla.=",'SLA Not Met'";
              
              }

          }

           if($met!=""){
              $string.= ",".$met;
             }
             else{
              $string.= ",0";
             }

             if($within!=""){
              $string.= ",".$within;
             }
             else{
              $string.= ",0";
             }

             if($not!=""){
              $string.= ",".$not;
             }
             else{
              $string.= ",0";
             }
               //$sla="['SLA'".$sla.",{ role: 'annotation' } ],";
              //echo $sla;
             $all_string=$all_string."[".$string.",''],";
          
        }

        echo $all_string;
       ?>

           ]);

     var options = {
         vAxis: {minValue: 0,textStyle : {fontSize: 12},gridlines: { count: 10 }},
         hAxis : {textStyle : {fontSize: 12}} ,
        chartArea: {width: '80%', height: '70%'},
        legend:{position: 'top',maxLines:3,textStyle: {fontSize: 10}},
        bar: { groupWidth: '75%' },
        isStacked: 'percent',
         title:'CSR by PM%',        
        titleTextStyle:{color:'#6F6F6F',fontName:'Helvetica Neue, Helvetica, and Arial',fontSize:14,bold:false}, 
       series: { 0: {color: '#3cba54'},1: {color: '#4885ed'},2: {color: '#db3236'} } ,
         legendTextStyle:{color:'#6B6B6B',fontName:'Helvetica Neue, Helvetica, and Arial'}, 
         legend:{position: 'top',maxLines:3,textStyle: {fontSize: 12}}, 
      };
      //var chart = new google.visualization.ColumnChart(document.getElementById('responsible_sla'));

    var container = document.getElementById('responsible_sla_pma_cum');
  //var chart = new google.visualization.LineChart(container);
   var chart = new google.visualization.ColumnChart(container);
  var btnSave = document.getElementById('pdfpma_cum');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', [297, 210]);
    doc.addImage(chart.getImageURI(), 0, 0)

     
    doc.save('chart.pdf');
  }, false); 
        chart.draw(data, options);

 }





 //-------------------------------------------------------------------------------------------------------------//



    <?php
    }
    ?>
    </script>
  
  


 

 </head>

<body>

  <!--=============================
                                             NAVIGATION
                                   =============================-->
  <!--top nav start=======-->
  <nav class="navbar navbar-inverse top-bar navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button> <span class="menu-icon" id="menu-icon"><i class="fa fa-times" aria-hidden="true" id="chang-menu-icon"></i></span>
        <a class="navbar-brand" href="#"><img src="" width="90%"> </a>
      </div>
      <div class="collapse navbar-collapse navbar-right" id="myNavbar">
        <form class="navbar-form navbar-left">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search">
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search"></i> </button>
            </div>
          </div>
        </form>
        <ul class="nav navbar-nav">
          
          
          <li class=""><a href="#"><i class="fa fa-bell"></i> <span class="badge">9</span></a> </li>
          <li class="">
            <a href="#" class="user-profile"> <span class=""><img class="img-responsive" src="https://lh3.googleusercontent.com/-uvTIvTubz-k/VnFSzW45FhI/AAAAAAAAAdM/7_Ziz6U9eF0E13wLap7cHuhtV3dI5MRXACEwYBhgL/w140-h140-p/f45b4eee-10a6-4a52-a175-80960c5e420e.jpg"></span> </a>
          </li>
          <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#">Darshana          
           <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li> <a href="#"><i class="fa fa-power-off"></i> Logout</a> </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--    top nav end===========-->
  <div class="wrapper" id="wrapper">
    <div class="left-container" id="left-container">
      <!-- begin SIDE NAV USER PANEL -->
      <div class="left-sidebar" id="show-nav">
        <ul id="side" class="side-nav">
          <li class="panel">
            <a id="panel1" href="javascript:;" data-toggle="collapse" data-target="#Dashboard"> <i class="fa fa-dashboard"></i> Dashboard
              <i class="fa fa-chevron-left pull-right" id="arow1"></i> </a>
            <ul class="collapse nav" id="Dashboard">
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> Option 1</a> </li>
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> Option 2</a> </li>
            </ul>
          </li>
          <li class="panel">
            <a id="panel2" href="javascript:;" data-toggle="collapse" data-target="#charts"> <i class="fa fa-bar-chart-o"></i> Charts
              <i class="fa fa-chevron-left pull-right" id="arow2"></i> </a>
            <ul class="collapse nav" id="charts">
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> Chart 1</a> </li>
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> Chart 2</a> </li>
            </ul>
          </li>
          <li class="panel">
            <a id="panel3" href="javascript:;" data-toggle="collapse" data-target="#calendar"> <i class="fa fa-calendar"></i> Report Type 1
              <span class="label label-danger">new event</span> <i class="fa fa-chevron-left pull-right" id="arow3"></i> </a>
            <ul class="collapse nav" id="calendar">
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> ABC</a> </li>
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> XYZ</a> </li>
            </ul>
          </li>
          <li class="panel">
            <a id="panel4" href="javascript:;" data-toggle="collapse" data-target="#clipboard"> <i class="fa fa-clipboard"></i> Report Type 2
              <i class="fa fa fa-chevron-left pull-right" id="arow4"></i> </a>
            <ul class="collapse nav" id="clipboard">
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> ABC</a> </li>
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> XYZ</a> </li>
            </ul>
          </li>
          <li class="panel">
            <a id="panel5" href="javascript:;" data-toggle="collapse" data-target="#edit"> <i class="fa fa-edit"></i> Report Type3
              <i class="fa fa fa-chevron-left pull-right" id="arow5"></i>
            </a>
            <ul class="collapse nav" id="edit">
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> ABC</a> </li>
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> XYZ</a> </li>
            </ul>
          </li>
          <li class="panel">
            <a id="panel6" href="javascript:;" data-toggle="collapse" data-target="#inbox"> <i class="fa fa-inbox"></i> Report Type4
              <i class="fa fa fa-chevron-left pull-right" id="arow6"></i> </a>
            <ul class="collapse nav" id="inbox">
              <li> <a href="#"><i class="fa fa-angle-double-right"></i> ABC</a> </li>
              <li> <a href="#"><i class="fa fa-angle-double-right"></i>XYZ</a> </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- END SIDE NAV USER PANEL -->
    </div>
    <div class="right-container" id="right-container">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            <ul class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="#"> Home</a></li>
						<li class="active">Dashboard</li>
					</ul>
            </div>
            <div class="col-md-8">
            <ul class="list-inline pull-right mini-stat">
							<li>
								<h5>CUSTOMERS <span class="stat-value color-blue"><i class="fa fa-plus-circle"></i> 25</span></h5>
								
							</li>
							<li>
								<h5>PRODUCTS <span class="stat-value color-green"><i class="fa fa-plus-circle"></i> 14</span></h5>
								
							</li>
							<li>
								<h5>CSR COUNT <span class="stat-value color-orang"><i class="fa fa-plus-circle"></i> 1205</span></h5>
								
							</li>
						</ul>
            </div>
            </div>
            
            <div class="row">
            <div class="col-md-12">
                <div class="main-header">
					<h2>DASHBOARD</h2>
					<em>the first priority information</em>  


               

				</div>
                </div>
        
                </div>
                <form name="hod" method="POST" action="dashboard.php">
    
    <div style=" margin: 0 200 auto;"ng-app="myApp" ng-controller="myCntrl">
    Select Date:
        <input type="text" uib-datepicker-popup="{{dateformat}}" ng-model="dt" is-open="showdp" max-date="dtmax" name="date" />
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

            
                <div class="row padding-top">

                 <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf11"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="linechart" style="height:500px; margin-bottom:30px;"></div> 

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="donutchart" style="height: 500px; margin-bottom:30px;">                
                </div>
                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf2"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="piechart" style="height: 500px; margin-bottom:30px;"></div>              
                </div>
            
             <div class="row padding-top">

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf4"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="stackchart" style="height: 500px; margin-bottom:30px;"></div>                

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf4a"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="stackcharta" style="height: 500px; margin-bottom:30px;"></div> 
                

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf3"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="barchart" style="height: 500px; margin-bottom:30px;"></div> 
                
                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf5"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div> 
                <div class="col-md-12" id="stackchart3" style="height: 500px; margin-bottom:30px;"></div>  

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf5a"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div> 
                <div class="col-md-12" id="stackchart3a" style="height: 500px; margin-bottom:30px;"></div>  

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf6"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="responsible_sla" style="height: 500px; margin-bottom:30px;"></div>  

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf6a"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="responsible_slaa" style="height: 500px; margin-bottom:30px;"></div>  

                 <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdfpm"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="responsible_sla_pm" style="height: 500px; margin-bottom:30px;"></div> 

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdfpma"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="responsible_sla_pma" style="height: 500px; margin-bottom:30px;"></div> 


                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf7"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>                 
                <div class="col-md-12" id="Priority_cumilative" style="height: 500px; margin-bottom:30px;"></div> 
                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf8"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="SLA_cumilative" style="height: 500px; margin-bottom:30px;"></div> 
                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf9"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>              
               
                <div class="col-md-12" id="Queue_wise" style="height:500px; margin-bottom:30px;"></div>  
                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf10"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="Customer" style="height:500px; margin-bottom:30px;"></div>  
               

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf12"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="stackchartcum" style="height:500px; margin-bottom:30px;"></div>  

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf12a"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="stackchartcuma" style="height:500px; margin-bottom:30px;"></div>  


                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf13"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="stackchart3cum" style="height:500px; margin-bottom:30px;"></div>  

                 <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdf13a"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="stackchart3cuma" style="height:500px; margin-bottom:30px;"></div> 

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdfpm_cum"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="responsible_sla_pm_cum" style="height:500px; margin-bottom:30px;"></div> 

                <div class="col-md-12">
                <a href="#" class="btn btn-danger" style="display: none;"  id="pdfpma_cum"><span class="glyphicon glyphicon-save"></span> Save as PDF</a>
                </div>
                <div class="col-md-12" id="responsible_sla_pma_cum" style="height:500px; margin-bottom:30px;"></div>  


                </div>
                
        </div>
    </div>
  </div>

   
  <script type="text/javascript">
    $(document).ready(function() {
      $("#panel1").click(function() {
        $("#arow1").toggleClass("fa-chevron-left");
        $("#arow1").toggleClass("fa-chevron-down");
      });
        
      $("#panel2").click(function() {
        $("#arow2").toggleClass("fa-chevron-left");
        $("#arow2").toggleClass("fa-chevron-down");
      });
        
      $("#panel3").click(function() {
        $("#arow3").toggleClass("fa-chevron-left");
        $("#arow3").toggleClass("fa-chevron-down");
      });
        
      $("#panel4").click(function() {
        $("#arow4").toggleClass("fa-chevron-left");
          $("#arow4").toggleClass("fa-chevron-down");
      });
        
      $("#panel5").click(function() {
        $("#arow5").toggleClass("fa-chevron-left");
        $("#arow5").toggleClass("fa-chevron-down");
      });
        
      $("#panel6").click(function() {
        $("#arow6").toggleClass("fa-chevron-left");
        $("#arow6").toggleClass("fa-chevron-down");
      });
        
      $("#panel7").click(function() {
        $("#arow7").toggleClass("fa-chevron-left");
        $("#arow7").toggleClass("fa-chevron-down");
      });
        
      $("#panel8").click(function() {
        $("#arow8").toggleClass("fa-chevron-left");
        $("#arow8").toggleClass("fa-chevron-down");
      });
        
      $("#panel9").click(function() {
        $("#arow9").toggleClass("fa-chevron-left");
        $("#arow9").toggleClass("fa-chevron-down");
      });
        
      $("#panel10").click(function() {
        $("#arow10").toggleClass("fa-chevron-left");
        $("#arow10").toggleClass("fa-chevron-down");
      });
        
      $("#panel11").click(function() {
        $("#arow11").toggleClass("fa-chevron-left");
        $("#arow11").toggleClass("fa-chevron-down");
      });
        
      $("#menu-icon").click(function() {
        $("#chang-menu-icon").toggleClass("fa-bars");
        $("#chang-menu-icon").toggleClass("fa-times");
        $("#show-nav").toggleClass("hide-sidebar");
        $("#show-nav").toggleClass("left-sidebar");
          
        $("#left-container").toggleClass("less-width");
        $("#right-container").toggleClass("full-width");
      });
        
     
        
    });
  </script>
    
    
    
    
    
    
    
    
    
    
    
    
    
</body>

</html>