<div class="wrapper ">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Bootstrap Sidebar</h3>
        </div>

        <ul class="list-unstyled components sideul">
            <p>Dummy Heading</p>
            <li class="active">
                <a class="sideul" href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
                <ul class="collapse list-unstyled sideul" id="homeSubmenu">
                    <li>
                        <a class="sideul" href="#">Home 1</a>
                    </li>
                    <li>
                        <a class="sideul" href="#">Home 2</a>
                    </li>
                    <li>
                        <a class="sideul" href="#">Home 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="sideul" href="#">About</a>
            </li>
            <li>
                <a class="sideul" href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                <ul class="collapse list-unstyled sideul" id="pageSubmenu">
                    <li>
                        <a href="#">Page 1</a>
                    </li>
                    <li>
                        <a href="#">Page 2</a>
                    </li>
                    <li>
                        <a class="sideul" href="#">Page 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="sideul" href="#">Portfolio</a>
            </li>
            <li>
                <a class="sideul" href="#">Contact</a>
            </li>
        </ul>

    </nav>
    <!-- Page Content -->
    <div class="content" id="content">

    </div>
</div>

<script>

$(document).ready(function () {

    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#sidebarCollapse').on('click', function () {
        // open or close navbar
        $('#sidebar').toggleClass('active');
        // close dropdowns
        $('.collapse.in').toggleClass('in');
        // and also adjust aria-expanded attributes we use for the open/closed arrows
        // in our CSS
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
});
</script>
