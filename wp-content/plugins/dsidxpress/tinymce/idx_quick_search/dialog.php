<?php
if (!current_user_can("edit_posts"))
	wp_die("You can't do anything destructive in here, but you shouldn't be playing around with this anyway.");

global $wp_version, $tinymce_version;
$localJsUri = get_option("siteurl") . "/" . WPINC . "/js/";
if (is_ssl()) {
	$localJsUri = preg_replace('/http/', 'https', $localJsUri);
}
$adminUri = get_admin_url();
?>

<!DOCTYPE html>
<html>
<head>
	<title>dsIDXpress: IDX Search Form</title>

	<script src="<?php echo $localJsUri ?>tinymce/tiny_mce_popup.js?ver=<?php echo urlencode($tinymce_version) ?>"></script>
	<script src="<?php echo $localJsUri ?>jquery/jquery.js"></script>
	<script src="<?php echo DSIDXPRESS_PLUGIN_URL; ?>/tinymce/idx_quick_search/js/dialog.js?ver=<?php echo urlencode(DSIDXPRESS_PLUGIN_VERSION) ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo DSIDXPRESS_PLUGIN_URL; ?>/css/admin-options.css?ver=<?php echo urlencode(DSIDXPRESS_PLUGIN_VERSION) ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $adminUri ?>css/wp-admin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo DSIDXPRESS_PLUGIN_URL; ?>/tinymce/idx_quick_search/css/dialog.css?foo=bar" />
	<style type="text/css">
		label {
			cursor: pointer;
		}
	</style>
</head>
<body class="wp-admin js admin-color-fresh">
	<div id="wpbody">

		<div class="postbox" id="ds-idx-dialog-notice">
			<div class="inside">
				<p>
					Choose either horizontal or vertical format. A simple responsive search form. Allow users to type any location, select from available property types and filter by price range.
				</p>
			</div>
		</div>
		<div class="postbox" id="ds-idx-dialog-notice">
			<div class="inside">

		    <strong>FORMAT:</strong>
		    <p>
		        <input id="format-vertical" type="radio" name="format" value="vertical"/> <label for="format-vertical">Vertical</label>
		        <br/>
		        <input id="format-horizontal" type="radio" name="format" value="horizontal" checked="checked"/><label for="format-horizontal">Horizontal</label>
		        <br/>
		    </p>

			<p class="button-controls">
				<span class="add-to-menu">
					<input type="button" id="dsidxpress-lb-cancel" name="cancel" value="Cancel" class="button-secondary" onclick="tinyMCEPopup.close();">
					<input type="button" id="dsidxpress-lb-insert" name="insert" value="Insert Search Form" class="button-primary" style="text-transform: capitalize;" onclick="dsidxSearchForm.insert();">
				</span>
			</p>

			</div>
		</div>
	</div>
</body>
</html>
