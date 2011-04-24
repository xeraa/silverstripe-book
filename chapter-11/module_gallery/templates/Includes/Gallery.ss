<% if GalleryImages %>
	<section id="gallery">
		<% control GalleryImages %>
			<a class="cboxElement" title="$Title" rel="gallery" href="$ResizedBaseImage">
				$BaseImage.CroppedImage(125, 125)
			</a>
		<% end_control %>
	</section>
<% end_if %>