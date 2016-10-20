<?php
	$brandstoff = get_post_meta(get_the_ID(), 'brandstof', true);
	$merkk = get_post_meta(get_the_ID(), 'merk', true);
	array_push($brandstof,$brandstoff);	
	array_push($merk, $merkk);
?>
<a href="<?php the_permalink() ?>" class="magneet--vwe--archive__item brandstof-<?php echo get_post_meta(get_the_ID(), 'brandstof', true) ?> merk-<?php echo get_post_meta(get_the_ID(), 'merk', true) ?> prijs-<?php magneet_prijs(  get_post_meta(get_the_ID(), 'verkoopprijs_particulier', true)  ) ?>">
							<span class="prijs"><?php echo get_post_meta(get_the_ID(), 'verkoopprijs_particulier', true) ?></span>
							<span class="magneet--vwe-archive__img"><?php the_post_thumbnail( 'medium_large' ); ?></span>
							<h4 class="naam"><?php the_title(); ?></h4>
							<ul class="magneet--vwe-features">
								<?php
									foreach($list as $key => $value){
										?>
											<li class="magneet--vwe-features__item">
												<span class="magneet--vwe-features__label"><?php echo $value ?> </span>
												<span class="magneet--vwe-features__value type-<?php echo $key ?>"><?php echo get_post_meta(get_the_ID(), $key, true) ?></span>
											</li>
										<?php
									}	
								?>
							</ul>
					</a>