<div id = "div_toastContainer" class="toast-container">
	<div id="myToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
		<div class="toast-header">
			<strong class="mr-auto">Notice</strong>
			<small id = "lab_toastTime">Just</small>
			<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
					<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div id = "div_toastBody" class="toast-body">
			Toast Message
		</div>
	</div>
</div>

<!--
<button id="showToastBtn" class="btn btn-primary">顯示 Toast</button>
-->

<style>
	.toast-container {
		width: 			350px;
		max-width: 	350px;
		bottom: 		1rem;
		right: 			1rem;
		z-index: 		1050; /* 你可以調整這個值來改變顯示層級 */
	}
</style>