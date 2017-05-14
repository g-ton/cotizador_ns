<?php

/**
 * This is the model class for table "productos".
 *
 * The followings are the available columns in table 'productos':
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property string $precio
 * @property string $descripcion
 * @property string $estatus
 * @property integer $id_categoria
 *
 * The followings are the available model relations:
 * @property Imagenes[] $imagenes
 * @property Categorias $idCategoria
 */
class Productos extends CActiveRecord
{
	public function getEditar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/productos/nuevo', array('id_producto'=>$this->id));
       $editar = "<a href=$rutaControlador><span class='icon-pencil'></span></a>";
    
       return $editar;
    }

    public function getEliminar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/productos/eliminar', array('id_producto'=>$this->id));
       $eliminar = "<a href=$rutaControlador class=fancyBox><span class='icon-cross'></span></a>";
    
       return $eliminar;
    }    

    public function getAgregarProducto()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/productos/seleccionProductos', array('id_producto'=>$this->id, 'precio'=>$this->precio));
       //$seleccionar = "<a href=$rutaControlador ><span class='icon-cross'></span></a>";
       $seleccionar= "CHtml::ajaxLink(Yii::app()->createUrl('/Joyeria/productos/seleccionProductos'), array('id_producto'=>$this->id, 'precio'=>$this->precio))";

	/*	echo "<pre>";
		print_r($seleccionar);
		echo "</pre>";

		exit();*/
    
       return $seleccionar;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clave, nombre, descripcion, precio, estatus, id_categoria', 'required', 'message'=>'Campo requerido'),
			array('precio', 'match', 'pattern'=>'/^\d{1,11}(\.\d{1,2})?$/', 'message'=>'Campo numérico ej: 123.50'),
			array('clave', 'length', 'max'=>45),
			array('nombre', 'length', 'max'=>70),
			array('precio', 'length', 'max'=>11),
			array('estatus', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, clave, nombre, precio, descripcion, estatus, id_categoria', 'safe', 'on'=>'search'),
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
			//--'imagenes' => array(self::HAS_MANY, 'Imagenes', 'id_producto'),
			'idCategoria' => array(self::BELONGS_TO, 'Categorias', 'id_categoria'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'clave' => 'Clave',
			'nombre' => 'Nombre',
			'precio' => 'Precio',
			'descripcion' => 'Descripción',
			'estatus' => 'Estatus',
			'id_categoria' => 'Categoría',
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
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('precio',$this->precio,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('id_categoria',$this->id_categoria);

		$criteria->addCondition('estatus = "ACTIVO"');
		$criteria->order = 'id DESC';

		Yii::app()->session['criteriaSession'] = $criteria;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=> array('pageSize'=>15),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
