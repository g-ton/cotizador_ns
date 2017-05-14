<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property integer $id_cliente
 * @property integer $id_personal
 * @property string $tipo_cliente
 * @property string $rfc
 * @property string $fecha_alta
 * @property string $nombre
 * @property string $calle
 * @property string $numero
 * @property string $interior
 * @property string $colonia
 * @property integer $cp
 * @property string $ciudad
 * @property string $edo
 * @property string $pais
 * @property string $dom_entrega
 * @property string $contacto
 * @property string $mail
 * @property string $mail_fact
 * @property string $telefono
 * @property string $user
 * @property string $pass
 * @property string $priv
 * @property string $giro
 * @property string $medio_contacto
 * @property string $observaciones
 * @property string $vigente
 * @property string $status
 * @property string $firma
 * @property integer $dias_credito
 * @property string $aut_credito
 * @property double $importe_credito
 * @property string $papeles
 * @property string $fecha_aprobacion
 * @property string $notas_credito
 * @property string $persona1
 * @property string $persona2
 * @property string $logo_empresa
 */
class Clientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_personal, nombre', 'required'),
			array('id_personal, cp, dias_credito', 'numerical', 'integerOnly'=>true),
			array('importe_credito', 'numerical'),
			array('tipo_cliente, numero', 'length', 'max'=>20),
			array('rfc', 'length', 'max'=>30),
			array('nombre', 'length', 'max'=>500),
			array('calle, colonia, pass', 'length', 'max'=>50),
			array('interior, status', 'length', 'max'=>10),
			array('ciudad, edo, pais, contacto, user, giro, medio_contacto, aut_credito', 'length', 'max'=>100),
			array('mail_fact', 'length', 'max'=>200),
			array('priv, vigente', 'length', 'max'=>1),
			array('papeles', 'length', 'max'=>2),
			array('fecha_alta, dom_entrega, mail, telefono, observaciones, firma, fecha_aprobacion, notas_credito, persona1, persona2, logo_empresa', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cliente, id_personal, tipo_cliente, rfc, fecha_alta, nombre, calle, numero, interior, colonia, cp, ciudad, edo, pais, dom_entrega, contacto, mail, mail_fact, telefono, user, pass, priv, giro, medio_contacto, observaciones, vigente, status, firma, dias_credito, aut_credito, importe_credito, papeles, fecha_aprobacion, notas_credito, persona1, persona2, logo_empresa', 'safe', 'on'=>'search'),
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
			'id_personal' => 'Id Personal',
			'tipo_cliente' => 'Tipo Cliente',
			'rfc' => 'Rfc',
			'fecha_alta' => 'Fecha Alta',
			'nombre' => 'Nombre',
			'calle' => 'Calle',
			'numero' => 'Numero',
			'interior' => 'Interior',
			'colonia' => 'Colonia',
			'cp' => 'Cp',
			'ciudad' => 'Ciudad',
			'edo' => 'Edo',
			'pais' => 'Pais',
			'dom_entrega' => 'Dom Entrega',
			'contacto' => 'Contacto',
			'mail' => 'Mail',
			'mail_fact' => 'Mail Fact',
			'telefono' => 'Telefono',
			'user' => 'User',
			'pass' => 'Pass',
			'priv' => 'Priv',
			'giro' => 'Giro',
			'medio_contacto' => 'Medio Contacto',
			'observaciones' => 'Observaciones',
			'vigente' => 'Vigente',
			'status' => 'Status',
			'firma' => 'Firma',
			'dias_credito' => 'Dias Credito',
			'aut_credito' => 'Aut Credito',
			'importe_credito' => 'Importe Credito',
			'papeles' => 'Papeles',
			'fecha_aprobacion' => 'Fecha Aprobacion',
			'notas_credito' => 'Notas Credito',
			'persona1' => 'Persona1',
			'persona2' => 'Persona2',
			'logo_empresa' => 'Logo Empresa',
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

		$criteria->compare('id_cliente',$this->id_cliente);
		$criteria->compare('id_personal',$this->id_personal);
		$criteria->compare('tipo_cliente',$this->tipo_cliente,true);
		$criteria->compare('rfc',$this->rfc,true);
		$criteria->compare('fecha_alta',$this->fecha_alta,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('interior',$this->interior,true);
		$criteria->compare('colonia',$this->colonia,true);
		$criteria->compare('cp',$this->cp);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('edo',$this->edo,true);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('dom_entrega',$this->dom_entrega,true);
		$criteria->compare('contacto',$this->contacto,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('mail_fact',$this->mail_fact,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('priv',$this->priv,true);
		$criteria->compare('giro',$this->giro,true);
		$criteria->compare('medio_contacto',$this->medio_contacto,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('vigente',$this->vigente,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('firma',$this->firma,true);
		$criteria->compare('dias_credito',$this->dias_credito);
		$criteria->compare('aut_credito',$this->aut_credito,true);
		$criteria->compare('importe_credito',$this->importe_credito);
		$criteria->compare('papeles',$this->papeles,true);
		$criteria->compare('fecha_aprobacion',$this->fecha_aprobacion,true);
		$criteria->compare('notas_credito',$this->notas_credito,true);
		$criteria->compare('persona1',$this->persona1,true);
		$criteria->compare('persona2',$this->persona2,true);
		$criteria->compare('logo_empresa',$this->logo_empresa,true);

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
	 * @return Clientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
