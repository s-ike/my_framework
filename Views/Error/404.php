<?php
namespace FW\Views;

use FW\Helper\SampleHelper as BH;

extract($data);

header('Content-Type: text/html; charset=utf-8');
$template->head()->showHtml();
?>

<body class="normal">

<!-- Navigation -->
<?php
$template->header()->showHtml();
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">404
    <small>Page Not Found</small>
    </h1>

    <?=BH::createBreadcrumb("404")?>

    <div class="jumbotron">
        <h1 class="display-1">404</h1>
        <p>Not found: <?=$requested_uri?></p>
        <p>お探しのページが見つかりませんでした。</p>

        <h2>Portfolio</h2>
        <ul>
            <li>
                <a href="/">Portfolio Top</a>
            </li>
        </ul>
    </div>
    <!-- /.jumbotron -->

</div>
<!-- /.container -->

<!-- Footer -->
<?php
$template->footer()->showHtml();
$template->footerscripts()->showHtml();
?>

</body>

</html>
