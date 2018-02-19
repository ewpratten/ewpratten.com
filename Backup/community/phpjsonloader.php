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