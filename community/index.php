<html lang="en"><head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, minimumscale=1.0, maximum-scale=1.0">

	
    <title>RetryLife Community</title>
  
<style>
	body {
		font-family: Roboto;
		margin: 0;
		padding: 0;
		background-image: url("../img/Background.png");
		background-size: 100% 100%;
		
	}
	.rant-top-bar {
		background-color:white;
	}
</style>
    

    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">

    <link href="./style.css" rel="stylesheet" type="text/css">
    <link href="https://devrant.io/static/devrant/css/font-style.css?v=5" rel="stylesheet" type="text/css">



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://devrant.io/static/devrant/js/script.js?v=23"></script>

    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    
</head>
<body >


  

	





<div class="container">

    <div class="interior-centered">
        <div class="interior-content" style="min-height: 804px;">

            <div class="body-col1">
            	<div class="body-col1-content">
                <h1>RetryLife</h1>
                <a href="https://twitter.com/retrylife_music" class="twitter-follow-button" data-show-count="false">Follow @retrylife_music</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                <br>
                <a href="https://twitter.com/ewpratten" class="twitter-follow-button" data-show-count="false">Follow @ewpratten</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                <br>
                <a href="https://twitter.com/nsdesjardins345" class="twitter-follow-button" data-show-count="false">Follow @nsdesjardins345</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                <br>
                </div>
            </div>

<div class="body-col2 page-feed">
    
    

		<div class="rantlist-bg">
	    <ul class="rantlist">
	    	            <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/search?q=from%3Aretrylife_music%20OR%20from%3Aewpratten%20OR%20from%3Ansdesjardins" data-widget-id="907392621961674753">Tweets about from:retrylife_music OR from:ewpratten OR from:nsdesjardins</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          
				<?php
				$files = glob('content/*.{json}', GLOB_BRACE);
				foreach($files as $file) {
				  //do your work here
				  
				
				$url = $file;
				$content = file_get_contents($url);
				$json = json_decode($content, true);
				echo '<li class="rant-comment-row-widget" data-id="829770" data-type="rant"><div class="rantlist-title-text">';
				echo $json{title};
				echo " - ";
				echo $json{author};
				echo '</div> <';
				echo $json{type};
				echo ' src="';
				echo $json{src}; echo '" href="';
				echo $json{href};
				echo '" width=100%>';
				echo $json{body};
				echo '</';
				echo $json{type};
				echo '>';
				echo '</li>';
				}
				?>
	    	
	    	
    
</div>
<div class="clearfix"></div>
</div>
</div>





</div>  <!-- end container -->



</body></html>
