<!--  Dispaly home page when user get login to chat server -->
<?php

?>
<script src='<?php echo $this->webroot;?>js/gab.js'></script>
<script>

  $(document).trigger('connect', {
                    jid: '<?php echo $user ;?>@gajendra-pc',
                    password: '123456'
                });
</script>
<form method ="post" action="<?php echo $this->webroot;?>/users/inviteUsers" />
    <div id='roster-area'>
      <ul></ul>
    </div>
  <div id="invite_button">
 <input type="button" value="invite" onClick=""/>
 </div>
 </form>   