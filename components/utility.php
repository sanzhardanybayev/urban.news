<?php

namespace app\components;

use app\models\Events;


/**
 * Class utility defines static utility functions aimed to make programming more efficient and elegant
 * @package app\components
 */
class utility
{

  /**
   * This function prettifies PHP's native function var_dump()
   * @param mixed $value
   * @return html
   */
  public static function dd($value)
  {
    echo "<pre>";
    echo var_dump($value);
    echo "</pre>";
    exit();
  }

  static $events_names = [
      '1' => 'Добавление новости',
      '2' => 'Удаление новости',
      '3' => 'Пулбикация новости',
      '4' => 'Смена заголовка новости',
      '5' => 'Смена содержания новости',
      '6' => 'Смена описания новости',
      '7' => 'Смена превью новости',
      '8' => 'Создание пользователя',
      '9' => 'Удаление пользователя',
      '10' =>'Блокироване пользователя',
      '11' => 'Смена пароля',
      '12' => 'Обновление почты',
      '13' => 'Обновление логина',
      '14' => 'Обновление имени',
      '15' => 'Обновления описания',
      '16' => 'Обновление сайта',
      '17' => 'Обновление публичной почты',
      '18' => 'Обновление фото пользователя'
  ];

  /** This function replaces templates words with context ones */
  public static function replaceTemplateWordsWithContextWords($templateWords, $templateWordsValues, $stringToChange)
  {
    for ($i = 0; $i < sizeof($templateWords); $i++) {
      ($i == 0) ? $i++ : '';
      $stringToChange = str_replace($templateWords[$i], $templateWordsValues[$templateWords[$i]], $stringToChange);
    }
    return $stringToChange;
  }

  public static function replaceUsernameWithRealName($name,$stringToChange){
    if (strpos($stringToChange, '$username') !== false) {
      return  str_replace('$username', $name , $stringToChange);
    }
  }

  public static function returnEventIdByEventName($eventName)
  {
    $eventInstances = Events::find()->select(['id', 'name'])->all();
    foreach ($eventInstances as $eventInstance) {
      if ($eventInstance->name == $eventName) {
        return $eventInstance->id;
      }
    }
    return 'Событие - ' . $eventName . ' не найдено';
  }
}