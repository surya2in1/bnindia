<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<div class="alert alert-danger">
	<div class="alert-text">			
		<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>
	</div>
	<div class="alert-close">                
		<i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>           
	 </div>	
</div>