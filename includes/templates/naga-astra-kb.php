<div class="wrap">
	<h1><?php esc_html_e( 'NagaTheme Astra Videos', 'astra-child' ); ?></h1>
	<p><?php esc_html_e( 'Please watch Astra videos before using it.', 'astra-child' ); ?></p>
	<div class="naga-box-help">
		<div class="naga-box">
			<div class="nga_vid_row">
				<div>
					<ul>
						<?php
						// Video List
						$videos = [
							'hswvA',
							'tiNwv',
							'ANvpB',
							'zG3cL',
							'49XPp',
							'rfFzM',
							'rFIi9',
							'tV3ur',
							'izh26',
							'4axd2',
							'IdkrN',
							'ImOKp',
							'KZ6zH',
							'ZRax3',
						];

						foreach ( $videos as $index => $video_id ) {
							echo '<li><a href="https://www.aparat.com/video/video/embed/videohash/' . esc_attr( $video_id ) . '/vt/frame" target="astra_iframe">';
							/* translators: %d video number */
							printf( esc_html__( 'Video Tutorial %d', 'astra-child' ), $index + 1 );
							echo '</a></li>';
						}
						?>
					</ul>
				</div>

				<div>
					<iframe src="https://www.aparat.com/video/video/embed/videohash/hswvA/vt/frame"
						name="astra_iframe"
						height="720"
						width="100%"
						title="<?php esc_attr_e( 'Astra Iframe', 'astra-child' ); ?>">
					</iframe>
				</div>
			</div>
		</div>
	</div>
</div>