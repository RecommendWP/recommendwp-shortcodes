<?php
add_filter( 'su/data/shortcodes', 'rwps_register_panel_shortcode', 10, 2 );
function rwps_register_panel_shortcode( $shortcodes ) {
	$shortcodes['panel'] = array(
		'name' => __( 'Panel', 'rwps' ),
		'type' => 'wrap',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( 'Panel class', 'rwps' )
			),
			'icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'rwps' ),
				'desc' => __( 'You can upload custom icon for this box', 'shortcodes-ultimate' )
			),
			'icon_color' => array(
				'type' => 'color',
				'default' => '#333',
				'name' => __( 'Icon color', 'rwps' ),
				'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'shortcodes-ultimate' )
			),
			'icon_size' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Icon Size', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'icon_type' => array(
				'type' => 'select',
				'default' => '',
				'name' => __( 'Icon Type', 'rwps' ),
				'desc' => __( '', 'rwps' ),
				'values' => array(
					'basic' => __( 'Basic', 'rwps' ),
					'left-align' => __( 'Left Align', 'rwps' )
				)
			),
			'title' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Panel Title', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'margin' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Margin', 'rwps' ),
				'desc' => __( 'Bottom margin', 'rwps' )
			)
		),
		'content' => __( 'Panel Content', 'rwps' ),
		'desc' => __( '', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_panel_shortcode'
	);

	return $shortcodes;
}

//* Panel
function rwps_custom_panel_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
		'icon' => '',
		'icon_color' => '',
		'icon_size' => '',
		'icon_type' => 'basic',
		'title' => '',
		'margin' => ''
	), $atts, 'panel' );

	$selector = 'rwps_panel-' . $instance;

	$classes = array();
	$classes[] = 'rwps_panel';
	$classes[] = 'rwps-panel';
	$classes[] = $atts['icon_type'];

	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	// wp_enqueue_script( 'rwps-shorcodes' );
	// wp_localize_script( 'rwps-shorcodes', 'panel' . $instance, $styles );

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance
	);

	ob_start(); ?>
	
	<div <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
	
	<?php
	if ( $atts['icon'] ) {
		echo '<span class="panel-icon">';
		// Built-in icon
		if ( strpos( $atts['icon'], 'icon:' ) !== false ) {
			$atts['icon'] = '<span class="icon-font fa fa-' . trim( str_replace( 'icon:', '', $atts['icon'] ) ) . '" style="width:' . $atts['icon_size'] . 'px;height:' . $atts['icon_size'] . 'px;font-size:' . $atts['icon_size'] . 'px;color:' . $atts['icon_color'] . ';"></span>';
			su_query_asset( 'css', 'font-awesome' );
		}
		// Uploaded icon
		else {
			$atts['icon'] = '<img class="icon-img" src="' . $atts['icon'] . '" width="' . $atts['icon_size'] . '" height="auto" />';
		}
		
		echo $atts['icon'];

		echo '</span>';
	} 
	?>

	<?php echo $atts['title'] ? '<h4 class="panel-title">'.$atts['title'].'</h4>' : ''; ?>
	
	<div class="panel-content">
		<?php 
		if ( function_exists( 'su_do_shortcode' ) ) :
			echo su_do_shortcode( $content, 's' ); 
		else :
			echo do_shortcode( $content );
		endif;	
		?>
	</div>
	
	</div>
	
	<?php $output = ob_get_clean();
	return $output;
}