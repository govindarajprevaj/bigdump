<?php
$xml = simplexml_load_file("db.xml") or die("Error: Cannot create object");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#dbform input").change(function(){
		select_table_change();
    });
	select_table_change();
	function select_table_change()
	{
		var datastring = $("#dbform").serialize();
       $.ajax({
			type: "POST",
			url: "dbajax.php",
			data: datastring,
			dataType: "json",
			 beforeSend: function() {
				$('#dbname').attr("disabled","disabled");
			},
			success: function(data) {
				if(data.status)
				{
					var database = data.db;
					database.forEach(function(entity){
						$('#dbname').removeAttr("disabled");
						$('#dbname').append($('<option>', { 
							value: entity,
							text : entity 
						}));
					});
				}
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
});
</script>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css" />
<div class="container">
<h1 class="h1">Upload file to Datbase</h1>
	<form id="dbform" action="/bigdump/bigdump.php" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="dbhost">DB host : </label>
					<input type="text" id="dbhost" class="form-control input-lg" value = "<?php echo $xml->dbhost; ?>" name = "dbhost" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="dbuser">DB user name : </label>
					<input type="text" id="dbuser" class="form-control input-lg" value = "<?php echo $xml->dbuser; ?>" name = "dbuser" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="dbpass">DB password : </label>
					<input type="text" id="dbpass" class="form-control input-lg" value = "<?php echo $xml->dbpass; ?>" name = "dbpass" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="dbname">DB table : </label>
					<select id="dbname" class="form-control input-lg" disabled><option value="">select option ..</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<label for="dbname">Select sql file :</label>
				<div class="form-group">
					<label class="btn btn-default  btn-file">
						Choose file to import <input type="file" size="60" name="dumpfile" class="hidden">
					</label>
				</div>
				<button type = "submit" name="uploadbutton" value="Upload" class = "btn btn-primary">Submit</button>
				<button type = "reset" class = "btn btn-danger">Clear</button>
			</div>
		</div>
	</form>
</div>
