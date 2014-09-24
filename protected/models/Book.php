<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property integer $book_id
 * @property string $book_price
 * @property string $book_isbn
 * @property string $book_title
 * @property string $book_description
 * @property string $book_copyright
 * @property string $book_language
 * @property string $book_cover_image_url
 * @property string $book_created_date
 * @property integer $publisher_id
 *
 * The followings are the available model relations:
 * @property Publisher $publisher
 * @property BookAuthor[] $bookAuthors
 * @property BookCategory[] $bookCategories
 */
class Book extends CActiveRecord
{
	public $price;
	public $totalPrice;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_title', 'required'),
			array('publisher_id', 'numerical', 'integerOnly'=>true),
			array('book_price, book_language', 'length', 'max'=>10),
			array('book_isbn', 'length', 'max'=>24),
			array('book_title, book_copyright', 'length', 'max'=>255),
			array('book_description', 'length', 'max'=>1024),
			array('book_cover_image_url', 'length', 'max'=>512),
			array('is_free','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('book_id, book_price, book_isbn, book_title, book_description, book_copyright, book_language, book_cover_image_url, book_created_date, publisher_id', 'safe', 'on'=>'search'),
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
			'publisher' => array(self::BELONGS_TO, 'Publisher', 'publisher_id'),
			'authors' => array(self::MANY_MANY, 'Author', 'book_author(book_id,author_id)'),
			'bookAuthors' => array(self::HAS_MANY, 'BookAuthor', 'book_id'),
			'categories' => array(self::MANY_MANY, 'Category', 'book_category(book_id,category_id)'),
			'bookCategories' => array(self::HAS_MANY, 'BookCategory', 'book_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'book_id' => 'Book',
			'book_price' => 'Book Price',
			'book_isbn' => 'Book Isbn',
			'book_title' => 'Book Title',
			'book_description' => 'Book Description',
			'book_copyright' => 'Book Copyright',
			'book_language' => 'Book Language',
			'book_cover_image_url' => 'Book Cover Image Url',
			'book_created_date' => 'Book Created Date',
			'publisher_id' => 'Publisher',
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
		$withs = array();
		if($this->price == 'free')
		{
			$criteria->compare('is_free',true);
		}else if($this->price == 'paid'){
			$criteria->compare('is_free',0);
		}
		
		$criteria->compare('book_title',$this->book_title,true);
		if(!empty($this->bookAuthors) && is_array($this->bookAuthors))
		{
			$authors_together = true;
			$criteria->compare('bookAuthors.author_id',$this->bookAuthors);
			
			$withs['bookAuthors'] = array('together'=>true);
		}

		if(!empty($this->bookCategories) && is_array($this->bookCategories))
		{
			$categories_together = true;
			$criteria->compare('bookCategories.category_id',$this->bookCategories);
			$withs['bookCategories'] = array('together'=>true);
		}

		$criteria->with = $withs;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Book the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeValidate() {
        if ($this->isNewRecord) {
        	if(empty(trim($this->book_price)))
        	{
        		$this->book_price = null;
        	}
            $this->book_created_date = date('Y-m-d H:i:s');
        }
        return parent::beforeValidate();
    }

    public function behaviors()
	{
	    return array(
	        'activerecord-relation'=>array(
	            'class'=>'ext.activerecord-relation.EActiveRecordRelationBehavior',
	    	)
	    );
	}

	public function cartBooks($cart) {
		$criteria=new CDbCriteria;
		$criteria->addInCondition('book_id',$cart);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function totalPrice($cart) {
		$criteria = new CDbCriteria;
		$criteria->select='SUM(book_price) as totalPrice';
		$criteria->addInCondition('book_id',$cart);

		$book = $this->find($criteria);

		if($book === null)
		{
			return 0;
		}else {
			return $book->totalPrice;
		}
	}
}
