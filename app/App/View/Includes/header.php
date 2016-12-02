<?php use App\Core\Config; ?>

<!DOCTYPE html>
<head>
    <title>Index Page</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Config::get('URL') . 'css/style.css?v=' . time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Config::get('URL') . 'css/font-awesome-4.6.3/css/font-awesome.min.css'; ?>"/>
    <meta name="viewport" content="width=device-width initial-scale=1.0">
</head>
<body>
    <div class="site-wrap">
        <header>
            <nav class="top-nav">
                <div class="container cf">
                    <div class="top-logo">LOGO</div>
                    <div class=""><?php echo $logInMenu; ?></div>
                </div>
            </nav>
            <nav>
                <div class="container cf">
                    <ul>
                        <li><a href="<?php echo Config::get('URL'); ?>">Sign in</a></li>
                        <li><a href="<?php echo Config::get('URL') . 'about'; ?>">About</a></li>
                        <li><a href="<?php echo Config::get('URL') . 'contact'; ?>">Contact</a></li>
                        <?php echo $memberArea; ?>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="body">
            <div class="container cf">
                <div class="main">

