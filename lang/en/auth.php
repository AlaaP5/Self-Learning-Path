<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    "login_success" => "Login successful!",
    "login_error" => "An error occurred during login. Please try again.",
    "invalid_credentials" => "The provided credentials are invalid.",
    "logout_success" => "Logout successful.",
    "logout_error" => "An error occurred during logout. Please try again.",
    "password_change_success" => "Password changed successfully.",
    "password_change_failed" => "Failed to change password. Please try again.",
    "password_change_error" => "An error occurred while changing the password.",

    "_comment" => "Auth-login Validation messages.",
    "username_exists" => "The username does not exist in our records.",
    "username_required" => "The username field is required.",
    "username_must_be_string" => "The username must be a string.",
    "username_max" => "The username must not exceed 255 characters.",
    "password_required" => "The password field is required.",
    "password_must_be_string" => "The password must be a string.",
    "password_min" => "The password must be at least 6 characters.",

    "_comment" => "Auth-change password Validation messages.",
    "current_password_required" => "The current password is required.",
    "current_password_string" => "The current password must be a string.",
    "current_password_invalid" => "The current password is incorrect.",
    "new_password_required" => "The new password is required.",
    "new_password_string" => "The new password must be a string.",
    "new_password_min" => "The new password must be at least 6 characters.",
    "new_password_confirmed" => "The new password confirmation does not match.",


    "_comment" => "Auth-check is admin",
    "admin_check"=>"you are not admin",

];
