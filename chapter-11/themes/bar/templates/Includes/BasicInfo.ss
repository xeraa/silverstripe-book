<a href="home"><img src="$ThemeDir/images/logo.png" alt="Logo" id="logo"/></a>
<ul id="details-first">
	<li><% _t('PHONE','Phone') %>: <b>$SiteConfig.Phone</b></li>
	<li><% _t('CONTACT','Contact') %>: <a href="contact"><span class="mail">$SiteConfig.Email</span></a></li>
	<li><% _t('ADDRESS','Address') %>: <a href="location">$SiteConfig.Address</a></li>
</ul>
<div id="details-second">
	<div class="left"><% _t('OPENINGHOURS','Opening hours') %>:</div>
	<div class="right">$SiteConfig.OpeningHours</div>
</div>
<a href="http://www.facebook.com/pages/">
	<img src="$ThemeDir/images/facebook.png" alt="Facebook" id="facebook"/>
</a>