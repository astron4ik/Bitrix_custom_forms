<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявка в Тех. Поддержку");
?>
<form action="/servicedesk/script.php" method="post">
	<fieldset>
	<legend>Заполните форму</legend>
		<table width="500px">
		<tbody>
		<tr>
			<td>
				Программа:
			</td>
			<td>
				<select name="app" width="100%" required>
					<option value="">Выберите программу</option>
					<option value="site">Сайт</option>
					<option value="wms">WMS Solvo</option>
					<option value="ax">MSDAX Axapta</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Тема обращения:
			</td>
			<td>
				<input type="text" name="small_description" style="width: 435px; height: 35px;" required>
			</td>
		</tr>
		<tr>
			<td>
				<label for="description">Описание:</label>
			</td>
			<td>
				<textarea name="description" cols="60" rows="15" required></textarea>
			</td>
		</tr>
		<tr>
			<td>
				Срочно
			</td>
			<td>
				<select name="quickly" width="100%" required>
					<option value="false" selected>Нет</option>
					<option value="true">Да</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				*После создания задачи, все исправления указываем в комментариях к задаче.
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				 *Описание задачи НЕ РЕДАКТИРУЕМ !!!
			</td>
		</tr>
		</tbody>
		</table>
		<input type="submit" name="request" value="Отправь заявку"> <input type="submit" name="debug_button" value="Отладка">
	</fieldset>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
