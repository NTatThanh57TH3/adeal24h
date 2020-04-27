<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Quản lý file thư mục elFinder 2.0</title>
		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="../include/js/jquery/css/jquery-ui.css">
		<script type="text/javascript" src="../include/js/jquery/js/jquery.min.js"></script>
		<script type="text/javascript" src="../include/js/jquery/js/jquery-ui-1.8.2.custom.min.js"></script>
		<script src="../include/js/jquery/jquery-ui-1.8.22/js/jquery-ui-1.8.22.custom.min.js" type="text/javascript" charset="utf-8"></script>
		
		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" href="../include/js/jquery/jquery-ui-1.8.22/css/ui-lightness/jquery-ui-1.8.22.custom.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="../include/js/jquery/elfinder-2.0/css/elfinder.min.css" type="text/css" media="screen" charset="utf-8" />
		
		<!-- elFinder JS (REQUIRED) -->
		<script src="../include/js/jquery/elfinder-2.0/js/elfinder.min.js"></script>
		{literal}
		<script type="text/javascript">
		var FileBrowserDialogue = {
			init: function() {
				//Here goes your code for setting your custom things onLoad.
			},
			mySubmit: function (URL) {
				//pass selected file path to TinyMCE
			top.tinymce.activeEditor.windowManager.getParams().setUrl(URL);

				// close popup window
				top.tinymce.activeEditor.windowManager.close();
			}
		}

		$().ready(function() {
			var elf = $('#elfinder').elfinder({
				// 	set your elFinder options here
				url: '../include/elfinder/connector.php?domain={/literal}{$admin->admin_site_default.site_domain}{literal}',  // connector URL
				getFileCallback: function(file) { // editor callback
					FileBrowserDialogue.mySubmit(file); // pass selected file path to TinyMCE
				},
                sort: 'date',
                sortDirect: 'desc'
			}).elfinder('instance');
		});
		</script>
		{/literal}	
	</head>
	<body>
		<div id="elfinder"></div>
	</body>
</html>