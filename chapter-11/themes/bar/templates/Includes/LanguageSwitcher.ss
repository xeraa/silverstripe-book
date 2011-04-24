<aside id="locales">
	$Locale.Nice
	<% if Translations %>
		<% control Translations %>
			| <a href="$Link" hreflang="$Locale.RFC1766" title="$Title">$Locale.Nice</a>
		<% end_control %>
	<% end_if %>
</aside>