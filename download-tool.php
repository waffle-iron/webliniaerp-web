<?php

if(isset($_GET) && !empty($_GET)) {
	$fields 			= $_GET["fields"];
	$input_file 		= fopen($_GET["input_filename"], "r");
	$output_format 		= $_GET["output_format"];
	$output_filename 	= fopen($_GET["output_filename"], "w");
	$table_name 		= $_GET["table_name"];

	$str_sql = "CREATE TABLE ". $table_name ." (";

	foreach ($fields as $key => $field) {
		$str_sql .= $field['field_name'] ." ". $field['field_type'];
		if($key < (count($fields)-1))
			$str_sql .= ", ";
	}

	$str_sql .= ");\n\n";
	
	fwrite($output_filename, $str_sql);
	// echo $str_sql . "<br/>";

	$count = -1;
	while(!feof($input_file)) {
		$count++;
		$line = fgets($input_file, 4096);
		if(strlen($line) === 0)
			continue;
		if($count > 0) {
			$str_sql = "INSERT INTO ". $table_name ." ( ";

			foreach ($fields as $key => $field) {
				$str_sql .= $field['field_name'];
				if($key < (count($fields)-1))
					$str_sql .= ", ";
			}

			$str_sql .=" ) VALUES ( ";

			$values = split(";", $line);

			foreach ($values as $key => $value) {
				$value = trim($value);
				$value = str_replace("'", "", $value);
				if(isset($fields[$key])) {
					switch ($fields[$key]['field_type']) {
						case 'VARCHAR(255)':
							$new_value = "'";
							$new_value .= $value;
							$new_value .= "'";
							$value = $new_value;
							break;
						case 'INT':
							$value = (int)str_replace(array("R$ ", ",", "."), "", $value);
							break;
						case 'DOUBLE':
							$value = str_replace("R$ ", "", $value);
							$value = (double)str_replace(",", ".", $value);
							$value = number_format($value, 2);
							break;
					}
				}
				
				$str_sql .= $value;
				if($key < (count($values)-1))
					$str_sql .= ", ";
			}
			
			$str_sql .= " );\n";
			
			fwrite($output_filename, $str_sql);
			// echo $str_sql . "<br/>";
		}
		else
			continue;
	}

	fclose($input_file);
	fclose($output_filename);
	die;
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"" . basename($_GET["output_filename"]) . "\"");

	readfile($_GET["output_filename"]);
	unlink($_GET["output_filename"]);
}

?>