<script>
$(function() {
    if ($('link[change="true"]')) {
        $('link[change="true"]').removeAttr('href');
    }
    $('head').append($('<link rel="stylesheet" change="true" type="text/css" />').attr('href','/assets/css/<?php echo $page?>.css'));
    $('head').append($('<script/><script>').attr('src','/assets/js/<?php echo $page?>.js'));

})
</script>