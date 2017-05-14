
<?php /* @var $this Controller */ ?>
<?php Yii::app()->bootstrap->register(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styleIco.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div>
		<?php 

		if(Yii::app()->user->isGuest)
		{
			$this->widget('bootstrap.widgets.TbNavbar', array(
	        'color' => TbHtml::NAVBAR_COLOR_INVERSE,
	        'brandLabel' => '<img id="imgLogoHeader" src ="' . Yii::app()->request->baseUrl . '/images/nsstore_logo.jpg" />',
	        'collapse' => true,
	        'items' => array(),
	        ));
		}

		else
		{
			$this->widget('bootstrap.widgets.TbNavbar', array(
				'color' => TbHtml::NAVBAR_COLOR_INVERSE,
				'brandLabel' => '<img id="imgLogoHeader" src ="' . Yii::app()->request->baseUrl . '/images/nsstore_logo.jpg" />',
		        'brandUrl' => '/cotizador/index.php?r=site',
		        'collapse' => true,
		        'items' => array(
		        	        array(
				            'class' => 'bootstrap.widgets.TbNav',
				            'items' => array(
				                array('label' => 'Cotizaciones', 'url' =>array('/Joyeria/cotizaciones/superIndex')),
				                array('label' => 'Clientes', 'url' =>array('/Joyeria/cotizaciones/indexClientes')),
				                array('label' => 'Configurar Plantilla', 'url' =>array('/Joyeria/cotizaciones/configurarDatos'), 'title'=>'Agregar los datos para ser mostrados en la plantilla o pdf de cotización'),
				                array('label'=>'Salir', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				            ),
		       			 ),

		        	    array(
			            'class'=>'bootstrap.widgets.TbNav',
			            'htmlOptions'=>array('class'=>'pull-right'),
			            'items'=>array(
			                array('label'=> Yii::app()->user->name, 'url'=>'#'),	              
			                array('label'=> 'Regresar a Comprar', 'url'=>'http://nsstore.mx/e-commerce'),	              
			            	),
			        	),
		        	),
		    )); 
	    }
	    ?>
	</div>
<div class="container" >

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
</html>
