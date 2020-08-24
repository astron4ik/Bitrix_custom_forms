<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Увольнение сотрудника");
?>

<fieldset>
<legend>Заполните заявку</legend>
	<form action="/forms/script.php" method="post">
		<table>
			<tr>
				<td>
					<label for="rmFIO">Фамилия Имя Отчество</label>
				</td>
				<td>
					<input type="text" style="width:250px;" id="rmFIO" name="rmFIO" required>
				</td>
			</tr>
			<tr>
				<td>Что делаем с почтой пользователя? </td><td>
					<select name="selectmail" onchange="RESentUserFunc(this.value);" style="width:250px;">
						<option value="Удаляем" selected>Удаляем</option>
						<option value="Переадресация">Переадресация</option>
					</select>
				</td>
			</tr>
			<tr id="RESentUserField" style="display:none">
				<td>
					<label for="RESentUser">Переадресация на сотрудника:</label>
				</td>
				<td>
					<input type="text" name="RESentUser" style="width:250px;" placeholder="ФИО сотрудника"/>
				</td>
			</tr>
			<tr>
				<td>Что делаем с документами пользователя в битриксе? </td><td>
					<select name="bxdisk" style="width:250px;">
						<option value="Удаляем" selected>Удаляем</option>
						<option value="Передаем руководителю">Передаем руководителю</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="rmcomment">Примечание</label>
				</td>
				<td>
					<textarea name="rmcomment" style="width:250px;height:150px;"></textarea>
				</td>
			</tr>
	<tr><td></td><td>*После создания задачи, все исправления указываем в комментария к задаче.</td></tr>
	<tr><td></td><td>*Описание задачи НЕ РЕДАКТИРУЕМ !!!</td></tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="remove_user" value="Отправить заявку">
				</td>
			</tr>
		</table>
	</form>
	</fieldset>
<script>
function RESentUserFunc(value){
	if (value == "Переадресация"){
		document.getElementById('RESentUserField').style.display = 'table-row';
	}
	else
	{
		document.getElementById('RESentUserField').style.display = 'none';
}
}
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>