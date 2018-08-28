<?php if (isset($extras['search'])) {?>
	<form class="right searchform" method='get' action='<?php echo $p_edit.'?'.$_SERVER['QUERY_STRING'];?>'>
		<div class="row collapse">
			<div class="large-2 columns">
				<span class="prefix">Search</span>
			</div>
			<div class="large-10 columns">
				<input type="text" name='s' class="search" value="<?php if (isset($_GET['s'])) echo $_GET['s'];?>" placeholder="<?php echo $extras['search']['placeholder'];?>" />
				<input type="submit" value="" class="search-bt" />
				<input type="hidden" name='list' value='1'>
			</div>
		</div>
    </form>
<?php } ?>