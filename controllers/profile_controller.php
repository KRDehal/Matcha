<?php

    class ProfileController {

        public function show() {
            if (isset($_SESSION["logged_on_user"]) && $_SESSION["logged_on_user"] != "") {

                require_once('views/pages/profile.php');
            } else {
                header("Location: index.php");
            }
        }

    }

?>