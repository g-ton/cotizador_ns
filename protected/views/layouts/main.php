<!-- Este es el archivo principal que controla el aspecto de la mayoría de las vistas en el Cotizador -->
<?php /* @var $this Controller */ ?>
<?php Yii::app()->bootstrap->register(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.min.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styleIco.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <!-- Sidebar -->
    <?php
    if(!Yii::app()->user->isGuest){
	?>        	
   	<div class="w3-sidebar w3-bar-block w3-collapse w3-card-2" style="width:200px; text-align: center;" id="mySidebar">
   		<div style="padding: 10px 0;"><img src="images/logo_ns_ps.png"></div>
		<button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Cerrar &times;</button>
		<a href="index.php?r=Joyeria/cotizaciones/superIndex" class="w3-bar-item w3-button"><span class='icon-folder'></span> Cotizaciones</a>
		<a href="index.php?r=Joyeria/cotizaciones/indexClientes" class="w3-bar-item w3-button"><span class='icon-user'></span> Clientes</a>
		<a href="index.php?r=Joyeria/cotizaciones/configurarDatos" class="w3-bar-item w3-button"><span class='icon-cog'></span> Configurar Plantilla</a>
		<a href="index.php?r=site/logout" class="w3-bar-item w3-button"><span class='icon-exit'></span> Salir</a>
		<a href="http://nsstore.mx/e-commerce" class="w3-bar-item w3-button"><span class='icon-cart'></span> Regresar a Comprar</a>
	</div>

	<div class="w3-main" style="margin-left:200px">
	<div class="w3-teal">
	  <button class="w3-button w3-teal w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
	</div> 
	<?php } ?>
    <!-- /#sidebar-wrapper -->

	<div class="w3-container" >
	<!-- mainmenu -->
		<?php echo $content; ?>

		<div class="clear"></div>
		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> Nsstore.<br/>
			Todos los Derechos Reservados.<br/>
			Developed by J. Dami&aacute;n<br/>
			<?php echo Yii::powered(); ?>
		</div><!-- footer -->

	</div><!-- page -->
</body>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sideBar.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/estilos.min.css">
<script type="text/javascript">
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
</script>
</html>
