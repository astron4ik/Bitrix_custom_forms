<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявка на оплату");
?>

<body>
<fieldset>
<legend>Заполните заявку</legend>
	<form action="/forms/script.php" method="post">
		<table>
			<tr>
				<td>
					<label for="article-name">Статья затрат</label>
				</td>
				<td>
					<input type="text" id="article-name" name="article-name" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="article-info">Примечание</label>
				</td>
				<td>
					<input type="text" id="article-info" name="article-info" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="article-sum">Сумма</label>
				</td>
				<td>
					<input type="number" step="any" id="article-sum" name="article-sum" required>
				</td>
			</tr>
			<tr><td></td><td>*После создания задачи, все исправления указываем в комментария к задаче.</td></tr>
			<tr><td></td><td>*Описание задачи НЕ РЕДАКТИРУЕМ !!!</td></tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="osn" value="Отправить заявку">
				</td>
			</tr>
		</table>
	</form>
	</fieldset>
</body>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>