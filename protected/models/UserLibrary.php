<?php

/**
 * This is the model class for table "user_library".
 *
 * The followings are the available columns in table 'user_library':
 * @property integer $user_library_id
 * @property integer $user_id
 * @property integer $book_id
 * @property integer $order_id
 * @property integer $is_sample
 * @property string $user_library_created_date
 *
 * The followings are the available model relations:
 * @property Book $book
 * @property User $user
 * @property Order $order
 */
class UserLibrary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_library';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, book_id', 'required'),
			array('user_id, book_id, order_id, is_sample', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_library_id, user_id, book_id, order_id, is_sample, user_library_created_date', 'safe', 'on'=>'search'),
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
			'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_library_id' => 'User Library',
			'user_id' => 'User',
			'book_id' => 'Book',
			'order_id' => 'Order',
			'is_sample' => 'Is Sample',
			'user_library_created_date' => 'User Library Created Date',
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

		$criteria->compare('user_library_id',$this->user_library_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('book_id',$this->book_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('is_sample',$this->is_sample);
		$criteria->compare('user_library_created_date',$this->user_library_created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function userBooks()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',Yii::app()->user->id);
		$criteria->order = 'user_library_created_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserLibrary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeValidate() {
        if ($this->isNewRecord) {
        
            $this->user_library_created_date = date('Y-m-d H:i:s');
        }
        return parent::beforeValidate();
    }
}
