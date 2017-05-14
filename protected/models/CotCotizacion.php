<?php

class CotCotizacion extends CActiveRecord
{
	public function getEditar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/cotizaciones', array('id'=>$this->id, 'tokenEdt'=>$this->token));
       $editar = "<a href=$rutaControlador class=fancyBox title='Editar Cotización'><span class='icon-pencil'></span></a>";
    
       return $editar;
    }

    public function getEliminar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/cotizaciones/eliminarGral', array('id_cotizacion'=>$this->id));
       $eliminar = "<a href=$rutaControlador class=cotizaciones title='Eliminar Cotización'><span class='icon-bin2'></span></a>";
    
       return $eliminar;
    }

    public function getPdf()
    {
      $rutaArchivo= $this->rutaArchivo;

      if(file_exists($rutaArchivo))
      {
      	$rutaControlador = Yii::app()->createUrl('/Joyeria/cotizaciones/descargarPdf', array('id_cotizacion'=>$this->id));
        $pdf = "<a href=$rutaControlador title='Descargar cotización PDF'><span style='height: 16px;' class='icon-file-pdf'></span></a>";
       }
      return $pdf;
    }

    public function getEmail()
    {
      	$rutaControlador = Yii::app()->createUrl('/Joyeria/cotizaciones/generarPdf', array('tokenEdt'=>$this->token, 'email'=>1));
        $email = "<a class='emailLink' href=$rutaControlador title='Eviar por Email cotización PDF'><span style='height: 16px;' class='icon-mail4'></span></a>";
      return $email;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cot_cotizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_cotizacion, nombre_cliente, tel1, email, empresa, ejecutivo', 'required', 'message'=>'{attribute} es requerido'),
			array('nombre_cliente, email, empresa, cargo', 'length', 'max'=>80),
			array('tel1, tel2', 'length', 'max'=>12),
			array('observaciones', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha_cotizacion, fecha_validez, nombre_cliente, cargo, email, empresa, ejecutivo, clave_cotizacion, activo, id_usuario', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'idUsuario' => array(self::BELONGS_TO, 'Usuarios', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'clave_cotizacion' => 'No. Cotización',
			'fecha_cotizacion' => 'Fecha Cotización',
			'nombre_cliente' => 'Dirigido a',
			'cargo' => 'Cargo',
			'tel1' => 'Tel1',
			'tel2' => 'Tel2',
			'email' => 'Email',
			'empresa' => 'Empresa',
			'ejecutivo' => 'Ejecutivo',
			'clave_cotizacion' => 'No. Cotización',
			'id_usuario' => 'id_usuario',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('clave_cotizacion',$this->clave_cotizacion, true);
		$criteria->compare('fecha_cotizacion',$this->fecha_cotizacion,true);
		$criteria->compare('nombre_cliente',$this->nombre_cliente,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('ejecutivo',$this->ejecutivo,true);
		$criteria->compare('activo',$this->activo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=> array('pageSize'=>30),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CotCotizacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
