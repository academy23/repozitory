<?php

	function addCountry(){//форма додавання країни
		$GLOBALS['h1'] = "Додавання нової країни";
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=addCountryDo">
					<div class="row-fluid">
						<label>Назва країни</label>
						<input type="text" name="country" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<button type="submit" class="btn">Додати</button>
					</div>
				</form>
			</div>
		</div>
HTML;
	}
	
	function addCountryDo(){//додавання країни
		$country = $_POST['country'];
		$query = 'INSERT INTO countries (country) VALUES ("'.$country.'")';
		$result = mysql_query($query) or die(mysql_error());
		header('Location: /?action=listCountries', true, 303);
	}
	
	function listCountries(){
		$GLOBALS['h1'] = "Країни";
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid"><a href="/?action=addCountry" class="btn btn-info right">Додати країну</a></div>
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Країна</th>
					</tr>
				</thead>
			<tbody>
TPL;
		$query="SELECT * FROM countries";
		$res=mysql_query($query);
		$i=0;
		while($row=mysql_fetch_array($res)){
			$i=$i+1;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['country']."</td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		
	}
	
	
	
	
	
	
	
?>