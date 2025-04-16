<?php
function sanitize_input($data) {

    // Remove extra spaces, tabs, newlines
    $data = trim($data);

    // Remove backslashes (\)
    $data = stripslashes($data);

    // Remove Tags
    $data = strip_tags($data);

    // Convert special characters to HTML entities
    $data = htmlspecialchars($data);
    return $data;
  }

?>