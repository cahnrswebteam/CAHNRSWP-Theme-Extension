
<?php
// Meta data.
if ( isset( $person->working_titles[0] ) ) {
	$title = $person->working_titles[0];
} else {
	$title = ucwords( strtolower( $person->position_title ) );
}

if ( ! empty( $person->email_alt ) ) {
	$email = $person->email_alt;
} else {
	$email = $person->email;
}

if ( ! empty( $person->office_alt ) ) {
	$office = $person->office_alt;
} else {
	$office = $person->office;
}

if ( ! empty( $person->phone_alt ) ) {
	$phone = $person->phone_alt;
} else {
	$phone = $person->phone;
}

$photo   = $person->profile_photo;
$degrees = $person->degrees;
$cv      = $person->cv_attachment;
$website = $person->website;

// Taxonomy data.
$departments = $person->terms->wsuwp_university_org;
$locations   = $person->terms->wsuwp_university_location;
?>
<div class="full-profile">

	<a class="profile-link close" href="#">x</a>

  <header class="article-header">
    <hgroup>
      <h2 class="article-title"><?php echo esc_html( $person->title ); ?></h2>
    </hgroup>
  </header>

	<?php if ( $title ) : ?>
  <p class="title"><?php echo esc_html( $title ); ?></p>
  <?php endif; ?>

  <?php if ( $email ) : ?>
  <p class="contact email"><span class="dashicons dashicons-email"></span> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
  <?php endif; ?>

  <?php if ( $phone ) : ?>
  <p class="contact phone"><span class="dashicons dashicons-phone"></span> <?php echo esc_html( $phone ); ?></p>
  <?php endif; ?>

  <?php if ( $office ) : ?>
  <p class="location"><span class="dashicons dashicons-location"></span> <?php echo esc_html( $office ); ?></p>
  <?php endif; ?>

  <?php if ( $cv ) : ?>
  <p class="contact cv"><span class="dashicons dashicons-download"></span><a href="<?php echo esc_url( $cv ); ?>">Curriculum Vitae</a></p>
  <?php endif; ?>

  <?php if ( $website ) : ?>
  <p class="contact website"><span class="dashicons dashicons-external"></span><a href="<?php echo esc_url( $website ); ?>">Website</a></p>
  <?php endif; ?>

	<!--<div class="column two">
		<?php if ( $photo ) : ?>
			<figure class="profile-photo"><img alt="<?php echo esc_attr( $person->title ) ?>" src="<?php echo esc_attr( $photo ); ?>" /></figure>
		<?php endif; ?>
	</div>-->



		<?php echo $person->content; ?>

</div>