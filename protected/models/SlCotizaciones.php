<?php

/**
 * This is the model class for table "cotizaciones".
 *
 * The followings are the available columns in table 'cotizaciones':
 * @property string $folio_cotizacion
 * @property string $fecha
 * @property string $hora
 * @property integer $id_cliente
 * @property integer $id_personal
 * @property double $tc
 * @property double $iva
 * @property string $notas
 * @property string $ensamble
 * @property string $paqueteria
 * @property string $status_cot
 * @property string $motivo
 * @property string $status
 * @property string $num_ensambles
 * @property string $lugar_entrega
 * @property string $comp_cli
 * @property string $intencion_compra
 * @property string $id_suc
 */
class SlCotizaciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cotizaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, hora, id_cliente, id_personal, tc', 'required'),
			array('id_cliente, id_personal', 'numerical', 'integerOnly'=>true),
			array('tc, iva', 'numerical'),
			array('hora', 'length', 'max'=>15),
			array('ensamble, paqueteria', 'length', 'max'=>1),
			array('status_cot, motivo, lugar_entrega, comp_cli', 'length', 'max'=>20),
			array('status', 'length', 'max'=>10),
			array('num_ensambles', 'length', 'max'=>4),
			array('intencion_compra', 'length', 'max'=>100),
			array('id_suc', 'length', 'max'=>5),
			array('notas', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('folio_cotizacion, fecha, hora, id_cliente, id_personal, tc, iva, notas, ensamble, paqueteria, status_cot, motivo, status, num_ensambles, lugar_entrega, comp_cli, intencion_compra, id_suc', 'safe', 'on'=>'search'),
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
			'folio_cotizacion' => 'Folio Cotizacion',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'id_cliente' => 'Id Cliente',
			'id_personal' => 'Id Personal',
			'tc' => 'Tc',
			'iva' => 'Iva',
			'notas' => 'Notas',
			'ensamble' => 'Ensamble',
			'paqueteria' => 'Paqueteria',
			'status_cot' => 'Status Cot',
			'motivo' => 'Motivo',
			'status' => 'Status',
			'num_ensambles' => 'Num Ensambles',
			'lugar_entrega' => 'Lugar Entrega',
			'comp_cli' => 'Comp Cli',
			'intencion_compra' => 'Intencion Compra',
			'id_suc' => 'Id Suc',
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

		$criteria->compare('folio_cotizacion',$this->folio_cotizacion,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('id_cliente',$this->id_cliente);
		$criteria->compare('id_personal',$this->id_personal);
		$criteria->compare('tc',$this->tc);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('notas',$this->notas,true);
		$criteria->compare('ensamble',$this->ensamble,true);
		$criteria->compare('paqueteria',$this->paqueteria,true);
		$criteria->compare('status_cot',$this->status_cot,true);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('num_ensambles',$this->num_ensambles,true);
		$criteria->compare('lugar_entrega',$this->lugar_entrega,true);
		$criteria->compare('comp_cli',$this->comp_cli,true);
		$criteria->compare('intencion_compra',$this->intencion_compra,true);
		$criteria->compare('id_suc',$this->id_suc,true);

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
	 * @return SlCotizaciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
