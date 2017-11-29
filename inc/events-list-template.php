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

if( $events->have_posts() ) {
	while( $events->have_posts() ) : $events->the_post(); 
		?>
		<div class="eventbox">
			<?php
			if( !empty( get_the_title() ) ) {
				?>
				<div>
					<h2><?php echo get_the_title(); ?></h2>
				</div>
				<?php
			}
			$event_date = date("Y-m-d");
			if( !empty( get_post_meta( get_the_ID(), 'fs_event_date', true ) ) ) {
				$event_date = get_post_meta( get_the_ID(), 'fs_event_date', true );
				?>
				<div>
					<span><?php echo date( "d-m-Y", strtotime( $event_date ) ); ?></span>
				</div>
				<?php
			}
			if( !empty( get_post_meta( get_the_ID(), 'fs_event_location', true ) ) ) {
				?>
				<div>
					<iframe
					  height="100"
					  frameborder="0" style="border:0"
					  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBSlGsQTwUQfbTsDR9zvxwLhU7RWIruI1s
					    &q=<?php echo str_replace( ' ', '+',  get_post_meta( get_the_ID(), 'fs_event_location', true ) ); ?>" allowfullscreen>
					</iframe>
				</div>
				<?php
			}
			if( !empty( get_post_meta( get_the_ID(), 'fs_event_url', true ) ) ) {
				?>
				<div>
					<p>More info <a href="<?php echo get_post_meta( get_the_ID(), 'fs_event_url', true ); ?>">here</a>.</p>
				</div>
				<?php
			}
			?>
			<div>
				<a href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode(get_the_title()); ?>&dates=<?php echo str_replace( "", "", $event_date ); ?>/<?php echo str_replace( "", "", $event_date ); ?>&details=<?php echo urlencode( get_the_content() ); ?>&location=<?php echo urlencode( get_post_meta( get_the_ID(), 'fs_event_location', true ) ); ?>">
				<div class="gcal_btn">Add to calendar</div></a>
			</div>
		</div>
<?php
	endwhile;
}
?>