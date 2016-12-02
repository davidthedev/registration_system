<?php use App\Core\Config; ?>

<h1>Register</h1>

<?php foreach ($messages as $message) {
    echo $message;
} ?>

<div class="form-style">
    <form method="POST" action="<?php echo Config::get('CURRENT_URL'); ?>">
        <input type="text" name="firstname" class="input-style" placeholder="First Name" value="<?php echo $firstname; ?>" autocomplete="off">
        <input type="text" name="username" class="input-style" placeholder="Username" value="<?php echo $username; ?>" autocomplete="off">
        <input type="text" name="email" class="input-style" placeholder="E-mail" value="<?php echo $email; ?>" autocomplete="off">
        <input type="password" name="password" class="input-style" placeholder="Password">
        <input type="password" name="password-retype" class="input-style" placeholder="Retype password">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <button type="submit" class="btn btn-lg btn-main" name="submit">Sign up</button>
    </form>
</div>
