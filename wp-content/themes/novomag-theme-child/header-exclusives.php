<?php
	$favicon = get_option(THEME_NAME."_favicon");
	$sXcode = get_field("site_xcode");
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->

<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--<![endif]-->
	<!-- BEGIN head -->
	<head>
  <style>
    img { opacity: 1 !important; }

    @media only screen and (max-width: 600px) {
      .header-topmenu .wrapper a.toggle-menu:nth-child(2),
      .main-menu .wrapper a.toggle-menu:nth-child(3) {
          display: none !important;
      }

      a.toggle-menu { text-indent: -9999px; }
    }
  </style>
<style>
.fancybox-overlay, .snp-theme-image, .fancybox-outer, .fancybox-wrap  {display: none !important;}
</style>

<script>
    (function(f,b,g){
        var xo=g.prototype.open,xs=g.prototype.send,c;
        f.hj=f.hj||function(){(f.hj.q=f.hj.q||[]).push(arguments)};
        f._hjSettings={hjid:12181, hjsv:2};
        function ls(){f.hj.documentHtml=b.documentElement.outerHTML;c=b.createElement("script");c.async=1;c.src="//static.hotjar.com/c/hotjar-12181.js?sv=2";b.getElementsByTagName("head")[0].appendChild(c);}
        if(b.readyState==="interactive"||b.readyState==="complete"||b.readyState==="loaded"){ls();}else{if(b.addEventListener){b.addEventListener("DOMContentLoaded",ls,false);}}
        if(!f._hjPlayback && b.addEventListener){
            g.prototype.open=function(l,j,m,h,k){this._u=j;xo.call(this,l,j,m,h,k)};
            g.prototype.send=function(e){var j=this;function h(){if(j.readyState===4){f.hj("_xhr",j._u,j.status,j.response)}}this.addEventListener("readystatechange",h,false);xs.call(this,e)};
        }
    })(window,document,window.XMLHttpRequest);
</script>

		<!-- Title -->
		<title>
			<?php
				if ( is_single() ) { single_post_title(); print ' | '; bloginfo('name'); }
				elseif ( is_home() || is_front_page() ) { bloginfo('name'); if(get_bloginfo('description')) { print ' | '; bloginfo('description'); } }
				elseif ( is_page() ) { single_post_title(''); if(get_bloginfo('description')) { print ' | '; bloginfo('description'); } }
				elseif ( is_search() ) { bloginfo('name'); print ' | Search results ' . esc_html($s); }
				elseif ( is_404() ) { bloginfo('name'); print ' | Page not found'; }
				else { bloginfo('name'); print ' | '; wp_title(''); }
			?>
		</title>

		<!-- Meta Tags -->
		<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="sitelock-site-verification" content="9184" />


		<!-- Favicon -->
		<?php
			if($favicon) {
		?>
			<link rel="shortcut icon" href="<?php echo $favicon;?>" type="image/x-icon" />
		<?php } else { ?>
			<link rel="shortcut icon" href="<?php echo THEME_IMAGE_URL; ?>favicon.ico" type="image/x-icon" />
		<?php } ?>
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  		<link rel="publisher" href="https://plus.google.com/+Dentresearchsurviveandprosper/">
		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', THEME_NAME), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', THEME_NAME), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


		<?php wp_head(); ?>
<script type="text/javascript">

function showDiv() {
   document.getElementById('welcomeDiv').style.display = "block";
    document.getElementById('butt').style.display = "none";
     document.getElementById('butt1').style.display = "none";
}
</script>
<script type="text/javascript">
function showDiv1() {
  document.getElementById('related1').style.display = "block";
    document.getElementById('butt1').style.display = "none";
      document.getElementById('butt').style.display = "none";
}

							</script>


<script>

var site = {
"twitter.com" : "X195QA09",
"peakprosperity.com" : "X195QB40",
"investmentwatchblog.com" : "X195QB43",
"safehaven.com" : "X195QB41",
"pinterest.com" : "X195QB20",
"yahoo.com" : "X195R149",
"investorplace.com" : "X195QC11",
"tumblr.com" :  "X195QC13",
"investors.com" : "X195QC12",
"wolfstreet.com" : "X195QA12",
"infowars.com" :  "X195QA39",
"marketsanity.com" : "X195QA13",
"instagram.com" : "X195QB50",
"dollarcollapse.com" : "X195QA14",
"marketoracle.co.uk" : "X195QA15",
"seekingalpha.com" : "X195QA16",
"dentresearch.com" : "X195QA17",
"valuewalk.com" : "X195QB46",
"endthelie.com" : "X195QB47",
"harrydent.com" : "X195QA18",
"youtube.com" : "X195QA22",
"goodreads.com" : "X195QA21",
"marketdailynews.com" : "X195QB45",
"linkedin.com" : "X195QA20",
"plus.google.com" : "X195QA11",
"facebook.com" : "X195QA10"
}

Object.keys(site).forEach(function(key) {
    if (document.referrer.indexOf(key) > -1) {
        if (localStorage) {
            localStorage.setItem("xcode", site[key]);
        }
    }
});
</script>
<script>
var field = 'x';
var url = window.location.href;
if(url.indexOf('?' + field + '=') != -1) {

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

var user_code = getUrlVars()["x"];

if (localStorage) {
   localStorage.setItem("xcode",user_code);
}
}

</script>

<!-- BEGIN Exclusives Tracking Code -->
<script>
jQuery(function($){
    var thecode = localStorage.getItem("xcode");
     if (thecode !== null) {
      $(".xcode-field").attr("value",thecode);
}
});
</script>

<script>
var site = {
"economyandmarkets.com" : "<?php echo $sXcode; ?>"
}

Object.keys(site).forEach(function(key) {
    if (document.referrer.indexOf(key) > -1) {
        if (localStorage) {
            localStorage.setItem("pcode", site[key]);
        }
    }
});
</script>
<script>var field = 'z';
var url = window.location.href;
if(url.indexOf('?' + field + '=') != -1) {

function getUrlVars()
{
var vars = [], hash;
var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
for(var i = 0; i < hashes.length; i++)
{
hash = hashes[i].split('=');
vars.push(hash[0]);
vars[hash[0]] = hash[1];
}
return vars;
}

var user_code = getUrlVars()["z"];
if (localStorage) {
localStorage.setItem("pcode",user_code);
}
}</script>


<script>jQuery(function($){
var thecode = localStorage.getItem("pcode");
if (thecode !== null) {
$(".plink").each(function(){
     this.href += thecode;
})
}
});</script>
	<!-- END head -->
	</head>



	<!-- BEGIN body -->
	<body <?php body_class();?>>
    <?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>

		<?php get_template_part(THEME_INCLUDES."banners");?>
			<?php get_template_part('exclusives','top'); ?>
