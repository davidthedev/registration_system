<?php use App\Core\Config; ?>

<h1>Sign in</h1>

<?php foreach ($messages as $message) {
    echo $message;
} ?>

<div class="form-style">
    <form method="POST" action="<?php echo Config::get('CURRENT_URL'); ?>">
        <input type="text" name="username" class="input-style" placeholder="Username">
        <input type="password" name="password" class="input-style" placeholder="Password">
        <div class="remember-forgot">
            <label for="remember-id">Remember me
                <input type="checkbox" id="remember-id" name="remember-me" class="align-left">
            </label>
            <div class="align-right">
                <a href="<?php echo Config::get('URL') . 'member/forgot'; ?>">Forgotten?</a>
            </div>
            <div class="align-right">
                <a href="<?php echo Config::get('URL') . 'home/register'; ?>">Register</a>
            </div>
        </div>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <button type="submit" class="btn btn-lg btn-main" name="submit">Enter</button>
    </form>
</div>
