<?php

/**
 * This is the model class for table "cot_cotizaciontmp".
 *
 * The followings are the available columns in table 'cot_cotizaciontmp':
 * @property integer $id
 * @property integer $id_producto
 * @property integer $cantidad_tmp
 * @property string $precio_tmp
 * @property string $id_cotizacion
 */
class CotCotizaciontmp extends CActiveRecord
{
	public $sku_producto;

	public function getEliminar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/cotizaciones/eliminar', array('id_cotizacion'=>$this->id));
       $eliminar = "<a href=$rutaControlador class='fancyBox opciones-color' title='Eliminar producto de la cotización'><span class='icon-bin2'></span></a>";
    
       return $eliminar;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cot_cotizaciontmp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_producto, nombre, cantidad_tmp, precio_tmp, id_cotizacion', 'required'),
			array('id_producto, cantidad_tmp, porcentaje', 'numerical', 'integerOnly'=>true),
			array('precio_modificado', 'match', 'pattern'=>'/^\d{1,20}(\.\d{1,6})?$/', 'message'=>'Ingrese un tipo de cambio válido ej: 123.00000'),
			array('precio_unitario, precio_modificado', 'length', 'max'=>20),
			array('precio_tmp', 'length', 'max'=>20),
			array('id_cotizacion', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_producto, cantidad_tmp, precio_unitario, precio_tmp, precio_modificado, id_cotizacion, nombre, 
				selected_price, producto_propio, id_original_producto, precio_prov', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'PsProduct', 'id_producto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_producto' => 'Id Producto',
			'nombre' => 'Producto',
			'cantidad_tmp' => 'Cantidad Tmp',
			'precio_unitario' => 'Precio Unitario',
			'precio_modificado' => 'Precio Modificado',
			'precio_tmp' => 'Precio Total',
			'id_cotizacion' => 'Session',
			'porcentaje' => 'Porcentaje',
			'producto_propio' => 'producto_propio',
			'sku_producto' => 'Clave Producto',
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

		$criteria->with=array('product');
		$criteria->compare('product.reference', $this->sku_producto, true);
		$sku= $_GET['CotCotizaciontmp']['sku_producto'];

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.id_producto',$this->id_producto);
		$criteria->compare('t.cantidad_tmp',$this->cantidad_tmp);
		$criteria->compare('t.precio_unitario',$this->precio_tmp,true);
		$criteria->compare('t.precio_tmp',$this->precio_tmp,true);
		$criteria->compare('t.id_cotizacion',$this->id_cotizacion,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.selected_price',$this->nombre);
		$criteria->addSearchCondition('product.reference', $sku);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CotCotizaciontmp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
