<?php
require_once("../includes/initialize.php");

define("PAGE_TITLE", "Home");
define("PAGE_JS", "home.js");
define("PAGE_CSS", "home.css");


Util::includeTemplate("public.header.php");
?>
<div class="wrapper">
	<section>
		<section class="slider neoslider">
			<img src="uploads/images/slide.jpg" data-tooltipheader="Nduledu water village" data-tooltipcontent="Explore the unlimited hidden connections of nature">
			<img src="uploads/images/slide.jpg" data-tooltipheader="Nduledu water village" data-tooltipcontent="Explore the unlimited hidden connections of nature">
		</section>
	</section>

	<!-- <section class="highlights-section">
		<figure>
			<img src="uploads/images/image.jpg">
			<figcaption>Image caption here</figcaption>
		</figure>
	</section> -->
</div>


<?php Util::includeTemplate("public.footer.php"); ?>
