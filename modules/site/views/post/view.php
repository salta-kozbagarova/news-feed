<?php

?>

<div class="container">
	<div class="row">
		<div class="col-lg-12 text-justify">
			<h4 class="title"><?=$model->title?></h4>
			<p>-<?=$model->author->first_name.' '.$model->author->last_name?></p>
			<p><?=$model->published?></p>
			<p><?=$model->content?></p>
		</div>
	</div>
</div>