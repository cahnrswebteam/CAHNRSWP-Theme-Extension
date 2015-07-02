<?php

/**
 * Retrieve an array of values to be used in the header.
 *
 * site_name
 * site_tagline
 * page_title
 * post_title
 * section_title
 * subsection_title
 * posts_page_title
 * sup_header_default
 * sub_header_default
 * sup_header_alternate
 * sub_header_alternate
 */
$spine_main_header_values = spine_get_main_header();

if ( spine_get_option( 'main_header_show' ) == 'true' ) :

?>
<header class="main-header<?php echo ( spine_get_option( 'cahnrs_header_bg_color' ) ) ? ' ' . esc_attr( spine_get_option( 'cahnrs_header_bg_color' ) ) : ' gray'; ?>">

	<div class="cahnrs-header-group<?php
		echo ( spine_get_option( 'cahnrs_header_fixed' ) ) ? ' fixed' : '';
		echo ( spine_get_option( 'cahnrs_header_bg_vellum' ) ) ? ' ' . esc_attr( spine_get_option( 'cahnrs_header_bg_vellum' ) ) : '';
	?>">
		<div id="cahnrs-heading">
			<a href="http://cahnrs.wsu.edu/">CAHNRS</a>
			<div class="quicklinks">
				<dl>
					<dt><a href="http://cahnrs.wsu.edu/">College of Agricultural, Human, and Natural Resource Sciences</a></dt>
					<span class="cahnrs-ql-padding">CAHNRS</span><dd>
						 <ul>
							<li><a href="http://cahnrs.wsu.edu/academics/">Students</a></li>
							<li><a href="http://cahnrs.wsu.edu/research/">Research</a></li>
							<li><a href="http://cahnrs.wsu.edu/extension/">Extension</a></li>
							<li><a href="http://cahnrs.wsu.edu/alumni/">Alumni and Friends</a></li>
							<li><a href="http://cahnrs.wsu.edu/fs/">Faculty and Staff</a></li>
						</ul>
					</dd>
				</dl>
			</div>
		</div><sup class="sup-header" data-section="<?php echo $spine_main_header_values['section_title']; ?>" data-pagetitle="<?php echo $spine_main_header_values['page_title']; ?>" data-posttitle="<?php echo $spine_main_header_values['post_title']; ?>" data-default="<?php echo esc_html($spine_main_header_values['sup_header_default']); ?>" data-alternate="<?php echo esc_html($spine_main_header_values['sup_header_alternate']); ?>"><span class="sup-header-default"><?php echo strip_tags( $spine_main_header_values['sup_header_default'], '<a>' ); ?></span></sup>
	</div>

		<sub class="sub-header" data-sitename="<?php echo $spine_main_header_values['site_name']; ?>" data-pagetitle="<?php echo $spine_main_header_values['page_title']; ?>" data-posttitle="<?php echo $spine_main_header_values['post_title']; ?>" data-default="<?php echo esc_html($spine_main_header_values['sub_header_default']); ?>" data-alternate="<?php echo esc_html($spine_main_header_values['sub_header_alternate']); ?>"><span class="sub-header-default"><?php echo strip_tags( $spine_main_header_values['sub_header_default'], '<a>' ); ?></span></sub>

</header>

<?php endif; ?>