<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';
$chinthaka_previous_count="0";
$chinthaka_previous_count2="0";
$chinthaka="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =49
                      group by res_name,t.customer_id 
                      order by count desc";
$table_list="";
$table_list.='<table class="hodlist"> 
<tr><th  colspan="4" class="header">HOD - Chinthaka</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$chinthaka_run=mysqli_query($connection,$chinthaka);

while ($result=mysqli_fetch_array($chinthaka_run)) {
	$customers.='\''.$result['customer_id'].'\',';
	$cx_id=$result['customer_id'];
	$count=$result['count'];
	$tot_cur+=$count;
	$chinthaka_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and
                      t.customer_id in ('$cx_id') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =49
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $chinthaka_previous_run=mysqli_query($connection,$chinthaka_previous);
     while($result=mysqli_fetch_array($chinthaka_previous_run)){

     	$chinthaka_previous_count=$result['count'];
     	$tot_pre+=$chinthaka_previous_count;
     	
     }

    $change=$count-$chinthaka_previous_count;

    
	$table_list.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$chinthaka_previous_count.'</td><td class="chg_count">'.$change.'</td>
	</tr>';
	$chinthaka_previous_count="0";	
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

   $chinthaka_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                     substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =49
                      group by res_name,t.customer_id 
                      order by count desc";

                      $chinthaka_previous2_run=mysqli_query($connection,$chinthaka_previous2);
     while($result=mysqli_fetch_array($chinthaka_previous2_run)){

     	$chinthaka_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list.='<tr><td>'.$chinthaka_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';	


//----------------------------------------------------------------------------------------------------------------------------------------------------------//


$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$prasad="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =56
                      group by res_name,t.customer_id 
                      order by count desc";
$table_list2="";
$table_list2.='<table class="hodlist"> 
<tr><th  colspan="4" class="header">HOD - Prasad</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$prasad_run=mysqli_query($connection,$prasad);

while ($result=mysqli_fetch_array($prasad_run)) {
	$customers.='\''.$result['customer_id'].'\',';
	$cx_id=$result['customer_id'];
	$count=$result['count'];
	$tot_cur+=$count;
	$prasad_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and
                      t.customer_id in ('$cx_id') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =56
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $prasad_previous_run=mysqli_query($connection,$prasad_previous);
     while($result=mysqli_fetch_array($prasad_previous_run)){

     	$prasad_previous_count=$result['count'];
     	$tot_pre+=$prasad_previous_count;
     	
     }

    $change=$count-$prasad_previous_count;

    
	$table_list2.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$prasad_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$prasad_previous_count="0";	
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

    $prasad_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                     substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =56
                      group by res_name,t.customer_id 
                      order by count desc";

                      $prasad_previous2_run=mysqli_query($connection,$prasad_previous2);
     while($result=mysqli_fetch_array($prasad_previous2_run)){

     	$prasad_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list2.='<tr><td>'.$prasad_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list2.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';	



     //----------------------------------------------------------------------------------------------------------------------------------------------------------//



$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$sanjeewa="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =48
                      group by res_name,t.customer_id 
                      order by count desc";
$table_list3="";
$table_list3.='<table class="hodlist"> 
<tr><th  class="header" colspan="4">HOD - Sanjeewa</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$sanjeewa_run=mysqli_query($connection,$sanjeewa);

while ($result=mysqli_fetch_array($sanjeewa_run)) {
	$customers.='\''.$result['customer_id'].'\',';
	$cx_id=$result['customer_id'];
	$count=$result['count'];
	$tot_cur+=$count;
	$sanjeewa_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and
                      t.customer_id in ('$cx_id') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =48
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $sanjeewa_previous_run=mysqli_query($connection,$sanjeewa_previous);
     while($result=mysqli_fetch_array($sanjeewa_previous_run)){

     	$sanjeewa_previous_count=$result['count'];
     	$tot_pre+=$sanjeewa_previous_count;
     	
     }

    $change=$count-$sanjeewa_previous_count;

    
	$table_list3.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$sanjeewa_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$sanjeewa_previous_count="0";	
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

    $sanjeewa_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                     substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =48
                      group by res_name,t.customer_id 
                      order by count desc";

                      $sanjeewa_previous2_run=mysqli_query($connection,$sanjeewa_previous2);
     while($result=mysqli_fetch_array($sanjeewa_previous2_run)){

     	$sanjeewa_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list3.='<tr><td>'.$sanjeewa_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list3.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';	


     //--------------------------------------------------------------------------------------------------------------------------------------------------//


$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$nimnaz="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =118
                      group by res_name,t.customer_id 
                      order by count desc";
$table_list12="";
$table_list12.='<table class="hodlist"> 
<tr><th  colspan="4" class="header">HOD - Nimnaz</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$nimnaz_run=mysqli_query($connection,$nimnaz);

while ($result=mysqli_fetch_array($nimnaz_run)) {
  $customers.='\''.$result['customer_id'].'\',';
  $cx_id=$result['customer_id'];
  $count=$result['count'];
  $tot_cur+=$count;
  $nimnaz_previous_count=0;
  $nimnaz_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and
                      t.customer_id in ('$cx_id') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =118
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $nimnaz_previous_run=mysqli_query($connection,$nimnaz_previous);
     while($result=mysqli_fetch_array($nimnaz_previous_run)){

      $nimnaz_previous_count=$result['count'];
      $tot_pre+=$nimnaz_previous_count;
      
     }

    $change=$count-$nimnaz_previous_count;

    
  $table_list12.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$nimnaz_previous_count.'</td><td class="chg_count">'.$change.'</td>
  </tr>';
  $nimnaz_previous_count="0";  
   
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

   $nimnaz_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                     substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) not in (77,175,141,58,63,165,110,59,97,7,
                                        70,81,102,104,186,160,191,20,51,60) and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) =118
                      group by res_name,t.customer_id 
                      order by count desc";

                      $nimnaz_previous2_run=mysqli_query($connection,$nimnaz_previous2);
     while($result=mysqli_fetch_array($nimnaz_previous2_run)){

      $nimnaz_previous_cx=$result['customer_id'];
      $pr_cx=$result['count'];

      $table_list12.='<tr><td>'.$nimnaz_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
      $tot_pre+=$pr_cx;
       

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list12.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>'; 




     //------------------------------------------------------------------------------------------------------------------------------------------------------//



$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';
$count="0";


$pm="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (77,175,141,58,63,165,110,94,20,25)
                      group by t.customer_id 
                      order by count desc";
$table_list4="";
$table_list4.='<table class="hodlist"> 
<tr><th  class="header" colspan="4">HOD - PM</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$pm_run=mysqli_query($connection,$pm);
$cxs[]="";

while ($result=mysqli_fetch_array($pm_run)) {
	$sql="";
	$pm_previous_count="0";
	$cx_id=$result['customer_id'];
	if (!in_array($cx_id, $cxs)){
		$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	}
	$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$pm_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') ".$sql."  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (77,175,141,58,63,165,110,94,20,25)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $pm_previous_run=mysqli_query($connection,$pm_previous);
     while($result=mysqli_fetch_array($pm_previous_run)){

     	$pm_previous_count=$result['count'];
     	$tot_pre+=$pm_previous_count;
     	
     }

    $change=$count-$pm_previous_count;

    
	$table_list4.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$pm_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$pm_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $pm_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (77,175,141,58,63,165,110,94,20,25)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $pm_previous2_run=mysqli_query($connection,$pm_previous2);
     while($result=mysqli_fetch_array($pm_previous2_run)){

     	$pm_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list4.='<tr><td>'.$pm_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list4.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';	


  //----------------------------------------------------------------------------------------------------------------------------------------------------------//




$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$imp="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (59,97)
                      group by t.customer_id 
                      order by count desc";
$table_list5="";
$table_list5.='<table class="hodlist"> 
<tr><th class="header" colspan="4">HOD - Don & Ishara</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$imp_run=mysqli_query($connection,$imp);
//$cxs[]="";

while ($result=mysqli_fetch_array($imp_run)) {
	//$sql="";
	$imp_previous_count="0";
	$cx_id=$result['customer_id'];
	//if (!in_array($cx_id, $cxs)){
		//$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	//}
	//$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$imp_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win')and t.customer_id in ('$cx_id')  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (59,97)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $imp_previous_run=mysqli_query($connection,$imp_previous);
     while($result=mysqli_fetch_array($imp_previous_run)){

     	$imp_previous_count=$result['count'];
     	$tot_pre+=$imp_previous_count;
     	
     }

    $change=$count-$imp_previous_count;

    
	$table_list5.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$imp_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$imp_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $imp_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (59,97)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $imp_previous2_run=mysqli_query($connection,$imp_previous2);
     while($result=mysqli_fetch_array($imp_previous2_run)){

     	$imp_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list5.='<tr><td>'.$imp_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list5.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';


     //-------------------------------------------------------------------------------------------------------------------------------------------------//




$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$phl="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (51,60)
                      group by t.customer_id 
                      order by count desc";
$table_list6="";
$table_list6.='<table class="hodlist"> 
<tr><th class="header"  colspan="4">HOD - PHL</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$phl_run=mysqli_query($connection,$phl);
//$cxs[]="";

while ($result=mysqli_fetch_array($phl_run)) {
	//$sql="";
	$phl_previous_count="0";
	$cx_id=$result['customer_id'];
	//if (!in_array($cx_id, $cxs)){
		//$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	//}
	//$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$phl_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win')and t.customer_id in ('$cx_id')  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (51,60)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $phl_previous_run=mysqli_query($connection,$phl_previous);
     while($result=mysqli_fetch_array($phl_previous_run)){

     	$phl_previous_count=$result['count'];
     	$tot_pre+=$phl_previous_count;
     	
     }

    $change=$count-$phl_previous_count;

    
	$table_list6.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$phl_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$phl_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $phl_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (51,60)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $phl_previous2_run=mysqli_query($connection,$phl_previous2);
     while($result=mysqli_fetch_array($phl_previous2_run)){

     	$phl_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list6.='<tr><td>'.$phl_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list6.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';


     //----------------------------------------------------------------------------------------------------------------------------------------------------//



$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$venura="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (54)
                      group by t.customer_id 
                      order by count desc";
$table_list7="";
$table_list7.='<table class="hodlist"> 
<tr><th class="header" colspan="4">HOD - Venura</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$venura_run=mysqli_query($connection,$venura);
//$cxs[]="";

while ($result=mysqli_fetch_array($venura_run)) {
	//$sql="";
	$venura_previous_count="0";
	$cx_id=$result['customer_id'];
	//if (!in_array($cx_id, $cxs)){
		//$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	//}
	//$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$venura_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win')and t.customer_id in ('$cx_id')  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (54)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $venura_previous_run=mysqli_query($connection,$venura_previous);
     while($result=mysqli_fetch_array($venura_previous_run)){

     	$venura_previous_count=$result['count'];
     	$tot_pre+=$venura_previous_count;
     	
     }

    $change=$count-$venura_previous_count;

    
	$table_list7.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$venura_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$venura_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $venura_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (54)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $venura_previous2_run=mysqli_query($connection,$venura_previous2);
     while($result=mysqli_fetch_array($venura_previous2_run)){

     	$venura_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list7.='<tr><td>'.$venura_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list7.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';


     //--------------------------------------------------------------------------------------------------------------------------------------------//



$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$support="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (7,70,81,102,104,186,160,191)
                      group by t.customer_id 
                      order by count desc";
$table_list8="";
$table_list8.='<table class="hodlist"> 
<tr><th class="header" colspan="4">HOD - Support</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$support_run=mysqli_query($connection,$support);
//$cxs[]="";

while ($result=mysqli_fetch_array($support_run)) {
	//$sql="";
	$support_previous_count="0";
	$cx_id=$result['customer_id'];
	//if (!in_array($cx_id, $cxs)){
		//$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	//}
	//$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$support_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win')and t.customer_id in ('$cx_id')  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (7,70,81,102,104,186,160,191)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $support_previous_run=mysqli_query($connection,$support_previous);
     while($result=mysqli_fetch_array($support_previous_run)){

     	$support_previous_count=$result['count'];
     	$tot_pre+=$support_previous_count;
     	
     }

    $change=$count-$support_previous_count;

    
	$table_list8.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$support_previous_count.'</td><td class=chg_count>'.$change.'</td></tr>';
	$support_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $support_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (7,70,81,102,104,186,160,191)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $support_previous2_run=mysqli_query($connection,$support_previous2);
     while($result=mysqli_fetch_array($support_previous2_run)){

     	$support_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list8.='<tr><td>'.$support_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list8.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';

     //-------------------------------------------------------------------------------------------------------------------------------------------//



$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$uditha="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (117)
                      group by t.customer_id 
                      order by count desc";
$table_list9="";
$table_list9.='<table class="hodlist"> 
<tr><th class="header" colspan="4">HOD - Uditha</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$uditha_run=mysqli_query($connection,$uditha);
//$cxs[]="";

while ($result=mysqli_fetch_array($uditha_run)) {
	//$sql="";
	$uditha_previous_count="0";
	$cx_id=$result['customer_id'];
	//if (!in_array($cx_id, $cxs)){
		//$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	//}
	//$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$uditha_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win')and t.customer_id in ('$cx_id')  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (117)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $uditha_previous_run=mysqli_query($connection,$uditha_previous);
     while($result=mysqli_fetch_array($uditha_previous_run)){

     	$uditha_previous_count=$result['count'];
     	$tot_pre+=$uditha_previous_count;
     	
     }

    $change=$count-$uditha_previous_count;

    
	$table_list9.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$uditha_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$uditha_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $uditha_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (117)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $uditha_previous2_run=mysqli_query($connection,$uditha_previous2);
     while($result=mysqli_fetch_array($uditha_previous2_run)){

     	$uditha_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list9.='<tr><td>'.$uditha_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list9.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';


     //-------------------------------------------------------------------------------------------------------------------------------------------------------//


$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$gayanee="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (22)
                      group by t.customer_id 
                      order by count desc";
$table_list10="";
$table_list10.='<table class="hodlist"> 
<tr><th class="header" colspan="4">HOD - Gayanee</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$gayanee_run=mysqli_query($connection,$gayanee);
//$cxs[]="";

while ($result=mysqli_fetch_array($gayanee_run)) {
	//$sql="";
	$gayanee_previous_count="0";
	$cx_id=$result['customer_id'];
	//if (!in_array($cx_id, $cxs)){
		//$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	//}
	//$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$gayanee_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win')and t.customer_id in ('$cx_id')  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (22)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $gayanee_previous_run=mysqli_query($connection,$gayanee_previous);
     while($result=mysqli_fetch_array($gayanee_previous_run)){

     	$gayanee_previous_count=$result['count'];
     	$tot_pre+=$gayanee_previous_count;
     	
     }

    $change=$count-$uditha_previous_count;

    
	$table_list10.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$gayanee_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$gayanee_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $gayanee_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (22)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $gayanee_previous2_run=mysqli_query($connection,$gayanee_previous2);
     while($result=mysqli_fetch_array($gayanee_previous2_run)){

     	$gayanee_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list10.='<tr><td>'.$gayanee_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list10.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';

     //----------------------------------------------------------------------------------------------------------------------------------------------//

$customers="";
$pr="";
$pr_cx="";
$tot_cur='0';
$tot_pre='0';
$tot_chg='0';

$nath="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win') and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (30)
                      group by t.customer_id 
                      order by count desc";
$table_list11="";
$table_list11.='<table class="hodlist"> 
<tr><th class="header" colspan="4">HOD - Nath</th></tr>
<tr><th class="cx">Customer</th><th class="header2">Current Count</th><th class="header2">Previous Count</th><th class="header2">Change</th></tr>';


$nath_run=mysqli_query($connection,$nath);
//$cxs[]="";

while ($result=mysqli_fetch_array($nath_run)) {
	//$sql="";
	$nath_previous_count="0";
	$cx_id=$result['customer_id'];
	//if (!in_array($cx_id, $cxs)){
		//$sql="and t.customer_id in ('".$cx_id."')";
		//echo "yes";
	//}
	//$cxs[]=$result['customer_id'];
	$customers.='\''.$result['customer_id'].'\',';
	
	$count=$result['count'];
	$tot_cur+=$count;
	

	$nath_previous="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win')and t.customer_id in ('$cx_id')  and substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (30)
                      group by res_name,t.customer_id 
                      order by count desc";

     

     $nath_previous_run=mysqli_query($connection,$nath_previous);
     while($result=mysqli_fetch_array($nath_previous_run)){

     	$nath_previous_count=$result['count'];
     	$tot_pre+=$nath_previous_count;
     	
     }

    $change=$count-$nath_previous_count;

    
	$table_list11.='<tr><td>'.$cx_id.'</td><td class="count">'.$count.'</td><td class="prv_count">'.$nath_previous_count.'</td><td class="chg_count">'.$change.'</td></tr>';
	$nath_previous_count="0";	
	$cx_id="";
	 
}

$customers=rtrim($customers,'\',');
$customers=ltrim($customers,'\'');

     $nath_previous2="select count(th.ticket_id) as count,t.customer_id, substring_index((select name as name
          from ticket_history
            where id = (
            select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
            and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) >= '2014-11-10' 
            ) ), '%', -1) as res_name,u2.first_name as responsible
              from ticket_history th
              inner join users u2 on u2.id=
              substring_index((select name as name
              from ticket_history
                where id = (
                select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from ticket_history h
                  inner join ticket ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and
                    date(h.change_time) >= '2014-11-10' 
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join ticket t on t.id = th.ticket_id
                    inner join users u1 on t.responsible_user_id=u1.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,14,30,13,33) and t.customer_id not in('phl-ubp','swe-win','$customers') and
                      substring_index((select name as name
                                      from ticket_history
                                        where id = (
                                        select max(id) from ticket_history x where history_type_id = 34 and ticket_id = th.ticket_id
                                        and date(x.change_time) < DATE_SUB(DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-2 DAY),INTERVAL 1 WEEK) and date(x.change_time) >= '2014-11-10' 
                                        ) ), '%', -1) in (30)
                      group by res_name,t.customer_id 
                      order by count desc";

                       $nath_previous2_run=mysqli_query($connection,$nath_previous2);
     while($result=mysqli_fetch_array($nath_previous2_run)){

     	$nath_previous_cx=$result['customer_id'];
     	$pr_cx=$result['count'];

     	$table_list11.='<tr><td>'.$nath_previous_cx.'</td><td class="count">0</td><td class="prv_count">'.$pr_cx.'</td><td class="chg_count">'.'-'.$pr_cx.'</td></tr>';
     	$tot_pre+=$pr_cx;
     	 

     }
     $tot_chg=$tot_cur-$tot_pre;
     $table_list11.='<tr><td style="font-weight:bold;">Total</td><td style="font-weight:bold;" class="count">'.$tot_cur.'</td><td style="font-weight:bold;" class="prv_count">'.$tot_pre.'</td><td style="font-weight:bold;" class="chg_count">'.$tot_chg.'</td></tr>';



?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Document</title>
  <link href="hod.css" rel="stylesheet" type="text/css" >  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="ums/css/main.css">

 </head>
 <body>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
  <main class="wrapper"> 
 	  <?php echo $table_list; ?><br>
 	  <?php echo $table_list2; ?><br>
 	  <?php echo $table_list3; ?><br>
 	  <?php echo $table_list4; ?><br>
 	  <?php echo $table_list5; ?><br>
 	  <?php echo $table_list6; ?><br>
 	  <?php echo $table_list7; ?><br>
 	  <?php echo $table_list8; ?><br>
 	  <?php echo $table_list9; ?><br>
 	  <?php echo $table_list10; ?><br>
 	  <?php echo $table_list11; ?><br>
    <?php echo $table_list12; ?><br>
    

  </main>

  <script type='text/javascript'>



 $(document).ready( function() { 

  
    $("td.prv_count").each (function () {
       var $cCell = $(this);      
          $cCell.css("color", "black");
          $cCell.css("text-align", "center");
          $cCell.css("background-color", "#8e9eab");   
            
       
    });


      $("td.chg_count").each (function () {
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

      
});
 </script>

 </body>
 </html>
