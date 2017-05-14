<?php

/**
 * This is the model class for table "cotizaciones_desc".
 *
 * The followings are the available columns in table 'cotizaciones_desc':
 * @property string $id
 * @property string $folio_cotizacion
 * @property integer $partida
 * @property integer $cantidad
 * @property string $id_producto
 * @property string $descripcion
 * @property double $precio_prov
 * @property double $precio_unitario
 * @property integer $tipo_precio
 * @property double $com_pesos
 * @property string $intencion_compra
 * @property double $promo
 */
class SlCotizacionesDesc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cotizaciones_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('folio_cotizacion, partida, cantidad, id_producto, precio_unitario', 'required'),
			array('partida, cantidad, tipo_precio', 'numerical', 'integerOnly'=>true),
			array('precio_prov, precio_unitario, com_pesos, promo', 'numerical'),
			array('folio_cotizacion', 'length', 'max'=>20),
			array('id_producto, intencion_compra', 'length', 'max'=>100),
			array('descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, folio_cotizacion, partida, cantidad, id_producto, descripcion, precio_prov, precio_unitario, tipo_precio, com_pesos, intencion_compra, promo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'folio_cotizacion' => 'Folio Cotizacion',
			'partida' => 'Partida',
			'cantidad' => 'Cantidad',
			'id_producto' => 'Id Producto',
			'descripcion' => 'Descripcion',
			'precio_prov' => 'Precio Prov',
			'precio_unitario' => 'Precio Unitario',
			'tipo_precio' => 'Tipo Precio',
			'com_pesos' => 'Com Pesos',
			'intencion_compra' => 'Intencion Compra',
			'promo' => 'Promo',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('folio_cotizacion',$this->folio_cotizacion,true);
		$criteria->compare('partida',$this->partida);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('id_producto',$this->id_producto,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('precio_prov',$this->precio_prov);
		$criteria->compare('precio_unitario',$this->precio_unitario);
		$criteria->compare('tipo_precio',$this->tipo_precio);
		$criteria->compare('com_pesos',$this->com_pesos);
		$criteria->compare('intencion_compra',$this->intencion_compra,true);
		$criteria->compare('promo',$this->promo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db1;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SlCotizacionesDesc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
