<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

	/**
	 * Class to create a custom post control
	 */
	class Beckett_Post_Dropdown_Custom_Control extends WP_Customize_Control {
	    public $type = 'dropdown-projects';

	    public function render_content() {
			$postargs = array( 'numberposts' => '-1', 'post_type' => array( 'project' ) );
			$this->posts = get_posts( $postargs );

			if( !empty( $this->posts ) ) { ?>

				 <label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<select data-customize-setting-link="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
						<?php

						foreach($this->posts as $post){

							printf( '<option value="%s" %s>%s</option>', $post->ID, selected( $this->value(), $post->ID, false ), $post->post_title );

					} ?>
					</select>
				</label>

	        <?php }

	        } // render_content()

		} // class