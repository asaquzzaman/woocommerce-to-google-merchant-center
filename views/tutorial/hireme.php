<?php

// $is_submit = false;
// $name = true;
// $email = true;
// $mail = false;

// if ( isset( $_POST['woogool_hireme_submit'] ) ) {
// 	$is_submit = true;
// 	$name = empty( $_POST['name'] ) ? false : sanitize_text_field( $_POST['name'] );
// 	$email = is_email( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : false;
// 	$subject = sanitize_text_field( $_POST['subject'] );
// 	$message = sanitize_textarea_field( $_POST['message'] );

// 	$header = [
// 		"From: $name <$email>"
// 	];

// 	$mail = wp_mail($email, $subject, $message, $header);
// }




?>

<div class="wrap woogool-hireme">
	<div class="form-wrap">
		<div class="title">You can hire me with a cup of coffee for any kind of wordPress solution.</div>
		<p class="hireme"><a href="http://wpspear.com/contact/" target="_blank" class="button button-primary">Hire me</a></p>
		<!-- <div class="form-content-wrap">
			<form action="" method="post">
				<div>

					<label class="label">Your name (required)</label>
					<input class="field" type="text" name="name">
					
						<?php 
						if(!$name) {
							?>

								<div class="help-text">This field is required!</div>
							<?php
						}
						?>
					
				</div>

				<div>
					<lable class="label">Your Email (required)</lable>
					<input class="field" type="email" name="email">
					<?php 
						if(!$name) {
							?>

								<div class="help-text">This field is required!</div>
							<?php
						}
					?>
				</div>	

				<div>

					<label class="label">Subject</label>
					<input class="field" type="text" name="subject">
				</div>

				<div>

					<lable class="label">Your Message</lable>
					<textarea class="field-textarea"  name="message"></textarea>
				</div>

				<div>
					<input class="button button-primary"  name="woogool_hireme_submit" type="submit" value="send">
				</div>	
				
					<?php if($mail) {
						?>
						<div class="successfully">Thank you for your message. It has been sent.</div>
						<?php
					}

					?>
				

			</form>
		</div> -->
	</div>
</div>

<style>
	.woogool-hireme .form-wrap .successfully {
		border: 2px solid #398f14;
	    margin-top: 10px;
	    padding: 3px;

	}
	.woogool-hireme .form-wrap .title {
	    background: #929eaa;
	    padding: 10px;
	    color: #f9f9f9;
	    font-size: 14px;
	}

	.woogool-hireme .form-wrap .hireme {
		margin-left: 10px;
	    margin-top: 10px;
	    font-style: normal;
	    font-size: 14px;
	    margin-bottom: 10px;
	}

	.woogool-hireme .form-wrap {
		margin-left: auto;
	    margin-right: auto;
	    border: 1px solid #ccc;
	    background: #fff;
	    width: 50%;
	}
	.woogool-hireme .form-content-wrap {
		padding: 10px;
	}
	.woogool-hireme .label {
		display: inline-block;
	    width: 28%;
	    margin-bottom: 15px;
	    vertical-align: top;
	}

	.woogool-hireme .field {
		height: 30px;
		width: 280px;

	}
	.woogool-hireme .field-textarea {
		width: 280px;
		height: 100px;
	}

	.woogool-hireme .form-wrap .help-text {
	    margin-left: 29%;
	    font-size: 10px;
	    font-style: italic;
	    color: #c1575c;
	    margin-bottom: 5px;
	    font-weight: 600;
	}
    
</style>


