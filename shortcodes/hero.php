<?php
add_filter( 'su/data/shortcodes', 'rwps_register_hero_shortcode', 10, 2 );
function rwps_register_hero_shortcode( $shortcodes ) {
	$shortcodes['hero_unit'] = array(
		'name' => __( 'Hero Unit', 'rwps' ),
		'type' => 'wrap',
		'group' => 'recommendwp',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
            'title' => array(
                'type' => 'text',
                'default' => '',
                'name' => __( 'Hero title', 'rwps' ),
            ),
			'image' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Upload hero background', 'rwps' ),
				'desc' => __( '', 'rwps' )
			),
            'color' => array(
                'type' => 'color',
                'default' => '',
                'name' => __( 'Background color', 'rwps' ),
                'desc' => __( '', 'rwps' )
            )
		),
		'content' => __( 'Hero', 'rwps' ),
		'desc' => __( 'Hero content', 'rwps' ),
		'icon' => 'code',
		'function' => 'rwps_custom_hero_shortcode'
	);

	return $shortcodes;
}

//* Hero Image
function rwps_custom_hero_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
		'image' => '',
		'title' => '',
        'hover' => 'yes'
	), $atts, 'hero' );

	$selector = 'rwps_hero-' . $instance;

	$classes = array();
	$classes[] = 'rwps_hero';
	$classes[] = 'hero';
    
    if ( $atts['hover'] == 'yes' ) $classes[] = 'hero-hover';
	
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	$styles = array();
	if ( !empty( $atts['image'] ) ) {
		$styles['background-size'] = 'cover';
		$styles['background-image'] = 'url('.esc_url( $atts['image'] ).')';
		$styles['background-position'] = 'top';
		$styles['background-repeat'] = 'no-repeat';
	}

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance,
		'style' => implode('; ', array_map( function ( $v, $k ) { return $k . ':' . $v; }, $styles, array_keys( $styles ) ) ),
	);

	ob_start(); ?>
	<div <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
		<div class="hero-container">
			<div class="hero-content">
				<div class="hero-title">
					<?php echo '<h2>'.$atts['title'].'</h2>'; ?>
				</div>
				<div class="hero-copy">
					<?php echo su_do_shortcode( $content, 's' ); ?>	
				</div>
			</div>
		</div>
	</div>

	<?php $output = ob_get_clean();
	return $output;
}
