<?php
session_start();
session_destroy();
?>
<script>
    alert("Log out");
    location.replace('/wp_project');
</script>