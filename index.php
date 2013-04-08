<?php

    $root = 'http://query.yahooapis.com/v1/public/yql?q=';

    $yql = 'select title,link,description from rss where url = "http://feeds.delicious.com/v2/rss/thinkphp/videos?count=30"';
  
    $url = $root . urlencode($yql) . '&format=json&diagnostics=false';
 
    $content = get($url);

    $json = json_decode($content);

    $results = $json->query->results;

    $videos = array('title'=>array(),'description'=>array());   

    if($results) {

            foreach($results->item as $i) {

                    $videos['title'][] = $i->title;

                    $videos['description'][] = $i->description;
            }
    }

    $n = count($videos['description']);
 
     $output = '<table>'; 

             for($i=0;$i<$n;$i++) {
                 $src = html_entity_decode($videos["description"][$i]);
                 $object = '<object height="385" width="640"><param name="movie" value="'.$src.'" /><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><embed allowfullscreen="true" allowscriptaccess="always" height="385" src="'.$src.'" type="application/x-shockwave-flash" width="640"></embed></object>';
                 $output .= '<tr><td><div class="title">'.$videos["title"][$i].'</div>'.$object.'</td></tr>';
             }

    $output .= '</table>';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Videos For The Open Minded</title>
   <style type="text/css">
    *{margin:20px;padding:0}
    body {
      font-size:24px;
      line-height:1.5;
      color:#333;
    }
    h1,h2,h3,body { font-family:'gill sans','dejavu sans',verdana,sans-serif; }

    h1 {
      font-weight:bold;
      font-size:50px;
      color:#000;
      margin-bottom:0;
      position:relative;
    }
    h1 b {
      color:#ccc;
    }
    h3 {
      font-weight:normal;
      color:#777;
      margin-bottom:40px;
      letter-spacing:2px;
    }
    h4 {
      font-size:26px;
      color:#111;
      margin-bottom:0;
    }
    div.title{
color: #fff;font-size: 20px;
    background-color: #1A90DB;
    border-radius: 10px 10px 10px 10px;
    font-weight: bold;
    margin: 0 0 10px;
    padding: 5px 10px;
}
    #ft{margin:0;text-align: left;padding:0;color: #1A90DB;border-top: 1px solid #1A90DB}
    #ft a{color: #000;text-decoration:none}
    #ft a:hover{color: #000;text-decoration:underline}
    #ft * {margin:0;padding:0}
   </style>
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h1>Videos For Real Developers</h1></div>
   <div id="bd" role="main">
	<div class="yui-g">
        <?php echo$output; ?>
	</div>
   </div>
   <div id="ft" role="contentinfo"><div>Created by @<a href="http://twitter.com/thinkphp">thinkphp</a> using PHP, YQL, and del.icio.us</div></div>
</div>

</body>
</html>


<?php

    //use cURL
    function get($url) {

          $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL,$url);
          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
          $buffer = curl_exec($ch);
          curl_close($ch);
          if (empty($buffer)){return 'Error retrieving data, please try later.'; } else { return $buffer; }

    }//end function
?>