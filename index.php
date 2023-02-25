<?php
	if(!($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['name'])))
    {
        
    }
	else{
		
		$txt="imenik.txt";
		$json = fopen("imenik.json", "a");
		$txtimenik=file_get_contents($txt);
		$nizimenik=explode("\n",$txtimenik);
		$i=0;
		$n=count($nizimenik);
		

		file_put_contents("imenik.json", "");
		fwrite($json, '[');
		foreach($nizimenik as $stavka){
			$stavka=rtrim($stavka);
			$podaci=explode("|",$stavka);
			$x = 0;
			foreach($podaci as $podatak){
				
				switch($x){
					case 0:{
						$dodTxt=' {"id":" '.$podatak.' ", ';
						fwrite($json, $dodTxt);
						break;
					}
					case 1:{
						$dodTxt=' "ime":" '.$podatak.' ",';
						fwrite($json, $dodTxt);
						break;
					}
					case 2:{
						$dodTxt=' "prezime":" '.$podatak.' ",';
						fwrite($json, $dodTxt);
						break;
					}
					case 3:{
						$dodTxt=' "adresa":" '.$podatak.' ", ';
						fwrite($json, $dodTxt);
						break;
					}
					case 4:{
						$dodTxt=' "mesto":" '.$podatak.' ",';
						fwrite($json, $dodTxt);
						break;
					}
					case 5:{
						if($i==($n-1)){
							$dodTxt=' "telefon": '.$podatak.' }]';
						}
						else{
							$dodTxt=' "telefon": '.$podatak.' },';
						}
						
						fwrite($json, $dodTxt);
						break;
					}
				}
					$x=$x+1;
			}
			$i++;
		}
	}

?>
	
<html>
	
	
	
	<head>
		<title>Imenik</title>
		<meta charset="utf-8">
		<meta name="author" content="Mihajlo Karadzic" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"/>
		<link rel="stylesheet" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark justify-content-center">
				<div class="justify-content-center">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Imenik</a>
						</li>
					</ul>
				</div>
		</nav>
		<div class="row justify-content-center mt-5 mb-5">
			<div class="col-lg-8 justify-content-center text-center mt-3">
				<form method="POST" action="index.php">
					Ime:<br> 
					<input type="text" name="name"><br>
			
					Prezime: <br>
					<input type="text" name="surn"><br>

					Adresa:<br>
					<input type="text" name="addr"><br>
					
					Mesto:<br>
					<select name="mesto">
						<option value="" selected="selected"></option>
						<?php
							$url = 'imenik.json';
							$data = file_get_contents($url); 
							$characters = json_decode($data);
							$niz=array();
							foreach ($characters as $character) {
								 array_push($niz,$character->mesto);
							}
							
							$niz1=array_unique($niz);
							var_dump($niz1);
							$j=0;
							foreach($niz1 as $stavka){
								
								echo "<option value='" . $stavka ."' >" . $stavka ."</option>";
								$j++;
							}
							
						?>
					</select></br>
					
					Broj telefona:<br><input type="text" name="phon"><br>

					<input type="submit" name="submitButton" value="Trazi">
				</form>
				<table class="table table-dark">
					<?php
						   if(isset($_POST['submitButton'])){
						
							$url = 'imenik.json';
							$data = file_get_contents($url); 
							$characters = json_decode($data);  
							// imamo jedan niz osoba , prolazimo sva polja,ko ostane on je ispisan name,surn,addr,phon,mest
							$t=$_POST['name'];
							if(!empty($t)){
								foreach ($characters as $elementKey =>$character) {
									if(!stristr($character->ime,$t )){
										unset($characters[$elementKey]);
									}
								}
							}
							$t=$_POST['surn'];
							if(!empty($t)){
								foreach ($characters as $elementKey =>$character) {
									if(!stristr($character->prezime,$t )){
										unset($characters[$elementKey]);
									}
								}
							}
							$t=$_POST['addr'];
							if(!empty($t)){
								foreach ($characters as $elementKey =>$character) {
									if(!stristr($character->adresa,$t )){
										unset($characters[$elementKey]);
									}
								}
							}
							$t=$_POST['mesto'];
							if(!empty($t)){
								foreach ($characters as $elementKey =>$character) {
									if(!stristr($character->mesto,$t )){
										unset($characters[$elementKey]);
									}
								}
							}
							$t=$_POST['phon'];
							if(!empty($t)){
								foreach ($characters as $elementKey =>$character) {
									if(!stristr($character->telefon,$t )){
										unset($characters[$elementKey]);
									}
								}
							}
							echo "
							<tr>
								<td style='color:blue;'>Ime</td>
								<td style='color:blue;'>Prezime</td>
								<td style='color:blue;'>Mesto</td>
								<td style='color:blue;'>Adresa</td>
								<td style='color:blue;'>Telefon</td>
							</tr>";
							foreach ($characters as $character) {
								echo "<tr>";
								echo "<td>" . $character->ime . "</td>";
								echo "<td>".$character->prezime."</td>";
								echo "<td>" . $character->mesto. "</td>";
								echo "<td>".$character->adresa."</td>";
								echo "<td>" . $character->telefon. "</td>";
								echo "</tr>";
							} 
						}
							
						
					?>
				</table></br>
			</div>
		</div>
		<script src="js/script.js"></script>
	</body>
</html>