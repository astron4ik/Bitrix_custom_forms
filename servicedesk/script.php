<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?php

global $APPLICATION;

//Функция отладки массива
function debug()
{
	echo "<pre>";
	echo print_r($_POST);
	echo "</pre>";
}

// Функция "Заявка в ТП"
function create_request()
{
	global $USER;
	
	// Назначение ответственного для задачи
	if ($_POST['app'] == 'site')
	{
		$RESPONSIBLE_ID = 118; // По сайту, на Максима Лютова
		$addTitle = '[Сайт]';
		
		// Список наблюдателей
		$arAuditors = array(35, $USER->GetID()); // Авдеев
		
		// Теги к задаче
		$Tags = 'WEBServiceDesk';
	}
	elseif ($_POST['app'] == 'wms')
	{
		$RESPONSIBLE_ID = 232; // WMS - на очередь
		$addTitle = '[WMS Solvo]';
		
		//Список наблюдателей
		$arAuditors = array(98, 31, 277, $USER->GetID()); // Макаров, Кириченко, Ратникова
		
		// Теги к задаче
		$Tags = 'WMSServiceDesk';
	}
	elseif ($_POST['app'] == 'ax')
	{
		$RESPONSIBLE_ID = 232; // AX - на очередь
		$addTitle = '[MSDAX Axapta]';
		
		//Список наблюдателей
		$arAuditors = array(98, 31, 277, $USER->GetID()); // Макаров, Кириченко, Ратникова
		
		// Теги к задаче
		$Tags = 'DAXServiceDesk';
	}
	
	//Формироване дейдлайна
	$deadline = date('d.m.Y H:i:s', strtotime($Realtime.' +2 hours'));
	
	//Формирование заголовка задачи
	ob_start();
	echo "[ТехПоддержка]-", $addTitle, "-", $_POST['small_description'];
	$TitleVar = ob_get_contents();
	ob_end_clean();
	
	//Формирование описание задачи
	ob_start();
	echo "<b>Программа</b>: ", $addTitle, "<br>",
		"<b>Описание проблемы</b>: ", $_POST['description'], "<br>",
		"<b>Тег</b>: ", $Tags, "<br>";
	$TaskDescription = ob_get_contents();
	ob_end_clean();
	
	//массив структуры задачи
	$arFields = Array(
		"TITLE" => $TitleVar,
		"SITE_ID" => "s1",
		"DESCRIPTION" => $TaskDescription,
		"RESPONSIBLE_ID" => $RESPONSIBLE_ID,
		"AUDITORS" => $arAuditors,
		"CREATED_BY" => $USER->GetID(),
		"DEADLINE" => $deadline,
		"TAGS" => $Tags,
		"TASK_CONTROL" => "Y",
		"ALLOW_CHANGE_DEADLINE" => "Y"
    );
	
	//Добавление задачи и получение ID
	$obTask = new CTasks;
	$ID = $obTask->Add($arFields);

	echo '<pre>';
	echo "Задача в Тех. Поддержку создана: ", $ID, "<br>";
	echo "Ссылка на задачу: <a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/", $ID, "/\">Здесь</a>";
	echo "А так же, вы можете посмотреть задачи в очереди: <a href=\"https://in.autokontinent.ru/servicedesk/queue.php\">Здесь</a>";
}

//Обработка вызова функции дебага
if (isset($_POST['debug_button']))
{
	$APPLICATION->SetTitle("Debug Page");
	debug();
}

// Обработка вызова функции "Заявка в ТП"
if (isset($_POST['request']))
{
	$APPLICATION->SetTitle("Заявка создана");
	create_request();
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
