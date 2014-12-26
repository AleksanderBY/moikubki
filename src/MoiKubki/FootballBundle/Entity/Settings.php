<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 22.12.14
 * Time: 11:32
 */

namespace MoiKubki\FootballBundle\Entity;

/**
 *
 * настройки турнира для сохранения в БД
 *
 * v - очки за победу
 * n - очки за ничью
 * p -  очки за поражение
 * u - число команд учасниц
 *
 */
class Settings {
    public $v;
    public $n;
    public $p;
    public $u;
}