<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(function(){
			let help = $(".content-header .pull-right");
			help.html('<a href="https://sumartestzulip.zulipchat.com/#narrow/stream/Soporte.20-.20Atyc" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-question-circle fa-lg"></i> <b>Soporte</b></a>');
		}, 3000);
	});
</script>

@if(env('APP_ENV') == 'qa')
<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(function(){
			let help = $(".content-header .pull-right");
			help.append(' <button class="btn btn-danger btn-xs" target="_blank"><i class="fa fa-thumb-tack fa-lg"></i> <b>Aclaraciones de desarrollo</b></button>');
		}, 3000);
	});
</script>
@endif
