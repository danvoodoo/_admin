<?php 
include_once('includes/fields/flexible_content/functions.php');


if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns flexiblecontainer">
	<hr>
	<h4><?php echo $field['name'];?></h4>

	<?php
	global $fixed, $co, $flexiblecount, $flexiblefield, $re, $bb;
	$flexiblefield = $field;

	
	$fixed = 0;
	if (isset($field['fixed']) AND $field['fixed'] == 1) $fixed = 1;


	if (isset($r)) $v = $r[$field['field']]; else $v ='';

	?>

	<div class="flexiblecontent">
		<?php
		$flexiblecount = 0;


		//$v = preg_replace( "/\r|\n/", "", $v );
		if (isset($_GET['debug'])) print_r($v);
		
		

		$contents = json_decode( $v , true);

		if (isset($_GET['debug'])) print_r($contents);

		if (is_array($contents))
		foreach ($contents as $co) {
			//print_r($co);
			$flexiblecount++;
			
			include('includes/fields/flexible_content/content/'.$co['type'].'.php');
			
		}
		?>
		
	</div>
	
	<?php
	if ($fixed == 0) {?>
	
	<a href="#" class="button addcontentbutton" data-reveal-id="addcontentmodal" >Add content</a><br>

	<div id="addcontentmodal" class="reveal-modal addcontent large" data-reveal>
		<div class="row">
			<div class="columns medium-12">
				<h2>Select the type of content</h2>
				<ul id="addcontent" class="medium-block-grid-4">

				<?php
				$fieldstypes = scandir('includes/fields/flexible_content/content');
				foreach ($fieldstypes as $fieldtype) {
					if ($fieldtype != '.' AND $fieldtype != '..'  AND strpos($fieldtype, '.php')  > 0) {
						$fieldimage = str_replace('.php', '', $fieldtype);
						$fieldname = str_replace('-', ' ', $fieldimage);
					?>
	        		<li>
	        			<a href="#" data-type='<?php echo $fieldtype;?>'>
	        				<figure>
	        					<div class="valignout"><div class="valignin">
	        					<?php if ( file_exists('includes/fields/flexible_content/content/'.$fieldimage.'.jpg') ){?>
	        						<img src="includes/fields/flexible_content/content/<?php echo $fieldimage; ?>.jpg" alt="">
	        					<?php } ?>
	        					</div></div>
	        				</figure>
	        				<?php echo ucfirst($fieldname);?>
	        			</a>
	        		</li>
	    			<?php } }?>
		
				</ul>
				
			</div>
		</div>
	</div>
	<?php } ?>
</div>