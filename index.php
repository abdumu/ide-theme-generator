<?php
/**
 * @author Abdulrahman Alshuwayi <hi@abdumu.com>
 * @copyright 2011 
 */

$current_theme = 'mnml';

#mnml theme
$inputs = array();
$inputs['mnml'] = array(
		'text_fg' => array('Text Foreground', '#f8f8f8', 'bi'),
		'text_bg' => array('Text Background', '#141414', ''),
		'line_highlight' => array('Line Highlight', '#3f3f3f', ''),
		'keyword_color' => array('Keywords <sapn class="exp">variables, constants, ...</span>', '#9b703f', 'biu'),
		'boolean_color' => array('Boolean', '#9b859d', 'biu'),
		'string_color' => array('Strings', '#8f9d6a', 'biu'),
		'number_color' => array('Numbers', '#cf6a4c', 'biu'),
		'comment_color' => array('Comments', '#5f5a60', 'biu'),
		'error_color' => array('Error', '#ff0000', 'biu')
);
#TODO add more theme for show randomly..


if(isset($_POST['_generate_']))
{
	$contents = file_get_contents('k/theme.xml');

	#info
	$iid = preg_replace('![^a-z0-9_]!i', '_', strtolower($_POST['theme_name']));
	$contents = str_replace('<%id%>', $iid, $contents);	
	$contents = str_replace('<%name%>', htmlspecialchars($_POST['theme_name']), $contents);	
	$contents = str_replace('<%author%>', htmlspecialchars($_POST['theme_author']), $contents);	
	$contents = str_replace('<%desc%>', htmlspecialchars($_POST['theme_desc']), $contents);	

	foreach($inputs[$current_theme] as $n=>$d)
	{
		$contents = str_replace('<%' . $n . '%>', preg_replace('![^a-z0-9#]!i', '_', strtolower($_POST[$n])), $contents);
		if($n != 'text_bg')
		{
			$opt = isset($_POST[$n . '_b']) ? ' bold="true"' : '';
			$opt .= isset($_POST[$n . '_i']) ? ' italic="true"' : '';
			$opt .= isset($_POST[$n . '_u']) ? ' underline="true"' : '';
			$contents = str_replace('<%' . $n . '_options%>', $opt, $contents);
		}
	}

	header('X-Download-Options: noopen');
	header("Content-Disposition: attachment; filename=theme_" . $iid . ".xml");
	header("Content-Type: text/xml; charset=utf-8");
	header("Content-Length: " . strlen($contents));
	echo $contents;

	exit;
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Scribes Theme Generator</title>
</head>
<link  href="//fonts.googleapis.com/css?family=Droid+Sans+Mono:regular" rel="stylesheet" type="text/css" >
<style type="text/css">
body{
	font-size: 62.5%;
	font-family: "Lucida Grande",Verdana,"Bitstream Vera Sans",Arial,sans-serif;
}
#wrap{
	width:60%;
	margin:0 auto;
}
#header{
	margin:0 auto;
	text-align:center;
	color:#91a3a2;
	font-size:21px;
}
#content{
	margin:50px 0 10px 0;
}

.item{
	width:100%;
	border-bottom:1px solid #ccc;
	padding:10px;
}
.item .right { float:right; }
.item .left .num { font-size:25px;}
.item .left .exp { font-size:10px;}
.item .left { float:left; font-size:18px; color:#666;}
.clear { clear:both;}
input[type=text]{
	border:1px solid #ccc; 
	padding:3px 0;
	border: 1px solid black;
	cursor: pointer;
	text-align: center;	
}
.submit{	
	margin:0 auto;
	margin-top:20px;
	text-align:center;
 }
.generate {
	border:1px solid #999;
	background:#ccc;
	width:300px;
	cursor:pointer;
	padding:3px;
	-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;
}
.copyrights{
	font-size:10px;
	color:#888;
	text-align:right;
	margin-top:30px;
}
.checkboxes{
	float:left;
	padding:0 11px;
	text-align:left;
	width:200px;
}
.colorbox{
	float:right;
}

#IDE{
	padding:10px 0;
	height: auto;
	max-height: 274px;
	background-color:<?php echo $inputs[$current_theme]['text_bg'][1];?>;
	border:1px solid #ccc;
	margin-bottom:10px;
	-moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;
	direction:ltr;
	overflow: auto;
	display: block;
 
	white-space: normal;
	line-height: 1.4em;
	font:1.3em 'Droid Sans Mono', Monaco, "DejaVu Sans Mono", monospace, Courier, mono;
	color:<?php echo $inputs[$current_theme]['text_fg'][1];?>;
}
#IDE, x:-moz-any-link, x:default {
	max-height: 290px;
	font-style:normal;
	font-weight:normal;
	text-decoration:none;
}

.highlight{
	width:100%;
	background-color:<?php echo $inputs[$current_theme]['line_highlight'][1];?>;
}
.highlight span{
	font-style:normal;
	font-weight:normal;
	text-decoration:none;
}
.keywords{color:<?php echo $inputs[$current_theme]['keyword_color'][1];?>;font-style:normal;font-weight:normal;text-decoration:none;}
.comments{color:<?php echo $inputs[$current_theme]['comment_color'][1];?>;font-style:normal;font-weight:normal;text-decoration:none;}
.booleans{color:<?php echo $inputs[$current_theme]['boolean_color'][1];?>;font-style:normal;font-weight:normal;text-decoration:none;}
.strings{color:<?php echo $inputs[$current_theme]['string_color'][1];?>;font-style:normal;font-weight:normal;text-decoration:none;}
.numbers{color:<?php echo $inputs[$current_theme]['number_color'][1];?>;font-style:normal;font-weight:normal;text-decoration:none;}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>	
<script type="text/javascript" src="k/jscolor.js"></script>
<script tyle="text/javascript">
$(document).ready(function(){
	$(':checkbox').click(function() {
	  //alert($(':checkbox:checked').length + '->' + $(this).attr('name'));
	  update_opt($(this).attr('name'), $(':checkbox:checked').length);
	  
	});
});

function random_color() {
	var letters = '0123456789ABCDEF'.split('');
	var color = '#';
	for (var i = 0; i < 6; i++ ) {
		color += letters[Math.round(Math.random() * 15)];
	}
	return color;
}
function __random(n)
{
    var c = random_color();
	$(n).val(c).css('background-color', c).fadeIn("fast");
	update_ide(n.replace('#', ''), c);
}

function update_ide(n, v)
{
	//alert(n + v);
	if(n == 'text_bg')
		$('#IDE').css('background-color', v);
	else if(n == 'text_fg')
		$('#IDE').css('color', v);
	else if(n == 'keyword_color')
		$('.keywords').css('color', v);
	else if(n == 'line_highlight')
		$('.highlight').css('background-color', v);
	else if(n == 'comment_color')
		$('.comments').css('color', v);
	else if(n == 'boolean_color')
		$('.booleans').css('color', v);
	else if(n == 'string_color')
		$('.strings').css('color', v);
	else if(n == 'number_color')
		$('.numbers').css('color', v);
}

function update_opt(n, o)
{
	var opt = n.substr(-1);
	var n2 = n.substr(0, n.length-2);

	var r = {'b':'font-weight', 'i':'font-style', 'u':'text-decoration'};
	var y = {'b':'bold', 'i':'italic', 'u':'underline'};
	var n = {'b':'normal', 'i':'normal', 'u':'none'};

	if(n2 == 'text_fg')
		if(o) {$('#IDE').css(r[opt], y[opt]) }else{ $('#IDE').css(r[opt], n[opt]);}
	else if(n2 == 'line_highlight')
		if(o) { $('.highlight span').css(r[opt], y[opt]) }else{  $('.highlight span').css(r[opt], n[opt]);}
	else if(n2 == 'keyword_color')
		if(o) { $('.keywords').css(r[opt], y[opt]) }else{  $('.keywords').css(r[opt], n[opt]);}
	else if(n2 == 'boolean_color')
		if(o) { $('.booleans').css(r[opt], y[opt]) }else{  $('.booleans').css(r[opt], n[opt]);}
	else if(n2 == 'string_color')
		if(o) { $('.strings').css(r[opt], y[opt]) }else{  $('.strings').css(r[opt], n[opt]);}
	else if(n2 == 'number_color')
		if(o) { $('.numbers').css(r[opt], y[opt]) }else{  $('.numbers').css(r[opt], n[opt]);}
	else if(n2 == 'comment_color')
		if(o) { $('.comments').css(r[opt], y[opt]) }else{  $('.comments').css(r[opt], n[opt]);}
}
</script>
<body>
<div id="wrap">
	<div id="header">
		<img src="k/editor.png" style="width:150px;height:160px" />
		<br />
		Scribes Theme Generator
	</div>

	<div id="content">
	<div id="IDE">
&nbsp;<span class="keywords">&lt;?php</span><br/>
&nbsp;<span class="comments">/**</span><br/>
&nbsp;&nbsp;<span class="comments">* Example</span><br/>
&nbsp;&nbsp;<span class="comments">*/</span><br/>
&nbsp;<span class="keywords">class</span> Example <span class="keywords">extends</span> Themes<br/>
&nbsp;{<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="keywords">public static function</span> SayHey<span class="keywords">($text)</span><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="keywords">if($text ==</span> <span class="booleans">True</span><span class="keywords">)</span><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="keywords">$text =</span> <span class="strings">'Hey Saanina, How are you ?'</span><span class="keywords">;</span><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="keywords">$number =</span> <span class="numbers">426035985</span><span class="keywords">;</span><br/>
<div class="highlight comments">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>//Highlighted line</span></div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
&nbsp;}<br/>
	</div>

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	<?php $i=0; foreach($inputs[$current_theme] as $name=>$d): $i++;?>
		<div class="item">
			<div class="left"><span class="num"><?php echo $i;?>.</span> <?php echo $d[0];?></div>
			<div class="right">
				<div class="checkboxes">
				<?php if(strpos($d[2], 'b') !== false):?>
					<input type="checkbox" id="<?php echo $name;?>_b" name="<?php echo $name;?>_b" /><label for="<?php echo $name;?>_b">Bold</label>
				<?php endif;?>
				<?php if(strpos($d[2], 'i') !== false):?>
					<input type="checkbox" id="<?php echo $name;?>_i" name="<?php echo $name;?>_i" /><label for="<?php echo $name;?>_i">Italic</label>
				<?php endif;?>
				<?php if(strpos($d[2], 'u') !== false):?>
						<input type="checkbox" id="<?php echo $name;?>_u" name="<?php echo $name;?>_u" /><label for="<?php echo $name;?>_u">Underline</label>
				<?php endif;?>
				</div>
				<div class="colorbox">
					<input class="color {hash:true}" type="text" name="<?php echo $name;?>" id="<?php echo $name;?>" onchange="javascript:update_ide('<?php echo $name;?>', this.value);" value="<?php echo $d[1];?>" style="background-color:<?php echo $d[1];?>" size="10"  />
					<img src="k/random.png" alt="Radom color" title="Random color" style="cursor:pointer" onclick="javascript:__random('#<?php echo $name;?>')" />
				</div>
			</div>
			<div class="clear"></div>
		</div>
	<?php endforeach;?>
		<div class="item">
				<div class="left"><span class="num">10.</span> Theme Name</div>
				<div class="right"><input style="200px" type="text" name="theme_name" value="theme_<?php echo rand(0, 100);?>" /></div>
				<div class="clear"></div>
		</div>
		<div class="item">
				<div class="left"><span class="num">11.</span> Theme Author</div>
				<div class="right"><input style="width:250px" type="text" name="theme_author" value="Your Name" /></div>
				<div class="clear"></div>
		</div>
		<div class="item">
				<div class="left"><span class="num">12.</span> Theme Description</div>
				<div class="right"><input style="width:300px" type="text" name="theme_desc" value="Dark minimal theme" /></div>
				<div class="clear"></div>
		</div>
			
		<div class="submit">
			<input type="submit" name="_generate_" value="Generate" class="generate" />
		</div>
		</form>
		
		<div class="copyrights">
			<a href="https://github.com/abdumu/ide-theme-generator">abdumu/ide-theme-generator</a>
		</div>
	</div>
</div>
</body>
</html>
