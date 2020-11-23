<html lang="en"><head>
	<meta charset="UTF-8">
	<title>Agent Wise</title>
	<link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="\icaredashboard/libraries/cloudflare/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="\icaredashboard/css/agent_wise.css">
	<link rel="stylesheet" href="\icaredashboard\ums/css/main.css">
	<link href="\icaredashboard/css/all.css" rel="stylesheet">
	<link href="\icaredashboard/css/solid.css" rel="stylesheet">
	<link href="\icaredashboard/css/regular.css" rel="stylesheet">
	<link href="\icaredashboard/css/brands.css" rel="stylesheet">
	<link href="\icaredashboard/css/fontawesome.css" rel="stylesheet">
	
	<script src="\icaredashboard/js/jquery.aCollapTable.js"></script>
	<style> 
		#loader { 
			border: 12px solid #f3f3f3; 
			border-radius: 50%; 
			border-top: 12px solid #444444; 
			width: 70px; 
			height: 70px; 
			animation: spin 1s linear infinite; 
		} 
		
		@keyframes spin { 
			100% { 
				transform: rotate(360deg); 
			} 
		} 
		
		.center { 
			position: relative; 
			top: 0; 
			bottom: 0; 
			left: 0; 
			right: 0; 
			margin: auto; 
		} 
	</style> 
</head>
<body style="visibility: visible;"><header>
	<div class="appname">iCare Dashboard</div>
	<div class="loggedin">Welcome Priyadarshana! <a href="ums/logout.php">Log Out</a></div>
</header>


	<script type="text/javascript">
		$(document).ready(function() {

			$('.collaptable').aCollapTable({

				// the table is collapased at start
				startCollapsed: true,

				// the plus/minus button will be added like a column
				addColumn: true,

				// The expand button ("plus" +)
				plusButton: '<span class="i"> <img class="arrow" src="img/right-arrow.png"></span>',

				// The collapse button ("minus" -)
				minusButton: '<span class="i"><img class="arrow" src="img/down-arrow.png"></i></span>'

			});
		});
	</script>

	<div id="container" class="container">
		<div class="card">
			<div class="card-header btn btn-danger">
				<span>CSR count breakdown agent wise in terms of banks assigned</span>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-10">
						<div id="loader" class="center" style="visibility: visible; display: none;"></div>
						<div class="input-group date">
							<form action="agent_wise.php?mid=20" method="POST">
								<input type="date" id="cutoff_date" name="cutoff_date" value="2020-06-04">
								<input type="submit" id="submit" name="submit" value="GO" class="btn btn-warning submit">
							</form>
						</div>
						<table class="collaptable table" id="table1">
							<thead>
								<tr class="act-tr-level-undefined main-heading"><td>&nbsp;&nbsp;</td>
									<th></th>
									<th>Agent Name</th>
									<th>IBL Pending</th>
									<th>Info Pending</th>
									<th>Exp Given</th>
									<th>Fix Given</th>
								</tr>
							</thead>
							<tbody><tr class="Priyadarshana act-tr-level-0 act-tr-expanded" data-id="1" data-parent="" data-level="0"><td><a href="javascript:void(0)" class="act-more act-expanded"><span class="i">-</span></a></td>
										<td></td>
										<td>Priyadarshana</td>
										<td>5</td>
										<td>6</td>
										<td>8</td>
										<td>12</td>
									</tr><tr class="customer act-tr-level-1 act-tr-expanded" data-id="100" data-parent="1" data-level="1" style="display: table-row;"><td><a href="javascript:void(0)" class="act-more act-expanded">&nbsp;&nbsp;<span class="i">-</span></a></td>
											<td></td>
											<td class="agent">LKA-UNI</td>
											<td>5</td>
											<td>6</td>
											<td>7</td>
											<td>9</td>
										</tr><tr class="support act-tr-level-2 act-tr-expanded" data-id="1000" data-parent="100" data-level="2" style="display: table-row;"><td><a href="javascript:void(0)" class="act-more act-expanded">&nbsp;&nbsp;&nbsp;&nbsp;<span class="i">-</span></a></td>
												
												<td class="agent">Support</td>
												<td>2 &nbsp;&nbsp;&nbsp;&nbsp;1</td>
												<td>4</td>
												<td>7</td>
												<td>9</td>
											</tr>
											<tr data-parent="1000" class="sup-ticket sup-heading act-tr-level-undefined" style="display: table-row;"><td>&nbsp;&nbsp;</td><th>#</th><th>CSR #</th><th>State</th><th>Create Date</th><th>Owner</th><th>Responsible</th></tr><tr class="sup-ticket act-tr-level-3" data-id="10000" data-parent="1000" data-level="3" style="display: table-row;"><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
													<td style="width:1%">1</td>
													<td style="width:15%" class="agent"><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=151517" target="_blank">100155557</a></td>
													<td style="width:15%">Assigned</td>
													<td style="width:15%">2019-03-08</td>
													<td style="width:15%">MWB</td>
													<td style="width:15%">Samira</td>
												</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>