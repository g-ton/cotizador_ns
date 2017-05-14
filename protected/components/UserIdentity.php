<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;
 
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=Usuarios::model()->find('LOWER(username)=?',array($username));

        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;

        else if(!$user->validatePassword($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;

        else
        {
            $this->_id=$user->id;
            $this->username=$user->username;
            $dispositivo= $user->tipoDispositivo();
            if($dispositivo== 1)
                Yii::app()->request->cookies['tipodispositivo'] = new CHttpCookie('tipodispositivo', $dispositivo);
            Yii::app()->session['rol_usuario']=  $user->getRole();
            Yii::app()->session['id_personal_sl']= $user->id_original_personal;
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode==self::ERROR_NONE;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}