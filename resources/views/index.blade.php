@extends('layouts.app')

@section('content')
                    <header class="special container">
						<span class="icon solid fa-chart-bar"></span>
						<h2>World of Warcraft Raid Roster Management</h2>
						<br />
						<p>Super-charge your discord with the ability to <strong>look up gear</strong>, <br />quickly and easily <strong>manage raid signups</strong><br /> and even allow players to set a <strong>soft reserve</strong>.
					</header>

					<!-- One -->
						<section class="wrapper style2 container special-alt">
							<div class="row gtr-50">
								<div class="col-8 col-12-narrower">

									<header>
										<h2>Manage Your Raid Roster</h2>
									</header>
                                    <p>
                                        Quickly and easily ping players who have signed up for your raid previously without notifying an entire server.<br />
                                        Export your raid roster to a spreadsheet for easy raid assignments.<br />
                                        See sign-ups based on class & spec, using the player's actual in-game character name.
                                    </p>
									<!-- <footer>
										<ul class="buttons">
											<li><a href="#" class="button">See More</a></li>
										</ul>
									</footer> -->

								</div>
								<div class="col-4 col-12-narrower imp-narrower">
                                    <a class="image featured">
                                        <img src="/images/roster.png" />
                                    </a>
								</div>
							</div>
						</section>

					<!-- Two -->
						<section class="wrapper style1 container special">
							<div class="row">
								<div class="col-4 col-12-narrower">

									<section>
										<span class="icon solid featured fa-check"></span>
										<header>
											<h3>Google Sheets Export</h3>
										</header>
										<p>Copy our awesome assignment spreadsheet or set the bot up with your own.  One simple command, and the bot will export the sign-ups to a spreadsheet for you!</p>
									</section>

								</div>
								<div class="col-4 col-12-narrower">

									<section>
										<span class="icon solid featured fa-check"></span>
										<header>
											<h3>Soft Reserves</h3>
										</header>
										<p>Enable soft reserves on your raid, and players can select an item from the list of available items in the raid as their reserve.  Easily export the reserves to your spreadsheet, to the channel, or view it on the site!</p>
									</section>

								</div>
								<div class="col-4 col-12-narrower">

									<section>
										<span class="icon solid featured fa-check"></span>
										<header>
											<h3>Completely Free</h3>
										</header>
										<p>I wrote this bot to make my life easier to manage my raids.  My hosting costs are minimal and are covered by the money I make from streaming on Twitch, so I'm able to offer this for free.</p>
									</section>

								</div>
							</div>
						</section>

					<!-- Three -->
						<section class="wrapper style3 container special">

							<header class="major">
								<h2>The bot that has everything<br /> you need for Classic WoW!</h2>
							</header>

							<div class="row">
								<div class="col-6 col-12-narrower">

									<section>
										<a href="#" class="image featured"><img src="images/image01.png" alt="" /></a>
										<header>
											<h3>Warcraft Logs Integration</h3>
										</header>
										<p>View your rankings & gear with Warcraft Logs integration!</p>
									</section>

								</div>
								<div class="col-6 col-12-narrower">

									<section>
										<a href="#" class="image featured"><img src="images/image02.png" alt="" /></a>
										<header>
											<h3>NexusHub Integration</h3>
										</header>
										<p>Look up items & prices with simple commands</p>
									</section>

								</div>
							</div>
							<div class="row">
								<div class="col-6 col-12-narrower">

									<section>
										<a href="#" class="image featured"><img src="images/image03.png" alt="" /></a>
										<header>
											<h3>Soft Reserves</h3>
										</header>
										<p>Quickly and easily manage soft reserves for your entire raid!</p>
									</section>

								</div>
								<div class="col-6 col-12-narrower">

									<section>
										<a href="#" class="image featured"><img src="images/image04.png" alt="" /></a>
										<header>
											<h3>Class & Role Management</h3>
										</header>
										<p>Allow users to easily manage their class & role through emojis in set-up channels.</p>
									</section>

								</div>
							</div>

							<!-- <footer class="major">
								<ul class="buttons">
									<li><a href="#" class="button">See More</a></li>
								</ul>
							</footer> -->

						</section>

				</article>

			<!-- CTA -->
				<section id="cta">

					<header>
						<h2>Ready for <strong>more</strong>?</h2>
						<p>Add GoodBot to your guild's discord!</p>
					</header>
					<footer>
						<ul class="buttons">
							<li><a target="_blank" href="https://discordapp.com/oauth2/authorize?client_id=525115228686516244&permissions=8&scope=bot" class="button primary">Add GoodBot</a></li>
							<li><a target="_blank" href="https://github.com/davedehaan/GoodBot/blob/master/README.md" class="button">View Docs</a></li>
						</ul>
					</footer>

                </section>
@endsection