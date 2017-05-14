<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $genero
 * @property string $estatus
 */
class Usuarios extends CActiveRecord
{
	public $valorRadioBtn;

	public function getEditar()
    {
       $rutaControlador = Yii::app()->createUrl('/Usuarios/default/nuevo', array('id_usuario'=>$this->id));
       $editar = "<a href=$rutaControlador class=fancyBox><span class='icon-pencil'></span></a>";
    
       return $editar;
    }

    public function getEliminar()
    {
       $rutaControlador = Yii::app()->createUrl('/Joyeria/productos/eliminar', array('id_usuario'=>$this->id));
       $eliminar = "<a href=$rutaControlador class=fancyBox><span class='icon-cross'></span></a>";
    
       return $eliminar;
    }

	public function validatePassword($password)
    {
        //return CPasswordHelper::verifyPassword($password,$this->password);
        return $this->hashPassword($password)=== $this->password;;
    }
 
    public function hashPassword($password)
    {
        //return CPasswordHelper::hashPassword($password);
        //Esto realiza la búsqueda del password por el algoritmo md5 en la tabla Usuarios
        return md5($password);
    }

    public function tipoDispositivo()
    {
        $tablet_browser = 0;
		$mobile_browser = 0;
		$body_class = 'desktop';
		 
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $tablet_browser++;
		    $body_class = "tablet";
		}
		 
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $mobile_browser++;
		    $body_class = "mobile";
		}
		 
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		    $mobile_browser++;
		    $body_class = "mobile";
		}
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
		    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		    'newt','noki','palm','pana','pant','phil','play','port','prox',
		    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		    'wapr','webc','winw','winw','xda ','xda-');
		 
		if (in_array($mobile_ua,$mobile_agents)) {
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
		    $mobile_browser++;
		    //Check for tablets on opera mini alternative headers
		    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
		    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
		      $tablet_browser++;
		    }
		}
		if ($tablet_browser > 0) {
		// Si es tablet has lo que necesites
		   return 1;
		}
		else if ($mobile_browser > 0) {
		// Si es dispositivo mobil has lo que necesites
		   return 1;
		}
    }
  
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, genero, estatus', 'required', 'message'=>'Campo requerido'),
			array('username, password', 'length', 'max'=>60),
			array('email', 'length', 'max'=>80),
			array('genero', 'length', 'max'=>25),
			array('estatus', 'length', 'max'=>12),
			array('nombre_cliente', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, genero, estatus, nombre_cliente', 'safe', 'on'=>'search'),
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
			'cotizaciones' => array(self::HAS_MANY, 'CotCotizacion', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Usuario',
			'password' => 'Contraseña',
			'email' => 'Correo Electrónico',
			'genero' => 'Género',
			'estatus' => 'Estatus',
			'valorRadioBtn' => 'Administrador',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('genero',$this->genero,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('nombre_cliente',$this->nombre_cliente,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getRole() 
	{
	        $role = Yii::app()->db->createCommand()
	                ->select('itemname')
	                ->from('AuthAssignment')
	                ->where('userid=:id', array(':id'=>$this->id))
	                ->queryScalar();

	        return $role;
	}
}
