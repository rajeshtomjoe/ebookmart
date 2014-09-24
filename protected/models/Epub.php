<?php


class Epub extends CFormModel
{
	public $file;

	public function rules()
	{
		return array(
			array('file','required'),
			array('file', 'file', 'types'=>'epub'),
		);
	}
}