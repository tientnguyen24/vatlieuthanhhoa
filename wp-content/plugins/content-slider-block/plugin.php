<?php
/**
 * Plugin Name: Content Slider Block
 * Description: Display your goal to your visitor in bountiful way with content slider block
 * Version: 3.0.3
 * Author: bPlugins LLC
 * Author URI: http://bplugins.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: content-slider-block
 */

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }

// Constant
define( 'CSB_PLUGIN_VERSION', 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '3.0.3' );
define( 'CSB_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'assets/' );

// Generate Styles
class CSBStyleGenerator {
    public static $styles = [];
    public static function addStyle( $selector, $styles ){
        if( array_key_exists( $selector, self::$styles ) ){
           self::$styles[$selector] = wp_parse_args( self::$styles[$selector], $styles );
        }else { self::$styles[$selector] = $styles; }
    }
    public static function renderStyle(){
        $output = '';
        foreach( self::$styles as $selector => $style ){
            $new = '';
            foreach( $style as $property => $value ){
                if( $value == '' ){ $new .= $property; }else { $new .= " $property: $value;"; }
            }
            $output .= "$selector { $new }";
        }
        return $output;
    }
}

// Content Slider
class CSBContentSliderBlock {
    function __construct(){
        add_action( 'enqueue_block_assets', [$this, 'enqueueBlockAssets'] );
        add_action( 'enqueue_block_editor_assets', [$this, 'enqueueBlockEditorAssets'] );
        add_action( 'init', [$this, 'onInit'] );
    }

    function enqueueBlockAssets() {
        wp_enqueue_script( 'swiperJS', CSB_ASSETS_DIR . 'js/swiper-bundle.min.js', [], '7.0.3', true );
    }

    function enqueueBlockEditorAssets() {
        wp_enqueue_script( 'jqueryUI', CSB_ASSETS_DIR . 'js/jquery-ui.min.js', [], '1.13.0', true );
    }
    
    function onInit() {
        wp_register_style( 'csb-content-slider-block-editor-style', plugins_url( 'dist/editor.css', __FILE__ ), [ 'wp-edit-blocks' ], CSB_PLUGIN_VERSION ); // Backend Style
        wp_register_style( 'csb-content-slider-block-style', plugins_url( 'dist/style.css', __FILE__ ), [ 'wp-editor' ], CSB_PLUGIN_VERSION ); // Frontend Style

        register_block_type( __DIR__, [
            'editor_style'      => 'csb-content-slider-block-editor-style',
            'style'             => 'csb-content-slider-block-style',
            'render_callback'   => [$this, 'render']
        ] ); // Register Block

        wp_set_script_translations( 'csb-content-slider-block-editor-script', 'content-slider-block', plugin_dir_path( __FILE__ ) . 'languages' ); // Translate
    }
    
    // Render
    function render( $attributes ){
        extract( $attributes );

        $linkTarget = $linkTarget ?? ''; // added in v 3.0.2

        $contentSliderStyle = new CSBStyleGenerator(); // Generate Styles
        $contentSliderStyle::addStyle( "#csbContentSlider-$cId", [ 'text-align' => $sliderAlign ] );
        $contentSliderStyle::addStyle( "#csbContentSlider-$cId .csbContentSlider", [
            'width' => $sliderWidth,
            'height' => $sliderHeight
        ] );
        $contentSliderStyle::addStyle( "#csbContentSlider-$cId .csbContentSlider .slide", [ 'height' => $sliderHeight ] );
        $contentSliderStyle::addStyle( "#csbContentSlider-$cId .csbContentSlider .slide .sliderTitle", [
            $titleTypo['styles'] ?? 'font-size: 25px;' => '',
        ] );
        $contentSliderStyle::addStyle( "#csbContentSlider-$cId .csbContentSlider .slide .sliderDescription", [
            $descTypo['styles'] ?? 'font-size: 15px;' => '',
        ] );
        $contentSliderStyle::addStyle( "#csbContentSlider-$cId .csbContentSlider .slide .sliderBtn", [
            $btnTypo['styles'] ?? 'font-size: 16px;' => '',
            'padding' => $btnPadding['styles'] ?? '12px 35px',
            $btnBorder['styles'] ?? 'border-radius: 3px;' => ''
        ] );

        $contentSliderStyle::addStyle( "#csbContentSlider-$cId .csbContentSlider .swiper-pagination .swiper-pagination-bullet", [
            'background' => $pageColor,
            'width' => $pageWidth,
            'height' => $pageHeight,
            $pageBorder['styles'] ?? 'border-radius: 50%;' => ''
        ] );
        $contentSliderStyle::addStyle( "#csbContentSlider-$cId .csbContentSlider .swiper-button-prev, #csbContentSlider-$cId .csbContentSlider .swiper-button-next", [ 'color' => $prevNextColor ] );

        $jsonData = wp_json_encode( [ 'slides' => $slides, 'columns' => $columns, 'columnGap' => $columnGap, 'isLoop' => $isLoop, 'isTouchMove' => $isTouchMove, 'isAutoplay' => $isAutoplay, 'speed' => $speed, 'effect' => $effect, 'isPageClickable' => $isPageClickable, 'isPageDynamic' => $isPageDynamic ] );

        ob_start(); ?>
        <div class='wp-block-csb-content-slider-block <?php echo 'align' . esc_attr( $align ); ?>' id='csbContentSlider-<?php echo esc_attr( $cId ); ?>' data-slider='<?php echo esc_attr( $jsonData ); ?>'>
            <style>@import url( <?php echo esc_url( $titleTypo['googleFontLink'] ?? '' ); ?> ); @import url( <?php echo esc_url( $descTypo['googleFontLink'] ?? '' ); ?> ); @import url( <?php echo esc_url( $btnTypo['googleFontLink'] ?? '' ); ?> );<?php echo wp_kses( $contentSliderStyle::renderStyle(), [] );
                foreach ( $slides as $index => $slide ) {
                    $backgroundStyle = $slide['background']['styles'] ?? 'background-color: #00000080;';
                    $titleColor = $slide['titleColor'] ?? $titleColor ?? '#fff';
                    $descColor = $slide['descColor'] ?? $descColor ?? '#fff';
                    $btnStyle = $slide['btnColors']['styles'] ?? $btnColors['styles'] ?? 'color: #fff; background: #4527a4;';
                    $btnHovStyle = $slide['btnHovColors']['styles'] ?? $btnHovColors['styles'] ?? 'color: #fff; background: #8344c5;';
                    $slideStyles = "#csbContentSlider-$cId .csbContentSlider .slide-$index{ $backgroundStyle }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderTitle{ color: $titleColor; }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderDescription{ color: $descColor; }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderBtn{ $btnStyle }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderBtn:hover{ $btnHovStyle }";
                    echo esc_html( $slideStyles );
                } ?>
            </style>
            <style class='csbContentSliderStyle'></style>

            <div class='csbContentSlider'>
                <div class='swiper-wrapper'>
                    <?php foreach ( $slides as $index => $slide ) {
                        extract( $slide );
                        $btnLinkURL = $btnLink ?? ''; ?>
                        <div class='slide slide-<?php echo esc_attr( $index ); ?> swiper-slide'>
                            <div class='sliderContent'>
                                <?php echo $isTitle && !empty( $title ) ? "<h2 class='sliderTitle'>". wp_kses_post( $title ) ."</h2>" : ''; ?>
                                <?php echo $isDesc && !empty( $description ) ? "<p class='sliderDescription'>". wp_kses_post( $description ) ."</p>" : ''; ?>
                                <?php echo $isBtn && !empty( $btnText ) ? "<a href='$btnLinkURL' class='sliderBtn' target='$linkTarget' rel='noreferrer'>". wp_kses_post( $btnText ) ."</a>" : ''; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php echo $isPage ? "<div class='swiper-pagination'></div>" : ''; ?>
                <?php echo $isPrevNext ? "<div class='swiper-button-prev'></div><div class='swiper-button-next'></div>" : ''; ?>
            </div>
        </div>

        <?php $contentSliderStyle::$styles = []; // Empty styles
        return ob_get_clean();
    }
}
new CSBContentSliderBlock;