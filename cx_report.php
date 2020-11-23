<?php

$mysql_host='192.168.1.25';
$mysql_user='priyadarshana';
$mysql_pw='priy@7otrc';
$conn_err='Could not connect';
$mysql_db='otrs';
$cx_err="Error: You have to select at least one customer";
$no_rec="Sorry! No records found :(";


if(!@mysql_connect($mysql_host,$mysql_user,$mysql_pw) || !@mysql_select_db($mysql_db)) 
{
	die(mysql_error());
}

echo '<link rel="stylesheet" type="text/css" href="css/table_style.css"/> 

<table border="0" cellpadding="1" cellspacing="1" style="width: 80%;">
	<tbody>
		<tr>
			<td align="center"><b>Interblocks Customer Services</b></td>
		</tr>
		<tr>
			<td align="center">Monthly CSR Analysis</td>
		</tr>
		<tr>
			<td bgcolor="7A6E65">&nbsp;</td>
		</tr>
		<tr>
			<td >&nbsp;</td>
		</tr>
	</tbody>
</table>
<table border="1" cellpadding="1" cellspacing="1" style="width: 30%;">
	<tbody>
		<tr>
			<td>Customer</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Customer Code</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Reporting Period</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Reporting Date</td>
			<td>&nbsp;</td>
		</tr>
	
	</tbody>
</table>
<br/>
<p>CSR Summary</p>

<table border="1" cellpadding="1" cellspacing="1" height="128" style="width: 80%" >
	<tbody>
		<tr>
			<td bgcolor="211CA1" align="center" class="csr" >&nbsp;</td>
			<td bgcolor="211CA1" align="center" class="csr"><b>Critical</b></td>
			<td bgcolor="211CA1" align="center" class="csr"><b>High</b></td>
			<td bgcolor="211CA1" align="center" class="csr"><b>Medium</b></td>
			<td bgcolor="211CA1" align="center" class="csr"><b>Low</b></td>
			<td bgcolor="211CA1" align="center" class="csr"><b>Total</b></td>
			<td bgcolor="211CA1" align="center" class="csr"><b>%</b></td>
		</tr>
		<tr>
			<td>BF</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Reported</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Resolved</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>CF</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<br/>
<table style="width: 80%">
<tr>
			<td bgcolor="7A6E65">&nbsp;</td>
		</tr>
</table>
<br/>

<table border="1" cellpadding="1" cellspacing="1" style="width:30%;">
	<tbody>
		<tr>
			<td bgcolor="211CA1" colspan="2"  class="status">By Status</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<br/>
<table border="1" cellpadding="1" cellspacing="1" style="width:20%;">
	<tbody>
		<tr>
			<td bgcolor="211CA1" colspan="2" class="status">By SLA</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
<br/>

<table style="width: 80%">
<tr>
			<td bgcolor="7A6E65">&nbsp;</td>
		</tr>
</table>

<p>CSR Details</p>
<table border="1" cellpadding="1" cellspacing="1" style="width: 80%;">
	<tbody>
		<tr>
			<td class="csrdetails">CSR#</td>
			<td class="csrdetails">Created</td>
			<td class="csrdetails">Close Time</td>
			<td class="csrdetails">State</td>
			<td class="csrdetails">Priority</td>
			<td class="csrdetails" >Service</td>
			<td class="csrdetails">Title</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>

<p>Product wise</p>
<table border="1" cellpadding="1" cellspacing="1" style="width: 30%">
	<tbody>
		<tr>
			<td class="product">Product wise</td>
			<td class="product">Count</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>';


?>