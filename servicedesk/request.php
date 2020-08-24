<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявка на нового пользователя");
?>

<form action="/forms/script.php" method="post">
<fieldset>
<legend>Заполните форму</legend>
<table border="0" width="500px">
	<tr><td width="40%">Фамилия Имя Отчество</td><td>  <input type="text" name="FIO" width="100%" required /></td></tr>
	<tr><td>Отдел (согласно структуре)</td><td> <input type="text" name="departament" required/></td></tr>
	<tr><td>Руководитель</td><td> <input type="text" name="chief" required/></td></tr>
	<tr><td>Должность (согласно списку)</td><td> <input type="text" name="position" required/></td></tr>
	<tr><td>Телефон: </td><td>
	<select name="tel" width="100%">
		<option value="Не нужен" selected>Не нужен</option>
		<option value="Ставим">Ставим</option>
	</select></td></tr>
	<tr><td>Офис: </td><td><input type="text" name="floor" required/></td></tr>
	<tr><td></td><td>*Для СПб, указываем этаж</td></tr>
	<tr><td>Дата выхода</td><td> <input type="date" name="date"/></td></tr>
	<br />
	<tr><td><label for="addcomment">Примечание</label></td>
	<td><textarea name="addcomment"></textarea></td></tr>
	<tr><td></td><td>*После создания задачи, все исправления указываем в комментария к задаче.</td></tr>
	<tr><td></td><td>*Описание задачи НЕ РЕДАКТИРУЕМ !!!</td></tr>
</table>

<fieldset>
	<legend><b>Список доступов</b></legend>
	<table border="1" width="500px">
	<tr><td width="40%"><p>Почта:</td><td>
	<select name="mail">
		<option value="Да" >Да</option>
		<option value="Нет" >Нет</option>
	</select></td></tr>
	<tr><td>DAX Axapta: </td><td>
	<select name="Axapta" onchange="ShowAdUser(this.value)">
		<option value="Да">Да</option>
		<option value="Нет" selected>Нет</option>
	</select></td></tr>
	<tr id="AsUserField" style="display:none"><td>Шаблон прав:</td><td><input type="text" name="AsUser" placeholder="ФИО сотрудника"/></td></tr>
	<tr><td>WMS Solvo: </td><td>
	<select name="solvo">
		<option value="Да">Да</option>
		<option value="Нет" selected>Нет</option>
	</select></td></tr>
	<tr><td>VPN: </td><td>
	<select name="vpn">
		<option value="Да">Да</option>
		<option value="Нет" selected>Нет</option>
	</select></td></tr>
	</table>
	</fieldset>
<input type="submit" name="add_user" value="Отправь заявку" />
</fieldset>
</form>

<script>
function ShowAdUser(value){
	if (value == "Да"){
		document.getElementById('AsUserField').style.display = 'table-row';
	}
	else
	{
		document.getElementById('AsUserField').style.display = 'none';
	}
}
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>