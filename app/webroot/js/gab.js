window.globalIq = []; // defining the array for preserving the rosters data in chat windows
var Gab = {
    connection: null,

    jid_to_id: function (jid) {
        return Strophe.getBareJidFromJid(jid)
            .replace("@", "-")
            .replace(".", "-");
    },
    on_roster: function (iq) {
    	globalIq = iq;  // assiging the rosters data for chat winodow used.
        $(iq).find('item').each(function () {
        	var groups = new Array();
        	 var jid = $(this).attr('jid');
        	  var name = $(this).attr('name') || jid;
        	  if(name.length > 15) name = name.substring(0,10) + '...';
        	  //get User Name
        	  var chatUser = jid;
        	  var userNameArray = chatUser.split("@");
        	  var userName = userNameArray[0];
              // transform jid into an id
              var jid_id = Gab.jid_to_id(jid);

            var contact = "";
            $(this).find("group").each(function () {
               var group_name = $(this).text();
               
               groups.push($(this).text()); 
             
              var contact = $("<li id='ol_" + jid_id + "' style='display:none;cursor:pointer;clear:both;' onClick=\"openChatWindow('"+userName+"&"+group_name+"');\">" +
                       "<div class='roster-contact offline'>" +
                       "<div class='roster-name'><input id='check_"+jid_id+"' type='image' src = '"+site_url1+"img/online_icon.png' style='display:none;'/>" +
                       name +
                       "<span id='check_online_"+jid_id+"' style='float:right; display:none;'></span></div><div class='roster-jid' style='display:none;'>" +
                       jid +
                       "</div></div><div class='roaster-group' style='display:none;'>"+group_name+"</div><input type='hidden' value='"+groups+"' name='section'/></li>");
               Gab.insert_contact(contact);
              
            });
           
            
        });
        // set up presence handler and send initial presence
        Gab.connection.addHandler(Gab.on_presence, null, "presence");
        Gab.connection.send($pres());
    },

    pending_subscriber: null,

    on_presence: function (presence) {

        var ptype = $(presence).attr('type');
        var from = $(presence).attr('from');
        var jid_id = Gab.jid_to_id(from);

		var usersLists = $('#usenamelist').val(); //define in home.ctp view chats 
		var splited_users = usersLists.split(',');
		var roster_midasid = Strophe.getBareJidFromJid(from);
		var splited_midas_id = roster_midasid.split('@');
		var isFoundResult = $.inArray( splited_midas_id[0], splited_users );
		var getUsers = '';
		if (isFoundResult != -1) {
			getUsers = 'found';
		} else {
			getUsers = 'notfound';
		}

        if (ptype === 'subscribe') {
            // populate pending_subscriber, the approve-jid span, and
            // open the dialog
            Gab.pending_subscriber = from;
            $('#approve-jid').text(Strophe.getBareJidFromJid(from));
            $('#approve_dialog').dialog('open');
        } else if (ptype !== 'error') {
            var contact = $('#roster-area li#' + jid_id + ' .roster-contact')
                .removeClass("online")
                .removeClass("away")
                .removeClass("offline");
            //user get logout from chat server
            if (ptype === 'unavailable') {
            	var getUserStatusResponse = getUserStatusData(Strophe.getBareJidFromJid(from));
            	if (getUserStatusResponse === 'logout') {
        		   contact.addClass("offline");
        		   $('#ol_'+jid_id).hide();
        		   $('#check_online_'+jid_id).hide();
        		   $('#check_'+jid_id).hide();
        	   }
            } else {
                var show = $(presence).find("show").text();
                if (show === "" || show === "chat") {
                	if(getUsers == "found"){
                    contact.addClass("online");
                    $('#ol_'+jid_id).show();
                    $('#check_online_'+jid_id).show();
                    $('#check_'+jid_id).show();
                	}else{
                		contact.addClass("offline");
                		 $('#ol_'+jid_id).hide();
                		 $('#check_online_'+jid_id).hide();
                		$('#check_'+jid_id).hide();
                	}
                	//code start by yogendra
               } else {
                	if(getUsers == "found"){
                    contact.addClass("online");
                    $('#ol_'+jid_id).show();
                    $('#check_online_'+jid_id).show();
                    $('#check_'+jid_id).show();
                	}else{
                		contact.addClass("offline");
                		 $('#ol_'+jid_id).hide();
                		 $('#check_online_'+jid_id).hide();
                		$('#check_'+jid_id).hide();
                	}
                }
                 //By Abhishek
                //show the invite button after the chat user get online
                $('#invite_button').show()
            }

          //  var li = contact.parent();
          //  li.remove();
          // Gab.insert_contact(li);
        }

        // reset addressing for user since their presence changed
        var jid_id = Gab.jid_to_id(from);
        $('#chat-' + jid_id).data('jid', Strophe.getBareJidFromJid(from));

        return true;
    },

    on_roster_changed: function (iq) {
    	
        $(iq).find('item').each(function () {
            var sub = $(this).attr('subscription');
            var jid = $(this).attr('jid');
            var name = $(this).attr('name') || jid;
            var jid_id = Gab.jid_to_id(jid);

            if (sub === 'remove') {
                // contact is being removed
                $('#' + jid_id).remove();
            } else {
                // contact is being added or modified
//                var contact_html = "<li id='" + jid_id + "'>" +
//                    "<div class='" + 
//                    ($('#' + jid_id).attr('class') || "roster-contact offline") +
//                    "'>" +
//                    "<div class='roster-name'><input type='checkbox' value='"+Strophe.getBareJidFromJid(from)+"' name= friends[] />" +
//                    name +
//                    "</div><div class='roster-jid'>" +
//                    jid +
//                    "</div></div></li>";
//
//                if ($('#' + jid_id).length > 0) {
//                    $('#' + jid_id).replaceWith(contact_html);
//                } else {
//                    Gab.insert_contact(contact_html);
//                }
            }
        });

        return true;
    },

    on_message: function (message) {
        var full_jid = $(message).attr('from');
        var jid = Strophe.getBareJidFromJid(full_jid);
        var jid_id = Gab.jid_to_id(jid);

        if ($('#chat-' + jid_id).length === 0) {
            $('#chat-area').tabs('add', '#chat-' + jid_id, jid);
            $('#chat-' + jid_id).append(
                "<div class='chat-messages'></div>" +
                "<input type='text' class='chat-input'>");
        }
        
        $('#chat-' + jid_id).data('jid', full_jid);

        $('#chat-area').tabs('select', '#chat-' + jid_id);
        $('#chat-' + jid_id + ' input').focus();

        var composing = $(message).find('composing');
        if (composing.length > 0) {
            $('#chat-' + jid_id + ' .chat-messages').append(
                "<div class='chat-event'>" +
                Strophe.getNodeFromJid(jid) +
                " is typing...</div>");

            Gab.scroll_chat(jid_id);
        }

        var body = $(message).find("html > body");

        if (body.length === 0) {
            body = $(message).find('body');
            if (body.length > 0) {
                body = body.text()
            } else {
                body = null;
            }
        } else {
            body = body.contents();

            var span = $("<span></span>");
            body.each(function () {
                if (document.importNode) {
                    $(document.importNode(this, true)).appendTo(span);
                } else {
                    // IE workaround
                    span.append(this.xml);
                }
            });

            body = span;
        }

        if (body) {
            // remove notifications since user is now active
            $('#chat-' + jid_id + ' .chat-event').remove();

            // add the new message
            $('#chat-' + jid_id + ' .chat-messages').append(
                "<div class='chat-message'>" +
                "&lt;<span class='chat-name'>" +
                Strophe.getNodeFromJid(jid) +
                "</span>&gt;<span class='chat-text'>" +
                "</span></div>");

            $('#chat-' + jid_id + ' .chat-message:last .chat-text')
                .append(body);

            Gab.scroll_chat(jid_id);
        }

        return true;
    },

    scroll_chat: function (jid_id) {
        var div = $('#chat-' + jid_id + ' .chat-messages').get(0);
        div.scrollTop = div.scrollHeight;
    },


    presence_value: function (elem) {
        if (elem.hasClass('online')) {
            return 2;
        } else if (elem.hasClass('away')) {
            return 1;
        }

        return 0;
    },

    insert_contact: function (elem) {
        var jid = elem.find('.roster-jid').text();
        var gid = elem.find('.roaster-group').text();
        var userType = "Student";
        var inUserSetting = 2;
        //get section type
        var section_type = $('#sectionsettingid').val();
        
        //get user course name
        var courseName = $('#csnameid').val();
        
  	    //get user type
  	    if(jid != "" && gid != ''){
		   //check for setting type
            var lowercase_gid = gid.toLowerCase();
            var userChatNameArray = jid.split("@");
            var loweruserChatNameArray = userChatNameArray[0].toLowerCase();
            
            var section_setting = $('#outersetting-'+lowercase_gid).val();
            if(section_setting) {
              inUserSetting = section_setting;
            }
            
  	  	   //check for userType
           var lowercase_gid = gid.toLowerCase();
           var userChatNameArray = jid.split("@");
           var loweruserChatNameArray = userChatNameArray[0].toLowerCase();
           
           var active_instructor;
           if($('#'+"outer-"+lowercase_gid).val()){
        	   active_instructor = $('#'+"outer-"+lowercase_gid).val();
        	   if ( active_instructor == loweruserChatNameArray) {
                   userType = "Instructor";
              }
           } else{
        	   userType = "Student";
           }
           
  	    }
  	    //remove blank space
  	    var newCourseName = courseName.replace(/\s+/g,"");
        var pres = Gab.presence_value(elem.find('.roster-contact'));
        
        var contacts = $('#roster-area li');
      
      //check for section type in section or all section
        
        if(section_type == 1){
       //Show the user's roaster according to the Course
        
        if(courseName == gid){
        	
        if (contacts.length > 0) {
            var inserted = false;
            contacts.each(function () {
                var cmp_pres = Gab.presence_value(
                    $(this).find('.roster-contact'));
                var cmp_jid = $(this).find('.roster-jid').text();

                if (pres > cmp_pres) {
                    $(this).before(elem);
                    inserted = false;
                    return false;
                } else {
                    if (jid < cmp_jid) {
                        $(this).before(elem);
                        inserted = false;
                        return false;
                    }
                }
            });
           
           
            if (!inserted) {
                var oldid = gid;
               //remove blank space
         		var newid = oldid.replace(/\s+/g,"");
				var newusertype = userType+newid;
				//remove blank space
             	var newusertype1 = newusertype.replace(/\s+/g,"");
            	if (!$('#'+newid).length){
            	$('#roster-area ul ').append('<div id="'+newid+'" class="roster-div"><p>'+gid+'</p></div>');
            	}
				if ($('#'+newid).length){
                	if (!$('#'+newusertype1).length){
                        $('#roster-area #'+newid).append('<div id="'+newusertype1+'"><p>'+userType+'</p></div>');
                   	}
                	}
                $('#'+newid).append(elem);
            }
        } else {
        	var oldid = gid;
        	//remove blank space
     		var newid = oldid.replace(/\s+/g,"");
			var newusertype = userType+newid;
				//remove blank space
             	var newusertype1 = newusertype.replace(/\s+/g,"");
        	if (!$('#'+newid).length){
        	$('#roster-area ul ').append('<div id="'+newid+'" class="roster-div"><p>'+gid+'</p></div>');
        	}
			if ($('#'+newid).length){
                	if (!$('#'+newusertype1).length){
                        $('#roster-area #'+newid).append('<div id="'+newusertype1+'"><p>'+userType+'</p></div>');
                   	}
                	}
        	$('#'+newid).append(elem);
        }
    }
        }
        //check for all section setting for the user for the same course
        //if section setting is all section then it will be added to the chat list
        //if current user section setting and coming roster setting is equal and all section then it will see
        if(inUserSetting==2 && section_type == 2){
        	
        	//get course name 
        	var crse = courseName.split("-");
        	var crse_name = crse[0];
        	//get course name from group id from openfire
        	var crse_gid = gid.split("-");
        	var crse_gid_name = crse_gid[0];
        	if(crse_name == crse_gid_name){
        	
            if (contacts.length > 0) {
                var inserted = false;
                contacts.each(function () {
                    var cmp_pres = Gab.presence_value(
                        $(this).find('.roster-contact'));
                    var cmp_jid = $(this).find('.roster-jid').text();

                    if (pres > cmp_pres) {
                        $(this).before(elem);
                        inserted = false;
                        return false;
                    } else {
                        if (jid < cmp_jid) {
                            $(this).before(elem);
                            inserted = false;
                            return false;
                        }
                    }
                });
               
              
                if (!inserted) {
                    var oldid = gid;
                   //remove blank space
             		var newid = oldid.replace(/\s+/g,"");
             		var newusertype = userType+newid;
             		//remove blank space
             		var newusertype1 = newusertype.replace(/\s+/g,"");
 
                	if (!$('#'+newid).length){
                	$('#roster-area ul ').append('<div id="'+newid+'" class="roster-div"><p>'+gid+'</p></div>');
                	}
                	if ($('#'+newid).length){
                	if (!$('#'+newusertype1).length){
                        $('#roster-area #'+newid).append('<div id="'+newusertype1+'"><p>'+userType+'</p></div>');
                   	}
                	}
                    $('#'+newusertype1).append(elem);
                    //sort the div by id
                    $("#roster-area ul div.roster-div").tsort({attr:"id"});
                }
            } else {
            	var oldid = gid;
            	//remove blank space
         		var newid = oldid.replace(/\s+/g,"");
         		
         		var newusertype = userType+newid;
         		var newusertype1 = newusertype.replace(/\s+/g,"");
         	
            	if (!$('#'+newid).length){
            	
            	$('#roster-area ul ').append('<div id="'+newid+'" class="roster-div"><p>'+gid+'</p></div>');
      
            	}
            	if ($('#'+newid).length){
                	if (!$('#'+newusertype1).length){
                        $('#roster-area #'+newid).append('<div id="'+newusertype1+'"><p>'+userType+'</p></div>');
                   	}
                	}
            	$('#'+newusertype1).append(elem);
            	  //sort the div by id
            	$("#roster-area ul div.roster-div").tsort({attr:"id"});
            }
   }
        }
    }
};

$(document).ready(function () {
   

    $('#contact_dialog').dialog({
        autoOpen: false,
        draggable: false,
        modal: true,
        title: 'Add a Contact',
        buttons: {
            "Add": function () {
                $(document).trigger('contact_added', {
                    jid: $('#contact-jid').val(),
                    name: $('#contact-name').val()
                });

                $('#contact-jid').val('');
                $('#contact-name').val('');
                
                $(this).dialog('close');
            }
        }
    });

    $('#new-contact').click(function (ev) {
        $('#contact_dialog').dialog('open');
    });

    $('#approve_dialog').dialog({
        autoOpen: false,
        draggable: false,
        modal: true,
        title: 'Subscription Request',
        buttons: {
            "Deny": function () {
                Gab.connection.send($pres({
                    to: Gab.pending_subscriber,
                    "type": "unsubscribed"}));
                Gab.pending_subscriber = null;

                $(this).dialog('close');
            },

            "Approve": function () {
                Gab.connection.send($pres({
                    to: Gab.pending_subscriber,
                    "type": "subscribed"}));

                Gab.connection.send($pres({
                    to: Gab.pending_subscriber,
                    "type": "subscribe"}));
                
                Gab.pending_subscriber = null;

                $(this).dialog('close');
            }
        }
    });

    $('#chat-area').tabs().find('.ui-tabs-nav').sortable({axis: 'x'});

    $('.roster-contact').live('click', function () {
        var jid = $(this).find(".roster-jid").text();
       
        var name = $(this).find(".roster-name").text();
        var jid_id = Gab.jid_to_id(jid);
        var chatadmin2 = Strophe.getNodeFromJid(Gab.connection.jid);
        if ($('#chat-' + jid_id).length === 0) {
            $('#chat-area').tabs('add', '#chat-' + jid_id, name);
            $('#chat-' + jid_id).append(
                "<div><a target='_blank' href='"+site_url1+"users/groupchat/"+chatadmin2+"/new'>Start Group Chat</a></div><div class='chat-messages'></div>" +
                "<input type='text' class='chat-input'>");
            $('#chat-' + jid_id).data('jid', jid);
        }
        $('#chat-area').tabs('select', '#chat-' + jid_id);

        $('#chat-' + jid_id + ' input').focus();
    });

    $('.chat-input').live('keypress', function (ev) {
        var jid = $(this).parent().data('jid');

        if (ev.which === 13) {
            ev.preventDefault();

            var body = $(this).val();

            var message = $msg({to: jid,
                                "type": "chat"})
                .c('body').t(body).up()
                .c('active', {xmlns: "http://jabber.org/protocol/chatstates"});
            Gab.connection.send(message);

            $(this).parent().find('.chat-messages').append(
                "<div class='chat-message'>&lt;" +
                "<span class='chat-name me'>" + 
                Strophe.getNodeFromJid(Gab.connection.jid) +
                "</span>&gt;<span class='chat-text'>" +
                body +
                "</span></div>");
            Gab.scroll_chat(Gab.jid_to_id(jid));

            $(this).val('');
            $(this).parent().data('composing', false);
        } else {
            var composing = $(this).parent().data('composing');
            if (!composing) {
                var notify = $msg({to: jid, "type": "chat"})
                    .c('composing', {xmlns: "http://jabber.org/protocol/chatstates"});
                Gab.connection.send(notify);

                $(this).parent().data('composing', true);
            }
        }
    });

    $('#disconnect').click(function () {
        Gab.connection.disconnect();
        Gab.connection = null;
    });
    
    $( window ).unload(function() {
    	Gab.connection.disconnect();
        Gab.connection = null;
  	});

    $('#chat_dialog').dialog({
        autoOpen: false,
        draggable: false,
        modal: true,
        title: 'Start a Chat',
        buttons: {
            "Start": function () {
                var jid = $('#chat-jid').val();
                var jid_id = Gab.jid_to_id(jid);

                $('#chat-area').tabs('add', '#chat-' + jid_id, jid);
                $('#chat-' + jid_id).append(
                    "<div class='chat-messages'></div>" +
                    "<input type='text' class='chat-input'>");
            
                $('#chat-' + jid_id).data('jid', jid);
            
                $('#chat-area').tabs('select', '#chat-' + jid_id);
                $('#chat-' + jid_id + ' input').focus();
            
            
                $('#chat-jid').val('');
                
                $(this).dialog('close');
            }
        }
    });

    $('#new-chat').click(function () {
        $('#chat_dialog').dialog('open');
    });
});

$(document).bind('connect', function (ev, data) {
    var conn = new Strophe.Connection(
        bosh_url);
     conn.connect(data.jid, data.password, function (status) {
         if (status === Strophe.Status.CONNECTED) {
             $(document).trigger('connected');
             var respMsg = "connected";
         } else if (status === Strophe.Status.DISCONNECTED) {
           //  $(document).trigger('disconnected');
             var respMsg = "disconnected";
         	$(document).trigger('connect', {
                 jid: data.jid,
                 password: data.password
             });
         } else if (status === Strophe.Status.ERROR) {
         	var respMsg = "ERROR";
         	$(document).trigger('connect', {
                 jid: data.jid,
                 password: data.password
             });
         } else if (status === Strophe.Status.CONNFAIL) {
         	 var respMsg = "CONNFAIL";
         	$(document).trigger('connect', {
                 jid: data.jid,
                 password: data.password
             });        
         } else if(status === Strophe.Status.CONNECTING) {
         	//var respMsg = "CONNFAIL";
         }
         //create log file using ajax
//         $.ajax({
//                 type : "POST",
//                 url : site_url1 + "chats/generateConnectionLog",
//                 data : {'response': respMsg,'jid':data.jid}
//              }).done(function(msg) {
//                      
//              });
         //changed above 7 lines commented.
       //end of request
            
    });

    Gab.connection = conn;
});

$(document).bind('connected', function () {
    var iq = $iq({type: 'get'}).c('query', {xmlns: 'jabber:iq:roster'});
    Gab.connection.sendIQ(iq, Gab.on_roster);

    Gab.connection.addHandler(Gab.on_roster_changed,
                              "jabber:iq:roster", "iq", "set");

    Gab.connection.addHandler(Gab.on_message,
                              null, "message", "chat");
});

$(document).bind('disconnected', function () {
    Gab.connection = null;
    Gab.pending_subscriber = null;

    $('#roster-area ul').empty();
    $('#chat-area ul').empty();
    $('#chat-area div').remove();

    $('#login_dialog').dialog('open');
});

$(document).bind('contact_added', function (ev, data) {
    var iq = $iq({type: "set"}).c("query", {xmlns: "jabber:iq:roster"})
        .c("item", data);
    Gab.connection.sendIQ(iq);
    
    var subscribe = $pres({to: data.jid, "type": "subscribe"});
    Gab.connection.send(subscribe);
});

function inviteusers(){
	var message = "<message from='abhi@gajendra-pc/desktop' to='daffodil@conference.gajendra-pc'><x xmlns='http://jabber.org/protocol/muc#user'><invite to='jenis@gajendra-pc'><reason>Hey Hecate, this is the place for all good witches!</reason></invite></x></message>";
	  Gab.connection.send(message);
}
