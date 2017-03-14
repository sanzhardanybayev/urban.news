<?php

namespace app\models;


/**
 * This is the model class for table "website_settings".
 *
 * @property integer $id
 * @property integer $amountOfNewsOnMainPage
 * @property integer $amountOfNewsOnNewsPage
 */
class WebsiteSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amountOfNewsOnMainPage', 'amountOfNewsOnNewsPage'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'amountOfNewsOnMainPage' =>  'Количество новостей на главной странице',
            'amountOfNewsOnNewsPage' =>  'Количество новостей на странице "Новости"'
        ];
    }
}
