<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<title></title>
	<meta name="viewport" content="width=1200, height=600, initial-scale=1">
	<style>
		* {
			font-family: sans-serif;
		}

		body {
			padding: 0;
			margin: 0;
		}

		main {
			width: 1200px;
			height: 600px;
			position: relative;
			background: cover;
		}

		main>div {
			position: absolute;
			line-height: 1.2;
		}

		.img {
			background-repeat: no-repeat;
			background-scale: cover;
		}

		.favicon {
			left: 80px;
			top: 80px;
			width: 60px;
			height: 60px;
		}

		.servername {
			left: 160px;
			top: 80px;
			width: 620px;
			height: 60px;
			color: #666;
			font-size: 40px;
		}

		.title {
			left: 80px;
			top: 160px;
			width: 700px;
			height: 140px;
			font-size: 64px;
			font-weight: bold;
			line-height: 1.2;
			color: #1A1A1A;
		}

		.image {
			left: 800px;
			top: 80px;
			width: 320px;
			height: 180px;
		}

		.description {
			left: 80px;
			top: 800px;
			width: 1040px;
			height: 120px;
			color: #666;
			line-height: 1.2;
			font-size: 40px;
		}

		.domain {
			left: 80px;
			top: 480px;
			width: 1040px;
			height: 40px;
			color: #666;
			font-size: 40px;
		}
	</style>

</head>

<body>
	<?php $article = rex_article::getCurrent(); ?>
	<main
		style="background: <?= rex_url::media(thumb::getConfig('background_image')) ?>">
		<div class="img favicon"
			style="background: <?= $this->getVar('favicon') ?? rex::getServer() . '/favicon.ico'  ?>">
		</div>
		<div class="servername">
			<?= $this->getVar('servername') ?? rex::getServerName() ?>
		</div>
		<div class="title">
			<?= $this->getVar('title') ?? $article->getName(); ?>
		</div>
		<div class="description">
			<?= $this->getVar('description') ?? ''; ?>
		</div>
		<div class="img image"
			style="background: <?= $this->getVar('image') ?? '' ?>">
		</div>
		<div class="domain">
			<?= $this->getVar('domain') ?? rex::getServer(); ?>
		</div>
	</main>
</body>

</html>