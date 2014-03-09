        <?php
		
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
										<button type="submit" name="submitCountry" class="btn">Додати</button>
									</div>
								</form>
							</div>
						</div>
HTML;

?>