<html>
	<head>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.5.min.js"></script>
		<script type="text/javascript" src="js/jquery-css-transform.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/jquery-animate-css-rotate-scale.js" type="text/javascript"></script>
	</head>
	<body onload="init()">
		<div id="othumb" class="othumb"></div>
		<?php
			$much = 7;
			$list = glob('photos/THUMB*');
			for($i = 0; $i < count($list); $i++){
				$list[$i] = substr($list[$i], strpos($list[$i], 'THUMB_')+strlen('THUMB_'));
			}
			sort($list, SORT_NUMERIC);
			for($i = 0; $i < count($list); $i++){
				echo '<img src="photos/THUMB_'.$list[$i].'" class="thumbnail" id="th'.$i.'" onclick="mtc('.$i.')">'."\n";
			}
			
			$total = count($list)-1;
		?>
		<div id="tshadow"></div>
		<div id="mlarge">
			
			<div id="tlarge">
				<div id="olarge" class="olarge">
					<img id="large" src="about:blank">
					<img id="loading" src="images/loading.gif">
				</div>
			</div>
		</div>
		<div id="debug">
		</div>
		<script type="text/javascript"> 
		var ie = false;
		</script>
		
		<!--[if lt IE 9]>
		<script type="text/javascript"> 
		ie = true;
		</script>
		<![endif]-->

		 <script type="text/javascript"> 
		 /*
		 * Jakub Kramarz (c) 2011
		 */
		 var total = <?php echo $total; ?>;
		 var mini = 0;
		 var maxi = 0;
		 var center = 0;
		 var actual = 0;
		 var much = <?php echo $much; ?>;
		 var names = new Array('<?php echo implode('\', \'', $list) ?>');
		 var surl;
		 var onstart = true;
		 
		 function position(i){
			var rotate = center - actual + (i-center);
			var Element = document.getElementById( 'th'+i );
			
			$(
				function(){
					if(ie){
						$('#th'+i).animate({top: (window.innerHeight/2)+(-75*rotate)+"px"}, 500);
					}else{
						$('#th'+i).animate({rotate: ((-0.15*rotate)+"rad")}, 500);
					}
				}
			);
		 }
		 
		 function hide(i){
			 position(i);
			 var Element = document.getElementById( 'th'+i );
			 $(
				function(){
					$('#th'+i).fadeOut('fast');
				}
			);
		 }
		 function show(i){
			 var Element = document.getElementById( 'th'+i );
			 Element.style.display="block";
			 position(i);
			 $(
				function(){
					$('#th'+i).hide();
					/*$('#th'+i).load(
						function(){*/
							$('#th'+i).fadeTo('fast', 0.8);
					/*	}
					);*/
				}
			);
		 }
		 function large(newc){
			if(center != newc || onstart){	 
				$(function(){
					$('#large').fadeOut('fast',
						function(){
							var Element = document.getElementById( 'large' );
							Element.src='photos/' + names[newc];
							
						}
					);
				});
				 
				$(function(){
					$('#large').load(
						function(){
							/*$('#loading').hide('fast', function(){*/$('#large').fadeIn('slow');/*});*/
						}
					);
				});
			}
		}
		 function mtc(newc){	
			 actual = newc;
			 large(newc);
			 var newmini = Math.max( (actual - much), 0);
			 var newmaxi = Math.min( (actual + much), total);
			 
			if(mini < newmini){
				for(var i = mini; i<=newmini; i++){
					hide(i);
				}
			}
			if(mini > newmini){
				for(var i = mini; i>=newmini; i--){
					show(i);
				}
			}
			for (var i= mini;i<=maxi;i++){
				 position(i);
			}
			
			if(newmaxi > maxi){
				for(var i = newmaxi; i>maxi; i--){
					show(i);
				}
			}
			if(newmaxi < maxi){
				for(var i = newmaxi; i<=maxi; i++){
					hide(i);
				}
			}
			
			document.all.debug.innerHTML = 
				'MinI: ' + mini + '<br>' +
				'MaxI: ' + maxi + '<br>' +
				'Center: ' + center + '<br>' +
				'NewMinI: ' + newmini + '<br>' +
				'NewMaxI: ' + newmaxi + '<br>' +
				'NewCenter: ' + actual + '<br>';
			mini = newmini;
			maxi = newmaxi;
			center = actual;
			window.location = surl.concat('#!', center.toString());
			onstart = false;
		}

		function init(){
			var url = window.location.toString();
			var pos = url.lastIndexOf("#!");
			var num;
			if(pos < 0){
				num = 0;
				surl = url;
			}else{
				num = url.substr(pos+2);
				surl = url.substr(0, pos);
			}
			
			num=mini=maxi=center=parseInt(num);
			show(num);
			mtc(num);
			
			document.all.debug.innerHTML = surl;
		}
		 </script>
	</body>
</html>
