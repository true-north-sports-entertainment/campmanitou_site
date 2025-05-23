<?php

// Fire up icon factory
Better_Framework::factory('icon-factory');

// Get fontawesome instance
$fontawesome  = BF_Icons_Factory::getInstance('fontawesome');


// Default selected
$current = array(
	'key'   => '' ,
	'title' => '',
);


?>
<div id="better-icon-modal" class="better-modal icon-modal" data-remodal-id="better-icon-modal" role="dialog">
	<div class="modal-inner">

		<div class="modal-header">
			<span><?php _e( 'Chose an Icon', 'better-studio' ); ?></span>

			<div class="better-icons-search bf-clearfix">
				<input type="text" class="better-icons-search-input" placeholder="<?php _e( 'Search...', 'better-studio' ); ?>"/>
				<i class="clean fa fa-search"></i>
			</div>

		</div><!-- modal header -->

		<div class="modal-body bf-clearfix">

			<div class="icons-container bf-clearfix">

				<div class="icons-inner bf-clearfix">

					<ul class="icons-list">

						<li data-value="" data-label="<?php echo __( 'Chose an Icon', 'better-studio' ); ?>" class="icon-select-option default-option">
	                        <p></p>
						</li>

						<?php

						foreach( (array) $fontawesome->icons as $key => $icon){
							$_cats = '';

							if( isset( $icon['category'] ) )
								foreach($icon['category'] as $category){
									$_cats .= ' cat-'.$category;
								}
								?>

							<li data-value="<?php echo $key; ?>" data-label="<?php echo esc_attr( $icon['label'] ); ?>" data-categories="<?php echo $_cats; ?>" class="icon-select-option <?php echo ( $key === $current['key'] ? 'selected' : '' ) . $_cats; ?>">
                                <?php echo $fontawesome->getIconTag( $key ); ?> <span class="label"><?php echo $icon['label']; ?></span>
                            </li>

							<?php
						}

						?>
					</ul><!-- icons list -->


				</div><!-- /icons inner -->

			</div><!-- /icons container -->

			<div class="cats-container bf-clearfix">

				<ul class="better-icons-category-list bf-clearfix">

					<li class="icon-category selected" id="cat-all">
						<span data-cat="#cat-all"><?php _e( 'All ', 'better-studio' ); ?></span> <span class="text-muted">(<?php echo count($fontawesome->icons); ?>)</span>
					</li>

					<?php

					foreach( (array)$fontawesome->categories as $key => $category){
						?>
						<li class="icon-category" id="cat-<?php echo $category['id']; ?>">
							<span data-cat="#cat-<?php echo $category['id']; ?>"><?php echo$category['label']; ?></span> <span class="text-muted">(<?php echo $category['counts'] ?>)</span>
						</li>
						<?php
					}

					?>
				</ul><!-- categories list -->

			</div><!-- /cats container -->

		</div><!-- /modal body -->

	</div><!-- /modal inner -->

</div><!-- /modal -->