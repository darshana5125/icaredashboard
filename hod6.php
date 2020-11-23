<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/variables.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
	 header('Location: index.php');
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

if(isset($_POST['submit'])){
$fulldate=$_POST['date'];

	$year=substr($fulldate,-4);
	$month=substr($fulldate,0,2);
	$day=substr($fulldate, 3,-5);

	$date="'".$year."-".$month."-".$day;
	
 $table_list="";


//get the id(max id) of the last responsible change as for the given date
$temp_max_id_group_1="CREATE TEMPORARY TABLE IF NOT EXISTS temp_max_id_group_1 AS
(
SELECT
					max(id) as max_id,
				  ticket_id
				FROM
					issuehis_view 
				WHERE
					history_type_id = 34
				AND change_time BETWEEN '2014-11-10 00:00:00'	AND $date 23:59:59'
				
							
				group by ticket_id
)";

$temp_max_id_group_1_run=mysqli_query($connection,$temp_max_id_group_1);
//creating an index
$temp_max_id_group_1_index="CREATE UNIQUE INDEX temp_max_id_group_1_index ON temp_max_id_group_1 (ticket_id)";

$temp_max_id_group_1_index_run=mysqli_query($connection,$temp_max_id_group_1_index);
//
$temp_max_id_group_2="CREATE TEMPORARY TABLE IF NOT EXISTS temp_max_id_group_2 AS
(
	SELECT
		max(h.id) AS max_hist
	FROM
		issuehis_view h
	INNER JOIN issue_view ti ON h.ticket_id = ti.id
	WHERE
		h.change_time BETWEEN '2014-11-10 00:00:00'	AND $date 23:59:59'
		
	GROUP BY
		h.ticket_id
)";

$temp_max_id_group_2_run=mysqli_query($connection,$temp_max_id_group_2);
//creating an index
$temp_max_id_group_2_index="CREATE UNIQUE INDEX temp_max_id_group_2_index ON temp_max_id_group_2 (max_hist)"; 

$temp_max_id_group_2_index_run=mysqli_query($connection,$temp_max_id_group_2_index);
//get all the responsible persons for this week
$temp_this_week_persons_1="CREATE TEMPORARY TABLE IF NOT EXISTS temp_this_week_persons_1 AS
(
SELECT
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	issuehis_view th
INNER JOIN intuser_view u2 ON u2.id = substring_index(
	(
		SELECT
			NAME AS NAME
		FROM
			issuehis_view m
		WHERE
			id = (
				SELECT
					max_id
				FROM
					temp_max_id_group_1 
				WHERE
					ticket_id = th.ticket_id
			)
	),
	'%',
	- 1
)
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_2
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	th.state_id IN (	1,		4,		12,		20,		23,		26,		27,		28,		29,		31,		32,		13,		14,		30,		33	)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
GROUP BY
	res_name
)";

$temp_this_week_persons_1_run=mysqli_query($connection,$temp_this_week_persons_1);

//get the id(max id) of the last responsible change as for the week before given date
$temp_max_id_group_3="CREATE TEMPORARY TABLE IF NOT EXISTS temp_max_id_group_3 AS
(
SELECT
					max(id) as max_id,
				  ticket_id
				FROM
					issuehis_view 
				WHERE
					history_type_id = 34
				AND change_time BETWEEN '2014-11-10 00:00:00'	AND DATE_SUB($date 23:59:59',INTERVAL 1 WEEK)
				
				group by ticket_id
)";

$temp_max_id_group_3_run=mysqli_query($connection,$temp_max_id_group_3);
//creating an index
$temp_max_id_group_3_index="CREATE UNIQUE INDEX temp_max_id_group_3_index ON temp_max_id_group_3 (ticket_id)";

$temp_max_id_group_3_index_run=mysqli_query($connection,$temp_max_id_group_3_index);
//
$temp_max_id_group_4="CREATE TEMPORARY TABLE IF NOT EXISTS temp_max_id_group_4 AS
(
	SELECT
		max(h.id) AS max_hist
	FROM
		issuehis_view h
	INNER JOIN issue_view ti ON h.ticket_id = ti.id
	WHERE
		h.change_time BETWEEN '2014-11-10 00:00:00'	AND DATE_SUB($date 23:59:59',INTERVAL 1 WEEK)
		
	GROUP BY
		h.ticket_id
)";

$temp_max_id_group_4_run=mysqli_query($connection,$temp_max_id_group_4);
//creating an index
$temp_max_id_group_4_index="CREATE UNIQUE INDEX temp_max_id_group_4_index ON temp_max_id_group_4 (max_hist)"; 

$temp_max_id_group_4_index_run=mysqli_query($connection,$temp_max_id_group_4_index);
//get all the responsible persons for last week
$temp_last_week_persons_1="CREATE TEMPORARY TABLE IF NOT EXISTS temp_last_week_persons_1 AS
(
SELECT
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	issuehis_view th
INNER JOIN intuser_view u2 ON u2.id = substring_index(
	(
		SELECT
			NAME AS NAME
		FROM
			issuehis_view m
		WHERE
			id = (
				SELECT
					max_id
				FROM
					temp_max_id_group_3 
				WHERE
					ticket_id = th.ticket_id
			)
	),
	'%',
	- 1
)
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_4
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	th.state_id IN (	1,		4,		12,		20,		23,		26,		27,		28,		29,		31,		32,		13,		14,		30,		33	)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
GROUP BY
	res_name
)";

$temp_last_week_persons_1_run=mysqli_query($connection,$temp_last_week_persons_1);

//ibl pending count for each responsible person for current week
$temp_this_week_ibl_pending="CREATE TEMPORARY TABLE IF NOT EXISTS temp_this_week_ibl_pending AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
		SELECT
		max_hist
	FROM
		temp_max_id_group_2
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
				SELECT
					max_id
				FROM
					temp_max_id_group_1 
				WHERE
					ticket_id = th.ticket_id
				)
		),
		'%',
		- 1
	) = u2.id
AND u2.id in ( select res_name from temp_this_week_persons_1)
AND th.state_id IN (	1,		4,		12,		20,		23,		26,		27,		28,		29,		32)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_this_week_ibl_pending_run=mysqli_query($connection,$temp_this_week_ibl_pending);

//ibl pending count for each responsible person for last week
$temp_last_week_ibl_pending="CREATE TEMPORARY TABLE IF NOT EXISTS temp_last_week_ibl_pending AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
		SELECT
		max_hist
	FROM
		temp_max_id_group_4
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
				SELECT
					max_id
				FROM
					temp_max_id_group_3 
				WHERE
					ticket_id = th.ticket_id
				)
		),
		'%',
		- 1
	) = u2.id
AND u2.id in ( select res_name from temp_last_week_persons_1)
AND th.state_id IN (	1,		4,		12,		20,		23,		26,		27,		28,		29,		32)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_last_week_ibl_pending_run=mysqli_query($connection,$temp_last_week_ibl_pending);

$temp_this_week_info_pending="CREATE TEMPORARY TABLE IF NOT EXISTS temp_this_week_info_pending AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_2
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
					SELECT
					max_id
				FROM
					temp_max_id_group_1 
				WHERE
					ticket_id = th.ticket_id
			)
		),
		'%',
		- 1
	) =  u2.id
AND u2.id in ( select res_name from temp_this_week_persons_1)
AND th.state_id IN (14, 30, 31)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_this_week_info_pending_run=mysqli_query($connection,$temp_this_week_info_pending);

$temp_last_week_info_pending="CREATE TEMPORARY TABLE IF NOT EXISTS temp_last_week_info_pending AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_4
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
					SELECT
					max_id
				FROM
					temp_max_id_group_3 
				WHERE
					ticket_id = th.ticket_id
			)
		),
		'%',
		- 1
	) =  u2.id
AND u2.id in ( select res_name from temp_last_week_persons_1)
AND th.state_id IN (14, 30, 31)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_last_week_info_pending_run=mysqli_query($connection,$temp_last_week_info_pending);

$temp_this_week_on_hold="CREATE TEMPORARY TABLE IF NOT EXISTS temp_this_week_on_hold AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_2
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
					SELECT
					max_id
				FROM
					temp_max_id_group_1 
				WHERE
					ticket_id = th.ticket_id
			)
		),
		'%',
		- 1
	) =  u2.id
AND u2.id in ( select res_name from temp_this_week_persons_1)
AND th.state_id IN (13)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_this_week_on_hold_run=mysqli_query($connection,$temp_this_week_on_hold);

$temp_last_week_on_hold="CREATE TEMPORARY TABLE IF NOT EXISTS temp_last_week_on_hold AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_4
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
					SELECT
					max_id
				FROM
					temp_max_id_group_3 
				WHERE
					ticket_id = th.ticket_id
			)
		),
		'%',
		- 1
	) =  u2.id
AND u2.id in ( select res_name from temp_last_week_persons_1)
AND th.state_id IN (13)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_last_week_on_hold_run=mysqli_query($connection,$temp_last_week_on_hold);

$temp_this_week_sh_rel="CREATE TEMPORARY TABLE IF NOT EXISTS temp_this_week_sh_rel AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_2
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
					SELECT
					max_id
				FROM
					temp_max_id_group_1 
				WHERE
					ticket_id = th.ticket_id
			)
		),
		'%',
		- 1
	) =  u2.id
AND u2.id in ( select res_name from temp_this_week_persons_1)
AND th.state_id IN (33)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_this_week_sh_rel_run=mysqli_query($connection,$temp_this_week_sh_rel);

$temp_last_week_sh_rel="CREATE TEMPORARY TABLE IF NOT EXISTS temp_last_week_sh_rel AS
(
SELECT
	count(u2.id) AS count,
	u2.id AS res_name,
	u2.first_name AS responsible
FROM
	intuser_view u2,
	issuehis_view th
INNER JOIN (
	SELECT
		max_hist
	FROM
		temp_max_id_group_4
) open_tickets ON open_tickets.max_hist = th.id
INNER JOIN issue_view t ON t.id = th.ticket_id
INNER JOIN intuser_view u1 ON t.responsible_user_id = u1.id
WHERE
	substring_index(
		(
			SELECT
				NAME AS NAME
			FROM
				issuehis_view
			WHERE
				id = (
					SELECT
					max_id
				FROM
					temp_max_id_group_3 
				WHERE
					ticket_id = th.ticket_id
			)
		),
		'%',
		- 1
	) =  u2.id
AND u2.id in ( select res_name from temp_last_week_persons_1)
AND th.state_id IN (33)
AND t.customer_id not in($cx_list) and t.queue_id not in($q_list) AND t.customer_id not like '%@%'
group by u2.id
)";

$temp_last_week_sh_rel_run=mysqli_query($connection,$temp_last_week_sh_rel);

$tw_count="select sum(big.twiblpen_count) as twiblpen_count, sum(big.lwiblpen_count) as lwiblpen_count, sum(big.twinfpen_count) as twinfpen_count,sum(big.lwinfpen_count) as lwinfpen_count,sum(big.twonhold_count) as twonhold_count,sum(big.lwonhold_count) as lwonhold_count,sum(big.twshrel_count) as twshrel_count,sum(big.lwshrel_count) as lwshrel_count,big.res_name, big.responsible
from
(
	select count as twiblpen_count, 0 as lwiblpen_count, 0 as twinfpen_count, 0 as lwinfpen_count,0 as twonhold_count, 0 as 	    lwonhold_count,0 as twshrel_count,0 as lwshrel_count, res_name, responsible from temp_this_week_ibl_pending
	union
	select 0 as twiblpen_count, count as lwiblpen_count, 0 as twinfpen_count, 0 as lwinfpen_count,0 as twonhold_count, 0 as 	   	lwonhold_count,0 as twshrel_count,0 as lwshrel_count, res_name, responsible from temp_last_week_ibl_pending
	union
    select 0 as twiblpen_count, 0 as lwiblpen_count, count as twinfpen_count, 0 as lwinfpen_count,0 as twonhold_count, 0 as 	lwonhold_count,0 as twshrel_count,0 as lwshrel_count, res_name, responsible from temp_this_week_info_pending
	union
    select 0 as twiblpen_count, 0 as lwiblpen_count, 0 as twinfpen_count, count as lwinfpen_count,0 as twonhold_count, 0 as 	lwonhold_count,0 as twshrel_count,0 as lwshrel_count, res_name, responsible from temp_last_week_info_pending
	union
    select 0 as twiblpen_count, 0 as lwiblpen_count, 0 as twinfpen_count, 0 as lwinfpen_count,count as twonhold_count, 0 as 	lwonhold_count, 0 as twshrel_count,0 as lwshrel_count, res_name, responsible from temp_this_week_on_hold
    union
    select 0 as twiblpen_count, 0 as lwiblpen_count, 0 as twinfpen_count, 0 as lwinfpen_count,0 as twonhold_count, count as 	lwonhold_count,0 as twshrel_count,0 as lwshrel_count, res_name, responsible from temp_last_week_on_hold
    union
    select 0 as twiblpen_count, 0 as lwiblpen_count, 0 as twinfpen_count, 0 as lwinfpen_count,0 as twonhold_count, 0 as 	lwonhold_count,count as twshrel_count,0 as lwshrel_count, res_name, responsible from temp_this_week_sh_rel
    union
    select 0 as twiblpen_count, 0 as lwiblpen_count, 0 as twinfpen_count, 0 as lwinfpen_count,0 as twonhold_count, 0 as 	lwonhold_count,0 as twshrel_count,count as lwshrel_count, res_name, responsible from temp_last_week_sh_rel
    
) as big
group by big.res_name, big.responsible";

$tw_count_run=mysqli_query($connection,$tw_count);

$table_list.='<table class="hodlist" id="myTable" border="1" style="border-collapse: collapse;">  
      <thead>
      <tr class="head">  
        <th rowspan="2" id="hod">HOD</th>      
        <th colspan="3" class="open">IBL Pending</th>  
        <th colspan="3" class="info">Cx Pending</th>  
        <th colspan="3" class="hold">On Hold</th> 
        <th colspan="3" class="shd">Scheduled Release</th>   
        <th colspan="3" class="total">Effective Total CSR</th>        
      </tr>   
      <tr class="head">        
        <td class="open">Current</td>
        <td class="open">Previous</td>
        <td class="open">Change</td> 
        <td class="info">Current</td>
        <td class="info">Previous</td>
        <td class="info">Change</td> 
        <td class="hold">Current</td>
        <td class="hold">Previous</td>
        <td class="hold">Change</td>  
        <td class="shd">Current</td>
        <td class="shd">Previous</td>
        <td class="shd">Change</td>
        <td class="total">Current</td>
        <td class="total">Previous</td>
        <td class="total">Change</td>        
      </tr> </thead><tbody>';
	  

 while($result_tw_count=mysqli_fetch_array($tw_count_run)){
	 $iblpen_chg=$result_tw_count['twiblpen_count']-$result_tw_count['lwiblpen_count'];
	 $infpen_chg=$result_tw_count['twinfpen_count']-$result_tw_count['lwinfpen_count'];
	 $onhold_chg=$result_tw_count['twonhold_count']-$result_tw_count['lwonhold_count'];
	 $shrel_chg=$result_tw_count['twshrel_count']-$result_tw_count['lwshrel_count'];
	 
	 $efe_cur=$result_tw_count['twiblpen_count']+$result_tw_count['twinfpen_count']+$result_tw_count['twonhold_count']+$result_tw_count['twshrel_count'];
     $efe_prv=$result_tw_count['lwiblpen_count']+$result_tw_count['lwinfpen_count']+$result_tw_count['lwonhold_count']+$result_tw_count['lwshrel_count'];
     $efe_chg=$efe_cur-$efe_prv;
	 
	 $table_list.='<tr class="data"><td class="res">'.$result_tw_count['responsible'].'</td><td class="center">'.$result_tw_count['twiblpen_count'].'</td><td class="previous">'.$result_tw_count['lwiblpen_count'].'</td><td class="change">'.$iblpen_chg.'</td><td class="center">'.$result_tw_count['twinfpen_count'].'</td><td class="previous">'.$result_tw_count['lwinfpen_count'].'</td><td class="change">'.$infpen_chg.'</td><td class="center">'.$result_tw_count['twonhold_count'].'</td><td class="previous">'.$result_tw_count['lwonhold_count'].'</td><td class="change">'.$onhold_chg.'</td><td class="center">'.$result_tw_count['twshrel_count'].'</td><td class="previous">'.$result_tw_count['lwshrel_count'].'</td><td class="change">'.$shrel_chg.'</td><td class="center">'.$efe_cur.'</td><td class="previous">'.$efe_prv.'</td><td class="change">'.$efe_chg.'</td></tr>';	 
 }

  $table_list.='</tbody></table>';
  
  //-----------------------------------------------------------------------------------------------------------------------------------------------//
  
   $query_pool="select t.tn,t.title,ts.name as state,tp.name as priority,t.customer_id,s.name as service,u.first_name as owner,
u2.first_name as responsible
              from issuehis_view th
              inner join intuser_view u2 on u2.id=
              substring_index((select name as name
              from issuehis_view
                where id = (
                select max(id) from issuehis_view x where history_type_id = 34 and ticket_id = th.ticket_id
                and date(x.change_time) 
				BETWEEN STR_TO_DATE('2014-11-10  00:00:00', '%Y-%m-%d %H:%i:%S')	AND STR_TO_DATE($date 23:59:59', '%Y-%m-%d %H:%i:%S')
			
                ) ), '%', -1) 
                  inner join (
                  select max(h.id) as max_hist, h.ticket_id
                  from issuehis_view h
                  inner join issue_view ti
                  on h.ticket_id=ti.id  
                    where date(h.change_time) BETWEEN STR_TO_DATE('2014-11-10  00:00:00', '%Y-%m-%d %H:%i:%S')	AND STR_TO_DATE($date 23:59:59', '%Y-%m-%d %H:%i:%S')
                    group by h.ticket_id
                    ) open_tickets on open_tickets.max_hist = th.id
                    inner join issue_view t on t.id = th.ticket_id
                    inner join intuser_view u1 on t.responsible_user_id=u1.id
                    inner join issuestate_view ts on th.state_id=ts.id
                    inner join issuelevel_view tp on t.ticket_priority_id=tp.id
                    left join service_view s on t.service_id=s.id
                    inner join intuser_view u on t.user_id=u.id
                      where th.state_id  in (1,4,12,20,23,26,27,28,29,31,32,13,14,30,33) 
                      and  t.customer_id not in($cx_list) and t.queue_id not in($q_list) and t.customer_id not like '%@%'";
  $query_pool_run=mysqli_query($connection,$query_pool);

   $pool_table='<table id="myTable2" border="0" style="border-collapse: collapse;" width="100%"><thead>

   <tr>  
        <th >CSR #</th>      
        <th >Title</th>  
        <th >State</th>  
        <th >Priority</th> 
        <th >CustomerID</th>   
        <th >Service</th>   
        <th >Owner</th>  
        <th >Responsible</th>  
   </tr> </thead><tbody>';

    while($result_pool_table=mysqli_fetch_array($query_pool_run)){
      $pool_table.='<tr class="data"><td>'.$result_pool_table['tn'].'</td>
                    <td>'.$result_pool_table['title'].'</td>
                    <td>'.$result_pool_table['state'].'</td>
                    <td>'.$result_pool_table['priority'].'</td>
                    <td>'.$result_pool_table['customer_id'].'</td>
                    <td>'.$result_pool_table['service'].'</td>
                    <td>'.$result_pool_table['owner'].'</td>
                    <td class="resp">'.$result_pool_table['responsible'].'</td></tr>';
    }
    $pool_table.='</tbody></table>';





}

?>
<html lang="en">
<head>

  <script type="text/javascript" src="\icaredashboard/libraries/gstatic/charts/loader.js"></script>
    
  <meta charset="UTF-8">
  <title>Document</title>
  <style type="text/css">
<!--
@import url("table.css");
-->
</style>
<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="\icaredashboard/js/jquery.tablesorter.min.js"></script> 
    <link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js" ></script>
    <script src="\icaredashboard/libraries\googleapis/ajax/libs/angularjs/1.4.7/angular.js" ></script>
    <script src="\icaredashboard/libraries\googleapis/ajax/libs/angularjs/1.4.7/angular-animate.js" ></script>
    <script src="\icaredashboard/hod/anujular_hod.js"></script>
  <link href="hod.css" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="ums/css/main.css">
</head>
<body>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
  <main>
  
  <form name="hod" method="POST" action="hod6.php?mid=14">
  	
  	    
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
	 
	 echo '
    <table id="tab1" class="tab"><tr><td>
  <input type="checkbox" id="Geehan" value="Geehan" ><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Geehan</span>
  <input type="checkbox" id="PHL" value="PHL"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">PHL</span>
  <input type="checkbox" id="Roshen" value="Venura"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Roshen</span>
  <input type="checkbox" id="Pubudu" value="Pubudu"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Pubudu</span>
  <input type="checkbox" id="Sanesh" value="Sanesh"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Sanesh</span>
  <input type="checkbox" id="Samira" value="Samira"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Samira</span>
  <input type="checkbox" id="Don" value="Don & Ishara"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Don</span>
  <input type="checkbox" id="Support" value="Support"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Helpdesk</span>
  <input type="checkbox" id="Chinthaka" value="Chinthaka"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Chinthaka</span>
  <input type="checkbox" id="Nimnaz" value="Nimnaz"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Nimnaz</span>
  <input type="checkbox" id="Gayanee" value="Gayanee"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Gayanee</span>
  <input type="checkbox" id="Uditha" value="Uditha"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Uditha</span>
  <input type="checkbox" id="All" value="All"><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">All</span></td></tr>
  </table>';

  echo '<span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;">Number of CSR:</span><span style="font-family: Lucida Sans Unicode, Lucida Grande, Sans-Serif;
  font-size: 12px;color: #039;" id="count"></span>';
	 
	 echo $pool_table; 
 
}

   ?>
   <script type="text/javascript">

   $(document).ready(function(){
	   
  var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;


    $('#Geehan').click(function() {
      

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Thilanchana" || customerId=="Geehan"){
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
     if(customerId=="Dinusha" || customerId=="Wyndel" || customerId=="Leojino"
	 || customerId=="Rameez " || customerId=="Lahiru" || customerId=="Omar" || customerId=="Abigail"
	 || customerId=="John Robin"	 || customerId=="Francis" || customerId=="Kanchana             " || customerId=="Lean" || customerId=="Joseph"
	 || customerId=="Rolimer" || customerId=="Mark" || customerId=="Madushanka" || customerId=="MegaLink"
	 || customerId=="John Paolo" || customerId=="Dunhill" || customerId=="Jake" || customerId=="Jessa" || 
	 customerId=="Arnie"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });

      var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows; 

  });



    $('#Roshen').click(function() {

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
         
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Roshen"){
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

    $('#Sanesh').click(function() {

       $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);


       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Sanesh"){
       $(this).show();
        }
        else{
         $(this).hide();  
        }
  });
       var numOfVisibleRows = $('#myTable2 tr.data:visible').length;
       document.getElementById("count").innerHTML =numOfVisibleRows;

  });

      $('#Samira').click(function() {

         $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
    $(this).prop("checked", true);

       $('#myTable2 tr.data').each(function() {
    customerId = $(this).find(".resp").html(); 
     if(customerId=="Samira"){
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
     if(customerId=="Bhanuka" || customerId=="Don" || customerId=="Mauran" || customerId=="Minura"){
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
     if(customerId=="Roshan" || customerId=="Viraj" || customerId=="Chamila" || customerId=="Priyadarshana" || customerId=="Aathif"
	 || customerId=="Suganthan" || customerId=="John" || customerId=="Shanaka"  || customerId=="Interblocks"){
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
     if(customerId=="Sanath" || customerId=="Hareen" || customerId=="Thilini " || customerId=="Chintaka"){
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

	   
            var customerId = "";
            var hod = "";
            var pm_ibl = 0;
            var pm_ibl_prv = 0;
            var pm_ibl_chg = 0;
            var pm_info = 0;
            var pm_info_prv = 0;
            var pm_info_chg = 0;
            var pm_hold = 0;
            var pm_hold_prv = 0;
            var pm_hold_chg = 0;
            var pm_shd = 0;
            var pm_shd_prv = 0;
            var pm_shd_chg = 0;
            var pm_efe_cur = 0;
            var pm_efe_prv = 0;
            var pm_efe_chg = 0;


            var pm_ibl2 = 0;
            var pm_ibl_prv2 = 0;
            var pm_ibl_chg2 = 0;
            var pm_info2 = 0;
            var pm_info_prv2 = 0;
            var pm_info_chg2 = 0;
            var pm_hold2 = 0;
            var pm_hold_prv2 = 0;
            var pm_hold_chg2 = 0;
            var pm_shd2 = 0;
            var pm_shd_prv2 = 0;
            var pm_shd_chg2 = 0;
            var pm_efe_cur2 = 0;
            var pm_efe_prv2 = 0;
            var pm_efe_chg2 = 0;



            var phl_ibl = 0;
            var phl_ibl_prv = 0;
            var phl_ibl_chg = 0;
            var phl_info = 0;
            var phl_info_prv = 0;
            var phl_info_chg = 0;
            var phl_hold = 0;
            var phl_hold_prv = 0;
            var phl_hold_chg = 0;
            var phl_shd = 0;
            var phl_shd_prv = 0;
            var phl_shd_chg = 0;
            var phl_efe_cur = 0;
            var phl_efe_prv = 0;
            var phl_efe_chg = 0;

            var sup_ibl = 0;
            var sup_ibl_prv = 0;
            var sup_ibl_chg = 0;
            var sup_info = 0;
            var sup_info_prv = 0;
            var sup_info_chg = 0;
            var sup_hold = 0;
            var sup_hold_prv = 0;
            var sup_hold_chg = 0;
            var sup_shd = 0;
            var sup_shd_prv = 0;
            var sup_shd_chg = 0;
            var sup_efe_cur = 0;
            var sup_efe_prv = 0;
            var sup_efe_chg = 0;

            var imp_ibl = 0;
            var imp_ibl_prv = 0;
            var imp_ibl_chg = 0;
            var imp_info = 0;
            var imp_info_prv = 0;
            var imp_info_chg = 0;
            var imp_hold = 0;
            var imp_hold_prv = 0;
            var imp_hold_chg = 0;
            var imp_shd = 0;
            var imp_shd_prv = 0;
            var imp_shd_chg = 0;
            var imp_efe_cur = 0;
            var imp_efe_prv = 0;
            var imp_efe_chg = 0;

            var pmo_ibl = 0;
            var pmo_ibl_prv = 0;
            var pmo_ibl_chg = 0;
            var pmo_info = 0;
            var pmo_info_prv = 0;
            var pmo_info_chg = 0;
            var pmo_hold = 0;
            var pmo_hold_prv = 0;
            var pmo_hold_chg = 0;
            var pmo_shd = 0;
            var pmo_shd_prv = 0;
            var pmo_shd_chg = 0;
            var pmo_efe_cur = 0;
            var pmo_efe_prv = 0;
            var pmo_efe_chg = 0;

            var sdi_ibl = 0;
            var sdi_ibl_prv = 0;
            var sdi_ibl_chg = 0;
            var sdi_info = 0;
            var sdi_info_prv = 0;
            var sdi_info_chg = 0;
            var sdi_hold = 0;
            var sdi_hold_prv = 0;
            var sdi_hold_chg = 0;
            var sdi_shd = 0;
            var sdi_shd_prv = 0;
            var sdi_shd_chg = 0;
            var sdi_efe_cur = 0;
            var sdi_efe_prv = 0;
            var sdi_efe_chg = 0;

            var sup2_ibl = 0;
            var sup2_ibl_prv = 0;
            var sup2_ibl_chg = 0;
            var sup2_info = 0;
            var sup2_info_prv = 0;
            var sup2_info_chg = 0;
            var sup2_hold = 0;
            var sup2_hold_prv = 0;
            var sup2_hold_chg = 0;
            var sup2_shd = 0;
            var sup2_shd_prv = 0;
            var sup2_shd_chg = 0;
            var sup2_efe_cur = 0;
            var sup2_efe_prv = 0;
            var sup2_efe_chg = 0;

            var hot_ibl = 0;
            var hot_ibl_prv = 0;
            var hot_ibl_chg = 0;
            var hot_info = 0;
            var hot_info_prv = 0;
            var hot_info_chg = 0;
            var hot_hold = 0;
            var hot_hold_prv = 0;
            var hot_hold_chg = 0;
            var hot_shd = 0;
            var hot_shd_prv = 0;
            var hot_shd_chg = 0;
            var hot_efe_cur = 0;
            var hot_efe_prv = 0;
            var hot_efe_chg = 0;

           

                $('#myTable tr').each(function() {
                    customerId = $(this).find(".res").html();
                    if (customerId == "Sanath" || customerId == "Hareen" || customerId == "Thilini " || customerId == "Chintaka" ||
                        customerId == "Supun" || customerId == "Hashani" || customerId == "Isuru" ||
                        customerId == "Thulith" || customerId == "Sanesh") {

                        pm_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        pm_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        pm_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        pm_info += parseInt($(this).children('td:nth-child(5)').text());
                        pm_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        pm_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        pm_hold += parseInt($(this).children('td:nth-child(8)').text());
                        pm_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        pm_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        pm_shd += parseInt($(this).children('td:nth-child(11)').text());
                        pm_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        pm_shd_chg += parseInt($(this).children('td:nth-child(13)').text());
                        pm_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        pm_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        pm_efe_chg += parseInt($(this).children('td:nth-child(16)').text());


                        //$(this).attr('id', 'test');
                        $(this).hide();

                    } else if (customerId == "Venura" || customerId == "Roshen" || customerId == "Nimnaz" || customerId == "Ashan" || 
                    customerId == "Samira" || customerId == "Manjula" || customerId == "Elite Shree") {
                        //to get to the top
                        $(this).prependTo('#myTable');
                        $(this).find('td:eq(0)').addClass('support');

                    } else if (customerId == "Thilanchana" || customerId == "Geehan") {

                        pm_ibl2 += parseInt($(this).children('td:nth-child(2)').text());
                        pm_ibl_prv2 += parseInt($(this).children('td:nth-child(3)').text());
                        pm_ibl_chg2 += parseInt($(this).children('td:nth-child(4)').text());
                        pm_info2 += parseInt($(this).children('td:nth-child(5)').text());
                        pm_info_prv2 += parseInt($(this).children('td:nth-child(6)').text());
                        pm_info_chg2 += parseInt($(this).children('td:nth-child(7)').text());
                        pm_hold2 += parseInt($(this).children('td:nth-child(8)').text());
                        pm_hold_prv2 += parseInt($(this).children('td:nth-child(9)').text());
                        pm_hold_chg2 += parseInt($(this).children('td:nth-child(10)').text());
                        pm_shd2 += parseInt($(this).children('td:nth-child(11)').text());
                        pm_shd_prv2 += parseInt($(this).children('td:nth-child(12)').text());
                        pm_shd_chg2 += parseInt($(this).children('td:nth-child(13)').text());
                        pm_efe_cur2 += parseInt($(this).children('td:nth-child(14)').text());
                        pm_efe_prv2 += parseInt($(this).children('td:nth-child(15)').text());
                        pm_efe_chg2 += parseInt($(this).children('td:nth-child(16)').text());


                        //$('myTable td').attr('id', 'test');
                        //$(this).attr('id','test');

                        $(this).hide();

                    } else if (customerId == "Dinusha" || customerId == "Wyndel" || customerId == "Leojino" ||
                        customerId == "Rameez " || customerId == "Lahiru" || customerId == "Omar" || customerId == "Abigail" ||
                        customerId == "John Robin" || customerId == "Francis" || customerId == "Kanchana             " || customerId == "Lean" || customerId == "Joseph" ||
                        customerId == "Rolimer" || customerId == "Mark" || customerId == "Madushanka" || customerId == "MegaLink" ||
                        customerId == "John Paolo" || customerId == "Dunhill" || customerId == "Jake" || customerId == "Jessa" ||
                        customerId == "Arnie") {
                        phl_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        phl_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        phl_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        phl_info += parseInt($(this).children('td:nth-child(5)').text());
                        phl_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        phl_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        phl_hold += parseInt($(this).children('td:nth-child(8)').text());
                        phl_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        phl_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        phl_shd += parseInt($(this).children('td:nth-child(11)').text());
                        phl_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        phl_shd_chg += parseInt($(this).children('td:nth-child(13)').text());
                        phl_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        phl_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        phl_efe_chg += parseInt($(this).children('td:nth-child(16)').text());

                        $(this).hide();


                    } else if (customerId == "Bhanuka" || customerId == "Don" || customerId == "Mauran" || customerId == "Minura") {

                        imp_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        imp_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        imp_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        imp_info += parseInt($(this).children('td:nth-child(5)').text());
                        imp_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        imp_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        imp_hold += parseInt($(this).children('td:nth-child(8)').text());
                        imp_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        imp_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        imp_shd += parseInt($(this).children('td:nth-child(11)').text());
                        imp_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        imp_shd_chg += parseInt($(this).children('td:nth-child(13)').text());
                        imp_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        imp_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        imp_efe_chg += parseInt($(this).children('td:nth-child(16)').text());

                        $(this).hide();


                    } else if (customerId == "Roshan" || customerId == "Viraj" || customerId == "Damith" || customerId == "Priyadarshana" || customerId == "Aathif" ||
                        customerId == "Suganthan" || customerId == "John" || customerId == "Shanaka" || customerId == "Interblocks") {

                        sup_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        sup_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        sup_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        sup_info += parseInt($(this).children('td:nth-child(5)').text());
                        sup_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        sup_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        sup_hold += parseInt($(this).children('td:nth-child(8)').text());
                        sup_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        sup_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        sup_shd += parseInt($(this).children('td:nth-child(11)').text());
                        sup_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        sup_hold_chg += parseInt($(this).children('td:nth-child(13)').text());
                        sup_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        sup_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        sup_efe_chg += parseInt($(this).children('td:nth-child(16)').text());

                        $(this).hide();                        

                    } else if (customerId == "Meena") {
                        hot_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        hot_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        hot_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        hot_info += parseInt($(this).children('td:nth-child(5)').text());
                        hot_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        hot_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        hot_hold += parseInt($(this).children('td:nth-child(8)').text());
                        hot_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        hot_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        hot_shd += parseInt($(this).children('td:nth-child(11)').text());
                        hot_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        hot_hold_chg += parseInt($(this).children('td:nth-child(13)').text());
                        hot_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        hot_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        hot_efe_chg += parseInt($(this).children('td:nth-child(16)').text());

                        $(this).hide();

                    }else if(customerId=="Kavinda"){
                        sdi_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        sdi_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        sdi_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        sdi_info += parseInt($(this).children('td:nth-child(5)').text());
                        sdi_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        sdi_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        sdi_hold += parseInt($(this).children('td:nth-child(8)').text());
                        sdi_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        sdi_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        sdi_shd += parseInt($(this).children('td:nth-child(11)').text());
                        sdi_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        sdi_hold_chg += parseInt($(this).children('td:nth-child(13)').text());
                        sdi_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        sdi_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        sdi_efe_chg += parseInt($(this).children('td:nth-child(16)').text());

                        $(this).hide();
                    }
                });
                var pm_ibl_chg = pm_ibl - pm_ibl_prv;
                var pm_info_chg = pm_info - pm_info_prv;
                var pm_hold_chg = pm_hold - pm_hold_prv;
                var pm_shd_chg = pm_shd - pm_shd_prv;
                var pm_efe = pm_ibl + pm_info + pm_hold + pm_shd;
                var pm_efe_prv = pm_ibl_prv + pm_info_prv + pm_hold_prv + pm_shd_prv;
                var pm_efe_chg = pm_efe - pm_efe_prv;

                var phl_ibl_chg = phl_ibl - phl_ibl_prv;
                var phl_info_chg = phl_info - phl_info_prv;
                var phl_hold_chg = phl_hold - phl_hold_prv;
                var phl_shd_chg = phl_shd - phl_shd_prv;
                var phl_efe = phl_ibl + phl_info + phl_hold + phl_shd;
                var phl_efe_prv = phl_ibl_prv + phl_info_prv + phl_hold_prv + phl_shd_prv;
                var phl_efe_chg = phl_efe - phl_efe_prv;



                var sup_ibl_chg = sup_ibl - sup_ibl_prv;
                var sup_info_chg = sup_info - sup_info_prv;
                var sup_hold_chg = sup_hold - sup_hold_prv;
                var sup_shd_chg = sup_shd - sup_shd_prv;
                var sup_efe = sup_ibl + sup_info + sup_hold + sup_shd;
                var sup_efe_prv = sup_ibl_prv + sup_info_prv + sup_hold_prv + sup_shd_prv;
                var sup_efe_chg = sup_efe - sup_efe_prv;

                $('#myTable tr:eq(2):first').after('<tr class="grp support" id="grp"><td class="support">Helpdesk</td>' + '<td class="center">' + sup_ibl + '</td><td class="previous">' + sup_ibl_prv + '</td><td class="change">' + sup_ibl_chg + '</td><td class="center">' + sup_info + '</td><td class="previous">' + sup_info_prv + '</td><td class="change">' + sup_info_chg + '</td><td class="center">' + sup_hold + '</td><td class="previous">' + sup_hold_prv + '</td><td class="change">' + sup_hold_chg + '</td><td class="center">' + sup_shd + '</td><td class="previous">' + sup_shd_prv + '</td><td class="change">' + sup_shd_chg + '</td><td class="center">' + sup_efe_cur + '</td><td class="previous">' + sup_efe_prv + '</td><td class="change">' + sup_efe_chg + '</td></tr>');

                $('#myTable tr:last').after('<tr class="grp pmo" id="grp"><td class="res pmo">Chintaka </td>' + '<td class="center">' + pm_ibl + '</td><td class="previous">' + pm_ibl_prv + '</td><td class="change">' + pm_ibl_chg + '</td><td class="center">' + pm_info + '</td><td class="previous">' + pm_info_prv + '</td><td class="change">' + pm_info_chg + '</td><td class="center">' + pm_hold + '</td><td class="previous">' + pm_hold_prv + '</td><td class="change">' + pm_hold_chg + '</td><td class="center">' + pm_shd + '</td><td class="previous">' + pm_shd_prv + '</td><td class="change">' + pm_shd_chg + '</td><td class="center">' + pm_efe_cur + '</td><td class="previous">' + pm_efe_prv + '</td><td class="change">' + pm_efe_chg + '</td></tr>');

                $('#myTable tr:last').after('<tr class="grp pmo" id="grp"><td class="res pmo">Geehan </td>' + '<td class="center">' + pm_ibl2 + '</td><td class="previous">' + pm_ibl_prv2 + '</td><td class="change">' + pm_ibl_chg2 + '</td><td class="center">' + pm_info2 + '</td><td class="previous">' + pm_info_prv2 + '</td><td class="change">' + pm_info_chg2 + '</td><td class="center">' + pm_hold2 + '</td><td class="previous">' + pm_hold_prv2 + '</td><td class="change">' + pm_hold_chg2 + '</td><td class="center">' + pm_shd2 + '</td><td class="previous">' + pm_shd_prv2 + '</td><td class="change">' + pm_shd_chg2 + '</td><td class="center">' + pm_efe_cur2 + '</td><td class="previous">' + pm_efe_prv2 + '</td><td class="change">' + pm_efe_chg2 + '</td></tr>');

                $('#myTable tr:last').after('<tr class="grp pmo" id="grp"><td class="res pmo">Don </td><td class="center">' + imp_ibl + '</td><td class="previous">' + imp_ibl_prv + '</td><td class="change">' + imp_ibl_chg + '</td><td class="center">' + imp_info + '</td><td class="previous">' + imp_info_prv + '</td><td class="change">' + imp_info_chg + '</td><td class="center">' + imp_hold + '</td><td class="previous">' + imp_hold_prv + '</td><td class="change">' + imp_hold_chg + '</td><td class="center">' + imp_shd + '</td><td class="previous">' + imp_shd_prv + '</td><td class="change">' + imp_shd_chg + '</td><td class="center">' + imp_efe_cur + '</td><td class="previous">' + imp_efe_prv + '</td><td class="change">' + imp_efe_chg + '</td></tr>');


                $('#myTable tr:last').after('<tr class="grp pmo" id="grp"><td class="res pmo">Meena  </td>' + '<td class="center">' + hot_ibl + '</td><td class="previous">' + hot_ibl_prv + '</td><td class="change">' + hot_ibl_chg + '</td><td class="center">' + hot_info + '</td><td class="previous">' + hot_info_prv + '</td><td class="change">' + hot_info_chg + '</td><td class="center">' + hot_hold + '</td><td class="previous">' + hot_hold_prv + '</td><td class="change">' + hot_hold_chg + '</td><td class="center">' + hot_shd + '</td><td class="previous">' + hot_shd_prv + '</td><td class="change">' + hot_shd_chg + '</td><td class="center">' + hot_efe_cur + '</td><td class="previous">' + hot_efe_prv + '</td><td class="change">' + hot_efe_chg + '</td></tr>');

                $('#myTable tr:last').after('<tr class="grp phl" id="grp"><td class="res phl">PHL </td>' + '<td class="center">' + phl_ibl + '</td><td class="previous">' + phl_ibl_prv + '</td><td class="change">' + phl_ibl_chg + '</td><td class="center">' + phl_info + '</td><td class="previous">' + phl_info_prv + '</td><td class="change">' + phl_info_chg + '</td><td class="center">' + phl_hold + '</td><td class="previous">' + phl_hold_prv + '</td><td class="change">' + phl_hold_chg + '</td><td class="center">' + phl_shd + '</td><td class="previous">' + phl_shd_prv + '</td><td class="change">' + phl_shd_chg + '</td><td class="center">' + phl_efe_cur + '</td><td class="previous">' + phl_efe_prv + '</td><td class="change">' + phl_efe_chg + '</td></tr>');

                $('#myTable tr:last').after('<tr class="grp sdi" id="grp"><td class="res sdi">Kavinda </td>' + '<td class="center">' + sdi_ibl + '</td><td class="previous">' + sdi_ibl_prv + '</td><td class="change">' + sdi_ibl_chg + '</td><td class="center">' + sdi_info + '</td><td class="previous">' + sdi_info_prv + '</td><td class="change">' + sdi_info_chg + '</td><td class="center">' + sdi_hold + '</td><td class="previous">' + sdi_hold_prv + '</td><td class="change">' + sdi_hold_chg + '</td><td class="center">' + sdi_shd + '</td><td class="previous">' + sdi_shd_prv + '</td><td class="change">' + sdi_shd_chg + '</td><td class="center">' + sdi_efe_cur + '</td><td class="previous">' + sdi_efe_prv + '</td><td class="change">' + sdi_efe_chg + '</td></tr>');


                $('#myTable tr').each(function() {


                    hod = $(this).find(".res").html();
                    if (hod == "Sanath" || hod == "Hareen" || hod == "Thilini " || hod == "Chintaka" ||
                        hod == "Supun" || hod == "Hashani" || hod == "Isuru" ||
                        hod == "Thulith" || hod == "Thilanchana" || hod == "Geehan" ||
                        hod == "Bhanuka" || hod == "Don" || hod == "Mauran" || hod == "Minura" ||
                        hod == "Meena" || hod == "Sanesh") {

                        $(this).addClass('pmo');
                        //$(this).find('td:eq(0)').addClass('pmo');
                        pmo_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        pmo_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        pmo_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        pmo_info += parseInt($(this).children('td:nth-child(5)').text());
                        pmo_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        pmo_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        pmo_hold += parseInt($(this).children('td:nth-child(8)').text());
                        pmo_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        pmo_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        pmo_shd += parseInt($(this).children('td:nth-child(11)').text());
                        pmo_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        pmo_shd_chg += parseInt($(this).children('td:nth-child(13)').text());
                        pmo_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        pmo_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        pmo_efe_chg += parseInt($(this).children('td:nth-child(16)').text());

                        // $(this).hide();

                    } else if (hod == "Kavinda") {
                        $(this).addClass("sdi");
                        $(this).find('td:eq(0)').addClass('sdi');
                        
                    } else if (hod == "Samira" || hod == "Ashan" || hod == "Roshen" || hod == "Venura" || hod == "Nimnaz" ||
                        hod == "Roshan" || hod == "Viraj" || hod == "Damith" || hod == "Priyadarshana" || hod == "Aathif" ||
                        hod == "Suganthan" || hod == "John" || hod == "Shanaka" || hod == "Interblocks" || hod == "Manjula"
                        || hod == "Elite Shree") {

                        $(this).addClass('support');
                        sup2_ibl += parseInt($(this).children('td:nth-child(2)').text());
                        sup2_ibl_prv += parseInt($(this).children('td:nth-child(3)').text());
                        sup2_ibl_chg += parseInt($(this).children('td:nth-child(4)').text());
                        sup2_info += parseInt($(this).children('td:nth-child(5)').text());
                        sup2_info_prv += parseInt($(this).children('td:nth-child(6)').text());
                        sup2_info_chg += parseInt($(this).children('td:nth-child(7)').text());
                        sup2_hold += parseInt($(this).children('td:nth-child(8)').text());
                        sup2_hold_prv += parseInt($(this).children('td:nth-child(9)').text());
                        sup2_hold_chg += parseInt($(this).children('td:nth-child(10)').text());
                        sup2_shd += parseInt($(this).children('td:nth-child(11)').text());
                        sup2_shd_prv += parseInt($(this).children('td:nth-child(12)').text());
                        sup2_hold_chg += parseInt($(this).children('td:nth-child(13)').text());
                        sup2_efe_cur += parseInt($(this).children('td:nth-child(14)').text());
                        sup2_efe_prv += parseInt($(this).children('td:nth-child(15)').text());
                        sup2_efe_chg += parseInt($(this).children('td:nth-child(16)').text());
                        // alert(sup2_ibl);
                    }else if(hod == "Dinusha" || hod == "Wyndel" || hod == "Leojino" ||
                        hod == "Rameez " || hod == "Lahiru" || hod == "Omar" || hod == "Abigail" ||
                        hod == "John Robin" || hod == "Francis" || hod == "Kanchana             " || hod == "Lean" || hod == "Joseph" ||
                        hod == "Rolimer" || hod == "Mark" || hod == "Madushanka" || hod == "MegaLink" ||
                        hod == "John Paolo" || hod == "Dunhill" || hod == "Jake" || hod == "Jessa" ||
                        hod == "Arnie" ){
                        $(this).addClass('phl');

                        }

                });

                $('#myTable tr.support:last').after('<tr class="grp sub" id="grp"><td>CS Sub</td>' + '<td class="center">' + sup2_ibl + '</td><td class="previous">' + sup2_ibl_prv + '</td><td class="change">' + sup2_ibl_chg + '</td><td class="center">' + sup2_info + '</td><td class="previous">' + sup2_info_prv + '</td><td class="change">' + sup2_info_chg + '</td><td class="center">' + sup2_hold + '</td><td class="previous">' + sup2_hold_prv + '</td><td class="change">' + sup2_hold_chg + '</td><td class="center">' + sup2_shd + '</td><td class="previous">' + sup2_shd_prv + '</td><td class="change">' + sup2_shd_chg + '</td><td class="center">' + sup2_efe_cur + '</td><td class="previous">' + sup2_efe_prv + '</td><td class="change">' + sup2_efe_chg + '</td></tr>');

                $('#myTable tr.pmo:last').after('<tr class="grp sub" id="grp"><td>PMO Sub</td>' + '<td class="center">' + pmo_ibl + '</td><td class="previous">' + pmo_ibl_prv + '</td><td class="change">' + pmo_ibl_chg + '</td><td class="center">' + pmo_info + '</td><td class="previous">' + pmo_info_prv + '</td><td class="change">' + pmo_info_chg + '</td><td class="center">' + pmo_hold + '</td><td class="previous">' + pmo_hold_prv + '</td><td class="change">' + pmo_hold_chg + '</td><td class="center">' + pmo_shd + '</td><td class="previous">' + pmo_shd_prv + '</td><td class="change">' + pmo_shd_chg + '</td><td class="center">' + pmo_efe_cur + '</td><td class="previous">' + pmo_efe_prv + '</td><td class="change">' + pmo_efe_chg + '</td></tr>');

                $('#myTable tr.phl:last').after('<tr class="grp sub" id="grp"><td>PHL Sub</td>' + '<td class="center">' + phl_ibl + '</td><td class="previous">' + phl_ibl_prv + '</td><td class="change">' + phl_ibl_chg + '</td><td class="center">' + phl_info + '</td><td class="previous">' + phl_info_prv + '</td><td class="change">' + phl_info_chg + '</td><td class="center">' + phl_hold + '</td><td class="previous">' + phl_hold_prv + '</td><td class="change">' + phl_hold_chg + '</td><td class="center">' + phl_shd + '</td><td class="previous">' + phl_shd_prv + '</td><td class="change">' + phl_shd_chg + '</td><td class="center">' + phl_efe_cur + '</td><td class="previous">' + phl_efe_prv + '</td><td class="change">' + phl_efe_chg + '</td></tr>');

                $('#myTable tr.sdi:last').after('<tr class="grp sub" id="grp"><td>MSD Sub</td>' + '<td class="center">' + sdi_ibl + '</td><td class="previous">' + sdi_ibl_prv + '</td><td class="change">' + sdi_ibl_chg + '</td><td class="center">' + sdi_info + '</td><td class="previous">' + sdi_info_prv + '</td><td class="change">' + sdi_info_chg + '</td><td class="center">' + sdi_hold + '</td><td class="previous">' + sdi_hold_prv + '</td><td class="change">' + sdi_hold_chg + '</td><td class="center">' + sdi_shd + '</td><td class="previous">' + sdi_shd_prv + '</td><td class="change">' + sdi_shd_chg + '</td><td class="center">' + sdi_efe_cur + '</td><td class="previous">' + sdi_efe_prv + '</td><td class="change">' + sdi_efe_chg + '</td></tr>');


              




                $('#myTable').append('<thead><tr class="totalColumn"><td>Total</td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td><td></td><td class"grand_previous"></td><td class="grand_change"></td></tr></thead>');

                $('#myTable tr').each(function() {
                    var $td = $(this);
                    var colTotal = 0;
                   

                    $('#myTable tr.sub').each(function() {
                        colTotal += parseInt($(this).children().eq($td.index()).html(), 10);
                    });

                    $('#myTable thead tr.totalColumn').children().eq($td.index()).html(colTotal);

                });

                $('#myTable thead tr.totalColumn').children('td:nth-child(1)').css("text-align", "left");
                $('#myTable thead tr.totalColumn').children('td:nth-child(1)').html("Total");


               /* $("#myTable").tablesorter({                   
                     sortList: [
                         [13, 1]
                     ]
                 });*/


  
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

    $('#myTable').find('tr:not(.totalColumn,.sub)').each(function(){
                    $(this).find('td').eq(15).after('<td class="remove"><a class="btn-remove">Hide</a></td>');
        }); 

    $(".remove").on('click', function(e) {
        var whichtr = $(this).closest("tr");                    
        whichtr.remove();      
      });

  });
	
	//--------------------------------------------------------------------------------------------------------------------------------------------------//



 </script>
 

   </main>
 
</body>
</html>
<?php
mysqli_close($connection);
}else{
	header('Location: index.php');
}
?>







