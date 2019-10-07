<?php

namespace backend\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;

class UploadController extends Controller
{
    public function actionIndex($dirname)
    {
        $img = UploadedFile::getInstanceByName('img');
        $name = explode('.', $img->name);
        if (!empty($img)) {
            $image_file_type = strtolower(pathinfo($img->name, PATHINFO_EXTENSION));
            $allowed = ['png', 'jpg', 'jpeg'];
            if (in_array($image_file_type, $allowed)) {
                $path = Yii::getAlias('@frontend/web/img/' . $dirname);
                $base_name = Yii::$app->security->generateRandomString(15);
                $file = $base_name . '.' . $img->extension;
                $path = $path . "/" . $file;
                $img->saveAs($path);
                $answer_arr = [
                    'status' => true,
                    'path' => 'img/' . $dirname . '/' . $file,
                    'full_path' => 'http://dym:8888/img/' . $dirname . '/' . $file,
                    'message' => 'Изображение сохранено'
                ];
                return json_encode($answer_arr);
            }

        }
        $answer_arr = [
            'status' => false,
            'message' => 'Произошла ошибка'
        ];
        $answer = json_encode($answer_arr);
        return $answer;
    }
}
