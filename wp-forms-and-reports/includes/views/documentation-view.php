<?php
/*
 * @package WP_Forms_and_Reports
 */

function enqueue()
{
	wp_enqueue_style('mypluginstyle', plugins_url('../../assets/mystyle.css', __FILE__));
	wp_enqueue_style('bootstrapstyle', plugins_url('../../assets/bootstrap.min.css', __FILE__));
	wp_enqueue_style('w3style', plugins_url('../../assets/w3.css', __FILE__));
	wp_enqueue_script('bootstrapjqueryscript', plugins_url('../../assets/jquery-3.3.1.slim.min.js', __FILE__));
	wp_enqueue_script('bootstrapminscript', plugins_url('../../assets/bootstrap.min.js', __FILE__));
	wp_enqueue_script('bootstrappopperscript', plugins_url('../../assets/popper.min.js', __FILE__));	
	wp_enqueue_script('mypluginscript', plugins_url('../../assets/myscript.js', __FILE__));
}

function auth_instructions()
{
?>
	<div class="wrap">
		<h1 class="wp-heading-inline">Google Authorization Set Up</h1>
		<a href="?page=far_documentation" class="page-title-action float-right">Back</a>
		<h5 id="Contents">Contents</h5>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">
				<a href="#Step-1">Step 1</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-2">Step 2</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-3">Step 3</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-4">Step 4</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-5">Step 5</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-6">Step 6</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-7">Step 7</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-8">Step 8</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-9">Step 9</a>
			</li>
		</ul>
		<p>
			<h5 id="Step-1">Step 1</h5>
			<p>
				Navigate to your <a href="https://console.developers.google.com" target="_blank">Google Developers Console</a> and click on the "Select a project" dropdown. If this is your first project, you will need to accept the <a href="https://cloud.google.com/terms/?_ga=2.181061730.-494573085.1566536748">Google Cloud Platform terms of service</a> and press "AGREE AND CONTINUE" at the bottom right corner of the pop-up.
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-1.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-2">Step 2</h5>
			<p>
				Once you accept the <a href="https://cloud.google.com/terms/?_ga=2.181061730.-494573085.1566536748">Google Cloud Platform terms of service</a> click the "NEW PROJECT" button at the top right. If you have already created a project that you want to use, you can select the project and skip to <a href="#Step-5">step 5</a>.
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-2.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-3">Step 3</h5>
			<p>
				Enter a name for your project, and click the "CREATE" button at the bottom of the page. You can also use the default project name.
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-3.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-4">Step 4</h5>
			<p>
				The new project should have been already selected, but if it has not been selected. You can either select the project as described in the <a href="#Step-2">previous step</a> or go to your notifications and click on the project as seen in the image below. If you navigate to this page through the notifications. You will need to scroll down to the "Getting Started" section and click on "Explore and enable APIs".
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-4.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-5">Step 5</h5>
			<p>
				On the laft hand side there should be an item named "OAuth consent screen". Click this tab and fill out the "Application Name" and the "Authorized domains" fields as seen in the image below. In the Authorized domains field you need to put the base URL of the page that you want to enable the Google Authorization on. For example: if I wanted to use Google Authorization on "https://example.com/this-random-page", I would only need to put "example.com". Do not include "http://", "https://" or anything after the top level domain (.com, .net, .edu, .gov, .org, etc...).
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-6.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-6">Step 6</h5>
			<p>
				You should be automatically navigated to the "Credentials" tab. If you were not automatically navigated here, you will see the "Cridentials" tab directly above the "OAuth consent scree" tab used in the <a href="#Step-5">previous step</a>. Click on the "Create cridentials" dropdown and then click on the "OAuth client ID" option.
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-8.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-7">Step 7</h5>
			<p>
				Select "Web application" in the "Application type" section. Choose a name for your client ID and enter it into the "Name" field as seen in the image below. Click the "Create" button.
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-9.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-8">Step 8</h5>
			<p>
				You will see a screen that has a "client ID" and a "client secret". Copy the "client ID". You will need this in the next step.
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-10.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-9">Step 9</h5>
			<p>
				Navigate back to your <a href="index.php">WordPress Admin</a> page. Paste the OAuth client ID in the text box under the WP Forms and Reports <a href="?page=far_settings">"Settings"</a> tab. Click save. Congradulations! You can start creating forms that need to be logged into.
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/google-oauth-11.png', __FILE__); ?>" width="600" />
			</center>
		</p>
		
		<a href="?page=far_documentation" class="page-title-action float-right">Back</a>
	</div>
<?php
}

function paypal_instructions()
{
?>
	<div class="wrap">
		<h1 class="wp-heading-inline">Google Authorization Set Up</h1>
		<a href="?page=far_documentation" class="page-title-action float-right">Back</a>
		<h5 id="Contents">Contents</h5>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">
				<a href="#Step-1">Step 1</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-2">Step 2</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-3">Step 3</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-4">Step 4</a>
			</li>
			<li class="list-group-item">
				<a href="#Step-5">Step 5</a>
			</li>
		</ul>
		<p>
			<h5 id="Step-1">Step 1</h5>
			<p>
				
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/paypal-tutorial-1.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-2">Step 2</h5>
			<p>
				
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/paypal-tutorial-2.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-3">Step 3</h5>
			<p>
				
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/paypal-tutorial-3.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-4">Step 4</h5>
			<p>
				
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/paypal-tutorial-4.png', __FILE__); ?>" width="600" />
			</center>
			
			<h5 id="Step-5">Step 5</h5>
			<p>
				
			</p>
			<center>
				<img class="img-thumbnail" src="<?php echo plugins_url('../../assets/paypal-tutorial-5.png', __FILE__); ?>" width="600" />
			</center>
		</p>
	</div>
<?php
}

function __main()
{
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	
	<h5 id="Introduction">Introduction</h5>
	<p>
		Welcome to the WP Forms and Reports plugin for WordPrss! We are glad you have chose our pluign.
		
		<ul class="list-group list-group-flush">
			<li class="list-group-item">
				<a href="#Getting-Started">Getting Started</a>
			</li>
			<li class="list-group-item">
				<a href="#Short-Codes">Short Codes</a>
			</li>
			<li class="list-group-item">
				<a href="#Accounts-Page">The Accounts Page</a>
			</li>
			<li class="list-group-item">
				<a href="#Paypal">PayPal Buttons</a>
			</li>
			<li class="list-group-item">
				<a href="#Custom-Forms">Custom Forms</a>
			</li>
			<li class="list-group-item">
				<a href="#Donate">Donate</a>
			</li>
		</ul>
	</p>
	
	<h5 id="Getting-Started">Getting Started with WP Forms and Reports</h5>
	<p>
		In order to get the app up and running you must first set up the database. This process can take a while depending on the speed of your server. In order to complete this task, you must go to the "<a href="?page=far_settings">Settings</a>" page under the WP Forms and Reports menu and click on the button labled "Create Database".
	</p>
	
	<h5 id="Short-Codes">Short Codes</h5>
	<p>
		
	</p>
	
	<h5 id="Accounts-Page">The Accounts Page</h5>
	<p>
		We understand that some forms receive sensitive information. In order to make it easier for our users to post forms that will collect sensitive information we have integrated Google Open Authorization with our reports. This functionallity is 100% optional. In order for this functionallity to work, you must first go to the settings tab and turn on the Google Open Authorization switch and click save. You must also enter your Google OAuth Client ID in your <a href="https://console.developers.google.com/" target="_blank"> Google Developers Console</a>. For more instuctions on how to set up Google OAuth in your <a href="https://console.developers.google.com/" target="_blank">Google Developer Console</a> <a href="?page=far_documentation&ref=g-oauth">click here</a>.
	</p>
	
	<h5 id="Paypal">Adding PayPal Buttons (Must have a PayPal Business account)</h5>
	<p>
		The PayPal button question is only practical for people who have a PayPal business account. This is because the feature to forward <a href="?page=far_documentation&ref=paypal-instructions">click here</a>.
	</p>
	
	<h5 id="Custom-Forms">Custom Forms</h5>
	<p>
		
	</p>
	
	<h5 id="Donate">Donate</h5>
	<p>
		We appreciate your choice to use the WP Forms and Reports plugin. If you liked your experience with the plugin and would like to continue to see free updates, please donate to help us to be able to continue to support and update this plugin. Thank you!
		<center>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_donations" />
				<input type="hidden" name="business" value="3ZR6UYU6EFGEJ" />
				<input type="hidden" name="item_name" value="Continue to keep the WP Forms and Reports plugin free!" />
				<input type="hidden" name="currency_code" value="USD" />
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
			</form>
		</center>
	</p>
</div>

<?php
}
enqueue();

if (isset($_GET['ref']))
	$ref = $_GET['ref'];
else
	$ref = '';

switch ($ref)
{
	case 'g-oauth':
		auth_instructions();
		break;
	case 'paypal-instructions':
		paypal_instructions();
		break;
	case 'main':
	default:
		__main();
}