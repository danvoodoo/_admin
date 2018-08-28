<?php
$bodyclass='';
include('includes/header.php');
?>

<div class="hero">
<div class="slider">
    <ul>

			<?php for($a=0;$a<5;$a++) { ?>
        	<li class="swiper-slide">

        		<div class="bg"  style='background-image: url("img/temp/01.jpg")'></div>
        		<!-- background image is in inline cause is being replaced by the cms -->
          
          		<div class="text">
	            	<h2>Title</h2>
	            	<p>
	            		BX Slider: <br>
	            		Docs in <a href="http://bxslider.com/options" target='_blank'>here</a>
	            	</p>
            	</div>
          
        	</li>
        	<?php } ?>

      	
    </ul>
 
</div>
</div> <!-- hero -->

<script type="text/javascript">
$(document).ready(function () {

$('.hero ul').bxSlider({
	pager: false,
	auto: true,
	pause: 4000,
	controls: true,
	onSlideBefore: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
		setTimeout(function () {
			$('.active-slide').removeClass('active-slide');
	    	$('.hero ul>li').eq(currentSlideHtmlObject + 1).addClass('active-slide')	
		},300);		    
	},
	onSliderLoad: function () {
		$('.hero ul>li').eq(1).addClass('active-slide')
	},
});

});
</script>

<section>
	<div class="row">
		<div class="columns medium-10 medium-offset-1 text-center">
			<h2>Section title</h2>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis felis id odio tempus vestibulum. Vestibulum viverra nunc vel tincidunt dignissim. Nam aliquam, diam ac faucibus scelerisque, felis quam sollicitudin urna, eget porta tellus tortor in felis. Ut leo purus, sagittis vitae dign.
			</p>

			<ul class="medium-block-grid-4">
				<?php for($a=0;$a<5;$a++) { ?>
				<li>
					<a href="img/temp/01.jpg" class='colorbox'>
						<img src="img/temp/01.jpg" alt="">
					</a>
				</li>	
				<?php } ?>
			</ul>

		</div>
		<div class="columns medium-10 medium-offset-1 end">

			<p>
				<a href="http://www.jacklmoore.com/colorbox/">Colorbox doc</a>
			</p>
			<p>
				<a href="http://foundation.zurb.com/sites/docs/v/5.5.3/">Foundation 5 docs</a>
			</p>
			<p>
				<a href="http://imakewebthings.com/waypoints/guides/jquery-zepto/">Waypoint (custom functions when an element is in the viewport)</a> <br>
				Waypoints is already build in as it is. Every < section > or < div class="section"> is added a class "in" when it reach half of the user view. <br>
				Check the parallax section on a practical example of this (the texts fade when users sees the section). <br>
				Also it executes a function, making it very easy to add effects to different sections. The function has to be declared somewhere, and then add the name of the function in a data-function attribute. Check the mapo for an example on this.
			</p>

			<p>
				<a href="http://t4t5.github.io/sweetalert/">Sweet alert (nicer alert box)</a>
			</p>

			

			

		</div>
	</div>	
</section>

<section class="parallaxexample">
	<div class="bg parallax2" data-speed='.5'  style="background-image: url('img/temp/01.jpg')"></div>
	<div class="text">
		<h2>Some text</h2>
		<a href="" class="button">Some button</a>
	</div>
</section>

<section data-function='mapfunction'>
	<div id="map"></div>
	<div class="row">
		<div class="columns medium-12">
			<p>
				<a href="http://www.pittss.lv/jquery/gomap/examples.php">Go map</a> <br>
				This gomap has some customs addons. It supports <a href="https://snazzymaps.com/">map themes </a> and some store location functions.
			</p>

		</div>
	</div>
</section>


<script>
function mapfunction () {
	sweetAlert('You have reach the map', "This function is called when the section reach half of the screen", "success");
}
$(document).ready(function () {
	$('.colorbox').colorbox(); 

	 $("#map").goMap({ 
        hideByClick: true ,
        maptype: 'ROADMAP',
        styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}],
        markers: [
			{  
            	id: 'markerid' ,
                //latitude: 0, 
            	//longitude: 0,
                title: "Title",
                address: 'Hereford',
                                         
                html: '<h3>title</h3>' ,
                icon: 'img/pin.png',
            }
        ] ,
        zoom: 15,
        ready: function () {

            if (navigator.geolocation) {
                position = navigator.geolocation.getCurrentPosition();
                //console.log(position);
                $.goMap.find_closest_marker( position.coords.latitude , position.coords.longitude );         
            } else {
              $.goMap.fitBounds();   
            }
        }
    }); 
});
</script>

    
<?php include('includes/footer.php');?>
