<?php

/**
 * This is the model class for table "ps_product_lang".
 *
 * The followings are the available columns in table 'ps_product_lang':
 * @property string $id_product
 * @property string $id_shop
 * @property string $id_lang
 * @property string $description
 * @property string $description_short
 * @property string $link_rewrite
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $meta_title
 * @property string $name
 * @property string $available_now
 * @property string $available_later
 */
class PsProductLang extends CActiveRecord
{
	public function getTruncate()
	{
		if(Yii::app()->request->cookies['tipodispositivo']->value== 1)
		{
			$cadenaTrunc= substr($this->name, 0, 35);
			$cadenaTrunc= strtolower($cadenaTrunc);
		}

		else
			$cadenaTrunc= strtolower($this->name);

		return $cadenaTrunc;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ps_product_lang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_lang, link_rewrite, name', 'required'),
			array('id_product, id_lang', 'length', 'max'=>10),
			array('id_shop', 'length', 'max'=>11),
			array('link_rewrite, meta_title, name', 'length', 'max'=>128),
			array('meta_description, meta_keywords, available_now, available_later', 'length', 'max'=>255),
			array('description, description_short', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_product, id_shop, id_lang, description, description_short, link_rewrite, meta_description, meta_keywords, meta_title, name, available_now, available_later', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'PsProduct', 'id_product'),
			'cotizacionTmp' => array(self::BELONGS_TO, 'CotCotizaciontmp', 'id_producto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_product' => 'Id Product',
			'id_shop' => 'Id Shop',
			'id_lang' => 'Id Lang',
			'description' => 'Description',
			'description_short' => 'Description Short',
			'link_rewrite' => 'Link Rewrite',
			'meta_description' => 'Meta Description',
			'meta_keywords' => 'Meta Keywords',
			'meta_title' => 'Meta Title',
			'name' => 'Producto',
			'available_now' => 'Available Now',
			'available_later' => 'Available Later',
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

		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_shop',$this->id_shop,true);
		$criteria->compare('id_lang',$this->id_lang,true);
		$criteria->compare('name',$this->name,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PsProductLang the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
