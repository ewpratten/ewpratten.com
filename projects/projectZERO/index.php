<head>
	<link href="./css/picnic.min.css" rel="stylesheet" media="all">
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
	<meta name="viewport" content="width=device-width, inital-scale=1">
	<link href="css/hover.css" rel="stylesheet" media="all">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<!-- <link href="./css/main.css" rel="stylesheet" media="all"> -->
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
echo "Project ZERO"
?>
</span>
</a>
<input id="bmenub" type="checkbox" class="show">
  <label for="bmenub" class="success burger button">menu</label>

  <div class="menu">
	<a href="#" class="button">Office Space</a>
	<a href="#" class="button">Housing</a>
	<a href="#" class="button">Design</a>
<?php
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
<div style="height:300">
	<div id="gradient" />
<!-- im a spacer -->



<div id="floater"></div>
    <div id="child">
    	<div class="front">
<h1>
<?php
$text = array("P", "r", "o", "j", "e", "c", "t", " ", "Z", "E", "R", "O");
$text2 = array("A", "n", " ", "a", "d", "v", "a", "n", "c", "e", "d", " ", "c", "o", "m", "m", "u", "n", "i", "t", "y", " ", "l", "i", "v", "i", "n", "g", " ", "s", "p", "a", "c", "e");

for($i = 0; $i <= 12 ; $i++){
	echo $text[$i];
}

echo "</h1><h1>";

for($ix = 0; $ix <= 33; $ix++){
	echo $text2[$ix];
}
?>
</h1>
</div>
</div>
</div>
</div>
<div class="spacer"></div>

<div class="housing">
	<div style="align:center:">
		<h1 align="center">Housing</h1>
		</div>
		
		<div class="flex one three-600 demo">
			<div><span><article class="card"><header>
    	<h3>Pricing</h3>
  </header>
  
  <p>All housing units can be rented for an affordable price and come outfitted with modern appliences.</p>
  
  <footer>
    <button>Learn More</button>
  </footer></article></span></div>
			<div><span><article class="card"><header>
    	<h3>Unit Styles</h3>
  </header>
  
  <p>All housing units are modular and come in one and two story sections. They can also be joined with a neighbouring unit for extra space.</p>
  
  <footer>
    <button>Learn More</button>
  </footer></article></span></div>
			<div><span><article class="card"><header>
    	<h3>Corporate Reservations</h3>
  </header>
  
  <p>We allow any company who is currently renting a modular office space to also rent housing for their employees.</p>
  
  <footer>
    <button>Learn More</button>
  </footer></article></span></div>
		</div>
</div>

<div class="spacer"></div>

<div class="offices">
	<div style="align:center:">
		<h1 align="center">Office Spaces</h1>
		</div>
		
		<div class="flex one three-600 demo">
			<div><span><article class="card"><header>
    	<h3>Pricing</h3>
  </header>
  
  <p>All office units can be rented for an affordable price and can be outfitted with modern appliences, furniture, and a TV.</p>
  
  <footer>
    <button>Learn More</button>
  </footer></article></span></div>
			<div><span><article class="card"><header>
    	<h3>Unit Styles</h3>
  </header>
  
  <p>All Office units are modular and come in one and two story sections. They can also be joined with a neighbouring unit for extra space.</p>
  
  <footer>
    <button>Learn More</button>
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




<div class="flex one-0 three-600 demo">
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

<div class="flex one-0 three-600 demo">
	<div><span>
  	<article class="card"><header>
    	<h3>Office Spaces</h3>
  </header>
  
  <p>(add details about the offices)</p>
  
  </article>
  </span></div>
  
  <div class="two-third"><span>
  	<img src="">
  	<h1>(Image of office space)</h1>
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
        

<div class="credits">
<p>Project by: <a title="My name is Evan" href="https://github.com/Ewpratten" style="color: white;">ewpratten</a>, Maya, Sarah, Nathan<a class="abc" title="Hey look! You can click me to make a donation!" href="http://retrylife.ca/donate" style="float:right;">Support the developer</a></p>
</div>
    </div>
</div>
</div>
</footer>
</body>
