var usernamearay = [];
var Groupie = {
	connection : null,
	room : null,
	nickname : null,
	NS_MUC : "http://jabber.org/protocol/muc#owner",

	joined : null,
	participants : null,
	/* edit by yogendra */
	jid_to_id : function(jid) {
		return Strophe.getBareJidFromJid(jid).replace("@", "-").replace(".",
				"-");
	},
	on_roster : function(iq) {

		$(iq)
				.find('item')
				.each(
						function() {
							var jid = $(this).attr('jid');
							var name = $(this).attr('name') || jid;
							if (name.length > 15)
								name = name.substring(0, 10) + '...';
							// transform jid into an id
							var jid_id = Groupie.jid_to_id(jid);

							var contact = $("<li id='" + jid_id + "'>"
									+ "<div class='roster-contact offline'>"
									+ "<div class='roster-name'>" + name
									+ "</div><div class='roster-jid'>" + jid
									+ "</div></div></li>");
							/*
							 * code edit by yogendra for rosters group by
							 */
							var nickname1 = jid_id.split('-');
							usernamearay.push({
								key : nickname1[0],
								value : name
							});
							var contact_new = "";
							var groups = new Array();
							$(this)
									.find("group")
									.each(
											function() {
												var group_name = $(this).text();
												var username_new = jid_id
														.split('-');
												groups.push($(this).text());

												// get User Name
												var chatUser = jid;
												var userNameArray = chatUser
														.split("@");
												var userName = userNameArray[0];

												var contact_new = $("<li style='display:none;' id='"
														+ username_new[0]
														+ "' >"
														+ "<div class='roster-contact offline'>"
														+ "<div class='roster-name'><input id='check_"
														+ jid_id
														+ "' type='checkbox' value='"
														+ userName
														+ '@'
														+ group_name
														+ "' name= invite_friends[] /> "
														+ name
														+ "</div><div class='roster-jid' style='display:none;'>"
														+ jid
														+ "</div></div><div class='roaster-group' style='display:none;'>"
														+ group_name
														+ "</div><input type='hidden' value='"
														+ groups
														+ "' name='section'/></li>");
												// function for adding the
												// rosters group by in the chat
												// list
												// location:groupchat.js
												send_rosters_bygroup(
														contact_new,
														Groupie.room);
											});
							/*
							 * code end for rosters group by
							 */
							Groupie.insert_contact(contact);
							//changed above one line
						});

		// set up presence handler and send initial presence
		Groupie.connection.addHandler(Groupie.on_presence_roster, null,
				"presence");
		Groupie.connection.send($pres());
	},
	on_roster_changed : function(iq) {
		$(iq)
				.find('item')
				.each(
						function() {
							var sub = $(this).attr('subscription');
							var jid = $(this).attr('jid');
							var name = $(this).attr('name') || jid;
							var jid_id = Groupie.jid_to_id(jid);

							if (sub === 'remove') {
								// contact is being removed
								$('#' + jid_id).remove();
							} else {
								// contact is being added or modified
								var contact_html = "<li id='"
										+ jid_id
										+ "'>"
										+ "<div class='"
										+ ($('#' + jid_id).attr('class') || "roster-contact offline")
										+ "'>" + "<div class='roster-name'>"
										+ name
										+ "</div><div class='roster-jid'>"
										+ jid + "</div></div></li>";

								if ($('#' + jid_id).length > 0) {
									$('#' + jid_id).replaceWith(contact_html);
								} else {
									Groupie.insert_contact(contact_html);
								}
							}
						});

		return true;
	},
	on_presence_roster : function(presence) {
		var ptype = $(presence).attr('type');
		var from = $(presence).attr('from');
		var jid_id = Groupie.jid_to_id(from);
		if (ptype === 'subscribe') {
			// populate pending_subscriber, the approve-jid span, and
			// open the dialog
			Groupie.pending_subscriber = from;
			$('#approve-jid').text(Strophe.getBareJidFromJid(from));
			$('#approve_dialog').dialog('open');
		} else if (ptype !== 'error') {
			var contact = $('#roster-area li#' + jid_id + ' .roster-contact')
					.removeClass("online").removeClass("away").removeClass(
							"offline");
			if (ptype === 'unavailable') {
				contact.addClass("offline");
				var rosters_jid = Strophe.getBareJidFromJid(from);
				var n = rosters_jid.split('@');
				var user_jname = n[0];
				$('#roster-area-group li#' + user_jname + ' .roster-contact')
						.removeClass('online').addClass("offline");
				$('#roster-area-group li#' + user_jname).hide();
			} else {
				var show = $(presence).find("show").text();
				if (show === "" || show === "chat") {
					contact.addClass("online");
					// code optimization for above commented lines
					var usersLists = $('#usenamelist', window.parent.document).val(); //define in home.ctp view chats 
					var splited_users = usersLists.split(',');
					var roster_midasid = Strophe.getBareJidFromJid(from);
					var splited_midas_id = roster_midasid.split('@');
					var isFoundResult = $.inArray( splited_midas_id[0], splited_users );
					var getUserscheck = '';
					if (isFoundResult != -1) {
						getUserscheck = 'found';
					} else {
						getUserscheck = 'notfound';
					}
					// locatin: js/groupchat.js
					if (getUserscheck == 'found') {
						send_online_rosters_bygroup(Strophe
								.getBareJidFromJid(from), Groupie.room);
						//changed above 2 lines commented.
					} else {
						var rosters_jid = Strophe.getBareJidFromJid(from);
						var n = rosters_jid.split('@');
						var user_jname = n[0];
						$(
								'#roster-area-group li#' + user_jname
										+ ' .roster-contact').removeClass(
								'online').addClass("offline");
						$('#roster-area-group li#' + user_jname).hide();
					}
					contact.html("<input type='checkbox' value='"
							+ Strophe.getBareJidFromJid(from)
							+ "' name= friends[] />"
							+ Strophe.getBareJidFromJid(from));
				} else {
					contact.addClass("online");
					// code optimization for above commented lines
					var usersLists = $('#usenamelist', window.parent.document).val(); //define in home.ctp view chats 
					var splited_users = usersLists.split(',');
					var roster_midasid = Strophe.getBareJidFromJid(from);
					var splited_midas_id = roster_midasid.split('@');
					var isFoundResult = $.inArray( splited_midas_id[0], splited_users );
					var getUserscheck = '';
					if (isFoundResult != -1) {
						getUserscheck = 'found';
					} else {
						getUserscheck = 'notfound';
					}
					// locatin: js/groupchat.js
					if (getUserscheck == 'found') {
						send_online_rosters_bygroup(Strophe
								.getBareJidFromJid(from), Groupie.room);
					} else {
						var rosters_jid = Strophe.getBareJidFromJid(from);
						var n = rosters_jid.split('@');
						var user_jname = n[0];
						$(
								'#roster-area-group li#' + user_jname
										+ ' .roster-contact').removeClass(
								'online').addClass("offline");
						$('#roster-area-group li#' + user_jname).hide();
					}
				}
			}

			var li = contact.parent();
			li.remove();
			Groupie.insert_contact(li);
		}

		// reset addressing for user since their presence changed
		var jid_id = Groupie.jid_to_id(from);
		$('#chat-' + jid_id).data('jid', Strophe.getBareJidFromJid(from));

		return true;
	},
	presence_value : function(elem) {
		if (elem.hasClass('online')) {
			return 2;
		} else if (elem.hasClass('away')) {
			return 1;
		}

		return 0;
	},

	insert_contact : function(elem) {
		var jid = elem.find('.roster-jid').text();
		var pres = Groupie.presence_value(elem.find('.roster-contact'));

		var contacts = $('#roster-area li');

		if (contacts.length > 0) {
			var inserted = false;
			contacts.each(function() {
				var cmp_pres = Groupie.presence_value($(this).find(
						'.roster-contact'));
				var cmp_jid = $(this).find('.roster-jid').text();

				if (pres > cmp_pres) {
					$(this).before(elem);
					inserted = true;
					return false;
				} else {
					if (jid < cmp_jid) {
						$(this).before(elem);
						inserted = true;
						return false;
					}
				}
			});

			if (!inserted) {
				$('#roster-area ul').append(elem);
			}
		} else {
			$('#roster-area ul').append(elem);
		}
	},
	/* edit by yogendra */
	on_presence : function(presence) {
		var from = $(presence).attr('from');
		var room = Strophe.getBareJidFromJid(from);
		// make sure this presence is for the right room
		if (room === Groupie.room) {
			var nick = Strophe.getResourceFromJid(from);

			if ($(presence).attr('type') === 'error' && !Groupie.joined) {
				// error joining room; reset app
				Groupie.connection.disconnect();
			} else if (!Groupie.participants[nick]
					&& $(presence).attr('type') !== 'unavailable') {
				// add to participant list
				var user_jid = $(presence).find('item').attr('jid');
				Groupie.participants[nick] = user_jid || true;

				// function for removing the current user from the online list
				// which are inivited further..
				remove_roster(user_jid, nick);
				var orname = '';
				for ( var i = 0; i < usernamearay.length; i++) {
					if ((usernamearay[i].key) == nick) {
						orname = usernamearay[i].value;
						break;
					} else
						orname = nick;
				}
				if (orname == '')
					orname = nick;
				if (nick == Groupie.nickname) {
					orname = current_username //current_username is defined in chatwindow.ctp layout..
				}
				if ( $('#participant-'+ nick).length) {
					$('#participant-'+ nick).remove();
				}
				$('#participant-list').append(
						'<li id="participant-' + nick + '"><img src="'
								+ site_url1
								+ 'img/online_icon.png" />&nbsp;&nbsp;'
								+ orname + '</li>');

				if (Groupie.joined) {
					$(document).trigger('user_joined', nick);
				}
			} else if (Groupie.participants[nick]
					&& $(presence).attr('type') === 'unavailable') {
				// remove from participants list
				$('#participant-list li').each(function() {
					if (nick === $(this).text()) {
						$(this).remove();
						return false;
					}
				});

				$(document).trigger('user_left', nick);
			}

			if ($(presence).attr('type') !== 'error' && !Groupie.joined) {
				// check for status 110 to see if it's our own presence
				if ($(presence).find("status[code='110']").length > 0) {
					// check if server changed our nick
					if ($(presence).find("status[code='210']").length > 0) {
						Groupie.nickname = Strophe.getResourceFromJid(from);
					}
					// room join complete
					$(document).trigger("room_joined");
				}
			}
		}

		return true;
	},

	on_public_message : function(message) {
		var from = $(message).attr('from');
		var room = Strophe.getBareJidFromJid(from);
		var nick = Strophe.getResourceFromJid(from);

		// make sure message is from the right place

		if (room === Groupie.room) {
			// is message from a user or the room itself?
			var notice = !nick;

			// messages from ourself will be styled differently
			var nick_class = "nick";
			if (nick === Groupie.nickname) {
				nick_class += " self";
			}

			var body = $(message).children('body').text();

			// get current time
			var chattime = getCtime();

			var delayed = $(message).children("delay").length > 0
					|| $(message).children("x[xmlns='jabber:x:delay']").length > 0;

			// look for room topic change
			var subject = $(message).children('subject').text();
			if (subject) {
				$('#room-topic').text(subject);
			}

			if (!notice) {
				var delay_css = delayed ? " delayed" : "";

				var action = body.match(/\/me (.*)$/);
				if (!action) {
					if (nick == cuser) {
						nick = "me";
					}else{
						for ( var i = 0; i < usernamearay.length; i++) {
							//alert('Key is : '+usernamearay[i].key);
							if ((usernamearay[i].key) == nick) { //showing the username from the nick name.
								nick = usernamearay[i].value;
								break;
							} else
								nick = nick;
						}
					}
					if (body != "") {
					    $('.oldmsg').hide();
						Groupie.add_message("<div class='message" + delay_css
								+ "'>" + "<span class='" + nick_class + "'>"
								+ nick + "</span>:&nbsp; <span class='body'>"
								+ body + chattime + "</span></div>");
					}
				} else {
					Groupie.add_message("<div class='message action "
							+ delay_css + "'>" + "* " + nick + " " + action[1]
							+ "</div>");
				}
			} else {
			    $('.estcon').hide();
			    $('.waitcon').hide(); //remove waiting connection msg
				var body1 = "Connected";
				Groupie.add_message("<div class='notice estcon'>*** " + body1
						+ "</div>");
			}
		}

		return true;
	},

	add_message : function(msg) {
		// detect if we are scrolled all the way down
		var chat = $('#chat').get(0);
		var at_bottom = chat.scrollTop >= chat.scrollHeight - chat.clientHeight;

		$('#chat').append(msg);

		// if we were at the bottom, keep us at the bottom
		if (at_bottom) {
			chat.scrollTop = chat.scrollHeight;
		}
		// set div scroll at bottom
		var objDiv = document.getElementById("chat");
		objDiv.scrollTop = objDiv.scrollHeight;
		// check for the new chat is coming and window is minimized
		// explode the chat room name
		var room_named = Groupie.room;
		var chat_room = room_named.split('@');
		if ($('#chatwindowMax' + chat_room[0] + ' .mxchat',
				window.parent.document).is(':visible')) {
			if ($('#chatwindowMax' + chat_room[0] + ' .mxchat',
					window.parent.document).hasClass('unread_chat')) {

			} else {
				$('#chatwindowMax' + chat_room[0] + ' .mxchat',
						window.parent.document).addClass('unread_chat');
			}
		} else {

		}
		// check end for the new chat is coming and window is minimized
	},

	on_private_message : function(message) {
		var from = $(message).attr('from');
		var room = Strophe.getBareJidFromJid(from);
		var nick = Strophe.getResourceFromJid(from);

		// make sure this message is from the correct room
		if (room === Groupie.room) {
			var body = $(message).children('body').text();
			Groupie.add_message("<div class='message private'>"
					+ "@@ &lt;<span class='nick'>" + nick
					+ "</span>&gt; <span class='body'>" + body
					+ "</span> @@</div>");

		}

		return true;
	}
};

$(document)
		.ready(
				function() {

					$('#leave').click(function() {
						$('#leave').attr('disabled', 'disabled');
						Groupie.connection.send($pres({
							to : Groupie.room + "/" + Groupie.nickname,
							type : "unavailable"
						}));
						Groupie.connection.disconnect();
					});

					$('#input')
							.keypress(
									function(ev) {

										if (ev.which === 13) {
											ev.preventDefault();

											var body = $(this).val();

											var body = replaceImage(body);
											// set div scroll at bottom
											var objDiv = document
													.getElementById("chat");
											objDiv.scrollTop = objDiv.scrollHeight;
											var match = body
													.match(/^\/(.*?)(?: (.*))?$/);
											var args = null;
											if (match) {
												if (match[1] === "msg") {
													args = match[2]
															.match(/^(.*?) (.*)$/);
													if (Groupie.participants[args[1]]) {
														Groupie.connection
																.send($msg(
																		{
																			to : Groupie.room
																					+ "/"
																					+ args[1],
																			type : "chat"
																		})
																		.c(
																				'body')
																		.t(body));
														Groupie
																.add_message("<div class='message private'>"
																		+ "@@ &lt;<span class='nick self'>"
																		+ Groupie.nickname
																		+ "</span>&gt; <span class='body'>"
																		+ args[2]
																		+ "</span> @@</div>");
													} else {
														Groupie
																.add_message("<div class='notice error'>"
																		+ "Error: User not in room."
																		+ "</div>");
													}
												} else if (match[1] === "me"
														|| match[1] === "action") {
													Groupie.connection
															.send($msg(
																	{
																		to : Groupie.room,
																		type : "groupchat"
																	})
																	.c('body')
																	.t(
																			'/me '
																					+ match[2]));
												} else if (match[1] === "topic") {
													Groupie.connection
															.send($msg(
																	{
																		to : Groupie.room,
																		type : "groupchat"
																	})
																	.c(
																			'subject')
																	.text(
																			match[2]));
												} else if (match[1] === "kick") {
													Groupie.connection
															.sendIQ($iq(
																	{
																		to : Groupie.room,
																		type : "set"
																	})
																	.c(
																			'query',
																			{
																				xmlns : Groupie.NS_MUC
																						+ "#admin"
																			})
																	.c(
																			'item',
																			{
																				nick : match[2],
																				role : "none"
																			}));
												} else if (match[1] === "ban") {
													Groupie.connection
															.sendIQ($iq(
																	{
																		to : Groupie.room,
																		type : "set"
																	})
																	.c(
																			'query',
																			{
																				xmlns : Groupie.NS_MUC
																						+ "#admin"
																			})
																	.c(
																			'item',
																			{
																				jid : Groupie.participants[match[2]],
																				affiliation : "outcast"
																			}));
												} else if (match[1] === "op") {
													Groupie.connection
															.sendIQ($iq(
																	{
																		to : Groupie.room,
																		type : "set"
																	})
																	.c(
																			'query',
																			{
																				xmlns : Groupie.NS_MUC
																						+ "#admin"
																			})
																	.c(
																			'item',
																			{
																				jid : Groupie.participants[match[2]],
																				affiliation : "admin"
																			}));
												} else if (match[1] === "deop") {
													Groupie.connection
															.sendIQ($iq(
																	{
																		to : Groupie.room,
																		type : "set"
																	})
																	.c(
																			'query',
																			{
																				xmlns : Groupie.NS_MUC
																						+ "#admin"
																			})
																	.c(
																			'item',
																			{
																				jid : Groupie.participants[match[2]],
																				affiliation : "none"
																			}));
												} else {
													Groupie
															.add_message("<div class='notice error'>"
																	+ "Error: Command not recognized."
																	+ "</div>");
												}
											} else {
											// messages from ourself will be styled differently
											       
					                               var chattime = getCtime();
												   
													if (Groupie.nickname == cuser) {
														nick = "Me";
													}
													Groupie.add_message("<div class='oldmsg' class='message" 
															+ "'>" + "<span class='nick self'>"
															+ nick + "</span>:&nbsp; <span class='body'>"
															+ body + chattime + "</span></div>");
												
												Groupie.connection.send($msg({
													to : Groupie.room,
													type : "groupchat"
												}).c('body').t(body));
												
												
											}

											$(this).val('');
										}
									}).delay(1000);
					

				});

$(document).bind('connect', function(ev, data) {
	Groupie.connection = new Strophe.Connection(bosh_url);

	Groupie.connection.connect(data.jid, data.password, function(status) {
	//$('.estcon').hide();
	    $('.waitcon').hide();
		Groupie.add_message("<div class='notice waitcon'>*** " + 'connecting...'
				+ "</div>");
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
//        $.ajax({
//                type : "POST",
//                url : site_url1 + "chats/generateGroupConnectionLog",
//                data : {'response': respMsg,'jid':data.jid}
//             }).done(function(msg) {
//                     
//             });
		//changed above 7 lines commmented
	});

});

$(document).bind(
		'connected',
		function() {
			
			Groupie.joined = false;
			Groupie.participants = {};

			// Groupie.connection.send($pres().c('priority').t('-1'));

			Groupie.connection
					.addHandler(Groupie.on_presence, null, "presence");
			Groupie.connection.addHandler(Groupie.on_public_message, null,
					"message", "groupchat");
			Groupie.connection.addHandler(Groupie.on_private_message, null,
					"message", "chat");

			Groupie.connection.send($pres({
				to : Groupie.room + "/" + Groupie.nickname
			}).c('x', {
				xmlns : Groupie.NS_MUC
			}));

			var iq = $iq({
				type : 'get'
			}).c('query', {
				xmlns : 'jabber:iq:roster'
			});
       	    //Groupie.connection.sendIQ(iq, Groupie.on_roster);
			//getting the iq from parent window (xml format), above line commented.
			Groupie.on_roster(top.globalIq); //getting rosters data for showing the available users for furhter invitation, define in gab js.
			Groupie.connection.addHandler(Groupie.on_roster_changed,
					"jabber:iq:roster", "iq", "set");
			top.isOpenChat = 0; //set the variable to 0 for further chat window.
		});

$(document).bind('disconnected', function() {
	Groupie.connection = null;
	$('#room-name').empty();
	$('#room-topic').empty();
	$('#participant-list').empty();
	$('#chat').empty();
	$('#login_dialog').dialog('open');
});

$(document).bind('room_joined', function() {
	Groupie.joined = true;

	$('#leave').removeAttr('disabled');
	$('#room-name').text(Groupie.room);

	Groupie.add_message("<div class='notice'>*** Room joined.</div>")
});

$(document).bind('user_joined', function(ev, nick) {
	Groupie.add_message("<div class='notice'>*** " + nick + " joined.</div>");
});

$(document).bind('user_left', function(ev, nick) {
	Groupie.add_message("<div class='notice'>*** " + nick + " left.</div>");
});

/**
 * function for pausing the connection
 */
function pause()
{
 Groupie.connection.pause();
}

/**
 * function for resume the connection
 */
function resume()
{
 Groupie.connection.resume();
}

/**
 * get current time
 */
 function getCtime()
 {
 // get current time
			var currentTime = new Date();
			var hours = currentTime.getHours();
			var minutes = currentTime.getMinutes();
			var seconds = currentTime.getSeconds();
			var day = currentTime.getDay();
			var dayName;
			switch (day) {
			case 1:
				dayName = "Monday";
				break;
			case 2:
				dayName = "Tuesday";
				break;
			case 3:
				dayName = "Wednesday";
				break;
			case 4:
				dayName = "Thursday";
				break;
			case 5:
				dayName = "Friday";
				break;
			case 6:
				dayName = "Saturday";
				break;
			case 7:
				dayName = "Sunday";
				break;
			default:
				dayName = "error";
			}
			if (minutes < 10)
				minutes = "0" + minutes

			var suffix = "AM";
			if (hours >= 12) {
				suffix = "PM";
				hours = hours - 12;
			}
			if (hours == 0) {
				hours = 12;
			}
			// end of get current time

			var chattime = "<div class='chatdate'>Sent at " + hours + ":"
					+ minutes + ":" + seconds + ":" + suffix + " on " + dayName
					+ "</div>";
			return chattime;
 }