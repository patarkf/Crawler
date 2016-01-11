<div class="alert alert-success" role="alert">
	<?= $this->Html->link(
		'&times;',
		'javascript:void(0)',
		[
			'class' => 'close',
			'data-dismiss' => 'alert',
			'escape' => false
		]
	) ?>
	<?= h($message) ?>
</div>
