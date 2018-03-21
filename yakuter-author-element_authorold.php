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
                    //'text' => '',
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

        $get_users_array = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'author',
            'role__in'     => array(),
            'role__not_in' => array(),
            'meta_key'     => '',
            'meta_value'   => '',
            'meta_compare' => '',
            'meta_query'   => array(),
            'date_query'   => array(),        
            'include'      => array(),
            'exclude'      => array(),
            'orderby'      => 'login',
            'order'        => 'ASC',
            'offset'       => '',
            'search'       => '',
            'number'       => '12',
            'count_total'  => false,
            'fields'       => 'all',
            'who'          => '',
         ); 
        
        $td_authors = get_users($get_users_array);

        $html = '';
    
        $html .= '<div class="vc_row wpb_row vc_row-fluid"><div class="owl-carousel owl-theme">';

            if (!empty($td_authors)) {
                foreach ($td_authors as $td_author) {

                    $args = array(
                        'author'        =>  $td_author->ID,
                        'orderby'       =>  'post_date',
                        'order'         =>  'ASC'
                    );
                    $yakuter_post_of_user = get_posts( $args );
                    $post_title = $yakuter_post_of_user[0]->post_title;
                    //$post_title = mb_substr(strip_tags($yakuter_post_of_user[0]->post_title), 0, 50,'UTF-8');

                    $html.='<div class="item">
                                <div class="wpb_column vc_column_container">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper" style="margin-bottom:15px">
                                            <div class="mnky-posts clearfix mp-layout-7">
                                                <div itemscope="" class="mp-container mp-post-1 clearfix" style="min-height:90px !important;">
                                                    <a href="' . get_author_posts_url($td_author->ID) . '" class="mp-image-yakuter" rel="bookmark">
                                                        <div itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
                                                            ' . get_avatar($td_author->ID, 240) . '
                                                        </div>
                                                    </a>
                                                    <div class="mp-content">
                                                        <h2 itemprop="headline" class="mp-title">
                                                            <a itemprop="mainEntityOfPage" href="' . get_permalink( $yakuter_post_of_user[0]->ID ) . '" title="' . $post_title . '" rel="bookmark">' . $post_title . '</a>
                                                        </h2>
                                                        <span class="mp-author">
                                                            <a class="author-url" href="' . get_author_posts_url($td_author->ID) . '" title="' . $td_author->display_name . '" rel="author">
                                                                <span itemprop="author" itemscope="" itemtype="http://schema.org/Person">
                                                                    <span itemprop="name">' . $td_author->display_name . '</span>
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

        $html .= '</div></div>';

        return $html;
         
    }
     
} // End Element Class
 
 
// Element Class Init
new vcInfoBox();
?>