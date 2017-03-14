<?php

namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;
use app\components\utility;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $preview_img;
    public static $url;

    public function rules()
    {
        return [
            [['preview_img'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif']
          ,
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $preview_img_path = 'uploads/'.uniqid().time().'.'.explode(".",$this->preview_img->name)[1];
            $this->preview_img->saveAs($preview_img_path);
            $this::$url = $preview_img_path;
            return true;
        } else {
            return false;
        }
    }


    public function uploadavatar($model)
    {

        if ($this->validate()) {
            $preview_img_path = 'uploads/avatars/'.uniqid().time().'.'.explode(".",$this->preview_img->name)[1];
            $model->avatar = $preview_img_path;

            $this->preview_img->saveAs($preview_img_path);


            return true;
        } else {
            return false;
        }
    }
}