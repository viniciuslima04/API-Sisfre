<div class="row col-md-8 col-md-offset-2 text-center">
	<?php if($message = Session::get('success')): ?>
		<div class="col-md-2"></div>
		<div class="alert alert-success alert-block">
			<span class="glyphicon glyphicon-ok-sign" style="font-size: 2em; vertical-align: middle;"> </span>
			<button type="button" class="close" data-dismiss="alert">×</button>
		    <strong><?php echo e($message); ?></strong>
		</div>
	<?php endif; ?>

	<?php if($message = Session::get('error')): ?>
		<div class="col-md-2"></div>
		<div class="alert alert-danger alert-block">
			<span class="glyphicon glyphicon-remove-sign" style="font-size: 2em; vertical-align: middle;"> </span>
			<button type="button" class="close" data-dismiss="alert">×</button>
		    <strong><?php echo e($message); ?></strong>
		</div>
	<?php endif; ?>


	<?php if($message = Session::get('warning')): ?>
		<div class="col-md-2"></div>
		<div class="alert alert-warning alert-block">
			<span class="glyphicon glyphicon-warning-sign" style="font-size: 2em; vertical-align: middle;"> </span>
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong><?php echo e($message); ?></strong>
		</div>
	<?php endif; ?>


	<?php if($message = Session::get('info')): ?>
		<div class="col-md-2"></div>
		<div class="alert alert-info alert-block">
			<span class="glyphicon glyphicon-exclamation-sign" style="font-size: 2em; vertical-align: middle;"> </span>
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong><?php echo e($message); ?></strong>
		</div>
	<?php endif; ?>
</div>