<?php

/**
 * This is the model class for table "cambio_dolar".
 *
 * The followings are the available columns in table 'cambio_dolar':
 * @property string $id_cambio
 * @property string $fecha
 * @property string $hora
 * @property double $importe_pesos
 */
class SlCambioDolar extends CActiveRecord
{
	public function scopes()
	{
		//Para obtener el último registro de tc
	    return array(
	        'lastRecord'=>array(
	            'order'=>'id_cambio DESC',
	            'limit'=>1,
	        ),
	    );
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cambio_dolar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, hora, importe_pesos', 'required'),
			array('importe_pesos', 'numerical'),
			array('hora', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cambio, fecha, hora, importe_pesos', 'safe', 'on'=>'search'),
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
			'id_cambio' => 'Id Cambio',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'importe_pesos' => 'Importe Pesos',
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

		$criteria->compare('id_cambio',$this->id_cambio,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('importe_pesos',$this->importe_pesos);

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
	 * @return CambioDolar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
