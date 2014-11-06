<!DOCTYPE html>
<html lang="en-gb" dir="ltr" class="uk-height-1-1">
<head>
<title>@section('title')代码发布系统@show</title>
<link rel="stylesheet" href="/uikit/css/uikit.gradient.min.css" />
</head>
    <body>
        <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
            <nav class="uk-navbar uk-margin-large-bottom">
                <a class="uk-navbar-brand uk-hidden-small" href="layouts_frontpage.html">Brand</a>
                <ul class="uk-navbar-nav uk-hidden-small">
                    <li>
                        <a href="layouts_frontpage.html">Frontpage</a>
                    </li>
                    <li>
                        <a href="layouts_portfolio.html">Portfolio</a>
                    </li>
                    <li class="uk-active">
                        <a href="layouts_blog.html">Blog</a>
                    </li>
                    <li>
                        <a href="layouts_documentation.html">Documentation</a>
                    </li>
                    <li>
                        <a href="layouts_contact.html">Contact</a>
                    </li>
                    <li>
                        <a href="layouts_login.html">Login</a>
                    </li>
                </ul>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small">Brand</div>
            </nav>
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-5">
                @section('sidebar')
                    @include('sidebar', array('currpage'=>'index'))
                @show
                </div>
                <div class="uk-width-medium-4-5">
                @section('content')
                @show
                </div>
            </div>
    </div>
<script type="text/javascript" src="//lib.sinaapp.com/js/jquery/2.0.2/jquery-2.0.2.min.js"></script>
<script type="text/javascript" src="/uikit/js/uikit.min.js"></script>
        @section('js')@show
    </body>
</html>