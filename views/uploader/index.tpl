<p>
	{Html::a(Yii::t('vps-uploader', 'File list'), [ 'file' ], [ 'class' => 'btn btn-primary', 'raw' => true ])}
	{Html::a(Yii::t('vps-uploader', 'Add files'), [ 'file/add' ], [ 'class' => 'btn btn-success', 'raw' => true ])}
</p>

<h1>{Yii::t('vps-uploader', 'Last uploaded')}</h1>
{include file="../file/table.tpl" files=$last}