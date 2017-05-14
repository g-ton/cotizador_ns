<?php

/**
 * This is the model class for table "imagenes".
 *
 * The followings are the available columns in table 'imagenes':
 * @property integer $id
 * @property string $ruta
 * @property string $estatus
 * @property integer $id_producto
 *
 * The followings are the available model relations:
 * @property Productos $idProducto
 */
class Imagenes extends CActiveRecord
{
	public $ruta0;
	public $ruta1;
	public $ruta2;
	public $ruta3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'imagenes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estatus, id_producto', 'required'),
			array('id_producto', 'numerical', 'integerOnly'=>true),
			//array('ruta', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'),
			//array('ruta', 'file', 'types'=>'jpg, gif, png', 'message'=>'Formato Incorrecto, Formatos permitidos: jpg, gif, png'),
			array('ruta0, ruta1, ruta2, ruta3', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'wrongType'=>'Formato Incorrecto, Formatos permitidos: jpg, gif, png'),
			array('ruta', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'),
			array('ruta', 'length', 'max'=>250, 'on'=>'insert,update'),
			array('estatus', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ruta, estatus, id_producto', 'safe', 'on'=>'search'),
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
			'idProducto' => array(self::BELONGS_TO, 'Productos', 'id_producto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ruta' => 'Ruta',
			'ruta0' => 'Imagen 1',
			'ruta1' => 'Imagen 2',
			'ruta2' => 'Imagen 3',
			'ruta3' => 'Imagen 4',
			'estatus' => 'Estatus',
			'id_producto' => 'Id Producto',
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
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('id_producto',$this->id_producto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Imagenes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
