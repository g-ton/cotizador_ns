<?php

/**
 * This is the model class for table "categorias".
 *
 * The followings are the available columns in table 'categorias':
 * @property integer $id
 * @property string $nombre_categoria
 *
 * The followings are the available model relations:
 * @property Productos[] $productoses
 */
class Categorias extends CActiveRecord
{
	public function getEditar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/default/nuevo', array('id_categoria'=>$this->id));
       $editar = "<a href=$rutaControlador class=fancyBox><span class='icon-pencil'></span></a>";
    
       return $editar;
    }

    public function getEliminar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/default/eliminar', array('id_categoria'=>$this->id));
       $eliminar = "<a href=$rutaControlador class=fancyBox><span class='icon-cross'></span></a>";
    
       return $eliminar;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'categorias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_categoria', 'required', 'message'=>'Campo requerido'),
			array('nombre_categoria', 'length', 'max'=>70),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre_categoria', 'safe', 'on'=>'search'),
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
			'productoses' => array(self::HAS_MANY, 'Productos', 'id_categoria'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre_categoria' => 'Categoría',
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
		$criteria->compare('nombre_categoria',$this->nombre_categoria,true);

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
	 * @return Categorias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
