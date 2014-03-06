<?php
//основний шаблон
$main_tpl =<<<TPL
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{$GLOBALS['h1']} - {$GLOBALS['title']}</title>
		
		<link rel="stylesheet" href="/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="/css/blue.css"/>
		<link rel="stylesheet" href="/css/style.css"/>
		<link rel="stylesheet" href="/js/datepicker/datepicker.css"/>

		<script src="/js/jquery.min.js"></script>
		<script src="/js/jquery.cookie.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/jquery.dataTables.js"></script>
		<script src="/js/datepicker/bootstrap-datepicker.js"></script>
		<script>
			$(document).ready(function(){
				$('a.confirm').click(function(){
					if(confirm("Впевнені?")){
						return true;
					}else{
						return false;
					}
				});
			});
		</script>
    </head>
    <body>
		<div id="maincontainer" class="clearfix">
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="brand" href="/"><i class="icon-signal icon-white"></i> Університет</a>
							<ul class="nav user_menu pull-right">
                                <li class="divider-vertical hidden-phone hidden-tablet"></li>
								<li class="divider-vertical hidden-phone hidden-tablet"></li>
                            </ul>
							
							<a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu">
								<span class="icon-align-justify icon-white"></span>
							</a>
                            <nav>
								<div class="nav-collapse">
									<ul class="nav">
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="/?action=listSubjects">Предмети</a>
										</li>
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="/?action=listFaculties">Факультети</a>
										</li>
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="/?action=listLectors">Лектори</a>
										</li>
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="/?action=listCountries">Країни</a>
										</li>
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="/?action=search">Пошук</a>
										</li>
										
										
									</ul>
								</div>
							</nav>
                        </div>
                    </div>
                </div>
            </header>
            
            <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">{$GLOBALS['h1']}</h3>
							{$GLOBALS['content']}
						</div>  
					</div>  
                </div>
            </div>            	
		</div>
	</body>
</html>
TPL;
?>