<?php
	// load up global things
	include_once 'autoloader.php';
	
	// only if you are logged out can you view the get started page
	loggedInRedirect();
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- icon of our page -->
		<link rel="icon" type="image/png" sizes="32x32" href="css/favicon-32x32.png">
		
		<!-- title of our page -->
		<title>FITchen | Get Started</title>

		<!-- need this so everything looks good on mobile devices -->
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

		<!-- css styles for our Get Started page-->
		<link rel="stylesheet" href="css/global.css">
		<link rel="stylesheet" href="css/home.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/animate.css">
		<link rel="stylesheet" href="css/owl.carousel.css">
		<link rel="stylesheet" href="css/owl.theme.default.min.css">
		<link rel="stylesheet" href="css/magnific-popup.css">

		<!-- jquery and icons -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/c1674e9cf8.js" crossorigin="anonymous"></script>	
	</head>
	<body>
		<div class="background-video-container">
			<video class="background-video-element" autoplay muted loop >
				<source src="assets/background_video.mp4" />
			</video>
			<div class="background-video-overlay"></div>
			<img class="background-video-image" src="assets/background_video_image.jfif" />
			<div class="background-video-text-overlay">
				<div>Welcome to FITchen</div>
				<div class="sub-text">Your Kitchen to Fitness <?php echo "<br>"; ?></div>
				<div class="action-container pc-only">
					<a class="a-action" href="signup_or_login.php">
						<div class="desktop-button-container">
							<div class="button-container-pad">
								Get Started
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="content-inner">
				<div class="content-inner-padding">
					<div class="action-container mobile-only">						
						<a class="a-action" href="signup_or_login.php">
							<div class="mobile-button-container default-margin-top">
								<div class="button-container-pad">
									Get Started
								</div>
							</div>
						</a>
					</div>
					
					<!-- ABOUT US -->
					<section id="about" data-stellar-background-ratio="0.5">
						<div class="container">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="about-info">
										<div class="section-title wow fadeInUp" data-wow-delay="0.2s">
										    <h4>About us</h4>
										    <h2>We've been Making Tailored Meal Plans Since 2016</h2>
										</div>
										<div class="wow fadeInUp" data-wow-delay="0.4s">
										    <p>FITchen is a weekly food subscription service that profiles average people, sports enthusiasts and athletes to provide them a healthy and focused diet specifically tailored to them for it to help them perform better in their work out or sport.</p>
										    <p>We are all about cleaning out poor food choices, and replacing them with the most beneficial foods we can find. As long as people are making the right food choices, then we know they’ll get the results they’re looking for. <a href="signup_or_login.php">Learn more</a></p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="wow fadeInUp about-image" data-wow-delay="0.6s">
									    <img src="assets/about-image.jpg" class="img-responsive" alt="">
									</div>
								</div>									
							</div>
						</div>
					</section>
					 
					<!-- MEAL PLANS -->
					<section id="team" data-stellar-background-ratio="0.5">
						<div class="container">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="section-title wow fadeInUp" data-wow-delay="0.1s">
										<h2>The Meal Plans</h2>
										<h4>See which one's right for you</h4>
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<a href="signup_or_login.php">
										<div class="team-thumb wow fadeInUp" data-wow-delay="0.2s">
											<img src="assets/plan-image1.jpg" class="img-responsive" alt="">
											<div class="team-hover">
												<div class="team-item">
													<h4>Just looking for a healthy alternative that you can cook at home? Here at FITchen, we guarantee the freshness of all our ingredients and deliver them in an insulated box right to your door.</h4> 
													<ul class="social-icon">
														<li><a href="#" class="fa fa-facebook-square"></a></li>
														<li><a href="#" class="fa fa-instagram"></a></li>
													</ul>
												</div>
											</div>
										</div>
									</a>
									<div class="team-info">
										<h3>Level 1</h3>
										<p>Healthy Alternative</p>
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<a href="signup_or_login.php">
										<div class="team-thumb wow fadeInUp" data-wow-delay="0.4s">
											<img src="assets/plan-image2.jpg" class="img-responsive" alt="">
											<div class="team-hover">
												<div class="team-item">
													<h4>Need a controlled diet to go with your workout? You're in the right place! Here at FITchen, your diet plan is equally as important as your workout routine (if not more so) in terms of getting the results you want to get.</h4>
													<ul class="social-icon">
														<li><a href="#" class="fa fa-facebook-square"></a></li>
														<li><a href="#" class="fa fa-instagram"></a></li>
													</ul>
												</div>
											</div>
										</div>
									</a>
									<div class="team-info">
										<h3>Level 2</h3>
										<p>Work-out Focused</p>
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<a href="signup_or_login.php">
										<div class="team-thumb wow fadeInUp" data-wow-delay="0.6s">											 
											<img src="assets/plan-image3.jpeg" class="img-responsive" alt="">
											<div class="team-hover">
												<div class="team-item">
													<h4>Need a specific diet to help you do better in your sport? We got you! Here at FITchen, a well-planned &amp; nutritious diet should meet most of an athlete’s vitamin and mineral needs to enhance sporting performance.</h4>
													<ul class="social-icon">
														<li><a href="#" class="fa fa-facebook-square"></a></li>
														<li><a href="#" class="fa fa-instagram"></a></li>
													</ul>
												</div>
											</div>
										</div>
									</a>
									<div class="team-info">
										<h3>Level 3</h3>
										<p>Sports Tailored</p>
									</div>
								</div>
									
							</div>
						</div>
					</section>
					 
					<!-- FOOTER -->
					<footer id="footer" data-stellar-background-ratio="0.5">
						<div class="container">
							<div class="row">
								<div class="col-md-3 col-sm-8">
									<div class="footer-info">
										<div class="section-title">
											<h2 class="wow fadeInUp" data-wow-delay="0.2s">Find us</h2>
										</div>
										<address class="wow fadeInUp" data-wow-delay="0.4s">
										    <p>@1st floor SM City Calamba<br>or<br>@2nd floor SM City Santa Rosa<br>Laguna, Calabarzon region</p>
										</address>
									</div>
								</div>
								<div class="col-md-3 col-sm-8">
									<div class="footer-info">
										<div class="section-title">
											<h2 class="wow fadeInUp" data-wow-delay="0.2s">Contact Information</h2>
										</div>
										<address class="wow fadeInUp" data-wow-delay="0.4s">
											<p>090-080-0650 | 090-070-0430</p>
											<p><a href="mailto:ask@fitchen.com">ask@fitchen.com</a></p>
											<p>LINE: FITchen </p>
										</address>
									</div>
								</div>
								<div class="col-md-4 col-sm-8">
									<div class="footer-info footer-open-hour">
										<div class="section-title">
											<h2 class="wow fadeInUp" data-wow-delay="0.2s">Operating Hours</h2>
										</div>
										<div class="wow fadeInUp" data-wow-delay="0.4s">
											<div>
												<strong>Monday to Friday</strong>
												<p>7:00 AM - 9:00 PM</p>
											</div>
											<div>
												<strong>Saturday - Sunday</strong>
												<p>10:00 AM - 10:00 PM</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-4">
									<ul class="wow fadeInUp social-icon" data-wow-delay="0.4s">
										<li><a href="#" class="fa fa-facebook-square" attr="facebook icon"></a></li>
										<li><a href="#" class="fa fa-twitter"></a></li>
										<li><a href="#" class="fa fa-instagram"></a></li>
										<li><a href="#" class="fa fa-google"></a></li>
									</ul>
									<div class="wow fadeInUp copyright-text" data-wow-delay="0.8s"> 
										<p><br>Copyright &copy; 2021 <br>FITchen</p>
									</div>
								</div>									
							</div>
						</div>
					</footer>					
				</div>
			</div>
		</div>
		
		<!-- SCRIPTS -->
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.stellar.min.js"></script>
		<script src="js/wow.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/jquery.magnific-popup.min.js"></script>
		<script src="js/smoothscroll.js"></script>
		<script src="js/custom.get.started.js"></script>
	</body>
</html>