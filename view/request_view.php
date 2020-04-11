<?php include 'header_view.php'; ?>
		<div id="content">
			<h2>Request <?php echo $this->subTitle; ?></h2>
			<?php
			//echo "test".$this->query;
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
			elseif ($this->query=='update') {				
				//include 'postupdate_part.php';
			}
			elseif ($this->query=='response') {
				include 'postview_part.php';
			}
			elseif ($this->query=='respond') {				
				//include 'postview_view.php';
			}
			else {
				//echo '<div><a id="add-request" class="link-button" href="/request/add">Post New Request</a></div>';
				include 'post_part.php';
			}
			?>			
			
			<?php //echo $this->requestTable; ?>			
			<?php //include 'post_view.php'; ?>			
		</div>
<?php include 'footer_view.php'; ?>