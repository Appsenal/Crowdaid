<?php include 'header_view.php'; ?>		
		<div id="content">
			<?php 
				if ($this->isLogin) {
					echo '<h2>Welcome to Crowd Aid!</h2>';
					echo '<p>You can start using it by updating your <a href="/profile">Profile</a>, logging a <a href="/request">Request</a> or logging an <a href="/offer">Offer</a>.</p>';
					//echo '<p>Alternatively, you can also check our <a href="/about">About Us</a> page or talk with us in <a href="/contact">Contact Us</a> page. We would love to hear what you think about Crowd Aid.</p>';					
					echo '<h3>Request</h3><h4>There is/are '.$this->requestCount.' open requests from other members that you need to look at.</h4>'.$this->requestTable;
					echo '<h3>Offer</h3><h4>There is/are '.$this->offerCount.' open offers from other members that might be helpful to you.</h4>'.$this->offerTable;
				}
				else {
					$requesttext='';
					$offertext='';
					if ($this->offerCount>0) {
						$offertext='<h4>'.$this->offerCount.' open offers that may help you.</h4>';
					}
					if ($this->requestCount>0) {
						//$requesttext='<h4>There are currently '.$this->requestCount.' active requests that you can help.</h4>'.$this->requestTable;
						$requesttext='<h4>'.$this->requestCount.' open requests that you can help.</h4>';
					}
					
					echo '<h2>Join the crowd!</h2> 
							<h3><span style="color: #e27c00;">Do you need medical or health related assistance?</span></h3> 
							<h3><span style="color: #e27c00;">Or do you want to make a difference by helping other people?</span></h3><br />';
					echo '<h3>In Crowd Aid there are, </h3>
							<h4>'.$this->activeMemberCount.' active members ready to help you.</h4>
							'.$offertext.$requesttext;
					echo '<br/><p><a id="about-button" class="link-button home-button" href="/about">What is Crowd Aid?</a>';
					echo '<a id="join-button" class="link-button home-button" href="/signup">Join Now!</a></p>';
					
				}
			?>

			<!--h2><span style="color: #d82a02;">Do you need medical or health related help?</span></h2-->
						
		</div>
<?php include 'footer_view.php'; ?>