
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!--script type="text/javascript">
$(document).ready(function(){
	var  nos=0;
  var found="";
  nos=$('#mytable').find('input[type="checkbox"]:checked').length;
  	
    $('#mytable').find('tr').each(function () { 
    do{  
var row = $(this);
if (row.find('input[type="checkbox"]').is(':checked') ) {
	var checkBox = document.getElementById("ch"+nos).value;
	//checkBox="Dfs";
    //found=found+checkBox;
    //alert(found);
     document.getElementById("txt"+nos).value=checkBox+",1";
}
nos--;
} while(nos>1);
});  
});




</script-->
</head>
<body>
	<table id="mytable">
		<?php
		$i=1;
		while($i<10){?>		
		<tr>
			<td><input type="checkbox" name="chk[]" id="ch<?php echo $i;?>" checked value="<?php echo $i;?>"></td>
			<td><input type="text" name="txt[]" id="txt<?php echo $i;?>" value="<?php echo $i;?>"></td>
		</tr>
	<?php $i++;}?>
	</table>
	<input type="text" id="mid" name="m_ids">
	<input type="button" id="button" name="button">
	<script type="text/javascript">
		var mids="";
		 $('input[type=checkbox]').click(function () {
	if($(this).prop("checked") == false){
		mids+=($(this).attr("value"))+",";
	}

	document.getElementById("mid").value=mids;


	});
	</script>
</body>
</html>

