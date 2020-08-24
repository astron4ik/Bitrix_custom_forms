<?
/*
	Для подключения файла с обработчиками, добавить блок в init.php
	if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/hundler_event.php"))
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/hundler_event.php");
*/

//Обработчик, добавляет наблюдателей после создания задачи на конкретного пользователя *Отключен*
/*AddEventHandler("tasks", "OnTaskAdd", "AddAuditorsTask");
function AddAuditorsTask(&$ID ,&$arFields)
{
	if($arFields['RESPONSIBLE_ID'] == 232)
	{
		//var_dump($arFields);
		//die;

		//Список наблюдателей
		$arAuditors = array(6, 7, 10);
		//Добавляем наблюдателей в задачу
		CTasks::AddAuditors($ID, $arAuditors);
	}
}
*/
//Обработчик, запрет создавать задачи на других сотрудников
AddEventHandler("tasks", "OnBeforeTaskAdd", "BlockЕaskСreation"); 
function BlockЕaskСreation(&$arFields)
{
	if ($arFields['CREATED_BY'] == 149)
		if($arFields['RESPONSIBLE_ID'] != 149)
		{
			ShowError("Запрещено назначать задачи на других пользователй, кроме себя.\nОбновите страницу");
			die;
		}
}

//Обработчик для чатов
AddEventHandler("im", "OnBeforeChatMessageAdd", "ActiveInformChannel");
function ActiveInformChannel($arFields)
{
	global $USER;

	//Только админы портала могут писать в чат "Информационный канал службы IT"
    if($arFields['TO_CHAT_ID'] == '638')
    {
        if ($USER->GetID() != '277')
        {
            if (!$USER->IsAdmin())
		    {
			    return Array(
                    'reason' => 'Вы не можете писать в данный чат. По вопросам AX и ИТ обращатся к сотрудникам соответствующих отделов.',
                    'result' => false,
                );
		    }
        }
	}

	//Пользователям из группы, для указанного чата, доступно только чтение.
	if($arFields['TO_CHAT_ID'] == '616')
    {
		$arGroups = CUser::GetUserGroup($USER->GetID()); //Получение групп пользователя в виде массива
		$group_id = 20;//ИД группы
		if (in_array($group_id, $arGroups)) //Проверка, что пользователь есть в группе
		{
			return Array(
                'reason' => 'Вы не можете писать в данный чат',
                'result' => false,
            );
		}

	}


}

/*** Запрет комментирования завершенных задач  ***/
/*AddEventHandler("forum", "onBeforeMessageAdd", "TestTask");
function TestTask($arEventFields)
{
	if (CModule::IncludeModule("tasks") && !empty($arEventFields['XML_ID']))
	{
		preg_match('#TASK_([0-9]+)#', $arEventFields['XML_ID'], $matches);
		if($matches[1])
		{
		    $rsTask = CTasks::GetByID($matches[1]);
		    if ($arTask = $rsTask->GetNext())
		    {
		    	if($arTask['REAL_STATUS'] == CTasks::STATE_COMPLETED)
		    	{
		    		global $APPLICATION;
					$APPLICATION->ThrowException('Задача завершена. Комментирование недоступно!'); 
		    		return false;
		    	}
		    }
		}
	}
}*/

/*** Запрет редактирования завершенных задач  ***/
AddEventHandler("tasks", "OnBeforeTaskUpdate", "OBTaskUpdate");
function OBTaskUpdate($ID, $arEventFields, $arTaskCopy)
{
	if(!isset($arEventFields['STATUS']) && $arTaskCopy['REAL_STATUS'] == CTasks::STATE_COMPLETED)
	{
		global $APPLICATION;
		$APPLICATION->ThrowException('Задача завершена. Редактирование недоступно!'); 
		return false;
	}
}

/*** Запрет создания подзадач для завершенных задач  ***/
AddEventHandler("tasks", "OnBeforeTaskAdd", "OBTaskAdd");
function OBTaskAdd($arEventFields)
{
	if($arEventFields['PARENT_ID'])
	{
		$rsTask = CTasks::GetByID($arEventFields['PARENT_ID']);
	    if ($arTask = $rsTask->GetNext())
	    {
	    	if($arTask['REAL_STATUS'] == CTasks::STATE_COMPLETED)
	    	{
	    		global $APPLICATION;
				$APPLICATION->ThrowException('Родительская задача завершена. Нельзя создать подзадачу!'); 
	    		return false;
	    	}
	    }
	}
}
?>