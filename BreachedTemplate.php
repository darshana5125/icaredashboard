<?php 
echo '
<html>
    <head>
	<style type="text/css">
                    div.BTable{ font-family: calibri;font-size: 9}
                    .customerId{float: right;}
					.heading{background-color: #779ecb;font-size: large;font-weight: bold;}
					 .titles{text-decoration: underline;font-size: medium;font-weight: bold;}
					 .currState{font-weight:bold;}
					 .tdata{padding-bottom: 10px;
                           padding-top: 10px0px;
                           padding-left: 10px;
                           padding-right: 10px;
						   text-align: center;
                    }
					#slabreach{background-color:#ef98aa;}
                </style>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="jquery/jquery.js"></script>
                
                 
    </head>
    <body>
        <div class="BTable">
            <table border="1">
                <thead>
                    <tr>
                       
                       <th colspan="6" class="heading">Nature of the issue : Time taken to fix the issue <span class="customerId">Bank :';print "customer-id-dynamic value"; echo' </span></th> 
                    </tr>
                </thead>
                <tbody class="tdata">
				
                    <tr> 
					
                        <td class="tdata"><span class="titles">CSR#</span> <br>';print "dynamic value";echo '</td>						
                        <td class="tdata"><span class="titles">Title</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">Priority</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">Created date</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">1st action date</span><br>';print "Fill manually";echo'</td>
                        <td class="tdata"><span class="titles">Number of times info requested</span><br>';print "fill manually";echo'</td>
						
                    </tr>
					
                    <tr>
                        <td class="tdata"><span class="titles">Country / Bank</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">Product</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">Current owner</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"></td>
                        <td class="tdata"></td>
                        <td class="tdata"></td>
                    </tr>
                    <tr>
                        <td class="tdata"><span class="titles">Number of fixes given</span><br>';print "Fill manually";echo'</td>
                        <td class="tdata"><span class="titles">Total working hours excluding holidays.</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">1st Escalation</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">Number of reminders from support</span><br>';print "Fill manually";echo'</td>
                        <td class="tdata"><span class="titles">2nd Escalation</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"><span class="titles">Number of reminders from customer</span><br>';print "Fill manually";echo'</td>
                    </tr>
                    <tr>
                        <td class="tdata"></td>
                        <td class="tdata"><span class="titles">Age of ticket as at</span><br>';print "dynamic value";echo'</td>
                        <td class="tdata"></td>
                        <td class="tdata"></td>
                        <td class="tdata"><span class="titles">Remarks / Important notes</span><br>';print "Fill manually";echo'</td>
                        <td class="tdata"></td>
                    </tr>
                   <tr>
                        <td class="tdata"><span class="currState">Current state</span></td>
                        <td class="tdata" id="slabreach">';print "dynamic value";echo'-SLA BREACHED</td>
                        <td class="tdata"></td>
                        <td class="tdata">';print "ddynamic value";echo '-SLA BREACHED</td>
                        <td class="tdata"></td>
                        <td class="tdata"</td>
                    </tr>
                </tbody>
            </table>

            
        </div>
    </body>
</html>

';

?>