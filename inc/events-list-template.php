<?php

$query_args = array(
	"post_type" => "fs_event",
	"post_status" => "publish",
	"posts_per_page" => -1,
	"meta_key" => "fs_event_date",
	"orderby" => "meta_value",
	"order" => "ASC"
);

$events = new WP_Query($query_args);

if($events->have_posts()) {
	while($events->have_posts()) : $events->the_post(); ?>
		<div class="eventbox">
			<div>
				<h2><?php echo get_the_title(); ?></h2>
			</div>
			<div>
				<span><?php echo get_post_meta( get_the_ID(), 'fs_event_date', true ); ?></span>
			</div>
			<div>
				<iframe
				  height="100"
				  frameborder="0" style="border:0"
				  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBSlGsQTwUQfbTsDR9zvxwLhU7RWIruI1s
				    &q=Space+Needle,Seattle+WA" allowfullscreen>
				</iframe>
			</div>
			<div>
				<p>More info <a href="<?php echo get_post_meta( get_the_ID(), 'fs_event_url', true ); ?>">here</a>.</p>
			</div>
			<div>
				<a href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode(get_the_title()); ?>&dates=20131124T000000Z/20131124T000000Z&details=<?php echo urlencode(get_the_content())?>&location=<?php echo urlencode(get_post_meta( get_the_ID(), 'fs_event_location', true )); ?>">
				<div class="gcal_btn">Add to calendar</div></a>
			</div>
		</div>
<?php
	endwhile;
}
?>