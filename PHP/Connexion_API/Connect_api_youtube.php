<?php
$API_Key    = 'AIzaSyA5SEQPLYmy5cpSJCkHSmIeh_mfsSvVijk'; 
$Channel_ID = 'UCuoKuTCQ9dmPIgOgyLm9HgQ'; 
$username='samuelkimmusic';
$Max_Results = 10; 
 
// Get videos from channel by YouTube Data API 
$apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$Channel_ID.'&maxResults='.$Max_Results.'&key='.$API_Key.''); 
if($apiData){ 
    $videoList = json_decode($apiData); 
}else{ 
    echo 'Invalid API key or channel ID.'; 
}
if(!empty($videoList->items)){ 
    foreach($videoList->items as $item){ 
        // Embed video 
        if(isset($item->id->videoId)){ 
            echo ' 
            <div class="yvideo-box"> 
                <iframe width="280" height="150" src="https://www.youtube.com/embed/'.$item->id->videoId.'" frameborder="0" allowfullscreen></iframe> 
                <h4>'. $item->snippet->title .'</h4> 
            </div>'; 
        } 
    } 
}else{ 
    echo '<p class="error">'.$apiError.'</p>'; 
}
echo "https://www.googleapis.com/youtube/v3/channels?key='.$API_Key.'&forUsername='.$username.'&part=id";
$apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/channels?key='.$API_Key.'&forUsername='.$username.'&part=id');
if($apiData){ 
  $videoList = json_decode($apiData); 
}else{ 
  echo 'Invalid API key or channel ID.'; 
}
echo json_encode($videoList->items);
?>