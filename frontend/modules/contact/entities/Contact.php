<?php

namespace app\modules\contact\entities;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $name
 * @property string $mail
 * @property string $body
 * @property string $created_at
 */
class Contact extends \yii\db\ActiveRecord
{
    public $reCaptcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body', 'name', 'mail'], 'required'],
            [['body'], 'string', 'min' => 10],
            [['created_at'], 'safe'],
            [['name', 'mail'], 'string', 'max' => 255],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6Lel0qcUAAAAAO9VlDAnsOtLOHEbsPAyFYpzqO3Y']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'mail' => 'Почта',
            'body' => 'Сообщение',
            'created_at' => 'Дата',
        ];
    }

    public function contact($mail)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($mail)
                ->setFrom([$this->mail => $this->name])
                ->setSubject('Обращение из контактной формы')
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
