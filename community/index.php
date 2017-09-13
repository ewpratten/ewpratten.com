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
	   
<?php
                    function getContent() {
                        //Thanks to https://davidwalsh.name/php-cache-function for cache idea
                        $file = "./feed-cache.txt";
                        $current_time = time();
                        $expire_time = 5 * 60;
                        $file_time = filemtime($file);
                        if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
                            return file_get_contents($file);
                        }
                        else {
                            $content = getFreshContent();
                            file_put_contents($file, $content);
                            return $content;
                        }
                    }
                    function getFreshContent() {
                        $html = "";
                        $newsSource = array(
                            array(
                                "title" => "RetryLife",
                                "url" => "https://twitrss.me/twitter_user_to_rss/?user=RetryLife_music"
                            ),
                            array(
                                "title" => "ewpratten",
                                "url" => "https://twitrss.me/twitter_user_to_rss/?user=Ewpratten"
                            ),
                            array(
                                "title" => "nsdesjardins",
                                "url" => "https://twitrss.me/twitter_user_to_rss/?user=Nsdesjardins345"
                            )
                            
                        );
                        function getFeed($url){
                            $rss = simplexml_load_file($url);
                            $count = 0;
                            $html .= '<ul>';
                            foreach($rss->channel->item as$item) {
                                $count++;
                                if($count > 7){
                                    break;
                                }
                                $html .= '<li><a href="'.htmlspecialchars($item->link).'">'.htmlspecialchars($item->title).'</a></li>';
                            }
                            $html .= '</ul>';
                            return $html;
                        }
                        foreach($newsSource as $source) {
                            $html .= '<h2>'.$source["title"].'</h2>';
                            $html .= getFeed($source["url"]);
                        }
                        return $html;
                    }
                    print getContent();
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
