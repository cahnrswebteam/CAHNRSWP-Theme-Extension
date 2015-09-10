<?php
$classes = array();
if ( $person->terms->wsuwp_university_location ) {
	foreach ( $person->terms->wsuwp_university_location as $locations ) {
		$classes[] = ' location-' . esc_attr( $locations->slug );
	}
}
?>
<article class="wsuwp-person-container <?php foreach( $classes as $class ) { echo $class; } ?>">

	<div class="person">

		<img src="<?php
			if ( isset( $person->profile_photo ) && $person->profile_photo ) {
    		echo esc_url( $person->profile_photo );
			} else {
				echo 'http://m1.wpdev.cahnrs.wsu.edu/wp-content/themes/CAHNRSWP-theme-extension/images/person-placeholder.jpg';
			}
		?>" />

		<header class="card">
			<div class="wsuwp-person-name">
				<a class="profile-link" href="<?php echo esc_url( $person->link ); ?>" data-id="<?php echo esc_html( $person->ID ); ?>"><?php echo esc_html( $person->title ); ?></a>
			</div>
			<div class="wsuwp-person-position"><?php echo esc_html( $title ); ?></div>
    	<!--<div class="wsuwp-person-email"><a href="mailto:<?php echo esc_html( $email ); ?>"><?php echo esc_html( $email ); ?></a></div>
			<div class="wsuwp-person-phone"><a href="tel:<?php echo esc_html( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></div>
			<div class="wsuwp-person-office"><?php echo esc_html( $office ); ?></div>-->
		</header>

	</div>

</article>