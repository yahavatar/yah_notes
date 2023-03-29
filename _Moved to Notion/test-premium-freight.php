<?php
    require_once("../../php_classes/_init.php");
	
	function date_mysql($date_mysql, $id){
		$sql = "
			UPDATE premium_freight
			SET
				date_mysql = :date_mysql
			WHERE id = :id
		";
	$binds = array(":date_mysql" => $date_mysql, ":id" => $id);
	//Log::sql($sql, $binds);
	$pdo = DB::my_s_e($sql, $binds);
	//if ($pdo->error){ $a->ret = $pdo->errorMessage; } else { $a->ret = ""; }
	}

	Log::e_vd($_POST);

	$a = new Application(0);
	if ($a->action){
		switch($a->action){
			case "start":
				$a->ret = "start";
				break;
			case "convert_dates":
				$sql = "
					SELECT
						id,
						date
					FROM premium_freight
				";
				$pdo = DB::my_s_e($sql);
        		$pdo->execute();
				if ($pdo->error){ $a->ret = $pdo->errorMessage; } else { $a->ret = ""; }
				while($row = $pdo->fetch( PDO::FETCH_ASSOC )){
					$date = $row["date"];
					$date_mysql = Date::std_to_mysql($date);
					$id = $row["id"];
					Log::e($date . " = mysql_date: " . $date_mysql);
					date_mysql($date_mysql, $id);
				}
				break;
			case "browse_data":
				Log::e("browse_data:");
				Log::e_vd($_POST);
				if ($_POST["date_beg"] == "" || $_POST["date_end"] == ""){
					$limit = "ORDER BY date_mysql DESC LIMIT 100";
					$binds = array();
				} else {
					$_POST["date_beg"] = Date::webix_full_to_mysql($_POST["date_beg"]);
					$_POST["date_end"] = Date::webix_full_to_mysql($_POST["date_end"]);
					$limit = "WHERE date_mysql >= :date_beg AND date_mysql <= :date_end";
					$binds = array(":date_beg"=>$_POST["date_beg"], ":date_end"=>$_POST["date_end"]);
					if ($_POST["job_number"] != ""){ 
						$_POST["job_number"] = "%".$_POST["job_number"]."%"; 
						$limit .= " AND job_number LIKE :job_number"; 
						$binds[":job_number"] = $_POST["job_number"]; }
					if ($_POST["operation"] != ""){ 
						$_POST["operation"] = "%".$_POST["operation"]."%"; 
						$limit .= " AND operation LIKE :operation"; 
						$binds[":operation"] = $_POST["operation"]; }
					if ($_POST["ship_from"] != ""){ 
						$_POST["ship_from"] = "%".$_POST["ship_from"]."%"; 
						$limit .= " AND ship_from LIKE :ship_from"; 
						$binds[":ship_from"] = $_POST["ship_from"]; }
					if ($_POST["ship_to"] != ""){ 
						$_POST["ship_to"] = "%".$_POST["ship_to"]."%"; 
						$limit .= " AND ship_to LIKE :ship_to"; 
						$binds[":ship_to"] = $_POST["ship_to"]; }
					if ($_POST["ship_via"] != ""){ 
						$_POST["ship_via"] = "%".$_POST["ship_via"]."%"; 
						$limit .= " AND ship_via LIKE :ship_via"; 
						$binds[":ship_via"] = $_POST["ship_via"]; }
					if ($_POST["authorized_by"] != ""){ 
						$_POST["authorized_by"] = "%".$_POST["authorized_by"]."%";
						$limit .= " AND authorized_by LIKE :authorized_by"; 
						$binds[":authorized_by"] = $_POST["authorized_by"]; }
					if ($_POST["reason_code"] != ""){ 
						$_POST["reason_code"] = "%".$_POST["reason_code"]."%";
						$limit .= " AND reason_code LIKE :reason_code"; 
						$binds[":reason_code"] = $_POST["reason_code"]; }
					if ($_POST["note_1"] != ""){ 
						$_POST["note_1"] = "%".$_POST["note_1"]."%";
						$limit .= " AND note_1 LIKE :note_1"; 
						$binds[":note_1"] = $_POST["note_1"]; }
					if ($_POST["note_2"] != ""){ 
						$_POST["note_2"] = "%".$_POST["note_2"]."%";
						$limit .= " AND note_2 LIKE :note_2"; 
						$binds[":note_2"] = $_POST["note_2"]; }
				}
				Log::e_vd($binds);
				$sql = "
					SELECT
						id,
						date,
						job_number,
						operation,
						ship_from,
						ship_to,
						ship_via,
						cost,
						authorized_by,
						reason_code,
						note_1,
						note_2,
						date_mysql
					FROM premium_freight
					$limit
				";
				Log::sql($sql, $binds);
				$a->ret = DB::my_json_s($sql, $binds);
				break;
			case "job_number_report":
				Log::e("job_number_report:");
				Log::e_vd($_POST);
				if ($_POST["date_beg"] == "" || $_POST["date_end"] == ""){
					$limit = "ORDER BY date_mysql DESC LIMIT 100";
					$binds = array();
				} else {
					$_POST["date_beg"] = Date::webix_full_to_mysql($_POST["date_beg"]);
					$_POST["date_end"] = Date::webix_full_to_mysql($_POST["date_end"]);
					$limit = "WHERE date_mysql >= :date_beg AND date_mysql <= :date_end";
					$binds = array(":date_beg"=>$_POST["date_beg"], ":date_end"=>$_POST["date_end"]);
					if ($_POST["job_number"] != ""){ 
						$_POST["job_number"] = "%".$_POST["job_number"]."%"; 
						$limit .= " AND job_number LIKE :job_number"; 
						$binds[":job_number"] = $_POST["job_number"]; }
					if ($_POST["operation"] != ""){ 
						$_POST["operation"] = "%".$_POST["operation"]."%"; 
						$limit .= " AND operation LIKE :operation"; 
						$binds[":operation"] = $_POST["operation"]; }
					if ($_POST["ship_from"] != ""){ 
						$_POST["ship_from"] = "%".$_POST["ship_from"]."%"; 
						$limit .= " AND ship_from LIKE :ship_from"; 
						$binds[":ship_from"] = $_POST["ship_from"]; }
					if ($_POST["ship_to"] != ""){ 
						$_POST["ship_to"] = "%".$_POST["ship_to"]."%"; 
						$limit .= " AND ship_to LIKE :ship_to"; 
						$binds[":ship_to"] = $_POST["ship_to"]; }
					if ($_POST["ship_via"] != ""){ 
						$_POST["ship_via"] = "%".$_POST["ship_via"]."%"; 
						$limit .= " AND ship_via LIKE :ship_via"; 
						$binds[":ship_via"] = $_POST["ship_via"]; }
					if ($_POST["authorized_by"] != ""){ 
						$_POST["authorized_by"] = "%".$_POST["authorized_by"]."%";
						$limit .= " AND authorized_by LIKE :authorized_by"; 
						$binds[":authorized_by"] = $_POST["authorized_by"]; }
					if ($_POST["reason_code"] != ""){ 
						$_POST["reason_code"] = "%".$_POST["reason_code"]."%";
						$limit .= " AND reason_code LIKE :reason_code"; 
						$binds[":reason_code"] = $_POST["reason_code"]; }
					if ($_POST["note_1"] != ""){ 
						$_POST["note_1"] = "%".$_POST["note_1"]."%";
						$limit .= " AND note_1 LIKE :note_1"; 
						$binds[":note_1"] = $_POST["note_1"]; }
					if ($_POST["note_2"] != ""){ 
						$_POST["note_2"] = "%".$_POST["note_2"]."%";
						$limit .= " AND note_2 LIKE :note_2"; 
						$binds[":note_2"] = $_POST["note_2"]; }
				}
				Log::e_vd($binds);
				$sql = "
					SELECT
						id,
						date,
						job_number,
						operation,
						ship_from,
						ship_to,
						ship_via,
						cost,
						authorized_by,
						reason_code,
						note_1,
						note_2,
						date_mysql
					FROM premium_freight
					$limit
				";
				Log::sql($sql, $binds);
				$a->ret = DB::my_json_s($sql, $binds);
				break;
			case "reason_code_add_save":
					$sql = "
						INSERT INTO premium_freight_reason_code (
							reason_code,
							reason,
							btd_caused
						)
						VALUES(
							:reason_code,
							:reason,
							:btd_caused
						)
					";
				$binds = array(":reason_code"=>$_POST["reason_code"], ":reason"=>$_POST["reason"], ":btd_caused"=>$_POST["btd_caused"]);
				Log::sql($sql, $binds);
				$pdo = DB::my_s_e($sql, $binds);
				if ($pdo->error){ $a->ret = $pdo->errorMessage; } else { $a->ret = ""; }
				break;	
			case "reason_code_edit":
				$id = $_POST["id"];
				$sql = "
					SELECT
						id,
						CASE WHEN reason_code IS NULL THEN '' ELSE reason_code  END AS reason_code,
						CASE WHEN reason  IS NULL THEN '' ELSE reason END AS reason,
						CASE WHEN btd_caused IS NULL THEN '' ELSE btd_caused END AS btd_caused
					FROM premium_freight_reason_code
					WHERE id = :id
				";
				$binds = array(":id" => $_POST["id"]);
        		$a->ret = DB::my_json_s($sql, $binds);
				break;
			case "reason_code_edit_save":
				Log::e_vd($_POST);
				Log::e("reason_code_edit_save: " . $_POST["id"] . " " . $_POST["reason_code"] . " " . $_POST["reason"] . " " . $_POST["btd_caused"]);
				$sql = "
					UPDATE premium_freight_reason_code
					SET
						reason_code = :reason_code,
						reason = :reason,
						btd_caused = :btd_caused
					WHERE id = :id
				";
				$binds = array(":reason_code" => $_POST["reason_code"], ":reason" => $_POST["reason"], ":btd_caused" => $_POST["btd_caused"], ":id" => $_POST["id"]);
				Log::sql($sql, $binds);
			    $pdo = DB::my_s_e($sql, $binds);
	            if ($pdo->error){ $a->ret = $pdo->errorMessage; } else { $a->ret = ""; }
				break;
			case "reason_codes_get":
				$sql = "
					SELECT
						id,
						reason_code,
						reason,
						btd_caused
					FROM premium_freight_reason_code
					ORDER BY
						reason_code
				";
				$a->ret = DB::my_json_s($sql);
				break;
		}
		echo $a->ret;
		exit();
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
		<script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>-->

		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&amp;display=swap" rel="stylesheet">

		<!--<link rel="stylesheet" href="https://cdn.webix.com/edge/webix.css" type="text/css">
		<script src="https://cdn.webix.com/edge/webix.js" type="text/javascript"></script>-->
		<style>
			/* These styles are to override the default styles of the webix datatable */
			.dt_style_1 .webix_hcell{
				background-color: rgb(59, 130, 246);
				border-bottom: 1px solid #EDEFF0 !important;
				border-right: 1px solid #EDEFF0 !important;
				color: white;
			}
			.dt_style_1 .webix_cell{
				border-right: 1px solid #EDEFF0 !important;
				font-size: 12px;
			}
			.webix_popup_style_1{
				border-radius: 10px !important;
			}
			.webix_column > div.webix_cell_select, .webix_column > div.webix_column_select, .webix_column > div.webix_row_select {
  				background:transparent;
  				color:#white;
  			}
			/* Webix Datepicker styles ===================*/
			.webix_inp_label{
				color: rgb(30 64 175) !important;
			}
			.webix_inp_static{
				border-radius: 5px !important;
			}
			/* Webix Input styles ======================= */
			.webix_el_box input{
				border-radius: 5px !important;
				color: rgb(30 64 175) !important;
			}

		</style>
	</head>

	<body style="display:none; font-family:Roboto,sans-serif;">
		<div class="flex flex-row w-full">
			<div class="mx-4" style="width:270px; min-width:240px;">
				<div class="flex flex-col">
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1 " onclick="reason_codes_get()">
						Reason Codes
					</button>
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1" onclick="browse_data()">
						Browse Data
					</button>
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1" onclick="job_number_report()">
						Job# Report
					</button>
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1" onclick="reason_report()">
						Reason Report
					</button>
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1" onclick="job_summary_report()">
						Job# Summary Report
					</button>
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1" onclick="reason_summary_report()">
						Reason Summary Report
					</button>
					<!--<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1" onclick="convert_dates()">
						Convert Dates
					</button>-->
					<!--<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1" onclick="popup_test()">
						Popup Test
					</button>-->
					<div id='div_search_fields' class="mt-6 w-full"></div>
					<div id='div_buttons' class="mt-6 w-full"></div>
				</div>
			</div>
			<div id='div_datatable' class="mt-2"></div>
		</div>
	</body>

	<script type="text/javascript" src='../js_classes/_init.js'></script>
	<script type="text/javascript"> btd.libs_load(["jquery","webix","tailwind"]); </script>
	<script type="text/javascript">
		window.onload = function() {
			btd.webpage.set({header:"Premium Freight", title:"Premium Freight", no_back: true});
			$("body").show();
			btd.webix.test();
		}

		function job_number_report(){
			let date_beg = $("#date_beg").val();
			let date_end = $("#date_end").val();
			if (date_end == undefined){ date_end = ""; }
			if (date_beg == undefined){ date_beg = ""; }
			l("date_beg: " + date_beg + ", date_end: " + date_end)
			$.post( document.URL, { action: "job_number_report", date_beg:"", date_end:""}, function(json){
				$("#div_main").html("");
				btd.log(json);
				btd.webix.ui.datatable({
					id:"datatable",
					css: "dt_style_1",
					data: json,
					click: function(id, e, node){ reason_code_edit(id, e, node)},
					columns: [
						{ id:"id",			      adjust:"all",	header:[{text:"Premium Freight Entries", colspan:12, css:{"font-size":"20px","text-align":"center", "font-weight":"bolder"} }, "Id"], hidden:true },
						{ id:"date", 		      adjust:"all",	header:["","Date"], sort:"string" },
						{ id:"job_number",        adjust:"all",	header:["","Job#"], sort:"string" },
						{ id:"operation",	      adjust:"all",	header:["","Operation"], sort:"string" },
						{ id:"ship_from",         adjust:"all",	header:["","Ship From"], sort:"string" },
						{ id:"ship_to",		      adjust:"all",	header:["","Ship To"], sort:"string" },
						{ id:"ship_via",	      adjust:"all",	header:["","Ship Via"], sort:"string" },
						{ id:"cost",		      adjust:"all",	header:["","Cost"], sort:"string" },
						{ id:"authorized_by",     adjust:"all",	header:["","Authorized By"], sort:"string" },
						{ id:"reason_code",       adjust:"all",	header:["","Reason Code"], sort:"string" },
						{ id:"note_1",		      adjust:"all",	header:["","Note 1"], sort:"string" },
						{ id:"note_2",		      adjust:"all",	header:["","Note 2"], sort:"string" },
					],
				});
				browse_data_search_fields_setup();
			});
		}

		function browse_data(){
			let date_beg = $("#date_beg").val();
			let date_end = $("#date_end").val();
			if (date_end == undefined){ date_end = ""; }
			if (date_beg == undefined){ date_beg = ""; }
			l("date_beg: " + date_beg + ", date_end: " + date_end)
			$.post( document.URL, { action: "browse_data", date_beg:"", date_end:""}, function(json){
				$("#div_main").html("");
				btd.log(json);
				btd.webix.ui.datatable({
					id:"datatable",
					css: "dt_style_1",
					data: json,
					click: function(id, e, node){ reason_code_edit(id, e, node)},
					columns: [
						{ id:"id",			      adjust:"all",	header:[{text:"Premium Freight Entries", colspan:12, css:{"font-size":"20px","text-align":"center", "font-weight":"bolder"} }, "Id"], hidden:true },
						{ id:"date", 		      adjust:"all",	header:["","Date"], sort:"string" },
						{ id:"job_number",        adjust:"all",	header:["","Job#"], sort:"string" },
						{ id:"operation",	      adjust:"all",	header:["","Operation"], sort:"string" },
						{ id:"ship_from",         adjust:"all",	header:["","Ship From"], sort:"string" },
						{ id:"ship_to",		      adjust:"all",	header:["","Ship To"], sort:"string" },
						{ id:"ship_via",	      adjust:"all",	header:["","Ship Via"], sort:"string" },
						{ id:"cost",		      adjust:"all",	header:["","Cost"], sort:"string" },
						{ id:"authorized_by",     adjust:"all",	header:["","Authorized By"], sort:"string" },
						{ id:"reason_code",       adjust:"all",	header:["","Reason Code"], sort:"string" },
						{ id:"note_1",		      adjust:"all",	header:["","Note 1"], sort:"string" },
						{ id:"note_2",		      adjust:"all",	header:["","Note 2"], sort:"string" },
					],
				});
				browse_data_search_fields_setup();
			});
		}
		function browse_data_search_fields_setup(){
			console.log("search_fields_setup()");
			$("#div_buttons").html(`
				<div class='w-full justify-center text-center font-bold'>
					<button onclick="browse_data_add()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-1">
						Add
					</button>
					<button onclick="browse_data_search()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-1">
						Search
					</button>
				</div>
			`);
			if ($("#div_search_fields").html() != ""){
				$("#div_search_fields").show();
				return;
			}
			$("#div_search_fields").show();
			$("#div_search_fields").html(`
				<div class='flex flex-col'>
					<div class='w-full text-center font-bold'>
						<label class="text-sm text-blue-800">Search Fields:</label><br>
					</div>
					<div>
						<div id='div_search_date_beg' class='w-full'></div>
					</div>
					<div>
						<div id='div_search_date_end' class='w-full'></div>
					</div>
					<div class='flex flex-row'>
						<div class='w-full'>
							<div id='div_search_job_number'></div>
						</div>
						<div class='w-full'>
							<div id='div_search_operation'></div>
						</div>
					</div>
					<div class='flex flex-row'>
						<div class='w-full'>
							<div id='div_search_ship_to'></div>
						</div>
						<div class='w-full'>
							<div id='div_search_ship_from'></div>
						</div>
						<div class='w-full'>
							<div id='div_search_ship_via' class='text-sm'></div>
						</div>
					</div>
					<div class='flex flex-row'>
						<div class='w-full'>
							<div id='div_search_authorized_by' class='w-full'></div>
						</div>
						<div class='w-full'>
							<div id='div_search_reason_code' class='w-full'></div>
						</div>
					</div>
					<div class='flex flex-row'>
						<div class='w-full'>
							<div id='div_search_note_1' class='w-full'></div>
						</div>
						<div class='w-full'>
							<div id='div_search_note_2' class='w-full'></div>
						</div>
					</div>
				</div>
			`);

			btd.webix.ui.datepicker({id:"search_date_beg", l: "Begin Date", lw:90, w:240});
			btd.webix.ui.datepicker({id:"search_date_end", l: "End Date", lw:90, w:240});

			btd.webix.ui.text({id:"search_job_number", ph: "Job#",      w:120});
			btd.webix.ui.text({id:"search_operation",  ph: "Operation", w:120});

			btd.webix.ui.text({id:"search_ship_to",    ph: "Ship To",   w:80});
			btd.webix.ui.text({id:"search_ship_from",  ph: "Ship From", w:80});
			btd.webix.ui.text({id:"search_ship_via",   ph: "Ship Via",  w:80});
			
			btd.webix.ui.text({id:"search_authorized_by",   ph: "Authorized By",  w:120});
			btd.webix.ui.text({id:"search_reason_code",     ph: "Reason Code",    w:120});

			btd.webix.ui.text({id:"search_note_1",     ph: "Note 1",    w:120});
			btd.webix.ui.text({id:"search_note_2",     ph: "Note 2",    w:120});
		}
		function browse_data_search(){
			console.log("reason_code_add()");
			let date_beg = $$("search_date_beg").getValues().val;
			let date_end = $$("search_date_end").getValues().val;
			let job_number = $$("search_job_number").getValues().val;
			let operation = $$("search_operation").getValues().val;
			let ship_to = $$("search_ship_to").getValues().val;
			let ship_from = $$("search_ship_from").getValues().val;
			let ship_via = $$("search_ship_via").getValues().val;
			let authorized_by = $$("search_authorized_by").getValues().val;
			let reason_code = $$("search_reason_code").getValues().val;
			let note_1 = $$("search_note_1").getValues().val;
			let note_2 = $$("search_note_2").getValues().val;
			let data = {
				action: "browse_data",
				date_beg: date_beg,
				date_end: date_end,
				job_number: job_number,
				operation: operation,
				ship_to: ship_to,
				ship_from: ship_from,
				ship_via: ship_via,
				authorized_by: authorized_by,
				reason_code: reason_code,
				note_1: note_1,
				note_2: note_2,
			};
			l(data);
			$.post( document.URL, data, function(json){
				//btd.log(json);
				let dt = $$("dt");
				dt.clearAll();
				dt.parse(json);
			});
		}
		function convert_dates(){
			$.post( document.URL, { action: "convert_dates" }, function(ret){
			    console.log("ret: " + ret)
			});
		}
		function l(s){ console.log(s); }
		
		
		/* ===================== Reason Codes ===================== */ 
		function reason_codes_get(){
			$("#div_search_fields").hide();
			$.post( document.URL, { action: "reason_codes_get" }, function(json){
				//btd.log(json);
				btd.webix.ui.datatable({
					id:"datatable",
					css: "dt_style_1",
					data: json,
					click: function(id, e, node){ reason_code_edit(id, e, node)},
					columns: [
						{ id:"id",			adjust:"all",	header:[{text:"Reason Codes", colspan:4, css:{"font-size":"20px","text-align":"center", "font-weight":"bolder"} }, "Id"], hidden:true },
						{ id:"reason_code", adjust:"all",	header:["","Reason Code"], sort:"string", editor:"text" },
						{ id:"reason",		adjust:"all",	header:["","Reason"], sort:"string", editor:"text" },
						{ id:"btd_caused",	adjust:"all",	header:["","BTD Caused"], sort:"string", editor:"text" },
					],
				});
				$(".webix_ss_body").attr("title", "Double click to edit");
				$("#div_buttons").html(`
					<div class='w-full justify-center text-center font-bold'>
						<button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-1" onclick="reason_code_add()">
							Add
						</button>
					</div>
				`);
			});
		}
		function reason_code_add(){
			let json = {id: 0, reason_code: "", reason: "", btd_caused: "", title:"Add Reason Code", form:"reason_code_add_save"};
			let html = template_reason_code_add_edit(json);
			btd.webix.popup_simple({ html:html, title:json.title});
		}
		function reason_code_add_save(form){
			console.log("reason_code_add_save()");
			let obj = btd.html.form_inputs(form);
			obj.action = "reason_code_add_save";
			if (obj.reason_code.isBlank()){ alert("Reason Code is required"); return; }
			if (obj.reason.isBlank()){      alert("Reason is required"); return; }
			if (obj.btd_caused.isBlank()){  alert("BTD Caused is required"); return; }
			if (obj.btd_caused.notYN()){    alert("BTD Caused must be Y or N"); return; }
			$.post( document.URL, obj, function(ret){
				$$("webix_popup_simple").destructor();
				reason_codes_get();
			});
		}
		function reason_code_edit(id, e, node){
			console.log("Getting reason info for id: " + id.row);
			$.post( document.URL, { action: "reason_code_edit", id: id.row }, function(json){
				json = JSON.parse(json)[0];
				json.title = "Edit Reason Code";
				json.form = "reason_code_edit_save";
				let html = template_reason_code_add_edit(json);
				btd.webix.popup_simple({ html:html, title:json.title});
			});
		}
		function reason_code_edit_save(form){
			console.log("reason_code_edit_save()");
			let obj = btd.html.form_inputs(form);
			obj.action = "reason_code_edit_save";
			if (obj.reason_code.isBlank()){ alert("Reason Code is required"); return; }
			if (obj.reason.isBlank()){      alert("Reason is required"); return; }
			if (obj.btd_caused.isBlank()){  alert("BTD Caused is required"); return; }
			if (obj.btd_caused.notYN()){    alert("BTD Caused must be Y or N"); return; }
			$.post( document.URL, btd.html.form_inputs(form), function(ret){
				$$("webix_popup_simple").destructor();
				reason_codes_get();
			});
		}

		/* ================================================ Templates ================================================ */
		function template_reason_code_add_edit(json){
			return `
				<form name="form_${json.form}" action="#" onsubmit="${json.form}(this)" class='mx-4'>
					<div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3">
							<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reason_code">Reason Code</label>
						</div>
						<div class="md:w-2/3">
							<input id='reason_code' class="bg-white appearance-none border-2 border-gray-200 rounded-md w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" value="${json.reason_code}">
						</div>
					</div><div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3">
							<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reason">Reason</label>
						</div>
						<div class="md:w-2/3">
							<input id='reason' class="bg-white appearance-none border-2 border-gray-200 rounded-md w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" value="${json.reason}">
						</div>
					</div><div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3">
							<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="btd_caused">BTD Caused</label>
						</div>
						<div class="md:w-2/3">
							<input id='btd_caused' class="bg-white appearance-none border-2 border-gray-200 rounded-md w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" value="${json.btd_caused}">
						</div>
					</div>
					<div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3"></div>
						<div class="md:w-2/3">
							<button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
								Save Changes
							</button>
						</div>
					</div>
					<input id='id' type=text value="${json.id}" class="hidden"></div>
				</form>
			`;
		}
		function template_premium_freight_add_edit(json){
			return `
				<form name="form_${json.form}" action="#" onsubmit="${json.form}(this)" class='mx-4'>
					<div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3">
							<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="date">Date</label>
						</div>
						<div class="md:w-2/3">
							<div id='date' class='w-full'></div>
							<!--<input id='reason_code' class="bg-white appearance-none border-2 border-gray-200 rounded-md w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" value="${json.reason_code}">-->
						</div>
					</div><div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3">
							<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reason">Reason</label>
						</div>
						<div class="md:w-2/3">
							<input id='reason' class="bg-white appearance-none border-2 border-gray-200 rounded-md w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" value="${json.reason}">
						</div>
					</div><div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3">
							<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="btd_caused">BTD Caused</label>
						</div>
						<div class="md:w-2/3">
							<input id='btd_caused' class="bg-white appearance-none border-2 border-gray-200 rounded-md w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" value="${json.btd_caused}">
						</div>
					</div>
					<div class="md:flex md:items-center mb-6">
						<div class="md:w-1/3"></div>
						<div class="md:w-2/3">
							<button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
								Save Changes
							</button>
						</div>
					</div>
					<input id='id' type=text value="${json.id}" class="hidden"></div>
				</form>
			`;

		}
		

	</script>
</html>