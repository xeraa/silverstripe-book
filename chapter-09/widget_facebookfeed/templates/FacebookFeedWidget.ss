<% if Limit == 0 %>
<% else %>
	<div id="facebookfeed" class="rounded">
		<h2>Latest Facebook Update<% if Limit == 1 %><% else %>s<% end_if %></h2>
		<% control Feeds %>
			<p>
				$Message.Parse(Nl2BrParser)<br/>
				<small>$Posted.Nice</small>
			</p>
			<% if Last %><% else %><hr/><% end_if %>
		<% end_control %>
	</div>
<% end_if %>