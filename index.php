<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 24.04.2019
 * Time: 23:26
 */

ini_set('display_errors', 1);
require_once 'application/core/model.php';
require_once 'application/core/view.php';
require_once 'application/core/controller.php';

/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/
require_once 'application/core/route.php';
Route::start(); // запускаем маршрутизатор