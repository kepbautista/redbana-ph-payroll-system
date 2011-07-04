<html>
<head>

<title>Simple Ajax Messaging</title>
    
<script language="javascript" src="<?= base_url() ?>js/jquery.js"></script>
<script language="javascript">
$(document).ready(function() {
    $('#submit').click(function() {

        var msg = $('#message').val();
        
        $.post("<?= site_url('message/add') ?>", {message: msg}, function() {
            $('#content').load("<?= site_url('message/view/ajax') ?>");
            $('#message').val('');
        });
    });
});
</script>
    
</head>
<body>
<h1>Simple Ajax Messaging</h1>
<div id="form">
    <input type="text" id="message" name="message" />
    <input type="submit" id="submit" name="submit" value="submit" />
</div>
<div id="content">
<?php $this->load->view('messages_list') ?>
</div>
</body>
</html>
