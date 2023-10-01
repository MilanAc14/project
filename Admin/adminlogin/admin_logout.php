<?php
session_start();

// JavaScript alert to inform the user about logout and auto-close after 5 seconds
echo '<script>
                        var showAlert = true;
                        setTimeout(function(){
                            if (showAlert) {
                                alert("You have been logout Successfully !");
                                showAlert = false;
                                window.location.href = "admin_login.php"
                            }
                        }, 1000); // 1000 milliseconds = 1 seconds
                      </script>';

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();
exit;
?>
