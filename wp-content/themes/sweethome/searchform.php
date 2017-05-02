<?php if( !defined('ABSPATH') ) exit;?>
<form class="search-box" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<input value="<?php print get_query_var('s');?>" type="text" name="s" id="s" placeholder="<?php _e('Search here...','swh');?>">
	<button type='submit'><i class='fa fa-search'></i></button>
</form>