<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $this->JSconfig['title'];?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
<div class="m-3">
<?php
if($vt_json_result['response_code'] == 1)
{
	$alert = ($vt_json_result['positives'] == 0) ? 'alert-success' : 'alert-danger';
	echo '<div class="alert '.$alert.' mt-3 mb-3"><strong>'.$vt_json_result['total'].'</strong> scans were performed. The file was detected as a virus in <strong>'.$vt_json_result['positives'].'</strong> engines.<br><br>
		<a href="'.$vt_json_result['permalink'].'" target="_blank" class="btn btn-primary">Open result on VirusTotal</a></div>';
	echo '<table class="table table-striped">';
	echo '<thead><tr><th scope="col">Engine</th><th scope="col" class="text-center">Detected</th><th>Result</th></tr></thead><tbody>';

	foreach($vt_json_result['scans'] as $key => $value) {
		echo '<tr><th scope="row">';
		echo $key;
		if ($value['detected']){
			echo '</th><td class="table-danger text-center">Detected';
		}
		else {
			echo '</th><td class="table-success text-center">Undetected';
		}
		echo '</td><td>';	
		echo $value['result'];
		echo '</td></tr>';
	}


	echo '</tbody><table>';
}
else {
	echo '<div class="alert alert-info mt-3 mb-3">Currently the file is being checked. Please open the menu again in 30 seconds or click the button to see the live results.<br><br>
		<a href="https://www.virustotal.com/gui/file/'.$hash.'" target="_blank" class="btn btn-primary">Open result on VirusTotal</a></div>';
}
?>
</div>
</body>
</html>
