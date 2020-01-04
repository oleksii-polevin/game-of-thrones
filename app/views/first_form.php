<form class="form" method="post" action="" id="firstForm">
    <div class="form">
        <label for="mail" class="form__label">Enter your email
            <span class="invalid" id="err_email"></span></label>
            <input type="email" class="form__input-box" id="mail"
            name="email" placeholder="example@gmail.com"
            value="<?php if(isset($_SESSION['user'])) echo $_SESSION['user'];?>">
            <label for="password" class="form__label">
                <h4 class="password__heading">Choose secure password
                    <span class="invalid" id="err_password"></span></h4>
                    <p class="password__text">Must be at least 8 characters</p>
                </label>
                <input type="password" class="form__input-box form__password"
                id="password" name="password" minlength="4"
                placeholder="enter your password">
                <input type="checkbox" id="checkbox" name="remember">
                <label for="checkbox" class="form__label form--checkbox-custom">
                    Remember me
                </label>
                <input type="hidden" name="signUp">
                <button type="submit" class="submit button"
                id="signUp">Sign Up</button>
            </div>
        </form>
