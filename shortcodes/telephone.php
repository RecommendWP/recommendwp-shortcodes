<?php
add_filter( 'su/data/shortcodes', 'rwps_register_telephone_shortcode', 10, 2 );
function rwps_register_telephone_shortcode( $shortcodes ) {
	$shortcodes['telephone'] = array(
		'name' => __( 'Telephone', 'rwps' ),
		'type' => 'wrap',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( 'Telephone class', 'rwps' )
			),
            'before' => array(
                'type' => 'text',
                'default' => 'Phone:',
                'name' => __( 'Text before', 'rwps' ),
                'desc' => __( '', 'rwps' )
            ),
			'number' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Telephone Number', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
		),
		'content' => __( 'Telephone', 'rwps' ),
		'desc' => __( '', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_telephone_shortcode'
	);

	return $shortcodes;
}

//* Telephone
function rwps_custom_telephone_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
        'before' => 'Phone:',
        'number' => ''
	), $atts, 'telephone' );

	$selector = 'rwps_telephone-' . $instance;

	$classes = array();
	$classes[] = 'rwps_telephone';
	$classes[] = 'telephone';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance
	);

	ob_start(); ?>

	<span <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
        <?php echo $atts['before'] ? $atts['before'] : ''; ?>
        <a itemprop="telephone" content="<?php echo $atts['number']; ?>" href="tel:<?php echo $atts['number']; ?>"><?php echo su_do_shortcode( $content, 's' ); ?></a>
    </span>

	<?php $output = ob_get_clean();
	return $output;
}