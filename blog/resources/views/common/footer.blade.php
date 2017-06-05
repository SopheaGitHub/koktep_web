<div class="container">
	<div class="dropup">
		<ul class="nav nav-pills">
		  <li role="presentation" class="dropdown">
		    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
		      
		      <?php
		      	if(\Lang::locale()=='en') { ?>
		      		<img style="margin-top:-3px;" src="<?php echo url('/images/flags/gb.png') ?>"> &nbsp; English
		      	<?php }else { ?>
		      		<img style="margin-top:-3px;" src="<?php echo url('/images/flags/kh.png') ?>"> &nbsp; Khmer
		      	<?php }
		      ?>
		      
		      <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu dropup">
		    	<li><a href="<?php echo url('/language?locale=en'); ?>"><img style="margin-top:-3px;" src="<?php echo url('/images/flags/gb.png') ?>"> English</a></li>
		    	<li><a href="<?php echo url('/language?locale=kh'); ?>"><img style="margin-top:-3px;" src="<?php echo url('/images/flags/kh.png') ?>"> Khmer</a></li>
		    </ul>
		  </li>
		  <li role="presentation" class="dropdown information">
		    <a href="#" role="button" data-toggle="information" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-university"></i>About Us</a>
		  </li>
		  <li role="presentation" class="dropdown">
		    <a href="#" role="button" data-toggle="information" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-phone"></i>Contact Us</a>
		  </li>
		  <li role="presentation" class="dropdown">
		    <a href="#" role="button" data-toggle="information" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-hand-paper-o"></i>Privacy Policy</a>
		  </li>
		  <li role="presentation" class="dropdown">
		    <a href="#" role="button" data-toggle="information" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-paperclip"></i>Terms &amp; Conditions</a>
		  </li>
		  <li role="presentation" class="dropdown">
		    <a href="#" role="button" data-toggle="information" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-envelope"></i>Send Feedback</a>
		  </li>
		</ul>
	</div>
</div>
<script type="text/javascript">

</script>