<div><img src="$ThemeDir/images/background.jpg" alt="Background" id="background"/></div>

<section id="content" class="transparent rounded shadow">
	<aside id="top">
		<% include BasicInfo %>
		$SearchForm
	</aside>

	<% include Menu %>
	<% include Share %>

	<section class="typography">
		<h1>Search for: &quot;{$SearchQueryTitle}&quot;</h1>
		<% if Results %>
			<% control Results %>
				<article>
					<a class="searchResultHeader" href="$Link"><h2>$Title</h2></a>
					<p>
						$Content.ContextSummary
						&nbsp;&nbsp;&nbsp;<a href="$Link">To this page</a><br/>&nbsp;
					</p>
				</article>
			<% end_control %>
			<% if Results.MoreThanOnePage %>
				<div id="PageNumbers">
					<% if Results.NotFirstPage %>
						<a class="prev" href="$Results.PrevLink">
							&larr; Previous page
						</a>
					<% end_if %>
					<span>
					<% control Results.Pages %>
						<% if CurrentBool %>
							&nbsp;&nbsp;<b>$PageNum</b>&nbsp;&nbsp;
						<% else %>
							&nbsp;<a href="$Link">$PageNum</a>&nbsp;
						<% end_if %>
					<% end_control %>
					</span>
					<% if Results.NotLastPage %>
						<a class="next" href="$Results.NextLink">
							Next page &rarr;
						</a>
					<% end_if %>
					<p>Page $Results.CurrentPage of $Results.TotalPages</p>
				</div>
			<% end_if %>
		<% else %>
			<article>No results found...</article>
		<% end_if %>
	</section>
</section>

<% include Footer %>