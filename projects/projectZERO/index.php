<head>
	<link href="./css/picnic.min.css" rel="stylesheet" media="all">
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
	<meta name="viewport" content="width=device-width, inital-scale=1">
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
<div style="height:30%">
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

<footer>
<div width="100%"  style="background-color: #243447;height:250;">
<h3>Website by: <a href="https://ewpratten.github.io">Ewpratten</a></h3>
</div>
</footer>
</body>
