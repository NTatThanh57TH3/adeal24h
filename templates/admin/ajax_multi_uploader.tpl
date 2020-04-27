<script src="../include/js/jquery/ax-jquery-multiuploader/js/shCore.js" type="text/javascript"></script>
<script src="../include/js/jquery/ax-jquery-multiuploader/js/shBrushJScript.js"  type="text/javascript" ></script>
<script src="../include/js/jquery/ax-jquery-multiuploader/js/shBrushXml.js"  type="text/javascript" ></script>

<!-- SET UP AXUPLOADER  -->
<script src="../include/js/jquery/ax-jquery-multiuploader/js/ajaxupload.js" type="text/javascript"></script>

<link rel="stylesheet" href="../include/js/jquery/ax-jquery-multiuploader/css/style.css" type="text/css" media="all" />
<!-- /SET UP AXUPLOADER  -->

<link rel="stylesheet" href="../include/js/jquery/ax-jquery-multiuploader/css/shCore.css" type="text/css" media="all" />
<link rel="stylesheet" href="../include/js/jquery/ax-jquery-multiuploader/css/shThemeEclipse.css" type="text/css" media="all" />
<link rel="stylesheet" href="../include/js/jquery/ax-jquery-multiuploader/css/shCoreDefault.css" type="text/css"/>

{literal}
<script type="text/javascript">
SyntaxHighlighter.all({toolbar:false});
</script>
{/literal}

<table class="options width-100">
<tbody>
	<tr>
		<td>
			<div id="demo1-message" style="padding: 10px; display: none; font-weight: bold;"></div>
			<div id="demo1"></div>
			{literal}
			<script type="text/javascript">
			$(document).ready(function(){
				{/literal}
				{if $task == "edit"}
				{literal}
					$.cookie("alias", $('#alias').val());
				{/literal}
				{else}
				{literal}
					$.cookie("alias", "{/literal}{$page|replace:'admin_':''}{literal}");
				{/literal}
				{/if}
				{literal}
					
				$('#alias').change(function(){
					value = $('#alias').val();
					if (value) $.cookie("alias", value);
				});
				var alias = $.cookie("alias");
				var StringFile = $('#listFileName').val();
				$('#demo1').ajaxupload({
					url:'{/literal}{$page}.php?task=ajaxMultiUpload&alias={literal}'+alias,
					remotePath:'../images/{/literal}{$page|replace:'admin_':''}{literal}s/',
					success: function(fileName){
						StringFile = StringFile+fileName+'|';
						$('#demo1-message').show();
            			$('#demo1-message').css('color', 'blue');
            			$('#demo1-message').append('Upload thành công file '+fileName+'<br />');
            			setTimeout('$("#demo1-message").hide()',5000);
            			//console.log(StringFile);
            			$('#listFileName').val(StringFile);
					}
				});
			});
			</script>
			{/literal}
		</td>
	</tr>
</tbody>
</table>
