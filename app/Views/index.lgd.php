<!DOCTYPE html>
<html>
<head>
	<title><?= $framework ?> Framework</title>

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div>
		<h1 class="page-title">Welcome to the <u><?= $framework ?></u> Framework</h1></div>
		<div  class="well"><?= $this->getSection('content') ?>
	</div>
</body>
</html>