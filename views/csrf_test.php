<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
	<title>Csrf test</title>
	
</head>
<body>

<div id="container">
	
	<?php if ( isset($text) ) echo $text; ?><br />
	
	<?php if ( isset($sample_link) ) echo anchor( $sample_link, 'click here' ); ?>
	

</div>

</body>
</html>
