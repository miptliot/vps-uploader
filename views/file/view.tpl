{if isset($file)}
	<h3>{$file->guid}</h3>
	<table class="table table-condensed table-hover table-striped vu-table-width">
		<tbody>
			<tr>
				<th>{Yii::t('vps-uploader', 'Original name')}</th>
				<td>{$file->name}</td>
			</tr>
			<tr>
				<th>{Yii::t('vps-uploader', 'Extension')}</th>
				<td>{$file->extension}</td>
			</tr>
			<tr>
				<th>{Yii::t('vps-uploader', 'Link')}</th>
				<td>{Html::a($file->path, $file->getUrl(), [ 'class' => 'vu-file-link' ])}</td>
			</tr>
			<tr>
				<th>{Yii::t('vps-uploader', 'Filesize')}</th>
				<td>{HumanHelper::size($file->size)}</td>
			</tr>
			<tr>
				<th>{Yii::t('vps-uploader', 'Status')}</th>
				<td>{$file->status}</td>
			</tr>
			<tr>
				<th>{Yii::t('vps-uploader', 'Message')}</th>
				<td>{$file->message}</td>
			</tr>
			<tr>
				<th>{Yii::t('vps-uploader', 'Last edit DT')}</th>
				<td>{Yii::$app->formatter->asDatetime($file->dt)}</td>
			</tr>
		</tbody>
	</table>
{else}
	<div class="alert alert-danger">{Yii::t('vps-uploader', 'File not found.')}</div>
{/if}