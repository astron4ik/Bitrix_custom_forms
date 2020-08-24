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

//Функция "Заявки на оплату"
function OSN()
{
	global $USER;

	//Список наблюдателей
	$arAuditors = array(11, 54, 172, $USER->GetID());

	//Формироване дейдлайна
	$deadline = date('d.m.Y H:i:s', strtotime($Realtime.' +2 hours'));

	//Формирование заголовка задачи
	ob_start();
	echo "Заявка на оплату";
	$TitleVar = ob_get_contents();
	ob_end_clean();

	//Формирование описание задачи
	ob_start();
	echo "<b>Статья затрат</b>: ", $_POST['article-name'], "<br>",
		"<b>Примечание</b>: ", $_POST['article-info'], "<br>",
		"<b>Сумма</b>: ", $_POST['article-sum'], "<br>";
	$TaskDescription = ob_get_contents();
	ob_end_clean();

	//массив структуры задачи
	$arFields = Array(
		"TITLE" => $TitleVar,
		//"DESCRIPTION_IN_BBCODE" => "Y",
		"SITE_ID" => "s1",
		"DESCRIPTION" => $TaskDescription,
		"RESPONSIBLE_ID" => 15,
		"AUDITORS" => $arAuditors,
		"CREATED_BY" => $USER->GetID(),
		"DEADLINE" => $deadline,
    );

	//Добавление задачи и получение ID
	$obTask = new CTasks;
	$ID = $obTask->Add($arFields);

	echo '<pre>';
	echo "Задача \"Заявка на оплату\" создана: ", $ID, "<br>";
	echo "Ссылка на задачу: <a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/", $ID, "/\">Здесь</a>";
}

//Функция "Увольнение пользователя"
function rmUser()
{
	global $USER;

	//Список наблюдателей
	$arAuditors = array(6, 10, 348, $USER->GetID());

	//Формироване дейдлайна
	$deadline = date('d.m.Y H:i:s', strtotime($Realtime.' +1 day'));

	//Формирование заголовка задачи
	ob_start();
	echo "Увольнение сотрудника: ", $_POST['rmFIO'];
	$TitleVar = ob_get_contents();
	ob_end_clean();

	//Формирование описание задачи
	ob_start();
	echo "<b>ФИО Сотрудника</b>: ", $_POST['rmFIO'], "<br>",
		"<b>Что делаем с почтой</b>: ", $_POST['selectmail'], "<br>",
		"<b>Переадресация на сотрудника</b>: ", $_POST['RESentUser'], "<br>",
		"<b>Что делаем с документами пользователя в битриксе</b>: ", $_POST['bxdisk'], "<br>",
		"<b>Примечание</b>: ", $_POST['rmcomment'], "<br>";
	$TaskDescription = ob_get_contents();
	ob_end_clean();

	//массив структуры задачи
	$arFields = Array(
		"TITLE" => $TitleVar,
		//"DESCRIPTION_IN_BBCODE" => "Y",
		"TASK_CONTROL" => "Y",
		"SITE_ID" => "s1",
		"DESCRIPTION" => $TaskDescription,
		"RESPONSIBLE_ID" => 7,
		"AUDITORS" => $arAuditors,
		"CREATED_BY" => $USER->GetID(),
		"DEADLINE" => $deadline,
    );

	//Добавление задачи и получение ID
	$obTask = new CTasks;
	$ID = $obTask->Add($arFields);

	echo '<pre>';
	echo "Задача \"Увольнение сотрудника\" создана: ", $ID, "<br>";
	echo "Ссылка на задачу: <a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/", $ID, "/\">Здесь</a>";
}

//Новый сотрудник
function AddUser()
{
	global $USER;

	//Формирование наблюдателей
	$arAuditors = array(6, 10, 348, $USER->GetID());

	//Формирование даты Dealine
	/*$Date_SubDay = date("d.m.Y", strtotime($_POST['date'].' -1 day'));
	ob_start();
	echo $Date_SubDay, " 12:00:00";
	$DataTime_Deadline = ob_get_contents();
	ob_end_clean();*/
	$deadline = date('d.m.Y H:i:s', strtotime($Realtime.' +1 day'));


	//Формирование описание задачи 
	ob_start();
	echo "<b>Фамилия Имя Отчество</b>: ", $_POST['FIO'], "<br>",
		"<b>Подразделение в Корпоративном портале</b>: ", $_POST['departament'], "<br>",
		"<b>Руководитель</b>: ", $_POST['chief'], "<br>",
		"<b>Должность</b>: ", $_POST['position'], "<br>",
		"<b>Телефон</b>: ", $_POST['tel'], "<br>",
		"<b>Дата выхода на работу</b>: ", $_POST['date'], "<br>",
		"<b>Офис</b>: ", $_POST['floor'], "<br>",
		"<b>Примечание</b>: ", $_POST['addcomment'], "<br>",
		"<br>---Список доступов---<br>",
		"<b>Почта</b>: ", $_POST['mail'], "<br>",
		"<b>DAX Axapta</b>: ", $_POST['Axapta'], "<br>",
		"<b>Права в Axapte как у пользователя</b>: ", $_POST['AsUser'], "<br>",
		"<b>WMS Solvo</b>: ", $_POST['solvo'], "<br>",
		"<b>VPN</b>: ", $_POST['vpn'], "<br>";
	$TaskDescription = ob_get_contents();
	ob_end_clean();

	//массив структуры задачи
	$arFields = Array(
		"TITLE" => "Создание нового пользователя",
		//"DESCRIPTION_IN_BBCODE" => "Y",
		"TASK_CONTROL" => "Y",
		"SITE_ID" => "s1",
		"DESCRIPTION" => $TaskDescription,
		"RESPONSIBLE_ID" => 7,
		"AUDITORS" => $arAuditors,
		"CREATED_BY" => $USER->GetID(),
		"DEADLINE" => $deadline,
    );

	//Добавление задачи и получение ID
	$obTask = new CTasks;
	$ID = $obTask->Add($arFields);

	echo '<pre>';
	echo "Задача создана с номером: ", $ID, "<br>";
	echo "Ссылка на задачу: <a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/", $ID, "/\">Здесь</a>";
	echo '<br /> ----';
}

//Обработка вызова функции дебага
if (isset($_POST['debug_button']))
{
	$APPLICATION->SetTitle("Debug Page");
	debug();
}

//Обработка вызова функции "Заявки на оплату"
if (isset($_POST['osn']))
{
	$APPLICATION->SetTitle("Заявка создана");
	OSN();
}

//Обработка вызова функции "Увольнение сотрудника"
if (isset($_POST['remove_user']))
{
	$APPLICATION->SetTitle("Заявка создана");
	rmUser();
}

//Обработка вызова функции "Принятие сотрудника на работу"
if (isset($_POST['add_user']))
{
	$APPLICATION->SetTitle("Заявка создана");
	AddUser();
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>