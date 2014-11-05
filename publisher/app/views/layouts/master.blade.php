<html>
    <body>
    	<h1>here is the layout title</h1>
        @section('sidebar')
            This is the master sidebar.
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>