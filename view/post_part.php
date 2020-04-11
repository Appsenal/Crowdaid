<div id="post-box" class="content-box">
	<div id="view-box" class="content-box">
		<div class="tab-label">							
			<?php 
			echo '<a class="tab '.(($this->query=='')?'tab-focus':'').'" href="/'.$this->view.'/'.$this->key.'">Open</a>
				<a class="tab '.(($this->query=='accepted')?'tab-focus':'').'" href="/'.$this->view.'/accepted/'.$this->key.'">Accepted</a>
				<a class="tab '.(($this->query=='closed')?'tab-focus':'').'" href="/'.$this->view.'/closed/'.$this->key.'">Closed</a>
				<a class="tab '.(($this->query=='cancelled')?'tab-focus':'').'" href="/'.$this->view.'/cancelled/'.$this->key.'">Cancelled</a>
				<a class="tab '.(($this->query=='responded')?'tab-focus':'').'" href="/'.$this->view.'/responded/'.$this->key.'">Responded</a>';
			?>
			<a id="add-request" class="tab" href="/<?php echo $this->view; ?>/add">Post New <? echo ($this->view=='request')?'Request':'Offer' ?></a>
		</div>
		<div class="tab-content">
			<?php 
			if ($this->view=='request') {
				$postypetext='request(s)';
			}
			else {
				$postypetext='offer(s)';
			}

			if ($this->query=='accepted') {
				$statustext='accepted';
			}
			elseif ($this->query=='closed') {
				$statustext='closed';
			}
			elseif ($this->query=='cancelled') {
				$statustext='cancelled';
			}
			elseif ($this->query=='responded') {
				$statustext='responded';
			}
			else {
				$statustext='open';
				//echo '<p>You have '.$this->userPostCount.' active requests. Please select action.</p>';				 
			}

			if ($this->query=='responded') {
				echo '<p>You have '.$statustext.' '.$this->userPostCount.' '.$postypetext.'. Please select action.</p>';
			}
			else {
				echo '<p>You have '.$this->userPostCount.' '.$statustext.' '.$postypetext.'. Please select action.</p>';
			}
			echo $this->requestTable;
			?>
		</div>
	</div>
</div>