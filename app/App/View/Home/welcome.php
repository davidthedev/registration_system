<?php use App\Core\Config; ?>

<h1>Member Area</h1>
<h2><?php echo $message; ?></h2>
<?php foreach ($messages as $message) {
    echo $message;
} ?>

<ul>
    <li>
        <a href="<?php echo Config::get('URL') . 'home/update'; ?>">
            <i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i>&nbsp; Update details
        </a>
    </li>
    <li>
        <a href="<?php echo Config::get('URL') . 'home/password'; ?>">
            <i class="fa fa-archive fa-fw" aria-hidden="true"></i>&nbsp; Update password
        </a>
    </li>
    <li>
        <a href="<?php echo Config::get('URL') . 'home/logout'; ?>">
            <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>&nbsp; Sign out
        </a>
    </li>
</ul>
