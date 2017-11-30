<?php

$query_args = array(
	"post_type" => "fs_event",
	"post_status" => "publish",
	"posts_per_page" => 6,
	"meta_key" => "fs_event_date",
	"orderby" => "meta_value",
	"order" => "ASC"
);

$events = new WP_Query( $query_args );

if( $events->have_posts() ):
	while( $events->have_posts() ): $events->the_post(); 
		?>
		<div class="eventbox">
			<?php
			if( !empty( $event_title = get_the_title() ) ) {
				?>
				<div>
					<h2><?php echo esc_html( $event_title ); ?></h2>
				</div>
				<?php
			}
			if( !empty( $event_date = get_post_meta( get_the_ID(), 'fs_event_date', true ) ) ) {
				//$event_date = get_post_meta( get_the_ID(), 'fs_event_date', true );
				?>
				<div>
					<span><?php echo date( "d-m-Y", strtotime( $event_date ) ); ?></span>
				</div>
				<?php
			} else {
				$event_date = date("Y-m-d");
			}
			if( !empty( $event_location = get_post_meta( get_the_ID(), 'fs_event_location', true ) ) ) {
				?>
				<div>
					<iframe
					  height="100"
					  frameborder="0" style="border:0"
					  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBSlGsQTwUQfbTsDR9zvxwLhU7RWIruI1s
					    &q=<?php echo $event_location; ?>" allowfullscreen>
					</iframe>
				</div>
				<?php
			}
			if( !empty( $event_url = get_post_meta( get_the_ID(), 'fs_event_url', true ) ) ) {
				?>
				<div>
					<p>More info <a href="<?php echo esc_url( $event_url ); ?>">here</a>.</p>
				</div>
				<?php
			}
			$formatted_date = str_replace( "-", "", $event_date );
			$event_desc = get_the_content();
			$gcal_url = "http://www.google.com/calendar/event?action=TEMPLATE&text=$event_title&dates=$formatted_date/$formatted_date&details=$event_desc&location=$event_location";
			?>
			<div>
				<a href="<?php echo esc_url( $gcal_url ); ?>" target="_blank">
				<div class="gcal_btn">Add to calendar</div></a>
			</div>
		</div>
<?php
	endwhile;
endif;

wp_reset_query();