<td>
	<?php
	//print_r($r);
	global $urlstructure;
	if ( isset( $urlstructure[ $extras['post_type'] ] ) ){

		$urls = $urlstructure[ $extras['post_type'] ] ['urlstructure'];
		
		$urls = explode( '/' , $urls);

		$url = '';
		foreach ($urls as $u) {
			switch ($u) {
				case '%url':
					$url .= $r[$field['field']];
					$url .= '/';
				break;

				case '%parent':
					if ( $r[$extras['page_parent']] > 0 ) {
						
						if ( isset($extras['url_column']) ) {
							$dataurl = new Database();
							$where = $extras['id'].' = '.$r[$extras['page_parent']].'' ;
							$count  =  $dataurl->select(" * ",  $extras['table'] , $where);
							$selecturl = $dataurl->getObjectResults();
							$url .= $selecturl->{$extras['url_column']};

							if ( $selecturl->{$extras['page_parent']} > 0 ) {
								$dataurl2 = new Database();
								$where = $extras['id'].' = '.$selecturl->{$extras['page_parent']}.'' ;
								$count  =  $dataurl2->select(" * ",  $extras['table'] , $where);
								$selecturl2 = $dataurl2->getObjectResults();								
								$url .= $selecturl2->{$extras['url_column']};
							}
							
						} else {
							$url .= get_post_url( $r[$extras['page_parent']] );
						}
						
						$url .= '/';
					}
				break;



				case '%parent2':
					if ( $r[$extras['page_parent2']] > 0 ) {
						
						if ( isset($extras['url_column']) ) {
							$dataurl = new Database();
							$where = $extras['id'].' = '.$selecturl->{$extras['page_parent2']}.'' ;
							$count  =  $dataurl->select(" * ",  $extras['table'] , $where);
							$selecturl = $dataurl->getObjectResults();
							$url .= $selecturl->{$extras['url_column']};
						} else {
							$url .= get_post_url( $r[$extras['page_parent2']] );
						}
						
						$url .= '/';
					}
				break;
				
				default:
					$url .= $u;
					$url .= '/';
				break;
			}
			
		}

	} else {
		$url = $r[$field['field']].'/';
	}

	

	?>
	<input type="text" readonly="" value="<?php echo $url;?>" class='urlinput'>
	<?php
	if ( isset( $urlstructure[ $extras['post_type'] ]['viewonsite'] ) AND $urlstructure[ $extras['post_type'] ]['viewonsite'] ){ ?>
	<a href="<?php echo SITEURL.$url;?>" target='_blank' class='viewonsite'><i class="fa fa-external-link" aria-hidden="true"></i> View <?php echo $title_singular; ?></a>
	<?php } ?>
</td>

<style>
	.urlinput{
		width: 100%;
	}
	.viewonsite{
		font-size: 12px;
	}
</style>
<script type="text/javascript">
$(document).ready(function () {

 $('.urlinput').click(function(e) {
    $(this).focus().select();
    document.execCommand("copy");
    e.preventDefault();
  });

});
</script>