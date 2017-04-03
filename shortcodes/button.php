<?php
add_filter( 'su/data/shortcodes', 'rwps_register_button_shortcode', 10, 2 );
function rwps_register_button_shortcode( $shortcodes ) {
	unset( $shortcodes['button'] );

	$shortcodes['button'] = array(
		'name' => __( 'Button', 'rwps' ),
		'type' => 'wrap',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( 'Button class', 'rwps' )
			),
			'type' => array(
				'type' => 'select',
				'default' => '',
				'values' => array(
					'default' => 'None',
					'flat' => 'Flat',
					'rounded' => 'Rounded',
					'ghost' => 'Border'
				),
				'name' => 'Button type',
				'desc' => ''
			),
			'background' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Button color', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'background_hover' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Button hover color', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'color' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Text color', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'color_hover' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Text hover color', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'padding' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => '',
				'name' => __( 'Padding', 'rwps' ),
				'desc' => __( 'Button padding', 'rwps' )
			),
			'radius' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Border Radius', 'rwps' ),
				'desc' => __( 'Border radius', 'rwps' )
			),
			'border' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Border Width', 'rwps' ),
				'desc' => __( '', 'rwps' )
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
			'width' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Width', 'rwps' ),
				'desc' => __( 'Button width on tablet and largescreen devices.', 'rwps' )
			),
			'margin' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Margin', 'rwps' ),
				'desc' => __( 'Bottom margin', 'rwps' )
			),
			'target' => array(
				'type' => 'select',
				'values' => array(
					'_self' => 'Self',
					'_blank' => 'Blank'
				),
				'default' => '_self',
				'name' => __( 'Target', 'rwps' ),
				'desc' => __( 'Button target', 'rwps' )
			),
			'url' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'URL', 'rwps' ),
				'desc' => __( 'Button URL', 'rwps' )
			)
		),
		'content' => __( 'Button text', 'rwps' ),
		'desc' => __( 'Button text', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_button_shortcode'
	);

	return $shortcodes;
}

// Button
function rwps_custom_button_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
		'target' => '_self',
		'url' => '',
		'padding' => '',
		'margin' => '',
		'size' => '',
		'width' => '',
		'radius' => '',
		'border' => '',
		'background' => '',
		'background_hover' => '',
		'color' => '#fff',
		'color_hover' => '#fff',
		'instance' => $instance,
		'type' => ''
	), $atts, 'button' );
	// $hover = $atts['backgroundhover'] ? $atts['backgroundhover'] : color_luminance( $atts['background'], -0.1 );
	if ( !empty( $atts['background_hover'] ) ) {
		$hover = $atts['background_hover'];
	} elseif ( empty( $atts['background_hover'] ) && !empty( $atts['background'] ) ) {
		$hover = color_luminance( $atts['background'], -0.1 );
	} else {
		$hover = 'transparent';
	}

	if ( !empty( $atts['background_hover'] ) ) {
		$hover = $atts['background_hover'];
	} else {
		$hover = color_luminance( $atts['background'], -0.1 );
	}

	if ( $atts['type'] == 'border' ) {
		if ( !empty( $atts['background_hover'] ) ) {
			$hover = $atts['background_hover'];
		} else {
			$hover = $atts['background'];
		}		
	}

	$colorhover = $atts['color_hover'] ? $atts['color_hover'] : $atts['color'];

	$classes = array();
	$classes[] = 'rwps_button';
	$classes[] = 'btn';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	$classes[] = $atts['type'] ? 'btn-' . $atts['type'] : 'btn-flat';

	$styles = array();
	if ( !empty( $atts['size'] ) ) $styles['fontSize'] = $atts['size'] . 'px';
	if ( !empty( $atts['padding'] ) ) $styles['padding'] = $atts['padding'] . 'px 0';
	// if ( !empty( $atts['margin'] ) ) $styles['margin-bottom'] = $atts['margin'] . 'px';
	if ( !empty( $atts['radius'] ) ) $styles['borderRadius'] = $atts['radius'] . 'px';
	if ( !empty( $atts['border'] ) ) $styles['borderWidth'] = $atts['border'] . 'px';
	if ( !empty( $atts['width'] ) ) $styles['width'] = $atts['width'] . 'px';
	if ( !empty( $atts['background'] ) ) $styles['backgroundColor'] = $atts['background'];
	if ( !empty( $atts['background'] ) ) $styles['borderColor'] = $atts['background'];
	if ( !empty( $atts['color'] ) ) $styles['color'] = $atts['color'];
	$styles['colorHover'] = $colorhover;
	$styles['hover'] = $hover;

	if ( $atts['margin'] == 0 ) {
		$styles['marginBottom'] = '0px';
	} else {
		$styles['marginBottom'] = $atts['margin'] . 'px';
	}

	if ( $atts['size'] >= 24 ) {
		$styles['tabletSize'] = ($atts['size'] - $atts['size']/4) . 'px';
	}
	
	wp_enqueue_script( 'rwps-vein-js' );
	wp_enqueue_script( 'rwps-shortcodes' );
	wp_localize_script( 'rwps-shortcodes', 'btn' . $instance, $styles );

	$wraps = array();
	if ( !empty( $atts['width'] ) ) $wraps['width'] = $atts['width'] . 'px';

	$selector = 'btn-' . $instance;

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance
		// 'style' => implode('; ', array_map( function ( $v, $k ) { return $k . ':' . $v; }, $styles, array_keys( $styles ) ) )
	);

	$spans = array(
		// 'style' => implode( '; ', array_map( function ( $v, $k ) { return $k . ':' . $v; }, $wraps, array_keys( $wraps ) ) ),
		'class' => 'btn-wrap'
	);

	if ( !empty( $atts['target'] ) ) $attributes['target'] = $atts['target'];
	if ( !empty( $atts['url'] ) ) $attributes['href'] = $atts['url'];

	ob_start(); ?>

	<a <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
	<span <?php foreach( $spans as $name => $value ) echo $name . '="' . $value . '" ' ?>>
	<?php echo do_shortcode( $content ); ?>
	</span>
	</a>
	<?php $output = ob_get_clean();
	return $output;
}