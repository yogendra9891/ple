<script src='<?php echo $this->webroot;?>js/gab.js'></script>
<script>

  $(document).trigger('connect', {
                    jid: '<?php echo $user ;?>@gajendra-pc',
                    password: '123456'
                });
</script>
    <h1>Gab</h1>
<style>
#friendbox{
display:none;
}
</style>
    <div id='toolbar'>
      <span class='button' id='new-contact'>add contact...</span> ||
      <span class='button' id='new-chat'>chat with...</span> ||
      <span class='button' id='disconnect'>disconnect</span>
    </div>

    <div id='chat-area'>
      <ul></ul>
    </div>
    
    <div id='roster-area'>
      <ul></ul>
    </div>

    

    <!-- contact dialog -->
    <div id='contact_dialog' class='hidden'>
      <label>JID:</label><input type='text' id='contact-jid'>
      <label>Name:</label><input type='text' id='contact-name'>
    </div>

    <!-- chat dialog -->
    <div id='chat_dialog' class='hidden'>
      <label>JID:</label><input type='text' id='chat-jid'>
    </div>

    <!-- approval dialog -->
    <div id='approve_dialog' class='hidden'>
      <p><span id='approve-jid'></span> has requested a subscription
        to your presence.  Approve or deny?</p>
    </div>
    
    <div>
    <input type="button" onclick = "inviteusers()" value="invite"/>
    </div>
    <div id="friendbox">
    <form method="post" action="/ple/users/groupchat">
    <input type="text" name="friend" id="friends"/>
    <input type="submit" value="invite" />
    </div>

