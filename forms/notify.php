<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Инструмент для работы с уведомлениями");
if (CModule::IncludeModule("im"))
{
	$rsTask = array();
	$CIMNElement = new CIMNotify;
	$rsTask = $CIMNElement->GetNotifyList();
	$NotifyCounter = $CIMNElement->GetNotifyCounter();
	$value = reset($rsTask);
	$NoDublicat = array();

	for ($i = 1; $i <= 15; $i++)
	{
		$arParams['PAGE'] = $i;
		$result = $CIMNElement->GetNotifyList($arParams);
		$rsTask = $rsTask + $result;
	}

	if ($_POST['id']) {
		for ($row = $value['id']; $row > 0; $row--) {
			if ($rsTask[$row] != null) {
				if ($rsTask[$row]['read'] == N) {
					$idTask2= explode("|", $rsTask[$row]['originalTag']);
					if ($idTask2[2] == $_POST['id']) {
						$SetReadNotifity = $CIMNElement->MarkNotifyRead($rsTask[$row]['id']);
					}
				}
			}
		}
		header("Location:https://in.autokontinent.ru/forms/notify.php");
	}
	else {
		echo "Выберите строку для удаления уведомлений по задаче";
	}

	echo '<table class="intask-main data-table">';
	echo '<legend>Список уведомлений. Количество уведомлений: '.$NotifyCounter.' </legend>';
	echo '<thead>';
	echo '<tr class=\"intask-row selected\">
			<td class=\"intask-cell\">№</td>
			<td class=\"intask-cell\">UserName</td>
			<td class=\"intask-cell\">text</td>
			<td class=\"intask-cell\">time</td>
			<td class=\"intask-cell\">date</td>
			<td class=\"intask-cell\">idTask</td>
			<td>Действие</td>
		</tr>';
	echo '</thead>';
	for ($row = $value['id']; $row > 0; $row--) 
	{
		if ($rsTask[$row] != null)
		{
			$idTask= explode("|", $rsTask[$row]['originalTag']);
			$rsTask[$row]['TaskID'] = $idTask[2];
			if ($rsTask[$row]['read'] == N)
			{
				if (in_array($rsTask[$row]['TaskID'], $NoDublicat) != true)
				{
					$NoDublicat[] = $rsTask[$row]['TaskID'];
					echo '<form action=/forms/notify.php method="post">';
					echo "<tr class=\"intask-row\">";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['id']."</td>";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['userName']."</td>";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['text']."</td>";
					echo "<td style=\"min-width: 100px;\" class=\"intask-cell\">".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "HH:MI")))."</td>";
					echo "<td style=\"min-width: 100px;\"  class=\"intask-cell\">".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD-MM-YYYY")))."</td>";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['TaskID']."</td>";
					echo "<input type=\"hidden\" name=\"id\" value=\"" . $rsTask[$row]['TaskID'] . "\">";
					echo "<td class=\"intask-cell\"><button class=\"ui-btn ui-btn-themes ui-btn-icon-setting ui-btn-icon-task tasks-quick-form-button\"
type=\"submit\" style=\"cursor:pointer;\" value=\"Прочитать все уведомления по задаче\"/>Прочитать все уведомления по задаче</button></td>";
					echo "</tr>";
					echo "</form>";
				}
			}
		}
	}
	echo '</table>';
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>