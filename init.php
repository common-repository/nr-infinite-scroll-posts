<?php
/*
Plugin Name: NR Infinite Scroll Posts
Plugin URI: http://nrtechwebsolution.com
Description: This plugin will load posts on scroll with ajax.
Author: Neeraj Chaturvedi
Text Domain: nr-infinite-scroll-posts
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Author URI: http://nrtechwebsolution.com
*/
if ( ! defined( 'NRPOSTSSCROLL_URL' ) ) {
define( 'NRPOSTSSCROLL_URL', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'NRPOSTSSCROLL_URL_ASSETS_URL' ) ) {
define( 'NRPOSTSSCROLL_URL_ASSETS_URL', NRPOSTSSCROLL_URL . 'assets/' );
}

class NRScrollInfinite{

		function __construct(){

				add_action( 'wp_ajax_nr_infinite_more', array($this,'nr_infinite_more') );
				add_action( 'wp_ajax_nopriv_nr_infinite_more', array($this,'nr_infinite_more') );
				add_action( 'wp_enqueue_scripts', array($this,'nr_load_script') );
				add_shortcode( 'NR_INIFINITE_SCROLL', array($this,'nr_render_html') );
			}

		/**
		 * Javascript for Load More
		 *
		 */
		public function nr_load_script() {
			global $wp_query;
			$args = array(
				'url'   => admin_url( 'admin-ajax.php' ),
			);	
			wp_enqueue_style( 'nr-load-css', NRPOSTSSCROLL_URL_ASSETS_URL . 'css/load-more.css' );				
			wp_enqueue_script( 'nr-load-js', NRPOSTSSCROLL_URL_ASSETS_URL . 'js/load-more.js', array( 'jquery' ), '1.0', true );
			wp_localize_script( 'nr-load-js', 'nrObj', $args );

			
		}
		/**
		 * AJAX Load More 
		 *
		 */
		public function nr_infinite_more() {
				$args['post_type'] = isset( $_POST['post_type'] ) ? $_POST['post_type'] : 'post';
				$args['paged'] = $_POST['page'];
				$args['post_status'] = 'publish';
				$args['posts_per_page'] = 5;
				$comments_active= $_POST['is_comments_label'];
				$author_label= $_POST['is_author_label'];
				$is_date_label= $_POST['is_date_label'];
				

				$loop = new WP_Query( $args );
				global $post;
				$html='';
				if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();	
					$html.='<div class="article artical-box">';
					 if ( has_post_thumbnail($post->ID) ) {   
						$html.='<div class="article_area_left">';
						$html.='<a href="'.get_the_permalink($post->ID).'">';
						$html.= get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'class' => 'alignleft' ) );
						$html.='</a>';
						$html.='</div>';
				     }
				     $author = get_the_author($post->ID);
				     $pfx_date = get_the_date( 'Y-m-d', $post->ID ); 
				     $commentCount= wp_count_comments( $post->ID );
					$html.='<div class="article_area_right">';
					$html.='<div class="article-title"> <a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></br>';
					if($author_label=="true"){
						$html.='<span class="article-badges"> created by '.$author.' </span> |';
					}
				    if($is_date_label=="true"){
						$html.='<span class="article-badges"> At: '.$pfx_date.' </span>|';
					}					
					if($comments_active=="true"){
						$html.='<span class="article-badges"> Comments: '.$commentCount->total_comments.' </span>';	
					}


					$html.='</div>
						<p>'.get_the_excerpt($post->ID).'</p>';
					$html.='</div>';
					$html.='</div>';	
					$html.='</div>';	
					$html.='<div class="clearboth"></div>';
				endwhile; endif; wp_reset_postdata();
				$data = $html;
				wp_send_json_success( $data );
			}


		public function nr_render_html($atts){
			$atts = shortcode_atts( array(
				'post_type' => 'post',
				'posts_per_page' => 5,
				'post_status'=>'publish',
				'author_label'=>"true",
				'comments_label'=>"true",
				'date_label'=>"true"

			), $atts );
	

			return $this->create_template_for_posts_container($atts);
			//nr_infinite_more();
		}	

		public function create_template_for_posts_container($args){
		  $html='';
			$html.='<h2> All Posts</h2>';
			$html.= '<div class="post-listing" data-post-type="'.$args['post_type'].'" data-per-page="'.$args['posts_per_page'].'" data-comments="'.$args['comments_label'].'" data-author="'.$args['author_label'].'" data-date="'.$args['date_label'].'">';
			$html.= '</div>';
			return $html;
		}


	  public function create_template_for_posts($args){
			$html='';
			$html.='<h2> All Posts</h2>';
			$html.= '<div class="post-listing" data-post-type="'.$args['post_type'].'" data-per-page="'.$args['posts_per_page'].'"  >';
			$html.= '<div>';
			return $html;
		}	

}
new NRScrollInfinite();
?>
