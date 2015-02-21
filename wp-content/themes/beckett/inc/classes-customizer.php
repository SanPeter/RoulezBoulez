<?php

// Section Headers
class Beckett_Tag extends WP_Customize_Control {
	public $type = 'tag';
	public function render_content() {
	?>
		<h3 class="tt_gfp"><?php echo esc_html( $this->label ); ?></h4>
	<?php
	}
}

//Text Area Control
class Beckett_Textarea_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
		<label>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php
	}
}

?>