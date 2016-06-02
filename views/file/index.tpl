{if isset($uploaded)}
	<h1>{Yii::t('vps-uploader', 'Just uploaded')}</h1>
	{include file="../file/table.tpl" files=$uploaded}
{/if}
<h1>{Yii::t('vps-uploader', 'File list')}</h1>
{include file="../file/table.tpl" files=$files}
{include file="../pagination.tpl"}