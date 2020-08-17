<!DOCTYPE HTML>
<html>
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-175462372-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'UA-175462372-1');
		</script>
		<title>GoodBot</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="/assets/css/main.css" />
		<noscript><link rel="stylesheet" href="/assets/css/noscript.css" /></noscript>
		
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!-- JQuery UI -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        
        <style>
            body.index #main {
                padding-top: 3em;
            }
            header.special {
                padding-top: 0;
            }
                            
                a {
                    color: #333;
                    border-bottom: none;
                }
                a img {
                    border: none;
                }
                .row h3 {
                    margin: 0;
                }
                .icon.featured {
                    cursor: pointer;
                }
                a:hover {
                    color: #CCC;
				}
				label {
					display: block;
					width: 100%
					clear: both;
					margin: 10px 0;
					border-bottom: solid 1px #CCC;
					color: #333;
					font-weight: bold;
				}
				select, input {
					width: 50%;
					height: 30px;
				}
				button {
					margin: 30px 0 10px;
				}
        </style>

		@if (session()->get('darkmode'))
			<style>
				body {
					background: #333;
				}
				.wrapper.style2, .wrapper.style3 {
					background: #772200;
				}
				#header, #footer {
					background: #772200;
					color: #CCC;
				}
				h1#logo {
					color: #CCC;
				}
				table th {
					color: #CCC;
				}
				h2 {
					color: #CCC;
				}
				#main section {
					color: #CCC;
				}
				.button.primary {
					background: #CC9900;
					border: solid 1px #CCC;
				}
				.dropotron {
					background: #772200;
					color: #CCC;
                } 

			</style>
		@endif
	</head>
	<body class="index is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header" class="alt">
					<h1 id="logo"><a href="/">GoodBot</a></h1>
					<nav id="nav">
						<ul>
                        <li class="current"><a href="/">Home</a></li>
                        <li class="current"><a class="button primary" target="_blank" href="https://discordapp.com/oauth2/authorize?client_id=525115228686516244&permissions=8&scope=bot">Add GoodBot</a></li>
                            @if (empty(session()->get('user')))
                                <li><a href="/characters" class="button">Sign In</a></li>
                            @else
                                <li class="submenu">
                                    <a href="#" class="">Welcome, {{ session()->get('user')->username }}</a>
                                    <ul>
									<li><a href="/dashboard">Dashboard</a></li>
									<li><a href="/characters">Characters</a></li>
									<li>
										@if (!session()->get('darkmode'))
										<a href="/darkmode">Dark Mode</a>
										@else
										<a href="/darkmode">Light Mode</a>
										@endif
									</li>
                                        <!-- <li><a href="/raids">Raids</a></li> -->
                                        <li><a href="/logout">Log Out</a></li>
                                    </ul>
                                </li>
                            @endif

						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">



				</section>

			<!-- Main -->
				<article id="main">
                <header class="special container">
                    <a href="/dashboard/{{ $server->id }}">
                        <img style="border-radius: 64px;" src="https://cdn.discordapp.com/icons/{{ $server->id }}/{{ $server->icon }}.png" />
                        <h2>{{ $server->name }}</h2>
                    </a>
                </header>
				@yield('content')

			<!-- Footer -->
				<footer id="footer">

					<ul class="copyright">
						<li>&copy; {{ date('Y') }} GoodBot</li>
					</ul>

				</footer>

		</div>

		<!-- Scripts -->
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>

			<!-- JQuery UI -->
			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

			<!-- TableSorter -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
			@yield('scripts')

	</body>
</html>