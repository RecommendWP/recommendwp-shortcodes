<?php
add_filter( 'su/data/shortcodes', 'rwps_register_address_shortcode', 10, 2 );
function rwps_register_address_shortcode( $shortcodes ) {
	$shortcodes['address'] = array(
		'name' => __( 'Address', 'rwps' ),
		'type' => 'single',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( 'Address class', 'rwps' )
			),
			'name' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Company Name', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'street' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Street Address', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'locality' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Address Locality', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'region' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Region', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'postal' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Postal Code', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
			'country' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Country', 'rwps' ),
				'desc' => __( '', 'rwps' )
			)
		),
		'content' => __( 'Address', 'rwps' ),
		'desc' => __( '', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_address_shortcode'
	);

	return $shortcodes;
}

//* Address
function rwps_custom_address_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
        'name' => '',
        'street' => '',
        'locality' => '',
        'region' => '',
        'postal' => '',
        'country' => ''
	), $atts, 'address' );

	$selector = 'rwps_address-' . $instance;

	$classes = array();
	$classes[] = 'rwps_address';
	$classes[] = 'address';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance
	);

	ob_start(); ?>

	<div itemscope itemtype="http://schema.org/PostalAddress" <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
        <?php echo $atts['name'] ? '<span itemprop="name">'.$atts['name'].'</span><br>' : ''; ?>
        <?php echo $atts['street'] ? '<span itemprop="streetAddress">'.$atts['street'].'</span><br>' : ''; ?> 
        <?php echo $atts['locality'] ? '<span itemprop="addressLocality">'.$atts['locality'].'</span>, ' : ''; ?>
        <?php echo $atts['region'] ? '<span itemprop="addressRegion">'.$atts['region'].'</span> ' : ''; ?>
        <?php echo $atts['postal'] ? '<span itemprop="postalCode">'.$atts['postal'].'</span><br>' : ''; ?>
        <?php echo $atts['country'] ? '<span itemprop="addressCountry">$atts['country']</span>' : ''; ?> 
    </div>

	<?php $output = ob_get_clean();
	return $output;
}