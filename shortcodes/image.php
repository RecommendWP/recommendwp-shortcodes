<?php
add_filter( 'su/data/shortcodes', 'rwps_register_image_shortcode', 10, 2 );
function rwps_register_image_shortcode( $shortcodes ) {
	$shortcodes['image'] = array(
		'name' => __( 'Image', 'rwps' ),
		'type' => 'single',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( 'Image class', 'rwps' )
			),
			'image' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Image Source', 'rwps' ),
				'desc' => __( 'Off-site images won\'t be resized.', 'rwps' )
			),
			'alt' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Alt', 'rwps' ),
				'desc' => __( 'Alt text', 'rwps' )
			),
			'width' => array(
				'type' => 'number',
				'default' => '',
				'name' => __( 'Width', 'rwps' ),
				'desc' => __( 'Image width', 'rwps' )
			),
			'height' => array(
				'type' => 'number',
				'default' => '',
				'name' => __( 'Height', 'rwps' ),
				'desc' => __( 'Image height', 'rwps' )
			),
			'url' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Link', 'rwps' ),
				'desc' => __( 'Image link', 'rwps' )
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
				'desc' => __( 'Text alignment', 'rwps' )
			),
			'margin' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Margin', 'rwps' ),
				'desc' => __( 'Image margin based on chosen alignment', 'rwps' )
			),
			'div' => array(
				'type' => 'bool',
				'default' => 'no',
				'name' => __( 'Add enclosing div tags?', 'rwps' ),
				'desc' => ''
			),
		),
		'content' => __( '', 'rwps' ),
		'desc' => __( 'Text content', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_image_shortcode'
	);
	
	return $shortcodes;
}

//* Image
function rwps_custom_image_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'class' => '',
		'image' => '',
		'url' => '',
		'width' => '',
		'height' => '',
		'margin' => '',
		'alignment' => '',
		'alt' => '',
		'div' => ''
	), $atts, 'image' );

	$image = $atts['image'];

	if ( $image ) {
		$image = rwps_thumb( $image, $atts['width'] ? $atts['width'] : 0, $atts['height'] ? $atts['height'] : 0 );
	} else {
		$image = $image;
	}

	$classes = array();
	$classes[] = 'rwps_image';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];
	if ( !empty( $atts['alignment'] ) ) $classes[] = $atts['alignment'];

	$styles = array();
	
	// if ( !empty( $atts['margin'] ) ) $styles['margin-bottom'] = $atts['margin'] . 'px';

	if ( $atts['margin'] == 0 ) {
		$styles['margin-bottom'] = '0px';
	} else {
		$styles['margin-bottom'] = $atts['margin'] . 'px';
	}

	$attributes = array();
	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'style' => implode('; ', array_map( function ( $v, $k ) { return $k . ':' . $v; }, $styles, array_keys( $styles ) ) ),
		'src' => esc_url( $image )
	);

	if ( !empty( $atts['alt'] ) ) $attributes['alt'] = $atts['alt'];

	ob_start(); ?>
	<?php echo $atts['div'] ? '<div class="image-wrapper">' : ''; ?>
	<?php echo $atts['url'] ? '<a href="'.esc_url( $atts['url'] ).'">' : ''; ?>
	<img <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?> />
	<?php echo $atts['url'] ? '</a>' : ''; ?>
	<?php echo $atts['div'] ? '</div>' : ''; ?>
	<?php
	// return apply_filters( 'rwps_custom_image_shortcode', $output, $atts );
	$output = ob_get_clean();
	return $output;
}