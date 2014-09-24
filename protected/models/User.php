<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_email
 * @property string $user_password
 * @property string $user_created_date
 * @property string $user_updated_date
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_name, user_email, user_password', 'required'),
			array('user_email','unique'),
			array('user_name', 'length', 'max'=>100),
			array('user_email', 'email'),
			array('user_email, user_password', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_name, user_email, user_password, user_created_date, user_updated_date', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'user_name' => 'User Name',
			'user_email' => 'User Email',
			'user_password' => 'User Password',
			'user_created_date' => 'User Created Date',
			'user_updated_date' => 'User Updated Date',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_password',$this->user_password,true);
		$criteria->compare('user_created_date',$this->user_created_date,true);
		$criteria->compare('user_updated_date',$this->user_updated_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave() {
        if ($this->isNewRecord)
            $this->user_password = $this->encrypt($this->user_password);


        return parent::beforeSave();
    }

    protected function beforeValidate() {
        if ($this->isNewRecord) {

            $this->user_created_date = $this->user_updated_date = date('Y-m-d H:i:s');
        } else {
            $this->user_updated_date = date('Y-m-d H:i:s');
        }
        return parent::beforeValidate();
    }

    public function encrypt($value) {
        return CPasswordHelper::hashPassword($value);
    }

    public function verify($password, $hash) {
        return CPasswordHelper::verifyPassword($password, $hash);
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
