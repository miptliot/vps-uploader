<table class="table table-striped table-bordered table-hover vu-table">
	<thead>
		<tr>
			<th>
				{Yii::t('vps-uploader', 'GUID')}
				<p class="help">{Yii::t('vps-uploader', 'Unique identifier.')}</p>
			</th>
			<th>{Yii::t('vps-uploader', 'Link')}</th>
			<th>{Yii::t('vps-uploader', 'Extension')}</th>
			<th>{Yii::t('vps-uploader', 'Original name')}</th>
			<th>{Yii::t('vps-uploader', 'Filesize')}</th>
			<th>{Yii::t('vps-uploader', 'Status')}</th>
			<th>
				{Yii::t('vps-uploader', 'Message')}
				<p class="help">{Yii::t('vps-uploader', 'In case of error.')}</p>
			</th>
			<th>{Yii::t('vps-uploader', 'Last edit DT')}</th>
		</tr>
	</thead>
	<tbody>
		{foreach $files as $file}
			<tr>
				<td>{$file->guid}</td>
				<td>{Html::a($file->path, $file->getUrl(), [ 'class' => 'vu-file-link' ])}</td>
				<td>{$file->extension}</td>
				<td>{$file->name}</td>
				<td>{HumanHelper::size($file->size)}</td>
				<td class="vu-file-status-{$file->status}">{$file->status}</td>
				<td>{$file->message}</td>
				<td>{Yii::$app->formatter->asDatetime($file->dt)}</td>
			</tr>
		{/foreach}
	</tbody>
</table>