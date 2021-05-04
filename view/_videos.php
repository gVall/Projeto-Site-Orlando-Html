<?php include_once("header.php");?>

<link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css" />

		<section>
			
			<div id="call-to-action">
				
				<div class="container">
					
					<div class="text-center">
						
						<h2>VIDEOS</h2>
						<hr>

					</div>

					<div class="text-center">
						
							<video id="player" playsinline controls poster="img/highlights.jpg">

								 <source class="sc" src="mp4/highlights.mp4" type="video/mp4">
								 <track kind="captions" label="Português (Brasil)" src="vtt/legendas.vtt" srclang="pt-br" default />	
								 

							</video>							
						

					</div>


				</div>	

			</div>

			<div id="news" class="container" style="top:0">

				<div class="text-center">
					
					<h2>LATEST NEWS</h2>
					<hr>

				</div>
				
				<div class="row thumbnails owl-carousel owl-theme">
					<div class="item" data-video="highlights">
						<div class="item-inner">
							<img src="img/highlights.jpg" alt="Noticia">
							<h3>Highlights</h3>
						</div>
					</div>
					<div class="item" data-video="Orlando_City_Foundation_2015">
						<div class="item-inner">
							<img src="img/Orlando_City_Foundation_2015.jpg" alt="Noticia">
							<h3>Orlando City Foundation 2015</h3>					
						</div>
					</div>
					<div class="item" data-video="highlights">
						<div class="item-inner">
							<img src="img/highlights.jpg" alt="Noticia">
							<h3>Highlights</h3>
						</div>
					</div>
					<div class="item" data-video="Orlando_City_Foundation_2015">
						<div class="item-inner">
							<img src="img/Orlando_City_Foundation_2015.jpg" alt="Noticia">
							<h3>Orlando City Foundation 2015</h3>					
						</div>
					</div>
					
					<div class="item" data-video="highlights">
						<div class="item-inner">
							<img src="img/highlights.jpg" alt="Noticia">
							<h3>Highlights</h3>
						</div>
					</div>
					<div class="item" data-video="Orlando_City_Foundation_2015">
						<div class="item-inner">
							<img src="img/Orlando_City_Foundation_2015.jpg" alt="Noticia">
							<h3>Orlando City Foundation 2015</h3>					
						</div>
					</div>
				</div>	
				
			</div>
			
		</section>

<?php include_once("footer.php");?>

<script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
		<script>
			$(function(){
		
				const player = new Plyr('#player');

				$(".thumbnails .item").on("click", function(){
					
					$("video").attr({	
						"src":"mp4/"+$(this).data('video')+".mp4",
						"poster":"img/"+$(this).data('video')+".jpg"	
						
					});

					

				});

				/*
				$("#volume").on("change", function(){

					$("video")[0].volume = parseFloat($(this).val());

				});

				$("#btn-play-pause").on("click", function(){


					var video = $("video")[0];

					if ($(this).hasClass("btn-success")) 
					{
						$(this).text("STOP");
						video.play();
					} else {
						$(this).text("PLAY");
						video.pause(); 
					}

					$(this).toggleClass("btn-success btn-danger");

				})*/
				
			});
		</script>