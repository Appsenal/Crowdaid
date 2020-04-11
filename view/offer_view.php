<?php include 'header_view.php'; ?>
	<div id="content">
		<h2>Offer <?php echo $this->subTitle; ?></h2>
		<?php
		if ($this->query=='add') {
			include 'postadd_part.php';
		}
		elseif ($this->query=='photo') {
			//include 'photo_view.php';
			include 'postview_part.php';
		}
		elseif ($this->query=='view') {
			include 'postview_part.php';
		}
		elseif ($this->query=='response') {
			include 'postview_part.php';
		}
		elseif ($this->query=='respond') {
		//	include 'postview_view.php';
		}
		else {
			//echo '<p>You have '.$this->userPostCount.' active offers. Please select action.</p>
			//<a id="add-request" class="link-button" href="/offer/add">New Offer</a>'.$this->requestTable;
			include 'post_part.php';
		}
		?>					
	</div>
<?php include 'footer_view.php'; ?>