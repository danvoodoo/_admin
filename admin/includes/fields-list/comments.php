<td>
	<?php
	$data2 = new Database();
	$where = 'co_post = '.$r['post_id'];
	$count  =  $data2->select(" * ", " comments ", $where);

	$where = 'co_state = 0 AND co_post = '.$r['post_id'];
	$count2  =  $data2->select(" * ", " comments ", $where);
	?>
	Total Comments: <?php echo $count; ?> <br>
	Unapproved Comments: <?php echo $count2; ?> <br>
	<a href="blog-comments.php?post=<?php echo $r['post_id'];?>&list=1">View comments</a>
</td>