<?php
add_filter( 'su/data/shortcodes', 'rwps_register_content_shortcode', 10, 2 );
function rwps_register_content_shortcode( $shortcodes ) {
	$shortcodes['content_box'] = array(
		'name' => __( 'Content Box', 'rwps' ),
		'type' => 'wrap',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( 'Text class', 'rwps' )
			),
			'padding' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Padding', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'width' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 2000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Width', 'rwps' ),
				'desc' => __( 'Content width', 'rwps' )
			),
			'tablet_width' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 2000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Tablet Width', 'rwps' ),
				'desc' => __( 'Content width', 'rwps' )
			),
			'alignment' => array(
				'type' => 'select',
				'values' => array(
					'alignnone' => 'None',
					'aligncenter' => 'Center',
					'alignleft' => 'Left',
					'alignright' => 'Right'
				),
				'default' => 'alignnone',
				'name' => __( 'Alignment', 'rwps' ),
				'desc' => __( 'Image alignment', 'rwps' )
			),
			'size' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Font Size', 'rwps' ),
				'desc' => __( 'Font size', 'rwps' )
			),
			'height' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Line Height', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'spacing' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1,
				'step' => 0.05,
				'default' => '',
				'name' => __( 'Letter Spacing', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'background' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Background color', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'color' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Font color', 'rwps' ),
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
		'content' => __( 'Box content', 'rwps' ),
		'desc' => __( '', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_box_shortcode'
	);

	return $shortcodes;
}

//* Box
function rwps_custom_box_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;
	$atts = shortcode_atts( array(
		'class' => '',
		'size' => '',
		'background' => '',
		'padding' => '',
		'margin' => '',
		'height' => '',
		'spacing' => '',
		'alignment' => '',
		'width' => null,
		'tablet_width' => null,
		'color' => '',
		'instance' => $instance
	), $atts, 'content_box' );

	// if ( $atts['height'] != 0 || $atts['size'] != 0 ) {
		// $height = ($atts['height']/$atts['size']);
	// }

	$selector = 'box-' . $instance;

	$classes = array();
	
	$classes[] = 'rwps_box';
	$classes[] = 'box';

	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];
	if ( !empty( $atts['alignment'] ) ) $classes[] = $atts['alignment'];

	$styles = array();
	if ( !empty( $atts['size'] ) ) $styles['fontSize'] = $atts['size'] . 'px';
	if ( !empty( $atts['padding'] ) ) $styles['padding'] = $atts['padding'] . 'px';
	if ( !empty( $atts['height'] ) ) $styles['lineHeight'] = $atts['height'] . 'px';
	if ( !empty( $atts['background'] ) ) $styles['backgroundColor'] = $atts['background'];
	if ( !empty( $atts['spacing'] ) ) $styles['letterSpacing'] = $atts['spacing'] . 'em';
	if ( !empty( $atts['width'] ) ) $styles['width'] = $atts['width'] . 'px';
	if ( !empty( $atts['color'] ) ) $styles['color'] = $atts['color'];
	// if ( !empty( $atts['margin'] ) ) $styles['margin-bottom'] = $atts['margin'] . 'px';
	if ( !empty( $atts['alignment'] ) ) $styles['textAlign'] = $atts['alignment'];
	$styles['tabletWidth'] = $atts['tablet_width'] ? $atts['tablet_width'] . 'px' : '100%';

	if ( $atts['margin'] == 0 ) {
		$styles['marginBottom'] = '0px';
	} else {
		$styles['marginBottom'] = $atts['margin'] . 'px';
	}

	wp_enqueue_script( 'rwps-shorcodes' );
	wp_localize_script( 'rwps-shorcodes', 'box' . $instance, $styles );

	$attributes = array(
		'id' => $selector,
		'class' => esc_attr( implode( ' ', $classes ) ),
		// 'style' => implode('; ', array_map( function ( $v, $k ) { return $k . ':' . $v; }, $styles, array_keys( $styles ) ) ),
		'data-instance' => $instance
	);

	ob_start(); ?>

	<div <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
	<?php echo su_do_shortcode( $content, 's' ); ?>
	</div>
	<?php
	$output = ob_get_clean();
	return $output;
}