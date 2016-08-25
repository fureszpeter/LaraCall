<div class="container">
    <h1 class="login_heading" style="text-align: center; width: 100%"><?= lang("login") ?> <span>/ <a href="<?= site_url("register") ?>.html" class="open_register_form"><?= lang("registration") ?></a></span></h1>
    <div style='border: 0 solid black; width: 300px; margin: 0 auto;'>
        <form id="login_form" class="ajax-form-bind" action="<?= site_url("login/doLogin"); ?>" method="post">
            <div class="form-group">
                <label for="login_username"><?= lang("username") ?> / <?= lang("card_number") ?> / <?= lang("email") ?></label>
                <input type="text" name="txt_username" class="form-control input-lg" placeholder="<?= lang("username") ?> / <?= lang("card_number") ?> / <?= lang("email") ?>" id="txt_username">
            </div>
            <div class="form-group">
                <label for="login_password"><?= lang("password") ?></label>
                <input type="password" name="txt_pass" class="form-control input-lg" placeholder="<?= lang("ph_password") ?>" id="txt_pass">
                <span class="help-block"><a href="<?= site_url("forget_pass") ?>"><?= lang("forget_password") ?></a></span>
            </div>
            <div class="submit_section">
                <button class="btn btn-lg btn-success btn-block"><?= lang("login") ?></button>
            </div>
        </form>
    </div>

