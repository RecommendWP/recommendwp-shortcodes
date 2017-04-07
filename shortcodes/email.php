<?php
add_filter( 'su/data/shortcodes', 'rwps_register_email_shortcode', 10, 2 );
function rwps_register_email_shortcode( $shortcodes ) {
	$shortcodes['email'] = array(
		'name' => __( 'Email', 'rwps' ),
		'type' => 'wrap',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( 'Email class', 'rwps' )
			),
            'before' => array(
                'type' => 'text',
                'default' => 'Email:',
                'name' => __( 'Text before', 'rwps' ),
                'desc' => __( '', 'rwps' )
            ),
			'address' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Email Address', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
		),
		'content' => __( 'Email', 'rwps' ),
		'desc' => __( '', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_email_shortcode'
	);

	return $shortcodes;
}

//* Email
function rwps_custom_email_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
        'before' => 'Email:',
        'address' => ''
	), $atts, 'email' );

	$selector = 'rwps_email-' . $instance;

	$classes = array();
	$classes[] = 'rwps_email';
	$classes[] = 'email';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance
	);

	ob_start(); ?>

	<span <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
        <?php echo $atts['before'] ? $atts['before'] : ''; ?>
        <a itemprop="email" href="mailto:<?php echo $atts['address']; ?>"><?php echo su_do_shortcode( $content, 's' ); ?></a>
    </span>

	<?php $output = ob_get_clean();
	return $output;
}