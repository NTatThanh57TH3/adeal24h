<!-- BEGIN DEBUG -->
<div id="pg_debug_window" style="display:none;">
	<div id="pg_debug_window_body">
      <div id="pg_debug_window_body_container"></div>
    </div>
</div>
<link rel="stylesheet" href="{$PG_URL_HOMEPAGE}include/js/jquery/jquery-ui-1.10.3/jquery-ui-1.10.3.css" />
<link rel="stylesheet" href="{$PG_URL_HOMEPAGE}templates/admin/css/debug.css?v=1.1" title="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$PG_URL_HOMEPAGE}include/sqlparserlib/sqlsyntax.css" title="stylesheet" type="text/css" />
<script type="text/javascript" src="{$PG_URL_HOMEPAGE}include/js/jquery/jquery-ui-1.10.3/jquery-ui.js"></script>
{literal}
<script type='text/javascript'>
$('window').ready(function() {
	$.ajax({
	    url: url_root + 'debug.php',
	    type: 'POST',
	    data: {
	      	task: 'get_debug_info',
	      	id: '{/literal}{$debug_uid}{literal}'
	    },
	    success: function(data)
	    {
	      	$('#pg_debug_window_body_container').html(data);
	      	$('#pg_debug_window').css('display','');
	    }
	});
	$('#pg_debug_window').css('display','');
});
</script>
{/literal}
<!-- END DEBUG -->