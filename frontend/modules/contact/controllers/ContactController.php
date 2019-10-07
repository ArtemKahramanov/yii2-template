<?php

namespace app\modules\contact\controllers;

use app\components\SendTelegram;
use app\modules\contact\entities\Contact;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `contact` module
 */
class ContactController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSend()
    {
        $entity = new Contact();
        $answer['status'] = false;
        if ($entity->load(Yii::$app->request->post())) {
            $entity->save();
            $text = "Обращение из контактной формы 
            Телефон: $entity->mail, 
            Имя: $entity->name, 
            Сообщение: $entity->body
            ";
            sendTelegram::messageToTelegram($text);
            $answer['status'] = true;
            return json_encode($answer);
        }
        return json_encode($answer);
    }

}
