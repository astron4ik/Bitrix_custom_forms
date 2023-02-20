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

	function bbc2html($content) {
		$search = array (
		'/(\[b\])(.*?)(\[\/b\])/',
		'/(\[i\])(.*?)(\[\/i\])/',
		'/(\[u\])(.*?)(\[\/u\])/',
		'/(\[ul\])(.*?)(\[\/ul\])/',
		'/(\[li\])(.*?)(\[\/li\])/',
		'/(\[URL=)(.*?)(\])(.*?)(\[\/URL\])/',
		'/(\[URL\])(.*?)(\[\/URL\])/',
		'/(\[url=)(.*?)(\])(.*?)(\[\/url\])/',
		'/(\[url\])(.*?)(\[\/url\])/'
	);

 	$replace = array (
		'<strong>$2</strong>',
		'<em>$2</em>',
		'<u>$2</u>',
		'<ul>$2</ul>',
		'<li>$2</li>',
		'<a href="$2" target="_blank">$4</a>',
		'<a href="$2" target="_blank">$2</a>',
		'<a href="$2" target="_blank">$4</a>',
		'<a href="$2" target="_blank">$2</a>'
	);

	return preg_replace($search, $replace, $content);
	}

	for ($i = 1; $i <= 50; $i++)
	{
		$arParams['PAGE'] = $i;
		$result = $CIMNElement->GetNotifyList($arParams);
		$rsTask = $rsTask + $result;
	}

	Bitrix\Main\Diag\Debug::writeToFile(array('fields'=>$_GET),"","/log/handler_log_1");

	/*if ($_GET['id']) {
		Bitrix\Main\Diag\Debug::writeToFile(array('fields'=>$_GET['id']),"","/log/handler_log_2");
		for ($row = $value['id']; $row > 0; $row--) {
			if ($rsTask[$row] != null) {
				if ($rsTask[$row]['read'] == "N") {
					$idTask2= explode("|", $rsTask[$row]['originalTag']);
					if ($idTask2[2] == $_POST['id']) {
						$SetReadNotifity = $CIMNElement->MarkNotifyRead($rsTask[$row]['id']);
					}
				}
			}
		}
		header("Location:https://192.168.40.220/forms/notify.php");
		
	}
	*/if ($_GET['arTaskIdNotifyRead']) {
		$arVar = $_GET['arTaskIdNotifyRead'];
		Bitrix\Main\Diag\Debug::writeToFile(array('fields'=>$arVar),"","/log/handler_log_3");
		foreach ($arVar as $idTaskNotify) {
			
			for ($row = $value['id']; $row > 0; $row--) {
				if ($rsTask[$row] != null) {
					if ($rsTask[$row]['read'] == "N") {
						$idTask2= explode("|", $rsTask[$row]['originalTag']);
						if ($idTask2[2] == $idTaskNotify) {
							$SetReadNotifity = $CIMNElement->MarkNotifyRead($rsTask[$row]['id']);
						}
					}
				}
			}
		}
		header("Location:https://192.168.40.220/forms/notify.php");
	}
	else {
		echo "</br>";
	}

	echo '<script type="text/javascript">
	function SelectAll()
	{
		var checkboxs = document.getElementsByName(\'arTaskIdNotifyRead[]\');
		var bt_checkbox = document.getElementById(\'chnt\');
		for(var i in checkboxs){
			if(bt_checkbox.value == \'select\'){
				checkboxs[i].checked = \'FALSE\';
				if (i == checkboxs.length - 1){
					bt_checkbox.value = \'deselect\';
				}
			}
			else {
				checkboxs[i].checked = \'\';
				if (i == checkboxs.length - 1){
					bt_checkbox.value = \'select\';
				}
			}
		}
	}
	</script>';
	


	echo '<form action=/forms/notify.php method="get">';
	echo '<div style="display: flex;justify-content: flex-end;"><div style="text-align: right;">
		<input type="checkbox" id="chnt" name="all_check" onclick="SelectAll()" value="select"><label for="chnt">Отметить все</label>
		</div>';
	echo '<div style="text-align: right;margin-left: 10px;">
		<button class="ui-btn ui-btn-themes ui-btn-icon-setting ui-btn-icon-task tasks-quick-form-button" type="submit" style="cursor:pointer;" value=""/>Прочитать</button>
</div></div>';
	echo '<table class="intask-main data-table">';
	echo '<legend>Список уведомлений.</legend>';
	echo '<thead>';
	echo '<tr class=\"intask-row selected\">
		<td class=\"intask-cell\">№</td>
		<td class=\"intask-cell\">UserName</td>
		<td class=\"intask-cell\">text</td>
		<td class=\"intask-cell\">time</td>
		<td class=\"intask-cell\">date</td>
		<td class=\"intask-cell\">idTask</td>';
	echo '<td class="intask-cell">
		</td>';
	//echo '<td>Действие</td>';
	echo '</tr>';
	echo '</thead>';

	for ($row = $value['id']; $row > 0; $row--) 
	{
		if ($rsTask[$row] != null)
		{
			$idTask= explode("|", $rsTask[$row]['originalTag']);
			$rsTask[$row]['TaskID'] = $idTask[2];
			if ($rsTask[$row]['read'] == "N" && $rsTask[$row]['settingName'] != "bizproc|activity")
			{
				if (in_array($rsTask[$row]['TaskID'], $NoDublicat) != true)
				{
					$NoDublicat[] = $rsTask[$row]['TaskID'];
					echo "<tr class=\"intask-row\">";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['id']."</td>";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['userName']."</td>";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['text_converted']."</td>";
					echo "<td style=\"min-width: 100px;\" class=\"intask-cell\">".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "HH:MI")))."</td>";
					echo "<td style=\"min-width: 100px;\"  class=\"intask-cell\">".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD-MM-YYYY")))."</td>";
					echo "<td class=\"intask-cell\">".$rsTask[$row]['TaskID']."</td>";
					echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"arTaskIdNotifyRead[]\" value=\"". $rsTask[$row]['TaskID'] ."\" /></td>";
					//echo "<input type=\"hidden\" name=\"id\" value=\"" . $rsTask[$row]['TaskID'] . "\">";
					//echo "<td class=\"intask-cell\"><button class=\"ui-btn ui-btn-themes ui-btn-icon-setting ui-btn-icon-task tasks-quick-form-button\"
						//type=\"submit\" style=\"cursor:pointer;\" value=\"Прочитать все уведомления по задаче\"/>Прочитать все</button></td>";
					echo "</tr>";
					
				}
			}
		}
	}
	echo '</form>';
	echo '</table>';

	if ($_POST['id_BP']) {
		$bp_id_notify = $_POST['id_BP'];
		for ($row = $value['id']; $row > 0; $row--) {
			if ($rsTask[$row]['id'] == $bp_id_notify)
			{
				if ($rsTask[$row]['read'] == N) {
					//Bitrix\Main\Diag\Debug::writeToFile(array('fields'=>$rsTask[$row]['id']),"","/log/handler_log_2");
					$SetReadNotifity = $CIMNElement->MarkNotifyRead($rsTask[$row]['id']);
					break;
				}
			}
		}
		header("Location:https://192.168.40.220/forms/notify.php");
	}
	else {
		echo "</br>";
	}

	echo '<br><table class="intask-main data-table">';
	echo '<legend>Список служебных уведомлений.</legend>';
	echo '<thead>';
	echo '<tr class="intask-row selected">
			<td class="intask-cell">№</td>
			<td class="intask-cell">UserName</td>
			<td class="intask-cell">text</td>
			<td class="intask-cell">time</td>
			<td class="intask-cell">date</td>
			<td>Действие</td>
		</tr>';
	echo '</thead>';
	echo '<form action=/forms/notify.php method="post">';
	for ($row = $value['id']; $row > 0; $row--) 
	{
		if ($rsTask[$row] != null)
		{
			$idTask= explode("|", $rsTask[$row]['originalTag']);
			$rsTask[$row]['TaskID'] = $idTask[2];
			if ($rsTask[$row]['read'] == "N" && $rsTask[$row]['settingName'] == "bizproc|activity")
			{
				echo "<tr class=\"intask-row\">";
				echo "<td class=\"intask-cell\">".$rsTask[$row]['id']."</td>";
				echo "<td class=\"intask-cell\">".$rsTask[$row]['userName']."</td>";
				echo "<td class=\"intask-cell\">".$rsTask[$row]['text_converted']."</td>";
				echo "<td style=\"min-width: 100px;\" class=\"intask-cell\">".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "HH:MI")))."</td>";
				echo "<td style=\"min-width: 100px;\"  class=\"intask-cell\">".$rsTask[$row]['date']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD-MM-YYYY")))."</td>";
				echo "<input type=\"hidden\" name=\"id_BP\" value=\"" . $rsTask[$row]['id'] . "\">";
				echo "<td class=\"intask-cell\"><button class=\"ui-btn ui-btn-themes ui-btn-icon-setting ui-btn-icon-task tasks-quick-form-button\"
type=\"submit\" style=\"cursor:pointer;\" value=\"Прочитать все уведомления по задаче\"/>Прочитать</button></td>";
				echo "</tr>";
				
			}
		}
	}
	echo '</form>';
	echo '</table>';
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>