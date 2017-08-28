<?php defined('_VR360') or die; ?>

<!-- Embed Modal -->
<div class="modal fade" id="editTour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-clipboard" aria-hidden="true"></i> Embed code
				</h4>
			</div>
			<div class="modal-body">
				<?php Vr360Layout::load('body.user.create.tour'); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
