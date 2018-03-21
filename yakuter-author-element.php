<?php
/*
Element Description: VC Info Box
*/
 
// Element Class 
class vcInfoBox extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_infobox_mapping' ) );
        add_shortcode( 'yakuter_yazarlar', array( $this, 'vc_infobox_html' ) );
    }
     
    // Element Mapping
    public function vc_infobox_mapping() {
         
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
         
        // Map the block with vc_map()
        vc_map( 
            array(
                'name' => __('Yakuter Yazarlar', 'text-domain'),
                'base' => 'yakuter_yazarlar',
                'description' => __('Yakuter tarafından yazılmış Yazarlar elementi', 'text-domain'), 
                'category' => __('Yakuter', 'text-domain'),   
                'icon' => get_template_directory_uri().'/assets/img/vc-icon.png',            
                'params' => array(   
                         
                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Başlık', 'text-domain' ),
                        'param_name' => 'title',
                        'value' => __( 'Yazarlar', 'text-domain' ),
                        //'description' => __( 'Başlık', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Genel',
                    ),
                    
                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Kategori İsmi', 'text-domain' ),
                        'param_name' => 'category',
                        //'value' => __( 'Kategori', 'text-domain' ),
                        //'description' => __( 'Başlık', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Genel',
                    ),
                    
                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Yazı Sayısı', 'text-domain' ),
                        'param_name' => 'postcount',
                        //'value' => __( 'Kategori', 'text-domain' ),
                        //'description' => __( 'Başlık', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Genel',
                    ),  
                     
                    /*array(
                        'type' => 'textarea',
                        'holder' => 'div',
                        'class' => 'text-class',
                        'heading' => __( 'Text', 'text-domain' ),
                        'param_name' => 'text',
                        'value' => __( 'Default value', 'text-domain' ),
                        'description' => __( 'Box Text', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Custom Group',
                    ),*/                      
                        
                ),
            )
        );                                
        
    }
     
     
    // Element HTML
    public function vc_infobox_html( $atts ) {
         
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'title'   => '',
                    'category' => '',
                    'postcount' => '',
                ), 
                $atts
            )
        );
         
        // Fill $html var with data
        /*$html = '
        <div class="vc-infobox-wrap">
         
            <h2 class="vc-infobox-title">' . $title . '</h2>
             
            <div class="vc-infobox-text">' . $text . '</div>
         
        </div>';*/

        $html = '';
    
        $html .= '<div class="vc_row wpb_row vc_row-fluid"><div class="owl-carousel owl-theme">';

        $args = array(
            'category_name' => $category,
            'posts_per_page' => $postcount
        );
        
        $my_query = new WP_Query( $args );
        
        if ( $my_query->have_posts() ) {
        
            while ( $my_query->have_posts() ) {
                
                $my_query->the_post();
                $author_name = get_the_author();
                $author_ID = get_the_author_meta('ID');
        
                $html.='<div class="item">
                                <div class="wpb_column vc_column_container">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper" style="margin-bottom:15px">
                                            <div class="mnky-posts clearfix mp-layout-7">
                                                <div itemscope="" class="mp-container mp-post-1 clearfix" style="min-height:90px !important;">
                                                    <a href="' . get_author_posts_url($author_ID) . '" class="mp-image-yakuter" rel="bookmark">
                                                        <div itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
                                                            ' . get_avatar($author_ID, 240) . '
                                                        </div>
                                                    </a>
                                                    <div class="mp-content">
                                                        <h2 itemprop="headline" class="mp-title">
                                                            <a itemprop="mainEntityOfPage" href="' . get_permalink( $my_query->ID ) . '" title="' . the_title( '', '', FALSE ) . '" rel="bookmark">' . the_title( '', '', FALSE ) . '</a>
                                                        </h2>
                                                        <span class="mp-author">
                                                            <a class="author-url" href="' . get_author_posts_url($author_ID) . '" title="' . $author_name . '" rel="author">
                                                                <span itemprop="author" itemscope="" itemtype="http://schema.org/Person">
                                                                    <span itemprop="name">' . $author_name . '</span>
                                                                </span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
        
            }
        
        }
        
        wp_reset_postdata();


        $html .= '</div></div>';

        return $html;
         
    }
     
} // End Element Class
 
 
// Element Class Init
new vcInfoBox();
?>