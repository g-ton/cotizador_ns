<?php

/**
 * This is the model class for table "cot_configuracion".
 *
 * The followings are the available columns in table 'cot_configuracion':
 * @property integer $id_usuario
 * @property string $departamento
 * @property string $telefono
 * @property string $email
 * @property string $pagina_web
 * @property string $razon_social
 * @property string $banco
 * @property string $num_cuenta
 * @property string $clabe
 * @property string $inf_extra
 * @property string $logo
 */
class CotConfiguracion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cot_configuracion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, departamento, telefono, email, pagina_web, razon_social, banco, num_cuenta, clabe, logo', 'required'),
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('departamento, telefono, email, pagina_web, razon_social, banco, num_cuenta, clabe, inf_extra, logo', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, departamento, telefono, email, pagina_web, razon_social, banco, num_cuenta, clabe, inf_extra, logo', 'safe', 'on'=>'search'),
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
			'id_usuario' => 'Id Usuario',
			'departamento' => 'Departamento',
			'telefono' => 'Teléfono',
			'email' => 'Email',
			'pagina_web' => 'Página Web',
			'razon_social' => 'Razón Social',
			'banco' => 'Banco',
			'num_cuenta' => 'Núm Cuenta',
			'clabe' => 'Clabe',
			'inf_extra' => 'Información Adicional',
			'logo' => 'Logo',
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

		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pagina_web',$this->pagina_web,true);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('banco',$this->banco,true);
		$criteria->compare('num_cuenta',$this->num_cuenta,true);
		$criteria->compare('clabe',$this->clabe,true);
		$criteria->compare('inf_extra',$this->inf_extra,true);
		$criteria->compare('logo',$this->logo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CotConfiguracion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
