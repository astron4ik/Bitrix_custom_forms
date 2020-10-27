<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Инструмент для работы с очередью задач");
if (CModule::IncludeModule("tasks"))
{
	global $USER;
	
	// Получаем список активных задач на очереди - Пользователь: Тех. Поддержка (232)
	$res = CTasks::GetList(
        Array(
			"PRIORITY" => "DESC",
			"DEADLINE" => "ASC"
		), 
        Array(
			"RESPONSIBLE_ID" => "232",
			"REAL_STATUS" => array(CTasks::STATE_NEW, CTasks::STATE_PENDING, CTasks::STATE_IN_PROGRESS))
		);

	// Делегирование задачи на ответственного в отделе
	if ($_POST['getTask']) 
	{
		$arFields = Array("RESPONSIBLE_ID" => $USER->GetID());
		$obTask = new CTasks;
		$success = $obTask->Update($_POST['id'], $arFields);
		if($success)
		{
			echo '<pre>';
			echo "Вы можете начать работу по задаче.<br>";
			echo "Ссылка на задачу: <a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/", $_POST['id'], "/\">Здесь</a>";
			die();
		}
		else
		{
			if($e = $APPLICATION->GetException())
			echo "Error: ".$e->GetString();
		}
	}
	else {
		echo "Вы можете получить любую задачу из очереди";
	}

	// Таблица для отображения списка задач
	echo '<table class="intask-main data-table">';
	echo '<legend>Список задач в очереди: </legend>';
	echo '<thead>';
	echo '<tr class=\"intask-row selected\">
			<td class=\"intask-cell\">№ Задачи</td>
			<td class=\"intask-cell\">Время создания</td>
			<td class=\"intask-cell\">Постановщик</td>
			<td class=\"intask-cell\">Задача</td>
			<td class=\"intask-cell\">Крайний срок</td>
			<td>Действие</td>
		</tr>';
	echo '</thead>';

	while ($arTask = $res->GetNext()) 
	{
		if ($arTask != null)
		{
			if ($arTask['PRIORITY'] == 2)
			{
				echo '<form action=/servicedesk/queue.php method="post">';
				echo "<tr class=\"intask-row\">";
				echo "<td class=\"intask-cell\"><font color=\"red\">".$arTask['ID']."</font></td>";
				echo "<td class=\"intask-cell\"><font color=\"red\">".$arTask['CREATED_DATE']."</font></td>";
				echo "<td class=\"intask-cell\"><font color=\"red\">".$arTask['CREATED_BY_LAST_NAME'], " ", $arTask['CREATED_BY_NAME'], " ",$arTask['CREATED_BY_SECOND_NAME']."</font></td>";
				echo "<td class=\"intask-cell\"><a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/",$arTask['ID'],"/\">",$arTask['TITLE'],"</a></td>";
				echo "<td style=\"min-width: 100px;\" class=\"intask-cell\"><font color=\"red\">".$arTask['DEADLINE']."</td>";
				echo "<input type=\"hidden\" name=\"id\" value=\"".$arTask['ID']."\">";
				echo "<td class=\"intask-cell\"><button class=\"ui-btn ui-btn-themes ui-btn-icon-setting ui-btn-icon-task tasks-quick-form-button\" type=\"submit\" style=\"cursor:pointer;\" name=\"getTask\" value=\"getTask\"/>Начать работу по задаче</button></td>";
				echo "</tr>";
				echo "</form>";
			}
			else
			{
				echo '<form action=/servicedesk/queue.php method="post">';
				echo "<tr class=\"intask-row\">";
				echo "<td class=\"intask-cell\">".$arTask['ID']."</td>";
				echo "<td class=\"intask-cell\">".$arTask['CREATED_DATE']."</td>";
				echo "<td class=\"intask-cell\">".$arTask['CREATED_BY_LAST_NAME'], " ", $arTask['CREATED_BY_NAME'], " ",$arTask['CREATED_BY_SECOND_NAME']."</td>";
				echo "<td class=\"intask-cell\"><a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/",$arTask['ID'],"/\">",$arTask['TITLE'],"</a></td>";
				echo "<td style=\"min-width: 100px;\" class=\"intask-cell\">".$arTask['DEADLINE']."</td>";
				echo "<input type=\"hidden\" name=\"id\" value=\"".$arTask['ID']."\">";
				echo "<td class=\"intask-cell\"><button class=\"ui-btn ui-btn-themes ui-btn-icon-setting ui-btn-icon-task tasks-quick-form-button\" type=\"submit\" style=\"cursor:pointer;\" name=\"getTask\" value=\"getTask\"/>Начать работу по задаче</button></td>";
				echo "</tr>";
				echo "</form>";
			}
		}
	}
	echo '</table>';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
