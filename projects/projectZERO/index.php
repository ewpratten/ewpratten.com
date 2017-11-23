 <!--

   _____           _           _   ____________ _____   ____
  |  __ \         (_)         | | |___  /  ____|  __ \ / __ \
  | |__) | __ ___  _  ___  ___| |_   / /| |__  | |__) | |  | |
  |  ___/ '__/ _ \| |/ _ \/ __| __| / / |  __| |  _  /| |  | |
  | |   | | | (_) | |  __/ (__| |_ / /__| |____| | \ \| |__| |
  |_|   |_|  \___/| |\___|\___|\__/_____|______|_|  \_\\____/
                 _/ |
                |__/
                
  |---------------------------------------------------------|
  |						Website Credits						|
  |				Front / Back end: Evan Pratten				|
  |					Artwork: Nathan Desjardins				|
  |---------------------------------------------------------|
  
  Check out my main website:
  
  Http://retrylife.ca
  
  
  Links:
  
  	Ewpratten:
  		
  		Github: https://github.com/Ewpratten/
  		Devrant: https://devrant.com/users/ewpratten
  		
  	Nds:
  	
  		Devrant: https://devrant.com/users/desjna
  
  -----
  NOTES:
  
  There is a lot of half working code here.. so sory if you cant figure it out.
  
  I also was too lazy to comment the code.

-->



<!-- php link processing -->
<?php
if($_GET['redirect'] == "donate"){
	echo "<script>window.location = 'http://retrylife.ca/donate';</script>";
}

// easter eggs

if($_GET['tgif'] == "true"){
	$TGIF = 1;
}

// setcookie("name","value",time()+$int);



?>

<head>
	<link href="./<?php if($_GET['theme'] == "dark"){echo "css/picnic.dark.css";}else{ echo "css/picnic.min.css";} ?>" rel="stylesheet" media="all">
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
	<meta name="viewport" content="width=device-width, inital-scale=1">
	<link href="css/hover.css" rel="stylesheet" media="all">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<!-- <link href="./css/main.css" rel="stylesheet" media="all"> -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-61008630-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-61008630-1');
</script>

	<style>
		#floater {
    float: left;
    height: 50%;
    width: 100%;
    margin-bottom: -110px;
}

#child {
    clear: both;
    height: 100px;
    text-align:center
}
body {
	
}
.spacer {
	background-color:#2f3136;
	width:100%;
	height:10;
}
.front {
	width:auto;
    background-color:rgba(25, 29, 25, 0.7);
    color:#fff;
}
.coverimg {
	filter: blur(5px);
// Browser Specific
-webkit-filter: blur(5px);
-moz-filter: blur(5px);
-o-filter: blur(5px);
-ms-filter: blur(5px);
}
footer {
	color: rgb(255, 255, 255);
}
#gradient
{
  width: 100%;
  height: 100%;
  padding: 0px;
  margin: 0px;
}
.border {
    border-color: white;
    border-style: solid;
    width: fit-content;
    border-radius: 100%;
}
.ewp {
    border-radius: 100%;
}

a.button.hvr-bob {
    border-radius: 100%;
    background-color: rgba(255, 255, 255, 0);
}
img.dri {
    height: 20%;
}
a.abc {
    color: #405c7d;
}
.line .linev {
	background-color:black;
}
.line {
	height: 1;
	width:100%;
}
.linev {
	height:100%;
	width:1;
}
.aptprice {
    background-color: #3d414a;
    color: whitesmoke;
}
.darkbox {
    border-color: white;
    border-width: 10px;
}

.darkbox {
    border-radius: .2em;
    border: 1px solid rgba(204, 204, 204, 0.14);
}
	</style>
</head>
<body>

	<script>
		var colors = new Array(
  [62,35,255],
  [60,255,60],
  [255,35,98],
  [45,175,230],
  [255,0,255],
  [255,128,0]);

var step = 0;
//color table indices for:
// current color left
// next color left
// current color right
// next color right
var colorIndices = [0,1,2,3];

//transition speed
var gradientSpeed = 0.002;

function updateGradient()
{
  
  if ( $===undefined ) return;
  
var c0_0 = colors[colorIndices[0]];
var c0_1 = colors[colorIndices[1]];
var c1_0 = colors[colorIndices[2]];
var c1_1 = colors[colorIndices[3]];

var istep = 1 - step;
var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
var color1 = "rgb("+r1+","+g1+","+b1+")";

var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
var color2 = "rgb("+r2+","+g2+","+b2+")";

 $('#gradient').css({
   background: "-webkit-gradient(linear, left top, right top, from("+color1+"), to("+color2+"))"}).css({
    background: "-moz-linear-gradient(left, "+color1+" 0%, "+color2+" 100%)"});
  
  step += gradientSpeed;
  if ( step >= 1 )
  {
    step %= 1;
    colorIndices[0] = colorIndices[1];
    colorIndices[2] = colorIndices[3];
    
    //pick two new target color indices
    //do not pick the same as the current one
    colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    
  }
}

setInterval(updateGradient,10);
	</script>
<div>
<nav class="demo imponent">
<a href="" class="brand">
<span>
<?php

// this is temp
if($TGIF == 1){
	echo "ITS FRIDAY!";
}
else{
if($_GET['scoreboard'] == "show"){
	echo "Your Score: ", $_GET['score'];
}
else{
	echo "Project ZERO";
}}

?>
</span>
</a>
<input id="bmenub" type="checkbox" class="show">
  <label for="bmenub" class="success burger button">menu</label>

  <div class="menu">
  	
  	
  	
	<a href="https://twitter.com/ProjectZERO_nr?ref_src=twsrc%5Etfw" class="button">Twittter</a>
	<a href="https://www.instagram.com/projectzero_nr/" class="button">Instagram</a>
	<a href="/#office" class="button">Office Space</a>
	<a href="#housing" class="button">Housing</a>
	<a href="#design" class="button">Design</a>
<?php
$pagestate = $_GET['page'];
if($pagestate == "")
$currentPage = "home";
if($currentPage != "home"){
    echo '<a href="./index.html" class="button">Home</a>';
}
?>
  </div>
</nav>
</div>



<br>
<br>

<div class="frontpage" >
	
	<img src="./img/cover.png" width="100%">
</div>


<!--
<div style="height:300">
	<?php
//	if($_GET['lagmode'] != "reduce"){
//	echo '<div id="gradient" />';
//	}
	?>
<!-- im a spacer -->


<!--
<div id="floater"></div>
    <div id="child">
    	<div class="front">
<h1>
-->
<?php

//$text = array("P", "r", "o", "j", "e", "c", "t", " ", "Z", "E", "R", "O");
//$text2 = array("A", "n", " ", "a", "d", "v", "a", "n", "c", "e", "d", " ", "c", "o", "m", "m", "u", "n", "i", "t", "y", " ", "l", "i", "v", "i", "n", "g", " ", "s", "p", "a", "c", "e");

//for($i = 0; $i <= 12 ; $i++){
//	echo $text[$i];
//}

//echo "</h1><h1>";

//for($ix = 0; $ix <= 33; $ix++){
//	echo $text2[$ix];
//}
?>
<!--
</h1>
</div>
</div>
-->


</div>
</div>
<div class="spacer"></div>

<div class="housing" id="housing">
	<div style="align:center:">
		<h1 align="center">Housing</h1>
		</div>
		
		<div class="flex one three-600 demo">
			<div><span><article class="card"><header>
    	<h3>Pricing</h3>
  </header>
  
  <p>All housing units can be rented for an affordable price and come outfitted with modern appliences.</p>
  
  <footer>
    <a href="#aptprices"><button>Learn More</button></a>
  </footer></article></span></div>
			<div><span><article class="card"><header>
    	<h3>Unit Styles</h3>
  </header>
  
  <p>All housing units are modular and come in two story sections. They can also be joined with a neighbouring unit for extra space.</p>
  
  <footer>
    <a href="#design2"><button>Check it out</button></a>
  </footer></article></span></div>
			<div><span><article class="card"><header>
    	<h3>Corporate Reservations</h3>
  </header>
  
  <p>We allow any company who is currently renting a modular office space to also rent housing for their employees.</p>
  
  <footer>
    <a href="#group"><button>Learn More</button></a>
  </footer></article></span></div>
		</div>
</div>

<div class="spacer"></div>

<div class="offices" id="office">
	<div style="align:center:">
		<h1 align="center">Office Spaces</h1>
		</div>
		
		<div class="flex one three-600 demo">
			<div><span><article class="card"><header>
    	<h3>Pricing</h3>
  </header>
  
  <p>All office units can be rented for an affordable price and can be outfitted with modern appliences, furniture, and a TV.</p>
  
  <footer>
    <a href="#officeprices"><button>Learn More</button></a>
  </footer></article></span></div>
			<div><span><article class="card"><header>
    	<h3>Unit Styles</h3>
  </header>
  
  <p>All Office units are modular and come in one and two story sections. They can also be joined with a neighbouring unit for extra space.</p>
  
  <footer>
    <a href="#officedesign"><button>Check It Out</button></a>
  </footer></article></span></div>
			<div><span><article class="card"><header>
    	<h3>Food and Conveniences</h3>
  </header>
  
  <p>All spaces are heated and cooled to keep the temprature allways enjoyable. In the central park, there are places to buy food and eat.</p>
  
  <footer>
    <button>Learn More</button>
  </footer></article></span></div>
		</div>
</div>





<div class="spacer"></div>

<!--
?php
/*
Configuration Array
 
explanation of each option can be seen here : https://dev.twitter.com/docs/api/1/get/statuses/user_timeline
 
user = the screen_name of the twitter user you wish to query
count = the "maximum" number of items to be returned
retweet = true or false to include retweets in the response
entities = true or false
exclude_replies = true or false to exclude replies
contributor_details = true or false
trim_user = true or false to trim extra user details
 
*/
 
$twitter = array(
	"user" => "karlblessing",
	"count" => "4",
	"retweet" => "true",
	"entities" => "true",
	"exclude_replies" => "true",
	"contributor_details" => "false",
	"trim_user" => "false"
);
 
// a small function to convert "created at" time to [blank] minutes/hours/days ago
 
function relativeTime($time)
{
    $delta = strtotime('+2 hours') - strtotime($time);
    if ($delta < 2 * MINUTE) {
        return "1 min ago";
    }
    if ($delta < 45 * MINUTE) {
        return floor($delta / MINUTE) . " min ago";
    }
    if ($delta < 90 * MINUTE) {
        return "1 hour ago";
    }
    if ($delta < 24 * HOUR) {
        return floor($delta / HOUR) . " hours ago";
    }
    if ($delta < 48 * HOUR) {
        return "yesterday";
    }
    if ($delta < 30 * DAY) {
        return floor($delta / DAY) . " days ago";
    }
    if ($delta < 12 * MONTH) {
        $months = floor($delta / DAY / 30);
        return $months <= 1 ? "1 month ago" : $months . " months ago";
    } else {
        $years = floor($delta / DAY / 365);
        return $years <= 1 ? "1 year ago" : $years . " years ago";
    }
}
 
// prepare the array
 
$twitter_feed = array();
 
// form the API url for the request
 
$api_url = "https://api.twitter.com/1/statuses/user_timeline/".$twitter['user'].
	".json?include_entities=".$twitter['entities'].
	"&include_rts=".$twitter['retweet'].
	"&exclude_replies=".$twitter['exclude_replies'].
	"&contributor_details=".$twitter['contributor_details'].
	"&trim_user=".$twitter['trim_user'].
	"&count=".$twitter['count'];
 
// obtain the results
 
$json = file_get_contents($api_url, true);
 
// decode the json response as a PHP array
 
$decode = json_decode($json, true);
 
//check for error during the last decode
if(json_last_error != JSON_ERROR_NONE) {
	// http://www.php.net/manual/en/function.json-last-error.php
	$twitter_feed[] = array('error' => "Unable to decode response");
} elseif(isset($decode['errors'])) {
	// just grabbing the first error listed
	$twitter_feed[] = array('error' => $decode['errors'][0]['message']);
} else {
	// if no decode or twitter response errors then proceed.
 
	foreach($decode as $tweet) {
		// If you are including retweets, you may want to check the status
		// as the main text is truncated as opposed to the original tweet
 
		// If you used the trim_user option, the retweeted user screen name will not be avaialble
 
		if (isset($tweet['retweeted_status'])) {
			$tweet_text = "RT @{$tweet['retweeted_status']['user']['screen_name']}:
			{$tweet['retweeted_status']['text']}";
		} else {
			$tweet_text = $tweet['text'];
		}
 
		$twitter_feed[] = array(
			'text' => $tweet_text,
			'created_at' => relativeTime($tweet['created_at']),
			'link' => "http://twitter.com/".$twitter['user']."/status/".$tweet['id']
		);
 
		unset($tweet_text);
	}
}
 
unset($decode, $json, $tweet);
?
-->

<!--
?php
 
// in a later portion of your code or page you can break down the array like so:
 
foreach($twitter_feed as $tweet) {
	echo "<a href=\"{$tweet['link']}\" target=\"_blank\">{$tweet['text']}</a><br>{$tweet['created_at']}<br><br>";
}
 
?
-->
<!--
 <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
 <a class="twitter-timeline" href="https://twitter.com/ProjectZERO_nr?ref_src=twsrc%5Etfw">Tweets by ProjectZERO_nr</a>
-->
<!--
<div class="flex one three-600 demo">
			<div><span><article class="card">
<a href="https://twitter.com/ProjectZERO_nr?ref_src=twsrc%5Etfw" align="center" class="twitter-follow-button" data-show-count="false"><button>Follow @ProjectZERO on twittter</button></a>
</article></span></div>
<div><span><article class="card"><h1>Follow our social media to see new updates</h1></article></article></span></div>
<div><span><article class="card">
	<a href="https://www.instagram.com/projectzero_nr/" class="twitter-follow-button" data-show-count="false" align="center"><button>Follow @ProjectZERO on instagram</button></a>
	
	
	
	</article></article></span></div>
	</div>

<div class="spacer"></div>
-->

<div class="flex one-0 three-600 demo" id="design">
  <div class="two-third"><span>
  	<img src="./img/cross.png" style="width:100%">
  </span></div>
  <div><span>
  	
  	<article class="card"><header>
    	<h3>The Ring</h3>
  </header>
  
  <p>This is a cross section of the ring, where residential spaces can be found on the left and shared offices on the right.</p>
  
  </article>
  </span></div>
  
</div>

<div class="spacer"></div>
<!--

max units:20
10 office

housing
empty room: $100/ month
The essentials: $250/ month
2 rooms + essentials: $450/ month

$200
electricity

$400
desk, whiteboard, chairs

$1500
speakers, 70" 4k tv
-->
<div class="grouprent" id="group">
	
	<div class="aptprice">
	<div style="align:center:">
		<h1 align="center">Company Rented Living Spaces</h1>
		</div>
		
		<div class="flex one three-600 demo">
			
				<div style="text-align:center;"><span>
				
				
				
			</span></div>
			<div style="text-align:center;"><span>
				
				<h3>Any company is allowed to rent up to 10 shared offices spaces and up to 20 living spaces of any tier</h3>
				</span></div>
			
			<div style="text-align:center;"><span>
				
				
				</span></div>
		</div>

<br>
<br>
</div>
	
</div>

<div class="spacer"></div>
<div class="flex one-0 three-600 demo" id="design2">
  <div class="two-third"><span>
  	<img src="">
  	<h1>(Image of living space)</h1>
  </span></div>
  <div><span>
  	<article class="card"><header>
    	<h3>Living Spaces</h3>
  </header>
  
  <p>(add details about the apartments)</p>
  
  </article>
  </span></div>
  
</div>

<div class="spacer"></div>

<div class="aptprice" id="aptprices">
	<div style="align:center:">
		<h1 align="center">Apartment Pricing</h1>
		</div>
		
		<div class="flex one three-600 demo">
			
				<div style="text-align:center;" class="darkbox"><span>
				
				<h1>$350 / Month</h1>
				<h3>The Minimalist</h3>
				<h5>An unfurnished room with electricity and water</h5>
				
			</span></div>
			<div style="text-align:center;" class="darkbox"><span>
				
			<h1>$600 / Month</h1>
				<h3>The Essentials</h3>
				<h5>Finished kitchen and living space</h5>
				</span></div>
			
			<div style="text-align:center;" class="darkbox"><span>
				
				<h1>$1000 / Month</h1>
				<h3>The Luxurious</h3>
				<h5>A fully furnished room with everything you need</h5>
				
				</span></div>
		</div>

<br>
<br>
</div>
<div class="spacer"></div>

<div class="flex one-0 three-600 demo" id="officedesign">
	<div><span>
  	<article class="card"><header>
    	<h3>Office Spaces</h3>
  </header>
  
  <p>(add details about the offices)</p>
  
  </article>
  </span></div>
  
  <div class="two-third"><span>
  	<img src="./img/office.png" width="100%">
  </span></div>
  
  
</div>
<!--
$200
electricity

$400
desk, whiteboard, chairs

$1500
speakers, 70" 4k tv
-->
<div class="spacer"></div>
<div class="aptprice" id="officeprices">
	<div style="align:center:">
		<h1 align="center">Office Pricing</h1>
		</div>
		
		<div class="flex one three-600 demo">
			
				<div style="text-align:center;" class="darkbox"><span>
				
				<h1>$200 / Month</h1>
				<h3>The Minimalist</h3>
				<h5>An unfurnished room with electricity</h5>
				
			</span></div>
			<div style="text-align:center;" class="darkbox"><span>
				
			<h1>$400 / Month</h1>
				<h3>The Essentials</h3>
				<h5>Comes with desks, whiteboard, and chairs</h5>
				</span></div>
			
			<div style="text-align:center;" class="darkbox"><span>
				
				<h1>$1500 / Month</h1>
				<h3>The Luxurious</h3>
				<h5>The previous tiers, with surround sound speakers, 4 desktop computers, and a 70" 4k TV</h5>
				
				</span></div>
		</div>

<br>
<br>
</div>
<div class="spacer"></div>

<div class="flex one-0 three-600 demo" id="design2">
  <div class="two-third"><span>
  	<img src="./img/rec.png" width="100%">
  </span></div>
  <div><span>
  	<article class="card"><header>
    	<h3>Recteational Space</h3>
  </header>
  
  <p>(add details about the rec space)</p>
  
  </article>
  </span></div>
  
</div>

<div class="spacer"></div>
<div class="flex one-0 three-600 demo" id="officedesign">
	<div><span>
  	<article class="card"><header>
    	<h3>Solar Power</h3>
  </header>
  
  <p>(add details about solar)</p>
  
  </article>
  </span></div>
  
  <div class="two-third"><span>
  	<img src="./img/solar.png" width="100%">
  </span></div>
  
  
</div>


<footer>
<div width="100%"  style="background-color: #243447;height:auto;">
<!-- <h3>Website by: <a href="https://ewpratten.github.io">Ewpratten</a></h3> -->

<!--
<div class="dr" style="white-space: nowrap;width: 90%;float: left;">
		<div class="ewp" style="display: inline-block;">
			<a href="https://devrant.com/users/ewpratten" title="ewpratten" class="button hvr-bob">
				<div class="border">
			<img style="border-radius: 100%;" class="dri" src="https://avatars.devrant.com/v-18_c-3_b-1_g-m_9-1_1-6_16-8_3-3_8-4_7-4_5-3_12-6_17-2_6-34_10-9_2-47_11-4_18-4_4-3_19-3_20-5_21-2.jpg">
			</div>
			</a>
			</div>
			<div class="404" style="display: inline-block;">
				<a href="https://devrant.com/users/desjna" title="desjna" class="button hvr-bob">
					<div class="border">
					<img style="border-radius: 100%;" class="dri" src="https://avatars.devrant.com/v-18_c-3_b-4_g-m_9-1_1-9_16-15_3-3_8-1_7-1_5-1_12-9_6-40_2-39_4-1.jpg">
					</div>
				</a>
			</div>
				
        </div>
        -->
        

<div class="credits" width="100%">
<p>Project by: <a title="My name is Evan" href="https://github.com/Ewpratten" style="color: white;">ewpratten</a>, Maya, Sarah, <a href="http://glitchop.newgrounds.com" style="color:white;" title=" ">Nathan</a><a class="abc" title="Hey look! You can click me to make a donation!" href="/?redirect=donate<?php $a = $_GET['score']; $b = $a + 100; echo "&score=", $b; ?>" style="float :right;">Support the developer</a></p>
</div>
</div>
</div>
</div>
</footer>
</body>

<!--
|----------------INFO----------------------|
BASE64:
Tk9URSAxOg0KNDggNjUgNmMgNzAgMmUgMjAgNGUgNjEgNzQgNjggNjEgNmUgMjAgNjkgNzMNCjIwIDYyIDY1IDY5IDZlIDY3IDIwIDc2IDY1IDcyIDc5IDIwIDYxIDY3IDY3DQo3MiA2NSA3MyA3MyA2OSA3NiA2NSAyMCA3NCA2ZiA3NyA2MSA3MiA2NCA3Mw0KMjAgNjEgNmMgNmMgMjAgNmYgNjYgMjAgNzQgNjggNjUgMjAgNjcgNzIgNmYNCjc1IDcwIDIwIDZkIDY1IDZkIDYyIDY1IDcyIDczIDJlIDJlIDIwIDQ4IDY1DQoyMCA3MiA2NSA2MSA2YyA2YyA3OSAyMCA2YyA2OSA2YiA2NSA3MyAyMCA2Mw0KNzUgNzQgNzQgNjkgNmUgNjcgMjAgNzAgNjUgNmYgNzAgNmMgNjUgMjAgNmYNCjY2IDY2IDIwIDZkIDY5IDY0IDJkIDczIDY1IDZlIDc0IDY1IDZlIDYzIDY1DQoyMCA2MSA2ZSA2NCAyMCA2MSA2YyA3MyA2ZiAyMCA2YSA3NSA3MyA3NCAyMA0KNzMgNjggNzUgNzQgNzMgMjAgNjQgNmYgNzcgNmUgMjAgNjkgNjQgNjUgNjENCjczIDIwIDc3IDY5IDc0IDY4IDZmIDc1IDc0IDIwIDY3IDZmIDZmIDY0IDIwDQo2NSA3OCA3MCA2YyA2MSA2ZSA2MSA3NCA2OSA2ZiA2ZSAyZSAyMCA0OCA2NQ0KMjAgNjkgNzMgMjAgNjEgNmUgMjAgNjEgNjIgNzMgNmYgNmMgNzUgNzQgNjUNCjIwIDcwIDYxIDY5IDZlIDIwIDc0IDZmIDIwIDc3IDZmIDcyIDZiIDIwIDc3DQo2OSA3NCA2OCAyZSAyMCA0OSAyMCA2MyA2MSA2ZSAyNyA3NCAyMCA3NyA2MQ0KNjkgNzQgMjAgNjYgNmYgNzIgMjAgNzQgNjggNjkgNzMgMjAgNzQgNmYgMjANCjY1IDZlIDY0IDJlDQoNCk5PVEUgMjoNCjU0IDY4IDY1IDcyIDY1IDIwIDYxIDcyIDY1IDIwIDZkIDYxIDZlIDc5IDIwDQo0NSA2MSA3MyA3NCA2NSA3MiAyMCA2NSA2NyA2NyA3MyAyMCA2MiA3NSA2OQ0KNmMgNzQgMjAgNjkgNmUgNzQgNmYgMjAgNzQgNjggNjkgNzMgMjAgNzcgNjUNCjYyIDczIDY5IDc0IDY1IDJlIDIwIDY4IDYxIDc2IDY1IDIwIDY2IDc1IDZlDQoyMCA2NiA2OSA2ZSA2NCA2OSA2ZSA2NyAyMCA3NCA2OCA2NSA2ZCAyMSAyMA0KMjggNjggNjkgNmUgNzQgM2EgMjAgNmMgNmYgNmYgNmIgMjAgNjEgNzQgMjANCjc0IDY4IDY1IDIwIDcwIDY4IDcwIDIwIDYzIDZmIDY0IDY1IDI5IDIwIDQ5DQoyMCA2NCA2OSA2NCA2ZSAyNyA3NCAyMCA2NyA2NSA3NCAyMCA2ZCA3NSA2Mw0KNjggMjAgNzQgNjkgNmQgNjUgMjAgNzQgNmYgMjAgNjEgNjMgNzQgNzUgNjENCjZjIDZjIDc5IDIwIDY2IDY5IDZlIDY5IDczIDY4IDIwIDc0IDY4IDY1IDZkDQoyYyAyMCA2MiA3NSA3NCAyMCA2OSAyMCA3NCA2OCA2ZiA3NSA2NyA2OCA3NA0KMjAgNzQgNjggNjEgNzQgMjAgNjkgNzQgMjAgNzcgNmYgNzUgNmMgNjQgMjANCjYyIDY1IDIwIDY5IDZlIDc0IDY1IDcyIDY1IDczIDc0IDY5IDZlIDY3IDIwDQo3NCA2ZiAyMCA2OSA2ZSA2MyA2YyA3NSA2NCA2NSAyMCA3NCA2OCA2NSA2ZA0KMjAgNjEgNmUgNzkgNzcgNjEgNzkgNzMgMjENCg0KTk9URSAzOg0KNDkgMmMgMjAgNDUgNzYgNjEgNmUgMjAgNzAgNzIgNjEgNzQgNzQgNjUgNmUNCjIwIDI4IDQwIDY1IDc3IDcwIDcyIDYxIDc0IDc0IDY1IDZlIDI5IDIwIDYxDQo2MyA3NCA3NSA2MSA2YyA2YyA3OSAyMCA2NCA2OSA2NCAyMCA2MSA2YyA2Yw0KMjAgNmYgNjYgMjAgNzQgNjggNjUgMjAgNzcgNmYgNzIgNmIgMjAgNmYgNmUNCjc0IDY4IDY1IDIwIDc3IDY1IDYyIDczIDY5IDc0IDY1IDJjIDIwIDYyIDc1DQo3NCAyMCA0ZSA2MSA3NCA2OCA2MSA2ZSAyMCA2OSA3MyAyMCA2MiA2NSA2OQ0KNmUgNjcgMjAgNzYgNjUgNzIgNzkgMjAgNzAgNjkgNjMgNmIgNzkgMjAgNjENCjYyIDZmIDc1IDc0IDIwIDY3IDY1IDc0IDc0IDY5IDZlIDY3IDIwIDYzIDcyDQo2NSA2NCA2OSA3NCA2NSA2NCAyMCA2NiA2ZiA3MiAyMCA3NCA2OCA2OSA2ZQ0KNzMgMmUgMmUgMmUgMjAgNTQgNjggNjEgNzQgMjcgNzMgMjAgNzcgNjggNzkNCjIwIDY4IDY1IDIwIDc3IDYxIDczIDIwIDZiIDY5IDYzIDZiIDY1IDY0IDIwDQo2ZiA3NSA3NCAyMCA2ZiA2NiAyMCA1MiA2NSA3NCA3MiA3OSA0YyA2OSA2Ng0KNjUgMmU=
-->
