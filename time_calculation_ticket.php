<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php
$ticket_create_time=0;
$first_responsible_change_time=0;




    $hd_time_in_seconds=0;
    $tech_time_in_seconds=0;
    $cx_time_in_seconds=0;
    $ticket_id=217873;
$query="select * from issue_view where id=".$ticket_id;
$query_run=mysqli_query($connection,$query);
while($result=mysqli_fetch_array($query_run)){
//getting ticket create time
$ticket_create_time= $result['create_time'];
//echo $ticket_create_time.'<br>';
}


$query2="select change_time,substring_index(name,'%',-1) as res_id,state_id from issuehis_view where id in(
select min(id) from issuehis_view where
history_type_id in (34) and ticket_id=".$ticket_id.")";
$query2_run=mysqli_query($connection,$query2);
while($result2=mysqli_fetch_array($query2_run)){
    $responsible_id=$result2['res_id'];
    $state_id=$result2['state_id'];
    if($responsible_id==104 || $responsible_id==7 || $responsible_id==70 || $responsible_id==239 || $responsible_id==238 || $responsible_id==191 
    ||$responsible_id==160 ||$responsible_id==217 ||$responsible_id==201 || $responsible_id==176 || $responsible_id==348){
        //if($state_id==14){
            $first_responsible_change_time= $result2['change_time'];
            //echo '1st responsible change'.$first_responsible_change_time.'<br>';  
        //}
    }else{
        //if($state_id!=14){
            $first_responsible_change_time= $result2['change_time'];
            //echo '1st responsible change'.$first_responsible_change_time.'<br>';  
       // }
    }
//getting first responsible change time apart from HD person
//$first_responsible_change_time= $result2['change_time'];
//echo '1st responsible change'.$first_responsible_change_time.'<br>';
}
//helpdesk time to assign the ticket to it's first responsible(non HD person)
if(strtotime($first_responsible_change_time)>0){
$hd_time_in_seconds+=strtotime($first_responsible_change_time) - strtotime($ticket_create_time);
echo 'hd time ' .$hd_time_in_seconds.'<br>';
//echo gmdate('H:i:s', $hd_time_in_seconds);
}

//to get the all records of responsible change and state change upto first closing state(exp,fix given etc..)
$query3="select id,substring_index(name,'%',-1) as res_id,change_time,state_id,history_type_id,change_by from issuehis_view where id <=(
        select min(id) from issuehis_view
        where state_id in(17,24,25,7)
        and ticket_id=".$ticket_id. "
        order by change_time asc)
        and history_type_id in(27,34) and
        ticket_id=".$ticket_id."
        order by id asc";
$query3_run=mysqli_query($connection,$query3);
$hd_assign_time=0;
$hd_unassign_time=0;
$tech_assign_time=0;
$tech_unassign_time=0;
$cx_assign_time=0;
$cx_unassign_time=0;
$change_by=0;
$hd_assign_flag=0;
$tech_assign_flag=0;
$cx_assign_flag=0;
$id=0;
$info_recvd_flag=0;
$info_req_flag=0;
$hd_1st=1;
$change_time="";
/*new line*/ $reponsible_to_tech_flag=0;
/*new line*/ $reponsible_to_hd_flag=0;

while($result3=mysqli_fetch_array($query3_run)){
    $responsible_id=$result3['res_id'];    
    $state_id=$result3['state_id']; 
    $history_type_id=$result3['history_type_id']; 
    $change_by=$result3['change_by']; 
    $id=$result3['id']; 
    $state_id2="";
    if($history_type_id==34){        
        //HD responsible person
        if($responsible_id==104 || $responsible_id==7 || $responsible_id==70 || $responsible_id==239 || $responsible_id==238 || $responsible_id==191 
        ||$responsible_id==160 ||$responsible_id==217 ||$responsible_id==201 || $responsible_id==176 || $responsible_id==348){ 
            //this is when 1st responsible update been to HD person. To avoid double calculation. In above we calculate the time from ticket
            //create time to ticket 1st assign time to a non HD person. Here also it will again calculate from 1st HD assign person to next non HD
            //responsible update if we dont use this $hd_1st flag.
            $hd_assign_flag=1;
            $hd_assign_time=$result3['change_time'];
            echo 'HD assign time 55555'.$hd_assign_time.'<br>';
            if($hd_1st!=1){
                $id=$id+1;
                //echo $id.'<br>';
                $query4="select state_id from issuehis_view where id=".$id." and history_type_id=27"; 
                $query4_run=mysqli_query($connection,$query4);            
                while($result4=mysqli_fetch_array($query4_run)){
                    $state_id2=$result4['state_id'];
                }
                //Reponsible upto HD without an state update
                /* new line*/if( $hd_assign_flag!=1){                
                $hd_assign_flag=1;
                $hd_assign_time=$result3['change_time'];
                echo 'HD assign time 2222 '.$hd_assign_time.'<br>'; 
                 /* new line*/}

                
                if($tech_assign_flag==1){
                    $tech_unassign_time=$result3['change_time'];
                    echo 'Tech unassign time 1 '.$tech_unassign_time.'<br>';               
                    echo 'Tech assign time '.$tech_assign_time.'<br>';                
                    $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
                    echo 'Tech time '.$tech_time_in_seconds.'<br>';
                    $tech_assign_flag=0;
                    //echo gmdate('H:i:s', $hd_time_in_seconds).'<br>';                  
                } 

                if(!($state_id2=="" || $state_id2==14 || $state_id2==13 || $state_id2==30)){
                //mark in when assign to HD
                    $hd_assign_flag=1;          
                    $hd_assign_time=$result3['change_time'];
                    echo 'HD assign time 3333 '.$hd_assign_time.'<br>';                 
                    if($tech_assign_flag==1){
                        $tech_unassign_time=$result3['change_time'];
                        echo 'Tech unassign time '.$tech_unassign_time.'<br>';
                        echo 'Tech assign time '.$tech_assign_time.'<br>';                    
                        $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
                        echo'Tech time '. $tech_time_in_seconds.'<br>';
                        $tech_assign_flag=0;
                    } 
                    if($cx_assign_flag==1){
                        $cx_unassign_time=$result3['change_time'];
                        echo 'cx unassign time '.$cx_unassign_time.'<br>';
                        echo 'cx assign time '.$cx_assign_time.'<br>';                    
                        $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time);
                        echo'cx time '. $cx_time_in_seconds.'<br>';
                        $cx_assign_flag=0;
                    } 
                } 
                if($state_id2==14 || $state_id2==13 || $state_id2==30){
                    //echo $info_req_flag.'xxx';
                    //mark in when assign to Cx
                    $cx_assign_flag=1; 
                    if($info_req_flag==0){
                        //echo 'yyy';         
                        $cx_assign_time=$result3['change_time'];
                        echo 'Cx assign time '.$cx_assign_time.'<br>'; 
                        $info_req_flag=1;                    
                    }                
                    if($hd_assign_flag==1){
                        $hd_unassign_time=$result3['change_time'];
                        echo 'HD unassign time 111 '.$hd_unassign_time.'<br>';
                        echo 'HD assign time 6666'.$hd_assign_time.'<br>';                    
                        $hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
                        echo 'HD time '.$hd_time_in_seconds.'<br>';
                        $hd_assign_flag=0;
                    }                 
                    if($tech_assign_flag==1){
                        $tech_unassign_time=$result3['change_time'];
                        echo 'Tech unassign time '.$hd_unassign_time.'<br>';
                        echo 'Tech assign time '.$tech_assign_time.'<br>';                    
                        $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
                        echo 'Tech time '.$tech_time_in_seconds.'<br>';
                        $tech_assign_flag=0;
                    } 
                }                
            }
            //$hd_1st=0;                    
        }else{
    /*new line*/        $reponsible_to_tech_flag=1;
            $hd_1st=0;
            $id=$id+1;
            //echo $id.'<br>';
            $query4="select state_id from issuehis_view where id=".$id." and history_type_id=27"; 
            $query4_run=mysqli_query($connection,$query4);            
            while($result4=mysqli_fetch_array($query4_run)){
                $state_id2=$result4['state_id'];
            } 
            //echo 'state'.$state_id2;
            //mark when assign to tech team(other than HD persons)
                if($tech_assign_flag==0){
                $tech_assign_flag=1;
                $tech_assign_time=$result3['change_time'];
                echo 'Tech assign time 11111'.$tech_assign_time.'<br>'; 
                }
            
            
            if($hd_assign_flag==1){  
                $hd_unassign_time=$result3['change_time'];                
                echo 'HD assign time 77777'.$hd_assign_time.'<br>';
                echo 'HD unassign time '.$hd_unassign_time.'<br>';              
                $hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
                echo 'HD time '.$hd_time_in_seconds.'<br>';
                $hd_assign_flag=0;
                //echo gmdate('H:i:s', $hd_time_in_seconds).'<br>';                  
            } 

                /*new*/        if($cx_assign_flag==1){  
                $cx_unassign_time=$result3['change_time'];                
                echo 'Cx assign time 77777'.$cx_assign_time.'<br>';
                echo 'cx unassign time '.$cx_unassign_time.'<br>';              
                $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time);
                echo 'cx time '.$cx_time_in_seconds.'<br>';
                $cx_assign_flag=0;                                 
            } /*new*/
            //echo  $state_id2.'xxx';     
            if($state_id2==14 || $state_id2==13 || $state_id2==30){ 
                                      
                if($tech_assign_flag==1){                    
                    $tech_unassign_time=$result3['change_time'];
                    echo 'Tech unassign time 2222'.$tech_unassign_time.'<br>';
                    echo 'Tech assign time '.$tech_assign_time.'<br>';                   
                    $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time); 
                    echo 'Tech time '. $tech_time_in_seconds.'<br>';
                    $tech_assign_flag=0;
                }  
                $Cx_assign_flag=1;
                if($info_req_flag==0){                                         
                    $cx_assign_time=$result3['change_time'];
                    echo 'Cx assign time '.$cx_assign_time.'<br>'; 
                    $info_req_flag=1;
                }              
            } 
            if(!($state_id2=="" || $state_id2==14 || $state_id2==13 || $state_id2==30)){
                $tech_assign_flag=1;          
                $tech_assign_time=$result3['change_time'];
                echo 'Tech assign time 22222'.$tech_assign_time.'<br>';  
            }                   
        }
        
    }    //end of reposible change

    if($history_type_id==27 && $change_by==1 && $state_id==4){
        if($cx_assign_flag==1){ 
            //echo 'hhh';  
            'Cx unassign time '.$cx_unassign_time=$result3['change_time'];
            echo 'Cx assign time '.$cx_assign_time.'<br>';
            echo 'Cx unassign time ffff '.$cx_unassign_time.'<br>';
            $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time); 
            echo 'Cx time '.$cx_time_in_seconds.'<br>';
            $cx_assign_flag=0;
            $info_recvd_flag=1;
            $info_req_flag=0;
        }

 /*edit line*/       if($hd_assign_flag==0 && $reponsible_to_tech_flag!=1){
            $hd_assign_flag=1;
            $hd_assign_time=$result3['change_time'];            
            echo 'HD assign time 11111'.$hd_assign_time.'<br>';            
        }
  /*edit line*/         if($tech_assign_flag==0 && $reponsible_to_tech_flag==1){
            //echo 'sfsf';
            $tech_assign_flag=1;
            $tech_assign_time=$result3['change_time'];
            echo 'Tech assign time 3333 '.$tech_assign_time.'<br>';
            //$tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
            //echo 'tech time '.$tech_time_in_seconds.'<br>';
            //$tech_assign_time=$result3['change_time'];
           //echo 'Tech assign time 33333'.$tech_assign_time.'<br>';
        }
                         
    } 
    if(($state_id==14 || $state_id==13 || $state_id==30) && $history_type_id==27){
        $cx_assign_flag=1;
               
        if($info_req_flag==0){
            $cx_assign_time=$result3['change_time'];
            echo 'cx assign timebb '.$cx_assign_time.'<br>';
            $info_req_flag=1;
            //$hd_assign_flag=0;
            //$tech_assign_flag=0;
        }
        if($hd_assign_flag==1){            
            $hd_unassign_time=$result3['change_time'];
            echo 'hd unassign //time '.$hd_unassign_time.'<br>';
            echo 'hd assign //time '.$hd_assign_time.'<br>';
            //echo strtotime($hd_assign_time).'<br>';
            //echo strtotime($hd_unassign_time).'<br>';
            $hd_time_in_seconds+= strtotime($hd_unassign_time)- strtotime($hd_assign_time);
            echo 'hd time '.$hd_time_in_seconds.'<br>';
            $hd_assign_flag=0;
        }
        if($tech_assign_flag==1){
            $tech_unassign_time=$result3['change_time'];
            echo 'tech unassign timehh '.$tech_unassign_time.'<br>';
            echo 'tech assign time '.$tech_assign_time.'<br>';
            $tech_time_in_seconds+= strtotime($tech_unassign_time)-strtotime($tech_assign_time);
            echo 'tech time '.$tech_time_in_seconds.'<br>';
            $tech_assign_flag=0;
        }
    }
    
    if(($state_id==17 || $state_id==24 || $state_id==25 || $state_id==7) && $history_type_id==27){
        if($tech_assign_flag==1){
            $tech_unassign_time=$result3['change_time'];
            echo 'Tech unassign time '.$tech_unassign_time.'<br>';
            echo 'Tech assign time '.$tech_assign_time.'<br>';                    
            $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
            echo 'Tech time '.$tech_time_in_seconds.'<br>';
            $tech_assign_flag=0;
        }
        if($hd_assign_flag==1){
            $hd_unassign_time=$result3['change_time'];
            echo 'HD unassign time '.$hd_unassign_time.'<br>';
            echo 'HD assign time 888'.$hd_assign_time.'<br>';                    
            $hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
            echo 'HD time '.$hd_time_in_seconds.'<br>';
            $hd_assign_flag=0;
        }
        if($cx_assign_flag==1){
            //echo 'ooo';
            $cx_unassign_time=$result3['change_time'];
            echo 'Cx unassign time '.$cx_unassign_time.'<br>'; 
            echo 'Cx assign time '.$cx_assign_time.'<br>';                   
            $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time);
            echo 'Cx time '.$cx_time_in_seconds.'<br>';
            $cx_assign_flag=0;
        }
    }
        
    //$hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
    //echo $hd_time_in_seconds.'<br>';
}
// end of finding the ticket age of a given ticket

echo $hd_time_in_seconds.'<br>';
echo 'tech '.$tech_time_in_seconds.'<br>';
echo 'cx '.$cx_time_in_seconds.'<br>';

?>
