<div class="people-actions">

	<div class="people-actions-inner">

		<?php //if ( $filters['search'] ) : ?>
		<input type="search" id="people-search" class="cahnrs-search-field" value="" placeholder="Search" autocomplete="off">
		<!--<input type="text" id="personnel-index-search" value="" placeholder="Search" autocomplete="off">
		<input type="search" class="search-field" placeholder="Search Impact Reports" value="<?php echo get_search_query(); ?>" name="s" title="Search Impact Reports for:" />-->
		<?php //endif; ?>

		<?php
  	//if ( $filters['locations'] ) {
			$locations_sortable_items = array();
			foreach ( $people as $person ) {
				if ( $person->terms->wsuwp_university_location ) {
					foreach ( $person->terms->wsuwp_university_location as $item ) {
						if ( ! in_array( array( 'slug'=>esc_attr( $item->slug ), 'name'=>esc_attr( $item->name ) ), $locations_sortable_items ) ) {
							array_push( $locations_sortable_items, array( 'slug'=>esc_attr( $item->slug ), 'name'=>esc_attr( $item->name ) ) );
						}
					}
				}
			}
			if ( ! empty( $locations_sortable_items ) ) {
			?>
				<h2>Locations</h2>
				<div class="filter locations-container">
					<ul class="items browse-terms locations">
					<?php foreach ( $locations_sortable_items as $item ) { ?>
						<li class="wsuwp_university_location-<?php echo $item['slug']; ?>">
            	<label>
								<input type="checkbox" data-filter="location" value="<?php echo $item['slug']; ?>" />
              	<span><?php echo $item['name']; ?></span>
							</label>
						</li>
					<?php } ?>
					</ul>
				</div>
			<?php
			}
  	//}
		?>

	</div>

</div>