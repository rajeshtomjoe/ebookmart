<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $_name;


    public function authenticate() {
        $record = User::model()->findByAttributes( array( 'user_email' => $this->username ) );
        if ( $record === null )
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else if ( !$record->verify( $this->password,$record->user_password ) )
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else {
            $this->_id = $record->user_id;
            $this->_name = $record->user_name;
            $this->errorCode = self::ERROR_NONE;

        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }
    public function getName() {
        return $this->_name;
    }



}
