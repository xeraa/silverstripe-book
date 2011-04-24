<div><img src="$ThemeDir/images/background.jpg" alt="Background" id="background"/></div>

<div id="content-page">
	<% include LanguageSwitcher %>
</div>

<section id="content" class="transparent rounded shadow">
	<aside id="top">
		<% include BasicInfo %>
		$SearchForm
	</aside>

	<% include Menu %>
	<% include Share %>

	<section class="typography">
		<% if IsSuccess && SubmitText %>
			$SubmitText
		<% else %>
			$Content
			$Form
		<% end_if %>
		<aside id="sidebar">$SideBar</aside>
	</section>
</section>

<% include Footer %>