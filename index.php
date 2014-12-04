<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Social stream</title>
	
	<!-- jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<!-- packery -->
	<script src="js/packery.pkgd.min.js"></script>
	<script src="js/socialstream_packery.js" type="text/javascript"></script>
	
	<!-- lightbox -->
	<?php if(1==1){?>
	<script src="helpers/lightbox/js/lightbox.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="helpers/lightbox/css/lightbox.css">
	<?php } else {?>
	<link rel="stylesheet" href="helpers/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="helpers/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
	<?php } ?>
	
	
	<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	
	<!-- fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:100,300,900' rel='stylesheet' type='text/css'>
	
	
	<!-- site -->
	<link rel="stylesheet" href="css/template.css" type="text/css" />
	
    
</head>

<body>

<?php 
$bgcolorstyle="fixed"; //fixed, profile, retweets_profile
$cols=6;
?>

	<div class="centered">
		<?php
		require_once("helpers/twitter.php");
		
		//echo "<pre>"; 
		//print_r($tweets);
		//echo "</pre>";
		
		$totalretweets=0;
		foreach($tweets as $tweet){
			$totalretweets+=(int)$tweet->retweet_count;
		}
		$meanretweets=$totalretweets/count($tweets);
		
		
		
		
		?>
		<ul class="socialStream cols<?php echo $cols;?> color<?php echo $bgcolorstyle;?>">
		<?php
		foreach($tweets as $tweet){
			
			$addClass="";
			
			//check if there is image
			$imageurl="";
			$scale="";
			if(!empty($tweet->entities->media[0])){
				
				if($tweet->entities->media[0]->type=="photo"){
					
					$format="medium";//small, thumb, medium, large
					$imagewidth=$tweet->entities->media[0]->sizes->$format->w;
					$imageheight=$tweet->entities->media[0]->sizes->$format->h;
					
					if($imagewidth/$imageheight>1.2){
						$scale="wide";
					} else if($imagewidth/$imageheight<0.8){
						$scale="high";
					} else {
						$scale="square";
					}
					
					
					$imageurl=$tweet->entities->media[0]->media_url_https.":".$format;
					
					$addClass.=" hasImage";
					//print_r($tweet->entities->media[0]);
					
				} else {
					
					$addClass.=" hasNoImage";
				}
			} else {
				
				
				$addClass.=" hasNoImage";
			}
			
			if($meanretweets!=0){
				if((100/$meanretweets)*(int)$tweet->retweet_count >=160 &&($scale!="wide" && $scale!="high")){ //100 is gemiddeld
					//belangrijk item
					$scale="highlight";
				}
			}
			
			/* retweeted */
			$retweet=false;
			if(!empty($tweet->retweeted_status)){
				$retweet=true;
				$addClass.=" retweeted";
				if($bgcolorstyle=="retweets_profile"){
					//$bgcolor=$tweet->retweeted_status->user->profile_sidebar_fill_color;
					$bgcolor=$tweet->retweeted_status->user->profile_background_color;
					$textcolor=$tweet->retweeted_status->user->profile_text_color;
				}
			} else {
				if($bgcolorstyle=="profile"){
					$bgcolor=$tweet->user->profile_sidebar_fill_color;
					$textcolor=$tweet->user->profile_text_color;
				}
			}
			
			//is video
			$hasVideo=false;
			if(!empty($tweet->entities->urls)){
				foreach($tweet->entities->urls as $url){
					if(strpos($url->display_url, "youtu.be")!==false){
						$addClass.=" hasVideo";
						$hasVideo=true;
						break;
					}
				}
			}
			
			/* text */
			$text=$tweet->text;
			
			/* - fix links */
			if(!empty($tweet->entities->urls)){
				foreach($tweet->entities->urls as $url){
					$text=str_replace($url->url,'<a href="'.$url->expanded_url.'" title="'.$url->expanded_url.'" target="_blank">'.$url->display_url.'</a>',$text);
					
				}
			}
			/* - fix hashtags */
			if(!empty($tweet->entities->hashtags)){
				foreach($tweet->entities->hashtags as $url){
					$text=str_replace("#".$url->text,'<a href="https://twitter.com/hashtag/'.$url->text.'" target="_blank">#'.$url->text.'</a>',$text);
					
				}
			}
			/* - fix @ */
			if(!empty($tweet->entities->user_mentions)){
				foreach($tweet->entities->user_mentions as $url){
					$text=str_replace("@".$url->screen_name,'<a href="https://twitter.com/'.$url->screen_name.'" target="_blank">@'.$url->screen_name.'</a>',$text);
					
				}
			}
			
			?>
			<li class="socialItem fbox <?php echo $scale;?> <?php echo $addClass;?>">
				<div class="fboxbefore"></div>
				<div class="fboxcontent" style="<?php if(!empty($imageurl)){?>background-image:url('<?php echo $imageurl;?>');<?php } ?><?php if(($retweet &&  $bgcolorstyle=="retweets_profile") || $bgcolorstyle=="profile" ){?>background-color:#<?php echo $bgcolor;?>;color:#<?php echo $textcolor;?>;<?php }?>">
					
					<?php if(!empty($imageurl)){?>
					<a href="<?php echo $tweet->entities->media[0]->media_url_https.":large";?>" data-title="<?php echo $tweet->text;?>" class="fboxlink fancybox" data-lightbox="fotos" rel="group">
						
					</a>
					<?php } ?>
					
					<div class="text">
						<?php echo $text;?>
					</div>
					
					<div class="bgShade">
					</div>
					
					
					
					
					<div class="date">
						<a href="https://twitter.com/<?php echo $tweet->user->screen_name;?>/status/<?php echo $tweet->id_str;?>" target="_blank"><?php echo date("d M",strtotime($tweet->created_at)); ?></a>
					</div>
					
					
					<?php if($tweet->retweet_count>0){?>
					<div class="retweets">
						<?php echo $tweet->retweet_count;?>
					</div>
					<?php } ?>
					
					<?php if($retweet){?>
					<div class="user">
						<a href="https://twitter.com/<?php echo $tweet->retweeted_status->user->screen_name;?>" target="_blank" title="<?php echo $tweet->retweeted_status->user->name;?>" class="hasTooltip" data-toggle="tooltip">
							<img src="<?php echo $tweet->retweeted_status->user->profile_image_url_https;?>" class="userImage" />
						</a>
					</div>
					<?php } ?>
				</div>
			</li>
			<?php
			
		}
		
		?>
		</ul>
	</div>
</body>
</html>