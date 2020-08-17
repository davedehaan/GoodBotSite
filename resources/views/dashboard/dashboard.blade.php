@extends('layouts.dashboard')

@section('content')

<section class="wrapper style1 container special">
							<div class="row">
								<div class="col-4 col-12-narrower">
									<section>
                                        <a href="/dashboard/setup/{{ $server->id }}">
                                            <span class="icon solid featured fa-key"></span>
                                            <header>
                                                <h3>Set-up</h3>
                                            </header>
                                        </a>
									</section>

								</div>
								<div class="col-4 col-12-narrower">
									<section>
                                        <a href="/dashboard/settings/{{ $server->id }}">
                                            <span class="icon solid featured fa-memory"></span>
                                            <header>
                                                <h3>Settings</h3>
                                            </header>
                                        </a>
									</section>
								</div>
								<div class="col-4 col-12-narrower">
									<section>
                                        <a href="/dashboard/logs/{{ $server->id }}">
										<span class="icon solid featured fa-book"></span>
                                            <header>
                                                <h3>Logs</h3>
                                            </header>
                                        </a>
									</section>

								</div>
							</div>
						</section>

@endsection

@section('scripts')

@endsection