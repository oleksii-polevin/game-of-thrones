<form action="" id="secondForm" method="post">
    <div class="form">
        <div class="message">
            <p class="message__text">You've successfully joined the game. <br>
                Tell us more about yourself.
            </p>
        </div>
        <label for="name" class="label">
            <h2 class="label__heading">Who are you?<span class='invalid' id="nameErr"></span></h2>
            <p class="label__text" id="nameErr2">Alpha-numeric username</p>
        </label>
        <input type="text" id="name" class="form__input-box" name="name"
        value="<?php
        if(isset($_SESSION['data']['name']))
        echo $_SESSION['data']['name'];
        ?>"
        placeholder="arya">
        <label for="houses" class="form__label">Your Great House
            <span class="invalid" id="houseErr"></span></label>
            <select id="houses" name="house" class="houses">
                <?php
                // default value for houses
                $not_selected = 'Select Your Great House';
                if(isset($_SESSION['data']['house'])) {
                    echo "<option>".$_SESSION['data']['house']."<option>";
                    foreach (IMAGES as $item) {
                        if($item !== $_SESSION['data']['house']) {
                            echo "<option>$item</option>";
                        }
                    }
                    echo "<option>$not_selected</option>";
                } else {
                    echo "<option>$not_selected<option>";
                    foreach(IMAGES as $item) {
                        echo "<option>$item</option>";
                    }
                }
                ?>
            </select>
            <label for="textarea" class="form__label">
                Your preferences, hobbies, wishes, etc.
                <span class='invalid' id="hobbyErr"></span></label>
                <textarea name="hobby" id="textarea" class="form__input-box form__input-box__textarea"
                rows="3" placeholder="I have long TOKILL list..."><?php
                if(isset($_SESSION['data']['hobby']))
                echo $_SESSION['data']['hobby']?></textarea>
                <button id="save" type="submit" class="submit button button__save"
                name="save">Save</button>
            </div>
            <input type="hidden" name="second" value="ok">
        </form>
