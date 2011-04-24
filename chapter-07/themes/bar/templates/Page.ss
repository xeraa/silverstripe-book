<% cached 'page', Aggregate(Page).Max(LastEdited), CacheSegment %>

	<!doctype html>
	<html lang="$ContentLocale">

		<head>
			<meta charset="utf-8"/>
			<% base_tag %>
			<title><% if MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
			$MetaTags(false)
			<link rel="shortcut icon" href="favicon.ico"/>
			<!--[if lt IE 9]>
				<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
		</head>

		<body>

			$Layout

			<noscript>
				<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;
				<div><p><b>Please activate JavaScript.</b><br/>Otherwise you won't be able to use all available functions properly...</p></div>
			</noscript>
		</body>
	</html>

<% end_cached %>