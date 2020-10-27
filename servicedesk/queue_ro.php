<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Список заявок в Тех. Поддержку");
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
			"GROUP_ID" => "88",
			"REAL_STATUS" => array(CTasks::STATE_NEW, CTasks::STATE_PENDING, CTasks::STATE_IN_PROGRESS))
		);

	// Таблица для отображения списка задач
	echo '<table class="intask-main data-table">';
	echo '<legend>Список задач в ТехПоддержке: </legend>';
	echo '<thead>';
	echo '<tr class=\"intask-row selected\">
			<td class=\"intask-cell\">№ Задачи</td>
			<td class=\"intask-cell\">Время создания</td>
			<td class=\"intask-cell\">Постановщик</td>
			<td class=\"intask-cell\">Задача</td>
			<td class=\"intask-cell\">Ответственный</td>
			<td class=\"intask-cell\">Крайний срок</td>
		</tr>';
	echo '</thead>';
	
	while ($arTask = $res->GetNext()) 
	{
		if ($arTask != null)
		{
			if ($arTask['PRIORITY'] == 2)
			{
				echo "<form>";
				echo "<tr class=\"intask-row\">";
				echo "<td class=\"intask-cell\"><font color=\"red\">".$arTask['ID']."</font></td>";
				echo "<td class=\"intask-cell\"><font color=\"red\">".$arTask['CREATED_DATE']."</font></td>";
				echo "<td class=\"intask-cell\"><font color=\"red\">".$arTask['CREATED_BY_LAST_NAME'], " ", $arTask['CREATED_BY_NAME'], " ",$arTask['CREATED_BY_SECOND_NAME']."</font></td>";
				echo "<td class=\"intask-cell\"><a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/",$arTask['ID'],"/\">",$arTask['TITLE'],"</a></td>";
				echo "<td class=\"intask-cell\"><font color=\"red\">".$arTask['RESPONSIBLE_LAST_NAME'], " ", $arTask['RESPONSIBLE_NAME'], " ",$arTask['RESPONSIBLE_SECOND_NAME']."</font></td>";
				echo "<td style=\"min-width: 100px;\" class=\"intask-cell\"><font color=\"red\">".$arTask['DEADLINE']."</font></td>";
				echo "</tr>";
				echo "</form>";
			}
			else
			{
				echo "<form><font color=\"red\">";
				echo "<tr class=\"intask-row\">";
				echo "<td class=\"intask-cell\">".$arTask['ID']."</td>";
				echo "<td class=\"intask-cell\">".$arTask['CREATED_DATE']."</td>";
				echo "<td class=\"intask-cell\">".$arTask['CREATED_BY_LAST_NAME'], " ", $arTask['CREATED_BY_NAME'], " ",$arTask['CREATED_BY_SECOND_NAME']."</td>";
				echo "<td class=\"intask-cell\"><a href=\"https://in.autokontinent.ru/company/personal/user/", $USER->GetID(),"/tasks/task/view/",$arTask['ID'],"/\">",$arTask['TITLE'],"</a></td>";
				echo "<td class=\"intask-cell\">".$arTask['RESPONSIBLE_LAST_NAME'], " ", $arTask['RESPONSIBLE_NAME'], " ",$arTask['RESPONSIBLE_SECOND_NAME']."</td>";
				echo "<td style=\"min-width: 100px;\" class=\"intask-cell\">".$arTask['DEADLINE']."</td>";
				echo "</tr>";
				echo "</font></form>";
			}
		}
	}
	echo '</table>';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
