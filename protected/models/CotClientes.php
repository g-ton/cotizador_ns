<?php

/**
 * This is the model class for table "cot_clientes".
 *
 * The followings are the available columns in table 'cot_clientes':
 * @property integer $id_cliente
 * @property integer $id_usuario
 * @property string $nombre_cliente
 * @property string $cargo
 * @property string $tel1
 * @property string $tel2
 * @property string $email
 * @property string $empresa
 */
class CotClientes extends CActiveRecord
{
	public function getEditar()
    {
       $rutaControlador = Yii::app()->createUrl('Joyeria/cotizaciones/clientesCotizacion', array('id'=>1, 'idCliente'=>$this->id_cliente));
       $editar = "<a href=$rutaControlador class=clientes><span class='icon-pencil'></span></a>";
    
       return $editar;
    }

    public function getEliminar()
    {
       $rutaControlador = Yii::app()->createUrl('Joyeria/cotizaciones/eliminarCliente', array('idCliente'=>$this->id_cliente));
       $eliminar = "<a href=$rutaControlador class=clientes><span class='icon-cross'></span></a>";
    
       return $eliminar;
    } 
    
	/*Regresa el nombre_cliente y empresa concatenados */
	public function getConcatened()
    {
       return $this->nombre_cliente.' - '.$this->empresa;
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cot_clientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, nombre_cliente, tel1, email, empresa', 'required'),
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('nombre_cliente, cargo, email, empresa', 'length', 'max'=>80),
			array('tel1, tel2', 'length', 'max'=>12),
			array(
	            'email',
	            'match', 'pattern' => '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',
	            'message' => 'Email Inválido',
	        ),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cliente, id_usuario, nombre_cliente, cargo, tel1, tel2, email, empresa, estatus', 'safe', 'on'=>'search'),
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
			'id_cliente' => 'Id Cliente',
			'id_usuario' => 'Id Usuario',
			'nombre_cliente' => 'Nombre Cliente',
			'cargo' => 'Cargo',
			'tel1' => 'Tel1',
			'tel2' => 'Tel2',
			'email' => 'Email',
			'empresa' => 'Empresa',
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

		$criteria->order= 'id_cliente DESC';
		$criteria->compare('id_cliente',$this->id_cliente);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('nombre_cliente',$this->nombre_cliente,true);
		$criteria->compare('cargo',$this->cargo,true);
		$criteria->compare('tel1',$this->tel1,true);
		$criteria->compare('tel2',$this->tel2,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('estatus',$this->estatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=> array('pageSize'=>10)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CotClientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
