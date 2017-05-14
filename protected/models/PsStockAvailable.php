<?php

/**
 * This is the model class for table "ps_stock_available".
 *
 * The followings are the available columns in table 'ps_stock_available':
 * @property string $id_stock_available
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_shop
 * @property string $id_shop_group
 * @property integer $quantity
 * @property integer $depends_on_stock
 * @property integer $out_of_stock
 */
class PsStockAvailable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ps_stock_available';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_product_attribute, id_shop, id_shop_group', 'required'),
			array('quantity, depends_on_stock, out_of_stock', 'numerical', 'integerOnly'=>true),
			array('id_product, id_product_attribute, id_shop, id_shop_group', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_stock_available, id_product, id_product_attribute, id_shop, id_shop_group, quantity, depends_on_stock, out_of_stock', 'safe', 'on'=>'search'),
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
			'producto' => array(self::BELONGS_TO, 'PsProduct', 'id_product'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_stock_available' => 'Id Stock Available',
			'id_product' => 'Id Product',
			'id_product_attribute' => 'Id Product Attribute',
			'id_shop' => 'Id Shop',
			'id_shop_group' => 'Id Shop Group',
			'quantity' => 'Existencia',
			'depends_on_stock' => 'Depends On Stock',
			'out_of_stock' => 'Out Of Stock',
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

		$criteria->compare('id_stock_available',$this->id_stock_available,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_product_attribute',$this->id_product_attribute,true);
		$criteria->compare('id_shop',$this->id_shop,true);
		$criteria->compare('id_shop_group',$this->id_shop_group,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('depends_on_stock',$this->depends_on_stock);
		$criteria->compare('out_of_stock',$this->out_of_stock);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PsStockAvailable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
