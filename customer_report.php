<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php');?>
<?php
if(!isset($_SESSION['user_id'])){
header('Location:ums/index2.php');
}
  $mid=$_GET['mid'];
  $uid = $_SESSION['user_id'];
  $access="";

  $sql="select access from module_access_view where user_id=$uid and module_id=$mid";
  $sql_run=mysqli_query($connection,$sql);

    while($result_sql=mysqli_fetch_assoc($sql_run)){
    $access=$result_sql['access'];
  }
  
if($access==1){
?>
<head>
    <script type="text/javascript" src="\icaredashboard/libraries/jquery/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="\icaredashboard/libraries/googleapis/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="\icaredashboard/libraries/googleapis/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">



  
     
    <link rel="stylesheet" type="text/css" href="\icaredashboard/css/cx_report.css">
<script type="text/javascript">
$(document).ready(function() {
    $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
});
</script>



</head>

<body>
    <div>
    <form action="customer_report.php?mid=18" method="POST">
    <div class="wrapper">
    <div class="date">
    <label for="startDate">Date :</label>
    <input name="startDate" id="startDate" class="date-picker" />
    </div>

    <div class="custom-select" style="width:200px;">
  <select name="customer" id="cus">
    <option value="0">Select Customer:</option>
        <?php
$customers="SELECT customer_id,name FROM icaredashboard2.excus_incomp
where customer_id not like'%@%'
order by customer_id asc";
$customers_run=mysqli_query($connection,$customers);
while($customers_result=mysqli_fetch_array($customers_run)){
    echo '<option value="'.$customers_result['customer_id'].'" data-id="'.$customers_result['name'].'">'.$customers_result['customer_id'].'</option>';
}
?>
    
  </select>
</div>



<div class="button">
    <Button type="submit" name="submit">Generate</Button>
</div>
<div class="hidden">
    <input type="hidden" id="hide" name="hidetxt">
</div>

</form>
</div>
<script type="text/javascript">
    
var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {

            /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    //set the bank name to hidden text filed
    var selectedValue = $("#cus").find("option:selected").attr("data-id");
    $("#hide").val(selectedValue);
          /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user_view clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script> 

    
    
 

<?php
if(isset($_POST['submit'])){
   $customer=$_POST['customer'];
   $cus_name=$_POST['hidetxt'];
   $date=$_POST['startDate'];


?>


<div class="whole" id="wh">
    <h5>Interblocks Customer Services</h5>
    <h6>Monthly CSR Analysis</h6>
    <hr>
<table class="first">
  <tr>
    <td><b>Customer</b></td>
    <td><?php echo $cus_name;?></td>
  </tr>
  <tr>
    <td><b>Customer Code</b></td>
    <td><?php echo $customer;?></td>
  </tr>
  <tr>
    <td><b>Reporting Period</b></td>
    <td>1st to 30th <?php echo date('M-Y', strtotime($date));?></td>
  </tr>
  <tr>
    <td><b>Report Date</b></td>
    <td><?php echo date("Y-M-d");?></td>
  </tr>
</table>
<p>CSR Summary</p>

<table class="second" id="2nd">
  <tr bgcolor="blue">
    <td></td>
    <td class="header"><b>Critical</b></td>
    <td class="header"><b>High</b></td>
    <td class="header"><b>Medium</b></td>
    <td class="header"><b>Low</b></td>
    <td class="header"><b>IR</b></td>
    <td class="header"><b>CR</b></td>
    <td class="header"><b>Total</b></td>
    <td class="header"><b>%</b></td>
  </tr>
  <?php
  $bf="select tp.id,coalesce(x.count,0) as count from(select t.ticket_priority_id,count(t.tn) as count
from issue_view t 
inner join issuehis_view th on t.id=th.ticket_id 
inner join (
    select max(h.id) as max_hist, h.ticket_id
    from issuehis_view h
    inner join issue_view ti
    on h.ticket_id=ti.id    
    where date(h.change_time) < '".$date."'    and
    date(h.change_time) >= '2014-11-10' 
    group by h.ticket_id
) open_issue_views on open_issue_views.max_hist = th.id
inner join issuestate_view ts on ts.id = th.state_id
inner join intuser_view u on u.id = th.owner_id
inner join service_view s on s.id=t.service_id
inner join intuser_view u1 on t.responsible_user_id=u1.id
where th.state_id not in ('24','25','5','10','17','16','7')
and t.customer_id in('".$customer."')
group by t.ticket_priority_id
order by t.ticket_priority_id asc) x right join issuelevel_view tp on x.ticket_priority_id=tp.id";
$bf_run=mysqli_query($connection,$bf);
  ?>
  <tr bgcolor="#0f9d58">
    <td>BF</td>
    <?php while($result_bf=mysqli_fetch_array($bf_run)) {
    echo '<td class="data ct">'.$result_bf['count'].'</td>';
}
?>
    <td class="total-data"></td>
    
    <td rowspan="4" bgcolor="#00acc1" class="data" id="per"></td>
  </tr>
  <?php 
    $reported="select tp.id,coalesce(x.count,0) as count from(select t.ticket_priority_id,count(t.tn) as count from issuelevel_view tp
inner join issue_view t
on tp.id=t.ticket_priority_id
where date(t.create_time)<DATE_ADD('".$date."', INTERVAL 1 MONTH) and 
t.create_time>='".$date."' and t.customer_id in('".$customer."')
group by tp.id) x right join issuelevel_view tp on x.ticket_priority_id=tp.id";
$reported_run=mysqli_query($connection,$reported);
?>
  <tr bgcolor="#f4b400">
    <td>Reported</td>
    <?php 
    while($result_reported=mysqli_fetch_array($reported_run)) {
    echo '<td class="data ct">'.$result_reported['count'].'</td>';
}
?>
    <td class="total-data"></td>    
    
  </tr>
  <?php
  $resolved="select tp.id,coalesce(x.count,0) as count from (select t.ticket_priority_id, count(t.tn) as count
from issue_view t 
inner join issuehis_view th on t.id=th.ticket_id 
inner join issuelevel_view tp on t.ticket_priority_id=tp.id
inner join (
    select max(h.id) as max_hist, h.ticket_id
    from issuehis_view h
    inner join issue_view ti
    on h.ticket_id=ti.id    
    where date(h.change_time) < DATE_ADD('".$date."', INTERVAL 1 MONTH)   and
    date(h.change_time) >= '".$date."' 
    group by h.ticket_id
) open_issue_views on open_issue_views.max_hist = th.id
where th.state_id in ('24','25','10','17','16','7')
and t.customer_id in('".$customer."')
and t.tn in (select t.tn
from issue_view t 
inner join issuehis_view th on t.id=th.ticket_id 
inner join (
    select max(h.id) as max_hist, h.ticket_id
    from issuehis_view h
    inner join issue_view ti
    on h.ticket_id=ti.id    
    where date(h.change_time) < '".$date."'    and
    date(h.change_time) >= '2014-11-10' 
    group by h.ticket_id
) open_issue_views on open_issue_views.max_hist = th.id
inner join issuestate_view ts on ts.id = th.state_id
inner join intuser_view u on u.id = th.owner_id
inner join service_view s on s.id=t.service_id
inner join intuser_view u1 on t.responsible_user_id=u1.id
where th.state_id not in ('24','25','10','17','16','7')
and t.customer_id in('".$customer."')
union all
select t.tn  from issue_view t
where date(t.create_time)<DATE_ADD('".$date."', INTERVAL 1 MONTH) and 
t.create_time>='".$date."' and t.customer_id in('".$customer."'))
group by tp.id) x right join issuelevel_view tp on x.ticket_priority_id=tp.id";
$resolved_run=mysqli_query($connection,$resolved);
?>
  <tr bgcolor="#4285f4">
    <td>Resolved</td>
    <?php
   
while($result_resolved=mysqli_fetch_array($resolved_run)){
      echo '<td class="data -ct">'.$result_resolved['count'].'</td>'; 
    }
    ?>
    <td class="total-data" id="tot"></td>    
    
  </tr>
  <tr bgcolor="#f06292" class="totalColumn">
    <td>CF</td>
    <td id="sum1">0</td>
    <td id="sum2">0</td>
    <td id="sum3">0</td>
    <td id="sum4">0</td>
    <td id="sum5">0</td>
    <td id="sum6">0</td>
    <td id="sum7">0</td>
  </tr>
</table>
<script type="text/javascript">
$(document).ready(function () {

    //iterate through each row in the table
    $('.second tr').each(function () {
        //the value of sum needs to be reset for each row, so it has to be set inside the row loop
        var sum = 0
        //find the combat elements in the current row and sum it 
        $(this).find('.data').each(function () {
            var combat = $(this).text();
            if (!isNaN(combat) && combat.length !== 0) {
                sum += parseFloat(combat);
            }
        });
        //set the value of currents rows sum to the total-combat element in the current row
        $('.total-data', this).html(sum);
    });



    
//these will hold the totals 
var critical = 0; 
var high = 0; 
var medium = 0;
var low=0;
var ir=0;
var cr=0; 
var tot=0;

//reference the rows you want to add 
//this will not include the header row 
var row1 = $("#2nd tr:eq(1)"); 
var row2 = $("#2nd tr:eq(2)"); 
critical = parseInt(row1.children("td:nth-child(2)").text())
+parseInt(row2.children("td:nth-child(2)").text());



high = parseInt(row1.children("td:nth-child(3)").text())
+parseInt(row2.children("td:nth-child(3)").text());



medium = parseInt(row1.children("td:nth-child(4)").text())
+parseInt(row2.children("td:nth-child(4)").text());

low = parseInt(row1.children("td:nth-child(5)").text())
+parseInt(row2.children("td:nth-child(5)").text());

ir = parseInt(row1.children("td:nth-child(6)").text())
+parseInt(row2.children("td:nth-child(6)").text());

cr = parseInt(row1.children("td:nth-child(7)").text())
+parseInt(row2.children("td:nth-child(7)").text());

tot = parseInt(row1.children("td:nth-child(8)").text())
+parseInt(row2.children("td:nth-child(8)").text());



var rows = $("#2nd tr:gt(2)"); 
rows.children("td:nth-child(2)").each(function() { 
//each time we add the cell to the total 

critical -= parseInt($(this).text(),10);

}); 
rows.children("td:nth-child(3)").each(function() { 
 
high -= parseInt($(this).text(),10); 
}); 

rows.children("td:nth-child(4)").each(function() { 
medium -= parseInt($(this).text(),10); 
}); 

rows.children("td:nth-child(5)").each(function() { 
low -= parseInt($(this).text(),10); 
}); 

rows.children("td:nth-child(6)").each(function() { 
ir -= parseInt($(this).text(),10); 
}); 

rows.children("td:nth-child(7)").each(function() { 
cr -= parseInt($(this).text(),10); 
}); 

rows.children("td:nth-child(8)").each(function() { 
tot -= parseInt($(this).text(),10); 
}); 

//then output them to the elements 
$("#sum1").html(critical); 
$("#sum2").html(high); 
$("#sum3").html(medium); 
$("#sum4").html(low); 
$("#sum5").html(ir); 
$("#sum6").html(cr); 
$("#sum7").html(tot); 

var tot_res=0;
var tot_csr=0;
var per=0;
var row3 = $("#2nd tr:eq(3)"); 
tot_res = parseInt(row3.children("td:nth-child(8)").text());
tot_csr=parseInt(row1.children("td:nth-child(8)").text())+parseInt(row2.children("td:nth-child(8)").text());
per=((tot_res/tot_csr)*100).toFixed(2);
$("#per").html(per+"%"); 


});

</script>
<hr>
<p>By Status</p>
<table class="third">
<?php 
$by_status="select ts.name as state,count(t.tn) as count
from issue_view t 
inner join issuehis_view th on t.id=th.ticket_id 
inner join (
    select max(h.id) as max_hist, h.ticket_id
    from issuehis_view h
    inner join issue_view ti
    on h.ticket_id=ti.id    
    where date(h.change_time) < '".$date."'    and
    date(h.change_time) >= '2014-11-10' 
    group by h.ticket_id
) open_issue_views on open_issue_views.max_hist = th.id
inner join issuestate_view ts on ts.id = th.state_id
where th.state_id not in ('24','25','5','10','17','16','7')
and t.customer_id='".$customer."'
group by ts.name
union all(
select ts.name,count(t.tn) as count
from issue_view t
inner join issuestate_view ts on t.ticket_state_id=ts.id
where date(t.create_time)<DATE_ADD('".$date."', INTERVAL 1 MONTH) and 
t.create_time>='".$date."' and t.customer_id in('".$customer."')
group by ts.name order by ts.name asc)";
$by_status_run=mysqli_query($connection,$by_status);
while($result_by_status=mysqli_fetch_array($by_status_run)){

    echo '<tr class="row">
            <td class="id">'.$result_by_status['state'].'</td>
            <td>'.$result_by_status['count'].'</td>        
        </tr>';
}
?>    
</table>

<hr>
<p>CSR Details</p>
<table class="fourth">
    <?php
    $csr_details="select t.tn as tn,t.create_time,ts2.name as state,
tp.name as priority,s.name as service_view,t.title
from issue_view t 
inner join issuelevel_view tp on tp.id=t.ticket_priority_id
inner join service_view s on s.id=t.service_id
inner join issuestate_view ts2 on ts2.id=t.ticket_state_id
inner join issuehis_view th on t.id=th.ticket_id 
inner join (
    select max(h.id) as max_hist, h.ticket_id
    from issuehis_view h
    inner join issue_view ti
    on h.ticket_id=ti.id    
    where date(h.change_time) < '".$date."'    and
    date(h.change_time) >= '2014-11-10' 
    group by h.ticket_id
) open_issue_views on open_issue_views.max_hist = th.id
inner join issuestate_view ts on ts.id = th.state_id
where th.state_id not in ('24','25','5','10','17','16','7')
and t.customer_id='".$customer."'
union all(
select t.tn as tn,t.create_time,ts.name as state,
tp.name as priority,s.name as service_view,t.title
from issue_view t 
inner join issuelevel_view tp on tp.id=t.ticket_priority_id
inner join service_view s on s.id=t.service_id
inner join issuestate_view ts on ts.id=t.ticket_state_id
where date(t.create_time)<DATE_ADD('".$date."', INTERVAL 1 MONTH) and 
t.create_time>='".$date."' and t.customer_id in('".$customer."')
order by ts.name asc)";
$csr_details_run=mysqli_query($connection,$csr_details);
    ?>
  <tr bgcolor="blue">
    <td class="header"><b>#</b></td>
    <td class="header"><b>CSR #</b></td>
    <td class="header"><b>Created</b></td>
    <td class="header"><b>State</b></td>
    <td class="header"><b>Priority</b></td>
    <td class="header"><b>service_view</b></td>
    <td class="header"><b>Title</b></td>
  </tr>
  <?php
  $count=1;
  while($result_csr_details=mysqli_fetch_array($csr_details_run)){
    echo'<tr><td>'.$count.'</td>
            <td>'.$result_csr_details['tn'].'</td>
            <td>'.date('Y:m:d',strtotime($result_csr_details['create_time'])).'</td>            
            <td>'.$result_csr_details['state'].'</td>
            <td>'.$result_csr_details['priority'].'</td>
            <td>'.$result_csr_details['service_view'].'</td>
            <td>'.$result_csr_details['title'].'</td>
  </tr>';
  $count++;
  }
  ?>
  
</table>

<table class="fifth">
    <?php
    $product="select s.name as product,count(t.tn) as count
from issue_view t 
inner join service_view s on s.id=t.service_id
inner join issuehis_view th on t.id=th.ticket_id 
inner join (
    select max(h.id) as max_hist, h.ticket_id
    from issuehis_view h
    inner join issue_view ti
    on h.ticket_id=ti.id    
    where date(h.change_time) < '".$date."'    and
    date(h.change_time) >= '2014-11-10' 
    group by h.ticket_id
) open_issue_views on open_issue_views.max_hist = th.id
where th.state_id not in ('24','25','5','10','17','16','7')
and t.customer_id='".$customer."'
group by product
union all(
select s.name as product,count(t.tn) as count
from issue_view t
inner join service_view s on t.service_id=s.id
where date(t.create_time)<DATE_ADD('".$date."', INTERVAL 1 MONTH) and 
t.create_time>='".$date."' and t.customer_id in('".$customer."')
group by product order by product asc)";
$product_run=mysqli_query($connection,$product);
?>
  <tr bgcolor="blue">
    <td class="header"><b>Product</b></td>
    <td class="header"><b>Count</b></td>
  </tr>
  <?php
  while($result_product=mysqli_fetch_array($product_run)){
    echo '<tr><td>'.$result_product['product'].'</td>
            <td align="center">'.$result_product['count'].'</td>    
  </tr>';
  }
    ?>
  
</table>
</div>


<?php
}
?>

</body>


<?php
}else{
  header('Location: index.php');
} 
?>



