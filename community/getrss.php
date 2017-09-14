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
                                "title" => "RetryLife-all",
                                "url" => "http://www.rssmix.com/u/8252161/rss.xml"
                            )
                            
                        );
                        function getFeed($url){
                            $rss = simplexml_load_file($url);
                            $count = 0;
                            $html .= '<ul class="rantlist">';
                            foreach($rss->channel->item as$item) {
                                $count++;
                                if($count > 1000){
                                    break;
                                }
                                $html .= '><a href="'.htmlspecialchars($item->link).'"><li class="rant-comment-row-widget" data-id="829770" data-type="rant" style="background-color:#243447;color:white;"><div class="rantlist-title-text" > '.htmlspecialchars($item->description).'</div></li>';
                                
                            }
                            $html .= '</ul>';
                            return $html;
                        }
                        return $html;
                    }
                    print getContent();
                ?>
