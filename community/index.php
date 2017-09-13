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
		background-attachment: fixed;
		
	}
	.rant-top-bar {
		background-color:white;
	}
</style>
    

    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">

    <link href="./style.css" rel="stylesheet" type="text/css">
    <link href="https://devrant.io/static/devrant/css/font-style.css?v=5" rel="stylesheet" type="text/css">



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>


    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    
</head>
<body >


  

	





<div class="container">

    <div class="interior-centered">
        <div class="interior-content" style="min-height: 804px;background-color:white;">

            <div class="body-col1">
            	<div class="body-col1-content">
            		
            		<div style="background-color:#243447;padding:15px;border-radius:10px;color:white;">
            			<img src="https://pbs.twimg.com/profile_images/884167837891342336/F8JOfFAf_400x400.jpg">
                <h1>RetryLife</h1>
                <p>Canada</p>
                <br>
                <br>
                
                <div style="padding:6px; background-color:#1ca2f2; border-radius:8px;">
                <a href="https://twitter.com/retrylife_music" class="twitter-follow-button" data-show-count="false">Follow @retrylife_music</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#1ca2f2; border-radius:8px;">
                <a href="https://twitter.com/ewpratten" class="twitter-follow-button" data-show-count="false">Follow @ewpratten</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#1ca2f2; border-radius:8px;">
                <a href="https://twitter.com/nsdesjardins345" class="twitter-follow-button" data-show-count="false">Follow @nsdesjardins345</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#ff0000; border-radius:8px;">
                <a href="https://www.youtube.com/channel/UCrHT3Lt0Mg90bspbMHJfTcA?sub_confirmation=1">Subscribe to RetryLife Official</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#ff0000; border-radius:8px;">
                <a href="https://www.youtube.com/channel/UCxzARKt0_U0sLHbF4pDN1Pw?sub_confirmation=1">Subscribe to Nathan Desjardins</a>
                </div>
                <br>
                
                </div>
                
                
                
                
                </div>
            </div>

<div class="body-col2 page-feed">
    
    

		<div class="rantlist-bg">
	    <ul class="rantlist">
	   
<?PHP
  // define script parameters
  $BLOGURL    = "http://www.rssmix.com/u/8252161/rss.xml";
  $NUMITEMS   = 2;
  $TIMEFORMAT = "j F Y, g:ia";
  $CACHEFILE  = "/tmp/" . md5($BLOGURL);
  $CACHETIME  = 4; // hours

  // download the feed iff a cached version is missing or too old
  if(!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)) {
    if($feed_contents = http_get_contents($BLOGURL)) {
      // write feed contents to cache file
      $fp = fopen($CACHEFILE, 'w');
      fwrite($fp, $feed_contents);
      fclose($fp);
    }
  }

  include "rssparser.php";
  $rss_parser = new RSSParser($CACHEFILE);

  // read feed data from cache file
  $feeddata = $rss_parser->getRawOutput();
  extract($feeddata['RSS']['CHANNEL'][0], EXTR_PREFIX_ALL, 'rss');

  // display leading image
  if(isset($rss_IMAGE[0]) && $rss_IMAGE[0]) {
    extract($rss_IMAGE[0], EXTR_PREFIX_ALL, 'img');
    echo "<p><a title=\"{$img_TITLE}\" href=\"{$img_LINK}\"><img src=\"{$img_URL}\" alt=\"\"></a></p>\n";
  }

  // display feed title
  echo "<h4><a title=\"",htmlspecialchars($rss_DESCRIPTION),"\" href=\"{$rss_LINK}\" target=\"_blank\">";
  echo htmlspecialchars($rss_TITLE);
  echo "</a></h4>\n";

  // display feed items
  $count = 0;
  foreach($rss_ITEM as $itemdata) {
    echo "<p><b><a href=\"{$itemdata['LINK']}\" target=\"_blank\">";
    echo htmlspecialchars(stripslashes($itemdata['TITLE']));
    echo "</a></b><br>\n";
    echo htmlspecialchars(stripslashes($itemdata['DESCRIPTION'])),"<br>\n";
    echo "<i>",date($TIMEFORMAT, strtotime($itemdata['PUBDATE'])),"</i></p>\n\n";
    if(++$count >= $NUMITEMS) break;
  }

  // display copyright information
  echo "<p><small>&copy; {",htmlspecialchars($rss_COPYRIGHT),"}</small></p>\n";
?>

<?php
				
				$files = glob('content/*.{json}', GLOB_BRACE);
				foreach($files as $file) {
				  //do your work here
				  
				
				$url = $file;
				$content = file_get_contents($url);
				$json = json_decode($content, true);
				echo '<li class="rant-comment-row-widget" data-id="829770" data-type="rant" style="background-color:#243447;color:white;"><div class="rantlist-title-text" >';
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
