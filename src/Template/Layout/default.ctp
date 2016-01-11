<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">

    <title>
        Crawler | HTML Parser
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('Crawler.bootstrap.css') ?>
    <?= $this->Html->css('Crawler.bootstrap-theme.css') ?>
    <?= $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') ?>
    <?= $this->Html->css('Crawler.custom.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <?= $this->Html->script('Crawler.jquery-2.1.4.min.js') ?>
    <?= $this->Html->script('Crawler.bootstrap.min.js') ?>
    <?= $this->fetch('script') ?>

</head>
<body>
    <div id="container">
        <?= $this->fetch('content') ?>
    </div>
</body>
</html>
