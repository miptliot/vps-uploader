{if isset($pagination)}
	<div class="pagination-container">
		{LinkPager pagination=$pagination}{/LinkPager}
		<ul class="pagination">
			<li><span>{Yii::t('vps-uploader', 'Total')}: {$pagination->totalCount}</span></li>
		</ul>
	</div>
{/if}