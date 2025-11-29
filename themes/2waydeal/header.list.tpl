<!-- BEGIN: HEADER -->
<!DOCTYPE html><!-- header.list.tpl -->
<html lang="{PHP.usr.lang}" data-bs-theme="light">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{HEADER_TITLE}</title>
    <!-- IF {HEADER_META_DESCRIPTION} -->
    <meta name="description" content="{HEADER_META_DESCRIPTION}" />
    <!-- ENDIF -->

	<!-- IF {PHP.out.meta} -->{PHP.out.meta}<!-- ENDIF -->
    <meta http-equiv="content-type" content="{HEADER_META_CONTENTTYPE}; charset=UTF-8" />
<script>
	(function () {
		const storedTheme = localStorage.getItem('theme');
		const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
		const defaultTheme = storedTheme || (prefersDark ? 'dark' : 'light');
		document.documentElement.setAttribute('data-bs-theme', defaultTheme);
	})();
</script>
<script>
  (function() {
    const isDesktop = window.innerWidth >= 992;
    const sidebarState = localStorage.getItem('sidebarState');

    if (isDesktop && sidebarState === 'hidden') {
      document.documentElement.classList.add('sidebar-hidden');
    }
  })();
</script>
<style>
  .sidebar-hidden #sidebar {
    display: none !important;
  }
</style>
    <meta name="generator" content="Cotonti http://www.cotonti.com" />
    <link rel="canonical" href="{HEADER_CANONICAL_URL}" /> 
	{HEADER_BASEHREF} 
	{HEADER_HEAD}
	<link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
  </head>
  <body id="body" class="d-flex flex-column min-vh-100">

	<header class="navbar navbar-expand-lg sticky-top" data-bs-theme="inherit">
	  <div class="container-fluid">
		
		<!-- Кнопка сайдбара -->
		<button class="btn btn-outline-secondary ms-2 btn-toggle-sidebar" onclick="toggleSidebar()">
		  <i class="fa-solid fa-list"></i>
		</button>

		<!-- Логотип -->
		<a class="navbar-brand ms-2 d-none d-md-block" href="{PHP.cfg.mainurl}">
		  {PHP.cfg.maintitle}
		</a>

		<div class="ms-auto d-flex align-items-center gap-2">
		  <!-- BEGIN: GUEST -->
		  <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#guestOffCanvas" aria-controls="guestOffCanvas" title="{PHP.L.Account}">
			<i class="fa-solid fa-user fa-lg"></i>
		  </button>
		  <!-- END: GUEST -->
			
		  
		  <!-- BEGIN: USER -->
		  <!-- IF {PHP|cot_modules('pm')} -->
		  <div class="position-relative d-none d-sm-block">
			<a class="btn" href="{PHP|cot_url('pm')}">
			  <i class="fa-solid fa-envelope-open-text fa-2xl"></i>
			  <span class="position-absolute position-start-75 position-top-20 translate-middle badge badge-pm">{PHP.usr.newpm}</span>
			</a>
		  </div>
		  <!-- ENDIF -->
      <!-- IF {PHP|cot_plugin_active('userimages')} -->
	  <button class="btn p-0 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#profileRightOffcanvas" aria-controls="profileRightOffcanvas" title="Аккаунт"> 
      <!-- IF {PHP.usr.profile.user_avatar} -->
      <img class="rounded-circle me-2 bg-white profile-img" src="{PHP.usr.profile.user_avatar}" alt="{PHP.usr.name}" width="36" height="36" style="object-fit: cover;">
      <!-- ELSE -->
      <img class="rounded-circle me-2 profile-img" src="{PHP.R.userimg_default_avatar}" alt="{PHP.usr.name}" width="36" height="36" style="object-fit: cover;">
      <!-- ENDIF -->
	  </button>
      <!-- ENDIF -->
		  <!-- END: USER -->
		</div>

	  </div>
	</header>
	<!-- IF {PHP.usr.id} > 0 -->
	<!-- Right Offcanvas Menu -->
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/header/profileRightOffcanvas.tpl"}
	<!-- ENDIF -->
    <div class="d-flex">
	  {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/header/sidebarMenuSections.tpl"}
      <!-- Left Offcanvas Menu -->
	  {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/header/infoLeftOffcanvas.tpl"}
	  {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/header/treecatspageLeftOffcanvas.tpl"}
      <main class="main-content container-fluid me-0 p-0">
        <!-- END: HEADER -->