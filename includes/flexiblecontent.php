<?php

$a = 0;
$content = json_decode($r->post_content);

if (isset($_GET['debug'])) print_r($content);

foreach ($content as $r) {
$a++;

//print_r($r);


switch ($r->type) {

case 'one-column': ?>
<div class="content">
	<div class="row">
		<div class="columns medium-12">
				<?php echo stripslashes($r->text);?>
		</div>
	</div>
</div>
<?php break; ?>

<?php case 'two-columns': ?>
<div class="content">
	<div class="row">
		<div class="columns medium-6">
				<?php echo $r->text1;?>
		</div>
		<div class="columns medium-6">
				<?php echo $r->text2;?>
		</div>
	</div>
</div>
<?php break; ?>

<?php case 'three-columns': ?>
<div class="content">
	<div class="row">
		<div class="columns medium-4">
				<?php echo $r->text1;?>
		</div>
		<div class="columns medium-4">
				<?php echo $r->text2;?>
		</div>
		<div class="columns medium-4">
				<?php echo $r->text3;?>
		</div>
	</div>
</div>
<?php break; ?>

<?php case 'four-columns': ?>
<div class="content">
	<div class="row">
		<div class="columns medium-3">
				<?php echo $r->text1;?>
		</div>
		<div class="columns medium-3">
				<?php echo $r->text2;?>
		</div>
		<div class="columns medium-3">
				<?php echo $r->text3;?>
		</div>
		<div class="columns medium-3">
				<?php echo $r->text4;?>
		</div>
	</div>
</div>
<?php break; ?>


<?php case 'ranges': ?>
<div class="content ranges">
	<div class="row">
		<?php
		foreach ($r->repeater as $c) { ?>
		<div class="columns medium-4">
			<a class="range"  href='<?php echo $c->link;?>'>
				<div class="bg"  style="background-image: url('photos/280_280_<?php echo $c->image; ?>')"></div>
				<div class="title"><?php echo $c->title; ?></div>
			</a>
		</div>
		<?php } ?>
	</div>
</div>
<?php break; ?>




<?php case 'slider': ?>
<div class="content slider">
	<ul>
		<?php foreach ($r->repeater as $c) {?>
		<li>
			<div class="bg"  style="background-image: url('photos/1600_500_<?php echo $c->image; ?>')"></div>
			<div class="text">
				<h2><?php echo $c->title; ?></h2>
				<?php if ( $c->text ) {?>
				<p>
					<?php echo $c->text; ?>
				</p>
				<?php } ?>
				<?php if ( $c->button ) {?>
				<a href='<?php echo $c->buttonlink; ?>' class="button whiteoutline small"><?php echo $c->button; ?></a>
				<?php } ?>
			</div>
		</li>
		<?php } ?>
	</ul>
</div>

<script type="text/javascript">
$(document).ready(function () {

$('.content.slider ul').bxSlider({
	pager: false,
	auto: true,
	pause: 4000,
	controls: false
});

});
</script>
<?php break; ?>



<?php case 'single-button': ?>
<div class="content cta">
	<div class="row">
		<div class="columns medium-12">
			<div class="ctain">
				<a class="button" href='<?php echo $r->link; ?>'><?php echo $r->text; ?></a>
			</div>
		</div>
	</div>
</div>
<?php break; ?>




<?php case 'image': ?>
<div class="content">
	<div class="row">
		<div class="columns medium-12">
			<div class="image">
				<div class="bg" style="background-image: url('photos/1100_500_<?php echo $r->image;?>')"></div>
				<div class="valignout">
					<div class="valignin">
						<h3>
							<?php echo $r->text;?>
						</h3>
						<?php if ( $r->button ) {?>
						<a href="<?php echo $r->link;?>" class="button medium"><?php echo $r->button;?></a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php break; ?>


<?php case 'iframe': ?>
<div class="content">
	<div class="row">
		<div class="columns medium-10 medium-offset-1">
			<?php if ($r->title) { ?>
			<h2><?php echo $r->title;?></h2>
			<?php } ?>

			<?php
			$url = $r->url;
			$isvideo = 0;
			if (strpos( $url , 'youtube') !== false) {
			    parse_str( parse_url( $url, PHP_URL_QUERY ), $urlid );
			    $url = "//www.youtube.com/embed/".$urlid['v'];
			    $isvideo = 1;
			}

			if (strpos($rurl, 'vimeo') !== false) {
			    $videoid = explode( '/', $url);
			    $videoid = $videoid[ count($videoid)-1 ];
			    $url = "//player.vimeo.com/video/".$videoid;
			    $isvideo = 1;
			}

			if (strpos($url, 'youtu.be') !== false) {
			    $videoid = explode( '/', $url);
			    $videoid = $videoid[ count($videoid)-1 ];
			   	$url = "//www.youtube.com/embed/".$videoid;
			   	$isvideo = 1;
			}
			?>
			<div class=" <?php if ( $isvideo ) echo 'flex-video'; ?>">
				<iframe src="<?php echo $url; ?>" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>
<?php break; ?>


<?php case 'gallery': ?>
<div class="gallery content">
	<div class="row">
		<div class="columns medium-12">
			
			<div class="slider">
			<ul>
				<?php
				foreach ($r->repeater as $c) { 
				?>
				<li>
					<a href="photos/1000_1000_<?php echo $c->image; ?>">
						<span class="img"  style="background-image: url('photos/280_280_<?php echo $c->image; ?>')"></span>
					</a>
				</li>
				<?php } ?>
			</ul>
			</div>

		</div>
	</div>
</div>	

<script type="text/javascript">
$(document).ready(function () {

$('.gallery ul').bxSlider({
	pager: false,
	auto: true,
	pause: 4000,
	controls: true,
	maxSlides: 4,
	minSlides: 1,
	slideWidth: 238
});

$('.gallery a').colorbox({
	'close': '<i class="fa fa-times" aria-hidden="true"></i>',
	'next': '<i class="fa fa-angle-right" aria-hidden="true"></i>',
	'previous': '<i class="fa fa-angle-left" aria-hidden="true"></i>',
	'maxWidth': '90%',
	'maxHeight': '90%',
	'transition': 'fade'
});

});
</script>
<?php break; ?>



<?php 
case 'form':
$emailto = openssl_encrypt ($r->emailto, 'AES-128-CBC', 'cms-key');
$redirect = openssl_encrypt ($r->redirect, 'AES-128-CBC', 'cms-key');

$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<script type="text/javascript">
$(document).ready(function () {
$('.contactform').attr('action', 'includes/actions.php');
});
</script>

<div class="content">
	<div class="row">
		<div class="columns medium-10 medium-offset-1">
			<h3>
				<?php echo $r->title;?>
			</h3>
			<?php echo $r->text;?>

			
			<form action="" data-abide class='contactform' method="post">
				<input type='hidden' name="action" value='contact'>
				<input type='hidden' name="formaction" value='<?php echo $emailto; ?>' >
				<input type='hidden' name="formred" value='<?php echo $redirect; ?>' >
				<input type='hidden' name="formurl" value='<?php echo $url; ?>' >
				<input type='hidden' name="subject" value='<?php echo $r->subject; ?>' >
				<div class="row">
					<?php
					foreach ($r->repeater as $i) {?>
						<div class="columns medium-<?php echo $i->size; ?> end">
							<label for="<?php echo slug($i->label);?>">
								<?php echo $i->label; ?>
							</label>

							<?php
							$required = '';
							if ($i->required) $required = ' required ';
							switch ($i->type) {
								case 'text':
									?>
									<input type="text" name='<?php echo slug($i->label);?>' <?php echo $required; ?>>
									<?php
								break;

								case 'email':
									?>
									<input type="text" name='<?php echo slug($i->label);?>' <?php echo $required; ?>>
									<?php
								break;

								case 'textarea':
									?>
									<textarea name="<?php echo slug($i->label);?>" id="" cols="30" rows="10" <?php echo $required; ?>></textarea>
									<?php
								break;


								case 'select':
									?>
									<select name='<?php echo slug($i->label);?>' <?php echo $required; ?> id="">
										<?php
										$options = preg_split("/\\r\\n|\\r|\\n/", $i->options);	
										foreach ($options as $v) { 
											?>
											<option><?php echo $v; ?></option>
										<?php } ?>
									</select>
									
									<?php
								break;


								case 'checkbox':
									?>
									<?php
									$options = preg_split("/\\r\\n|\\r|\\n/", $i->options);	
									$a = 0;
									foreach ($options as $v) { $a++;
									?>
									<label for="<?php echo slug($i->label);?>_<?php echo $a; ?>">
										<input id="<?php echo slug($i->label);?>_<?php echo $a; ?>" type="checkbox" name='<?php echo slug($i->label);?>[]' <?php echo $required; ?>>
										<?php echo $v; ?>
									</label>
									<?php } ?>
									<?php
								break;

								case 'radio':
									?>
									<?php
									$options = preg_split("/\\r\\n|\\r|\\n/", $i->options);	
									$a = 0;
									foreach ($options as $v) { $a++;
									?>
									<label for="<?php echo slug($i->label);?>_<?php echo $a; ?>">
										<input id="<?php echo slug($i->label);?>_<?php echo $a; ?>" type="radio" name='<?php echo slug($i->label);?>' <?php echo $required; ?>>
										<?php echo $v; ?>
									</label>
									<?php } ?>
									<?php
								break;
								
								default:
									# code...
									break;
							}?>
						</div>
						
					<?php } ?>
				</div>
				<div class="text-center">
					<button><?php echo $r->button;?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php break; ?>

<?php } ?>
<?php } ?>