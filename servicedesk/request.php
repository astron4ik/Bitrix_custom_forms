<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявка на Тех. Поддержку");
?>

<form action="/servicedesk/script.php" method="post">
<fieldset>
<legend>Заполните форму</legend>
<table border="0" width="500px">
	<tr><td>Программа: </td><td>
	<select name="tel" width="100%" required>
		<option value="">Выберите программу</option>
		<option value="site">Сайт</option>
		<option value="wms">WMS Solvo</option>
		<option value="ax">MSDAX Axapta</option>
	</select></td></tr>
	<tr><td>Тип обращения: </td><td>
	<select name="tel" width="100%" required>
		<option value="incident" selected>Инцидент</option>
		<option value="consultation">Консультация</option>
	</select></td></tr>
	<tr><td>Тема обращения:</td><td> <input type="text" name="small_description" required /></td></tr>
	<tr><td><label for="description">Описание проблемы</label></td>
	<td><textarea name="description" required></textarea></td></tr>
	<tr><td>Срочно?</td><td> <input type="checkbox" name="quickly" value="quickly">
	<tr><td></td><td>*После создания задачи, все исправления указываем в комментария к задаче.</td></tr>
	<tr><td></td><td>*Описание задачи НЕ РЕДАКТИРУЕМ !!!</td></tr>
</table>

<input type="submit" name="request" value="Отправь заявку">
<input type="submit" name="debug_button" value="Отладка">
</fieldset>
</form>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
