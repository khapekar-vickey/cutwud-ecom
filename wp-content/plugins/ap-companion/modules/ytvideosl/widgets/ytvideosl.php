<?php
namespace ApCompanion\Modules\Ytvideosl\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use ApCompanion\Group_Control_Query;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Ytvideosl extends Widget_Base {

	public function get_name() {
		return 'ap-ytvideosl';
	}

	public function get_title() {
		return  esc_html__( 'YouTube Video Slider', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-ytvideosl';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

    protected function _register_controls() {

        $this->start_controls_section(
            'ap_companion_ytvideosl_section',
            [
                'label' => __( 'YouTube Videos', 'ap-companion' ),
                'type' => \Elementor\Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'ap_companion_ytvideosl_channel',
            [
                'label' => __( 'YouTube Channel ID', 'ap-companion' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'UCalTPpsFaf34ABbfJbhegRQ',
                'frontend_available' => true,
                'description' => 'You can find your channel id in your channel page url. Like This is url of Youtube Channel of 8DegreeThemes "https://www.youtube.com/channel/UCalTPpsFaf34ABbfJbhegRQ", part after channel/ is channel id = "UCalTPpsFaf34ABbfJbhegRQ"',
            ]
        );

        $this->add_control(
            'ap_companion_ytvideosl_key',
            [
                'label' => __( 'YouTube API key', 'ap-companion' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'AIzaSyCgUNoo_CeiRhOPCCPHtLbDeo7NVWkbtVw',
                'frontend_available' => true,
                'description' => 'This is the api key for fetching information. You can find how to create the key <a target="_blank" href="https://developers.google.com/youtube/registering_an_application">here</a>.'
            ]
        );

        $this->add_control(
            'ap_companion_ytvideosl_number',
            [
                'label' => __( 'Total Number of Videos', 'ap-companion' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '10',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'ap_companion_ytvideosl_sort',
            [
                'label' => __( 'Sort By', 'ap-companion' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __( 'Date', 'ap-companion' ),
                    'rating' => __( 'Rating', 'ap-companion' ),
                    'title' => __( 'Title - Alphabetically', 'ap-companion' ),
                    'viewCount' => __( 'View Count', 'ap-companion' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'ap_companion_ytvideosl_lay',
            [
                'label' => __( 'Layout', 'ap-companion' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'scroller',
                'options' => [
                    'slider' => __( 'Slider', 'ap-companion' ),
                ],
                'frontend_available' => true,
            ]
        );
        

        $this->end_controls_section();

        /**
        * Styling tab
        */
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__( 'General Styles', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //slider title
        $this->add_control('vt_color',
            [
                'label'     => esc_html__( 'Video Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .video-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(),
            [
                'name'      => 'vt_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .video-title h4',
                
            ]
        );


        $this->end_controls_section();//end for styling tab

    }

    protected function render() {

        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();

        $ap_companion_ytvideosl_lay = (!empty($settings['ap_companion_ytvideosl_lay']))?$settings['ap_companion_ytvideosl_lay']:"scroller";
        
        $this->add_render_attribute( 'ap-companion-attr', 'class', 'ap-companion-ytvideosl' );
        $this->add_render_attribute( 'ap-companion-attr', 'class', 'lay-'.$ap_companion_ytvideosl_lay );
        ?>
        <div <?php echo $this->get_render_attribute_string('ap-companion-attr')?> >
            <?php
            /** Dynamic Listing of video IDs starts here */
            $player_video_id = array();
            $channel_id = $settings['ap_companion_ytvideosl_channel'];
            $key = $settings['ap_companion_ytvideosl_key'];
            $maxVids = $settings['ap_companion_ytvideosl_number'];
            $order = $settings['ap_companion_ytvideosl_sort'];

            $video_list_array = wp_remote_get( 'https://www.googleapis.com/youtube/v3/search?key='.$key.'&channelId='.$channel_id.'&part=snippet,id&order='.$order.'&maxResults='.$maxVids );
            $listFromYouTube = json_decode( wp_remote_retrieve_body( $video_list_array ), true );
            foreach($listFromYouTube['items'] as $vd){
                if(isset($vd['id']['videoId'])){
                    $player_video_id[] = $vd['id']['videoId'];
                }
            }
            /** Dynamic Listing of video IDs ends here */
            $video_list = array();
            if ( is_array( $player_video_id ) ) {
                foreach ( $player_video_id as $video_id ) {
                    $video_list[] = $video_id;
                }
            }
            $new_video_list = $video_list;

            $new_video_list = implode( ',', $new_video_list );
            ?>

            <div class="ap-companion-yt-player">

                <div class="ap-companion-video-holder clearfix"> 

                    <div class="big-video">
                        <div class="big-video-inner">
                            <i class="dashicons dashicons-no-alt"></i>
                            <div id="ap-companion-video-placeholder"></div>
                        </div>
                        <div class="video-controls">
                            <div class="video-control-holder">
                                <div class="video-play-pause stopped"><i class="dashicons dashicons-controls-play" aria-hidden="true"></i><i class="dashicons dashicons-controls-pause" aria-hidden="true"></i></div>
                            </div>
                            <div class="video-track">
                                <div class="video-current-playlist section-title">
                                    <?php esc_html_e( 'Fetching Video Title..', 'ap-companion' ) ?>
                                </div>
                                <div class="video-duration-time section-desc wow fadeInRight">
                                    <span class="video-current-time">0:00</span>
                                    /
                                    <span class="video-duration"><?php esc_html_e( 'Loading..', 'ap-companion' ) ?></span>     
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="video-thumbs">
                        <div class="ap-companion-video-thumbnails">
                            <?php
                            $video_title = $video_thumb_url = $video_duration = "";
                            $key = 'AIzaSyCgUNoo_CeiRhOPCCPHtLbDeo7NVWkbtVw';
                            $i = 1;
                            foreach ( $video_list as $video ) {
                                $video_api = wp_remote_get( 'https://www.googleapis.com/youtube/v3/videos?id=' . $video . '&key='.$key.'&part=snippet,contentDetails', array(
                                    'sslverify' => false
                                ) );

                                $video_api_array = json_decode( wp_remote_retrieve_body( $video_api ), true );
                                if ( is_array( $video_api_array ) && !empty( $video_api_array[ 'items' ] ) ) {
                                    $snippet = $video_api_array[ 'items' ][ 0 ][ 'snippet' ];
                                    $video_title = $snippet[ 'title' ];
                                    $video_thumb_url = $snippet[ 'thumbnails' ][ 'medium' ][ 'url' ];
                                    $video_duration = $video_api_array[ 'items' ][ 0 ][ 'contentDetails' ][ 'duration' ];

                                    ?>
                                    <div class="ap-companion-video-list" data-index="<?php echo absint($i); ?>" data-video-id="<?php echo esc_attr($video); ?>"> 
                                        <div class="img-icon-wrap">
                                            <img alt="<?php echo esc_attr( $video_title ); ?>" src="<?php echo esc_url( $video_thumb_url ); ?>">
                                            <i class="dashicons dashicons-controls-play" aria-hidden="true"></i>
                                        </div>
                                        <div class="video-title">
                                            <h4><?php echo esc_html( $video_title ); ?></h4>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>  
                                    <div class="ap-companion-video-list clearfix">  
                                        <div class="video-title-duration">
                                            <h4><i><?php _e( 'Either this video has been removed or you don\'t have access to watch this video', 'ap-companion' ); ?></i></h4>
                                        </div>
                                    </div>
                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            wp_enqueue_script( 'youtube-api' );
            ?>
            <script type="text/javascript">

                var player;
                var time_update_interval;

                function onYouTubeIframeAPIReady() {
                    player = new YT.Player('ap-companion-video-placeholder', {
                        videoId: '<?php echo esc_html($video_list[0]); ?>',
                        playerVars: {
                            color: 'white',
                            playlist: '<?php echo esc_html($new_video_list); ?>',
                        },
                        events: {
                            onReady: initialize,
                            onStateChange: onPlayerStateChange
                        }
                    });

                }

                function initialize() {

                    /* Update the controls on load*/
                    updateTimerDisplay();

                    jQuery('.video-current-playlist').text(jQuery('.ap-companion-video-list:first').text());
                    jQuery('.ap-companion-video-list:first').addClass('video-active');
                    //jQuery('.big-video').addClass('active');

                    /* Clear any old interval.*/
                    clearInterval(time_update_interval);

                    /* Start interval to update elapsed time display and*/
                    /* the elapsed part of the progress bar every second.*/
                    time_update_interval = setInterval(function () {
                        updateTimerDisplay();
                    }, 1000);

                }

                /*This function is called by initialize()*/
                function updateTimerDisplay() {
                    /* Update current time text display.*/
                    jQuery('.video-current-time').text(formatTime(player.getCurrentTime()));
                    jQuery('.video-duration').text(formatTime(player.getDuration()));
                }

                function formatTime(time) {
                    time = Math.round(time);
                    var minutes = Math.floor(time / 60),
                    seconds = time - minutes * 60;
                    seconds = seconds < 10 ? '0' + seconds : seconds;
                    return minutes + ":" + seconds;
                }

                function onPlayerStateChange(event) {
                    updateButtonStatus(event.data);
                }

                function updateButtonStatus(playerStatus) {
                    /*console.log(playerStatus);*/
                    if (playerStatus == -1) {
                        jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); /* unstarted*/
                        var currentIndex = player.getPlaylistIndex();

                        var currentElement = jQuery('.ap-companion-video-list').map(function () {
                            if (currentIndex == jQuery(this).attr('data-index')) {
                                return this;
                            }
                        });

                        var videoTitle = currentElement.find('h4').text();

                        currentElement.siblings().removeClass('video-active');
                        currentElement.addClass('video-active');

                        jQuery('.video-current-playlist').html(videoTitle);

                        player.setLoop(true);

                    } else if (playerStatus == 0) {
                        jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); /* ended */
                    } else if (playerStatus == 1) {
                        jQuery('.video-play-pause').removeClass('stopped').addClass('playing'); /* playing */
                    } else if (playerStatus == 2) {
                        jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); /* paused */
                    } else if (playerStatus == 3) {
                        jQuery('.video-play-pause').removeClass('playing').addClass('stopped'); /* buffering */
                    } else if (playerStatus == 5) {
                        /* video cued */
                    }
                }

                jQuery(function ($) {

                    $('body').on('click', '.video-play-pause.stopped', function () {
                        $('.big-video-inner').show();
                        $('.big-video').addClass('active');
                        player.playVideo();
                        $(this).removeClass('stopped').addClass('playing');
                    });

                    $('body').on('click', '.video-play-pause.playing', function () {
                        player.pauseVideo();
                        $(this).removeClass('playing').addClass('stopped');
                    });

                    $('body').on('click', '.big-video-inner .dashicons-no-alt', function(){
                        player.pauseVideo();
                        $(this).removeClass('playing').addClass('stopped');
                        $('.big-video').removeClass('active');
                        $('.big-video-inner').hide();
                    });

                    $('.video-next').on('click', function () {
                        player.nextVideo();
                    });

                    $('.video-prev').on('click', function () {
                        player.previousVideo()
                    });

                    $('body').on('click','.ap-companion-video-list', function () {
                        var videoIndex = $(this).attr('data-index');
                        player.playVideoAt(videoIndex);
                        player.setLoop(true);
                        $('.big-video').addClass('active');
                        $('.big-video-inner').show();
                    });
                });
            </script>
        </div>
        <?php
    }

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {}

}

/**
* Youtube video time convert 
*
*/
if ( !function_exists( 'ap_companion_pro_youtube_duration' ) ) {
    function ap_companion_pro_youtube_duration( $duration ) {

        preg_match_all( '/(\d+)/', $duration, $parts );
       //Put in zeros if we have less than 3 numbers.
        if ( count( $parts[ 0 ] ) == 1 ) {

            array_unshift( $parts[ 0 ], "0", "0" );
        } elseif ( count( $parts[ 0 ] ) == 2 ) {
            array_unshift( $parts[ 0 ], "0" );
        }

        $sec_init = $parts[ 0 ][ 2 ];
        $seconds = $sec_init % 60;
        $seconds = str_pad( $seconds, 2, "0", STR_PAD_LEFT );
        $seconds_overflow = floor( $sec_init / 60 );

        $min_init = $parts[ 0 ][ 1 ] + $seconds_overflow;
        $minutes = ( $min_init ) % 60;
        $minutes = str_pad( $minutes, 2, "0", STR_PAD_LEFT );
        $minutes_overflow = floor( ( $min_init ) / 60 );

        $hours = $parts[ 0 ][ 0 ] + $minutes_overflow;

        if ( $hours != 0 ) {
            return $hours . ':' . $minutes . ':' . $seconds;
        } else {
            return $minutes . ':' . $seconds;
        }
    }

}