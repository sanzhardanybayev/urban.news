<?php

namespace app\models;

use Yii;
use yii\base\Model;

class WebsiteSettingsForm extends Model
{
  public $amountOfNewsOnMainPage;
  public $amountOfNewsOnNewsPage;
  public $_websiteSettings;

  public function rules()
  {
    return [
        [['amountOfNewsOnMainPage', 'amountOfNewsOnNewsPage'], 'required'],
        'amountOfNewsOnMainPage' => ['amountOfNewsOnMainPage', 'integer', 'min' => 3, 'max' => 15],
        ['amountOfNewsOnNewsPage', 'integer', 'min' => 3, 'max' => 15]
    ];
  }

  /** @return WebsiteSettings */
  public function getWebsiteSettings()
  {
    if ($this->_websiteSettings == null) {
      $this->_websiteSettings = WebsiteSettings::findOne(1);
    }
    return $this->_websiteSettings;
  }

  /** @inheritdoc */
  public function __construct($config = [])
  {
    $this->setAttributes([
        'amountOfNewsOnMainPage' => $this->websiteSettings->amountOfNewsOnMainPage,
        'amountOfNewsOnNewsPage'    => $this->websiteSettings->amountOfNewsOnNewsPage
    ], false);
    parent::__construct($config);
  }

  public function attributeLabels()
  {
    return [
        'amountOfNewsOnMainPage' => 'Количество новостей на главной странице',
        'amountOfNewsOnNewsPage' => 'Количество новостей на странице "Новости"',
    ];
  }

  public function formName(){
    return 'websiteSettingsForm';
  }

  public function save(){
    if (!$this->validate()) {
      return $this->getErrors();
    }
    $websiteSettings = WebsiteSettings::findOne(1);
    $websiteSettings->amountOfNewsOnNewsPage = $this->amountOfNewsOnNewsPage;
    $websiteSettings->amountOfNewsOnMainPage = $this->amountOfNewsOnMainPage;
    $websiteSettings->save();
  }
}