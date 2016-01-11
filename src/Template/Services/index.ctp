<div class="jumbotron vertical-center crawler-jumbotron">
    <div class="container text-center">
        <h1 class="crawler-title">
        	Crawler
        	<i class="fa fa-fire"></i>
        </h1>

        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <?= $this->Form->create() ?>
			
			<?= $this->Form->input('url', ['class' => 'form-control input-l', 'label' => false, 'placeholder' => 'http://example.com/page.html']) ?>
			
			<?= $this->Form->button('<i class="fa fa-check"></i> Submit', [
				'type' => 'submit', 
				'class' => 'btn btn-lg btn-success',
				'id' => 'submitPageUrl',
				'style' => 'margin-top: 10px;',
				'required' => true,
				'escape' => false
			]) ?>

			<?= $this->Form->end() ?>
          </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <?php if (!empty($links)): ?>
            <div class="col-md-12">
                <a href="#linksList" data-toggle="collapse" aria-expanded="false" aria-controls="linksList">
                    <h2 style="margin-left:20px;">
                        <i class="fa fa-external-link"></i>
                        Found links
                        <span class="badge">
                            total:
                            <?= $links['numberOfLinks'] ?>
                        </span>

                        <?php foreach ($links['linksHttpResponses'] as $key => $value): ?>
                            <?= $this->Parser->httpResponseCountBadge($key, $value) ?>
                        <?php endforeach; ?>
                    </h2>
                </a>

                <div class="collapse" id="linksList">
                    <ul class="list-group">
                        <?php foreach ($links['links'] as $link): ?>
                            <li class="list-group-item">
                                <?= $this->Parser->httpResponseBadge($link['httpStatus']) ?>
                                <?= $this->Html->link($link['url'], $link['url'], ['target' => '_blank']) ?>
                                <span class="badge">
                                    <i class="fa fa-clock-o"></i>
                                    <?= $link['timeResponse'] ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($images)): ?>
            <div class="col-md-12">
                <a href="#imagesList" data-toggle="collapse" aria-expanded="false" aria-controls="imagesList">
                    <h2 style="margin-left:20px;">
                        <i class="fa fa-picture-o"></i>
                        Found images
                        <span class="badge">
                            total:
                            <?= $images['numberOfImages'] ?>
                        </span>

                        <?php foreach ($images['imagesHttpResponses'] as $key => $value): ?>
                            <?= $this->Parser->httpResponseCountBadge($key, $value) ?>
                        <?php endforeach; ?>
                    </h2>
                </a>

                <div class="collapse" id="imagesList">
                    <ul class="list-group">
                        <?php foreach ($images['images'] as $image): ?>
                            <li class="list-group-item">
                                <?= $this->Parser->httpResponseBadge($image['httpStatus']) ?>
                                <?= $this->Html->link($image['url'], $image['url'], ['target' => '_blank']) ?>
                                <span class="badge">
                                    <i class="fa fa-clock-o"></i>
                                    <?= $image['timeResponse'] ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($scripts)): ?>
            <div class="col-md-12">
                <a href="#scriptsList" data-toggle="collapse" aria-expanded="false" aria-controls="scriptsList">
                    <h2 style="margin-left:20px;">
                        <i class="fa fa-code"></i>
                        Found scripts
                        <span class="badge">
                            total:
                            <?= $scripts['numberOfScripts'] ?>
                        </span>

                        <?php foreach ($scripts['scriptsHttpResponses'] as $key => $value): ?>
                            <?= $this->Parser->httpResponseCountBadge($key, $value) ?>
                        <?php endforeach; ?>
                    </h2>
                </a>

                <div class="collapse" id="scriptsList">
                    <ul class="list-group">
                        <?php foreach ($scripts['scripts'] as $script): ?>
                            <li class="list-group-item">
                                <?= $this->Parser->httpResponseBadge($script['httpStatus']) ?>
                                <?= $this->Html->link($script['url'], $script['url'], ['target' => '_blank']) ?>
                                <span class="badge">
                                    <i class="fa fa-clock-o"></i>
                                    <?= $script['timeResponse'] ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($cssLinks)): ?>
            <div class="col-md-12">
                <a href="#cssLinksList" data-toggle="collapse" aria-expanded="false" aria-controls="cssLinksList">
                    <h2 style="margin-left:20px;">
                        <i class="fa fa-file-code-o"></i>
                        Found stylesheets
                        <span class="badge">
                            total:
                            <?= $cssLinks['numberOfCssLinks'] ?>
                        </span>

                        <?php foreach ($cssLinks['cssLinksHttpResponses'] as $key => $value): ?>
                            <?= $this->Parser->httpResponseCountBadge($key, $value) ?>
                        <?php endforeach; ?>
                    </h2>
                </a>

                <div class="collapse" id="cssLinksList">
                    <ul class="list-group">
                        <?php foreach ($cssLinks['cssLinks'] as $cssLink): ?>
                            <li class="list-group-item">
                                <?= $this->Parser->httpResponseBadge($cssLink['httpStatus']) ?>
                                <?= $this->Html->link($cssLink['url'], $cssLink['url'], ['target' => '_blank']) ?>
                                <span class="badge">
                                    <i class="fa fa-clock-o"></i>
                                    <?= $cssLink['timeResponse'] ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->Html->script('Crawler.template/services/index.js') ?>