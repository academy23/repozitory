<?php			function search(){		$GLOBALS['h1'] = "Пошук";		$GLOBALS['content'] = <<<HTML		<div class="row-fluid">			<div class="span6">				<form class="well form-inline" method="POST" action="/?action=searchDo">					<div class="row-fluid">						<label>Ключове слово</label>						<input type="text" name="search" class="span12" value=""/>					</div>					<div class="row-fluid">						<label>Таблиця</label>						<select name="table" class="span12">							<option value=""></option>							<option value="faculties">Факультет</option>							<option value="lectors">Лектор</option>							<option value="subjects">Предмет</option>						</select>					</div>					<div class="row-fluid">						<button type="submit" class="btn">Пошук</button>					</div>				</form>			</div>		</div>HTML;	}		function searchDo(){	 if($_POST['table']=='lectors'){		header('Location: /?action=listLector&filter=search&query='.$_POST['search'], true, 303);	 }elseif($_POST['table']=='faculties'){		header('Location: /?action=listFaculty&filter=search&query='.$_POST['search'], true, 303);	 }elseif($_POST['table']=='subjects'){		header('Location: /?action=listSubject&filter=search&query='.$_POST['search'], true, 303);	 }else{		header('Location: /?action=listLector', true, 303);	 }	 ;	}	?>