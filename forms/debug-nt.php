<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("debug_nt");
if (CModule::IncludeModule("im"))
{
	$rsTask = array();
	$CIMNElement = new CIMNotify;
	$NotifyCounter = $CIMNElement->GetNotifyCounter();

	for ($i = 1; $i <= 10; $i++)
	{
		$arParams['PAGE'] = $i;
		$result = $CIMNElement->GetNotifyList($arParams);
		$rsTask = $rsTask + $result;
	}

	//$rsTask2 = $CIMNElement->GetUnreadNotify();

	$value = reset($rsTask);
	$NoDublicat = array();

	echo "<pre>";
	echo print_r($rsTask);
	echo "</pre>";

	/*echo '<table border="2">';
	echo '<legend>Список уведомлений. Количество уведомлений: '.NotifyCounter.' </legend>';
	echo '<tr><td>№№</td><td>UserName</td><td>text</td><td>time</td><td>date</td><td>idTask</td><td>Действие</td></tr>';
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
					echo '<form action="alex.php" method="post">';
					echo "<tr>";
					echo "<td>".$rsTask[$row]['id']."</td>";
					echo "<td>".$rsTask[$row]['userName']."</td>";
					echo "<td style=\"max-width: 200px;\">".$rsTask[$row]['text']."</td>";
					echo "<td>".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "HH:MI")))."</td>";
					echo "<td style=\"min-width: 150px;\">".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD-MM-YYYY")))."</td>";
					echo "<td>".$rsTask[$row]['TaskID']."</td>";
					echo "<td><input type=\"submit\" value=\"Прочитать все уведомления по задаче\"/></td>";
					echo "</tr>";
					echo "</form>";
				}
			}
		}
}*/
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>