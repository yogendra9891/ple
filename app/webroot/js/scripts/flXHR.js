/*	flXHR 1.0.4 <http://flxhr.flensed.com/> | Copyright (c) 2008 Kyle Simpson, Getify Solutions, Inc. | This software is released under the MIT License <http://www.opensource.org/licenses/mit-license.php> */
(function(c) {
	var E = c, h = c.document, z = "undefined", a = true, L = false, g = "", o = "object", k = "function", N = "string", l = "div", e = "onunload", H = null, y = null, K = null, q = null, x = 0, i = [], m = null, r = null, G = "flXHR.js", n = "flensed.js", P = "flXHR.vbs", j = "checkplayer.js", A = "flXHR.swf", u = c.parseInt, w = c.setTimeout, f = c.clearTimeout, s = c.setInterval, v = c.clearInterval, O = "instanceId", J = "readyState", D = "onreadystatechange", M = "ontimeout", C = "onerror", d = "binaryResponseBody", F = "xmlResponseText", I = "loadPolicyURL", b = "noCacheHeader", p = "sendTimeout", B = "appendToId", t = "swfIdPrefix";
	if (typeof c.flensed === z) {
		c.flensed = {}
	}
	if (typeof c.flensed.flXHR !== z) {
		return
	}
	y = c.flensed;
	w(function() {
		var Q = L, ab = h.getElementsByTagName("script"), V = ab.length;
		try {
			y.base_path.toLowerCase();
			Q = a
		} catch (T) {
			y.base_path = g
		}
		function Z(ai, ah, aj) {
			for ( var ag = 0; ag < V; ag++) {
				if (typeof ab[ag].src !== z) {
					if (ab[ag].src.indexOf(ai) >= 0) {
						break
					}
				}
			}
			var af = h.createElement("script");
			af.setAttribute("src", y.base_path + ai);
			if (typeof ah !== z) {
				af.setAttribute("type", ah)
			}
			if (typeof aj !== z) {
				af.setAttribute("language", aj)
			}
			h.getElementsByTagName("head")[0].appendChild(af)
		}
		if ((typeof ab !== z) && (ab !== null)) {
			if (!Q) {
				var ac = 0;
				for ( var U = 0; U < V; U++) {
					if (typeof ab[U].src !== z) {
						if (((ac = ab[U].src.indexOf(n)) >= 0)
								|| ((ac = ab[U].src.indexOf(G)) >= 0)) {
							y.base_path = ab[U].src.substr(0, ac);
							break
						}
					}
				}
			}
		}
		try {
			y.checkplayer.module_ready()
		} catch (aa) {
			Z(j, "text/javascript")
		}
		var ad = null;
		(function ae() {
			try {
				y.ua.pv.join(".")
			} catch (af) {
				ad = w(arguments.callee, 25);
				return
			}
			if (y.ua.win && y.ua.ie) {
				Z(P, "text/vbscript", "vbscript")
			}
			y.binaryToString = function(aj, ai) {
				ai = (((y.ua.win && y.ua.ie) && typeof ai !== z) ? (!(!ai))
						: !(y.ua.win && y.ua.ie));
				if (!ai) {
					try {
						return flXHR_vb_BinaryToString(aj)
					} catch (al) {
					}
				}
				var am = g, ah = [];
				try {
					for ( var ak = 0; ak < aj.length; ak++) {
						ah[ah.length] = String.fromCharCode(aj[ak])
					}
					am = ah.join(g)
				} catch (ag) {
				}
				return am
			};
			y.bindEvent(E, e, function() {
				try {
					c.flensed.unbindEvent(E, e, arguments.callee);
					for ( var ai in r) {
						if (r[ai] !== Object.prototype[ai]) {
							try {
								r[ai] = null
							} catch (ah) {
							}
						}
					}
					y.flXHR = null;
					r = null;
					y = null;
					q = null;
					K = null
				} catch (ag) {
				}
			})
		})();
		function Y() {
			f(ad);
			try {
				E.detachEvent(e, Y)
			} catch (af) {
			}
		}
		if (ad !== null) {
			try {
				E.attachEvent(e, Y)
			} catch (X) {
			}
		}
		var S = null;
		function R() {
			f(S);
			try {
				E.detachEvent(e, R)
			} catch (af) {
			}
		}
		try {
			E.attachEvent(e, R)
		} catch (W) {
		}
		S = w(function() {
			R();
			try {
				y.checkplayer.module_ready()
			} catch (af) {
				throw new c.Error("flXHR dependencies failed to load.")
			}
		}, 20000)
	}, 0);
	y.flXHR = function(aQ) {
		var ab = L;
		if (aQ !== null && typeof aQ === o) {
			if (typeof aQ.instancePooling !== z) {
				ab = !(!aQ.instancePooling);
				if (ab) {
					var aF = function() {
						for ( var aZ = 0; aZ < i.length; aZ++) {
							var a0 = i[aZ];
							if (a0[J] === 4) {
								a0.Reset();
								a0.Configure(aQ);
								return a0
							}
						}
						return null
					}();
					if (aF !== null) {
						return aF
					}
				}
			}
		}
		var aV = ++x, ai = [], af = null, ah = null, X = null, Y = null, aL = -1, aa = null, ac = null, ao = null, aE = null, aw = null, aU = null, ak = null, Q = null, aK = null, Z = a, aB = L, aX = "flXHR_"
				+ aV, au = a, aC = L, aA = a, aI = L, S = "flXHR_swf", ae = "flXHRhideSwf", V = null, aG = -1, T = g, aJ = null, aD = null, aN = null;
		var U = function() {
			if (typeof aQ === o && aQ !== null) {
				if ((typeof aQ[O] !== z) && (aQ[O] !== null) && (aQ[O] !== g)) {
					aX = aQ[O]
				}
				if ((typeof aQ[t] !== z) && (aQ[t] !== null) && (aQ[t] !== g)) {
					S = aQ[t]
				}
				if ((typeof aQ[B] !== z) && (aQ[B] !== null) && (aQ[B] !== g)) {
					V = aQ[B]
				}
				if ((typeof aQ[I] !== z) && (aQ[I] !== null) && (aQ[I] !== g)) {
					T = aQ[I]
				}
				if (typeof aQ[b] !== z) {
					au = !(!aQ[b])
				}
				if (typeof aQ[d] !== z) {
					aC = !(!aQ[d])
				}
				if (typeof aQ[F] !== z) {
					aA = !(!aQ[F])
				}
				if (typeof aQ.autoUpdatePlayer !== z) {
					aI = !(!aQ.autoUpdatePlayer)
				}
				if ((typeof aQ[p] !== z) && ((H = u(aQ[p], 10)) > 0)) {
					aG = H
				}
				if ((typeof aQ[D] !== z) && (aQ[D] !== null)) {
					aJ = aQ[D]
				}
				if ((typeof aQ[C] !== z) && (aQ[C] !== null)) {
					aD = aQ[C]
				}
				if ((typeof aQ[M] !== z) && (aQ[M] !== null)) {
					aN = aQ[M]
				}
			}
			Y = S + "_" + aV;
			function aZ() {
				f(af);
				try {
					E.detachEvent(e, aZ)
				} catch (a2) {
				}
			}
			try {
				E.attachEvent(e, aZ)
			} catch (a0) {
			}
			(function a1() {
				try {
					y.bindEvent(E, e, aH)
				} catch (a2) {
					af = w(arguments.callee, 25);
					return
				}
				aZ();
				af = w(aS, 1)
			})()
		}();
		function aS() {
			if (V === null) {
				Q = h.getElementsByTagName("body")[0]
			} else {
				Q = y.getObjectById(V)
			}
			try {
				Q.nodeName.toLowerCase();
				y.checkplayer.module_ready();
				K = y.checkplayer
			} catch (a0) {
				af = w(aS, 25);
				return
			}
			if ((q === null) && (typeof K._ins === z)) {
				try {
					q = new K(r.MIN_PLAYER_VERSION, aT, L, aq)
				} catch (aZ) {
					aO(r.DEPENDENCY_ERROR, "flXHR: checkplayer Init Failed",
							"The initialization of the 'checkplayer' library failed to complete.");
					return
				}
			} else {
				q = K._ins;
				ag()
			}
		}
		function ag() {
			if (q === null || !q.checkPassed) {
				af = w(ag, 25);
				return
			}
			if (m === null && V === null) {
				y
						.createCSS("." + ae,
								"left:-1px;top:0px;width:1px;height:1px;position:absolute;");
				m = a
			}
			var a3 = h.createElement(l);
			a3.id = Y;
			a3.className = ae;
			Q.appendChild(a3);
			Q = null;
			var a0 = {}, a4 = {
				allowScriptAccess : "always"
			}, a1 = {
				id : Y,
				name : Y,
				styleclass : ae
			}, a2 = {
				swfCB : aR,
				swfEICheck : "reset"
			};
			try {
				q.DoSWF(y.base_path + A, Y, "1", "1", a0, a4, a1, a2)
			} catch (aZ) {
				aO(r.DEPENDENCY_ERROR, "flXHR: checkplayer Call Failed",
						"A call to the 'checkplayer' library failed to complete.");
				return
			}
		}
		function aR(aZ) {
			if (aZ.status !== K.SWF_EI_READY) {
				return
			}
			R();
			aU = y.getObjectById(Y);
			aU.setId(Y);
			if (T !== g) {
				aU.loadPolicy(T)
			}
			aU.autoNoCacheHeader(au);
			aU.returnBinaryResponseBody(aC);
			aU.doOnReadyStateChange = al;
			aU.doOnError = aO;
			aU.sendProcessed = ap;
			aU.chunkResponse = ay;
			aL = 0;
			ax();
			aW();
			if (typeof aJ === k) {
				try {
					aJ(ak)
				} catch (a0) {
					aO(r.HANDLER_ERROR, "flXHR::onreadystatechange(): Error",
							"An error occurred in the handler function. ("
									+ a0.message + ")");
					return
				}
			}
			at()
		}
		function aH() {
			try {
				c.flensed.unbindEvent(E, e, aH)
			} catch (a2) {
			}
			try {
				for ( var a3 = 0; a3 < i.length; a3++) {
					if (i[a3] === ak) {
						i[a3] = L
					}
				}
			} catch (ba) {
			}
			try {
				for ( var a5 in ak) {
					if (ak[a5] !== Object.prototype[a5]) {
						try {
							ak[a5] = null
						} catch (a9) {
						}
					}
				}
			} catch (a8) {
			}
			ak = null;
			R();
			if ((typeof aU !== z) && (aU !== null)) {
				try {
					aU.abort()
				} catch (a7) {
				}
				try {
					aU.doOnReadyStateChange = null;
					al = null
				} catch (a6) {
				}
				try {
					aU.doOnError = null;
					doOnError = null
				} catch (a4) {
				}
				try {
					aU.sendProcessed = null;
					ap = null
				} catch (a1) {
				}
				try {
					aU.chunkResponse = null;
					ay = null
				} catch (a0) {
				}
				aU = null;
				try {
					c.swfobject.removeSWF(Y)
				} catch (aZ) {
				}
			}
			aP();
			aJ = null;
			aD = null;
			aN = null;
			ao = null;
			aa = null;
			aK = null;
			Q = null
		}
		function ay() {
			if (aC && typeof arguments[0] !== z) {
				aK = ((aK !== null) ? aK : []);
				aK = aK.concat(arguments[0])
			} else {
				if (typeof arguments[0] === N) {
					aK = ((aK !== null) ? aK : g);
					aK += arguments[0]
				}
			}
		}
		function al() {
			if (typeof arguments[0] !== z) {
				aL = arguments[0]
			}
			if (aL === 4) {
				R();
				if (aC && aK !== null) {
					try {
						ac = y.binaryToString(aK, a);
						try {
							aa = flXHR_vb_StringToBinary(ac)
						} catch (a1) {
							aa = aK
						}
					} catch (a0) {
					}
				} else {
					ac = aK
				}
				aK = null;
				if (ac !== g) {
					if (aA) {
						try {
							ao = y.parseXMLString(ac)
						} catch (aZ) {
							ao = {}
						}
					}
				}
			}
			if (typeof arguments[1] !== z) {
				aE = arguments[1]
			}
			if (typeof arguments[2] !== z) {
				aw = arguments[2]
			}
			ad(aL)
		}
		function ad(aZ) {
			ax();
			aW();
			ak[J] = Math.max(0, aZ);
			if (typeof aJ === k) {
				try {
					aJ(ak)
				} catch (a0) {
					aO(r.HANDLER_ERROR, "flXHR::onreadystatechange(): Error",
							"An error occurred in the handler function. ("
									+ a0.message + ")");
					return
				}
			}
		}
		function aO() {
			R();
			aP();
			aB = a;
			var a2;
			try {
				a2 = new y.error(arguments[0], arguments[1], arguments[2], ak)
			} catch (a3) {
				function a0() {
					this.number = 0;
					this.name = "flXHR Error: Unknown";
					this.description = "Unknown error from 'flXHR' library.";
					this.message = this.description;
					this.srcElement = ak;
					var a7 = this.number, a6 = this.name, a9 = this.description;
					function a8() {
						return a7 + ", " + a6 + ", " + a9
					}
					this.toString = a8
				}
				a2 = new a0()
			}
			var a4 = L;
			try {
				if (typeof aD === k) {
					aD(a2);
					a4 = a
				}
			} catch (aZ) {
				var a1 = a2.toString();
				function a5() {
					this.number = r.HANDLER_ERROR;
					this.name = "flXHR::onerror(): Error";
					this.description = "An error occured in the handler function. ("
							+ aZ.message + ")\nPrevious:[" + a1 + "]";
					this.message = this.description;
					this.srcElement = ak;
					var a7 = this.number, a6 = this.name, a9 = this.description;
					function a8() {
						return a7 + ", " + a6 + ", " + a9
					}
					this.toString = a8
				}
				a2 = new a5()
			}
			if (!a4) {
				w(function() {
					y.throwUnhandledError(a2.toString())
				}, 1)
			}
		}
		function W() {
			am();
			aB = a;
			if (typeof aN === k) {
				try {
					aN(ak)
				} catch (aZ) {
					aO(r.HANDLER_ERROR, "flXHR::ontimeout(): Error",
							"An error occurred in the handler function. ("
									+ aZ.message + ")");
					return
				}
			} else {
				aO(r.TIMEOUT_ERROR, "flXHR: Operation Timed out",
						"The requested operation timed out.")
			}
		}
		function R() {
			f(af);
			af = null;
			f(X);
			X = null;
			f(ah);
			ah = null
		}
		function aY(a0, a1, aZ) {
			ai[ai.length] = {
				func : a0,
				funcName : a1,
				args : aZ
			};
			Z = L
		}
		function aP() {
			if (!Z) {
				Z = a;
				var a0 = ai.length;
				for ( var aZ = 0; aZ < a0; aZ++) {
					try {
						ai[aZ] = L
					} catch (a1) {
					}
				}
				ai = []
			}
		}
		function at() {
			if (aL < 0) {
				ah = w(at, 25);
				return
			}
			if (!Z) {
				for ( var aZ = 0; aZ < ai.length; aZ++) {
					try {
						if (ai[aZ] !== L) {
							ai[aZ].func.apply(ak, ai[aZ].args);
							ai[aZ] = L
						}
					} catch (a0) {
						aO(r.HANDLER_ERROR, "flXHR::" + ai[aZ].funcName
								+ "(): Error", "An error occurred in the "
								+ ai[aZ].funcName + "() function.");
						return
					}
				}
				Z = a
			}
		}
		function aW() {
			try {
				ak[O] = aX;
				ak[J] = Math.max(0, aL);
				ak.status = aE;
				ak.statusText = aw;
				ak.responseText = ac;
				ak.responseXML = ao;
				ak.responseBody = aa;
				ak[D] = aJ;
				ak[C] = aD;
				ak[M] = aN;
				ak[I] = T;
				ak[b] = au;
				ak[d] = aC;
				ak[F] = aA
			} catch (aZ) {
			}
		}
		function ax() {
			try {
				aX = ak[O];
				if (ak.timeout !== null && (H = u(ak.timeout, 10)) > 0) {
					aG = H
				}
				aJ = ak[D];
				aD = ak[C];
				aN = ak[M];
				if (ak[I] !== null) {
					if ((ak[I] !== T) && (aL >= 0)) {
						aU.loadPolicy(ak[I])
					}
					T = ak[I]
				}
				if (ak[b] !== null) {
					if ((ak[b] !== au) && (aL >= 0)) {
						aU.autoNoCacheHeader(ak[b])
					}
					au = ak[b]
				}
				if (ak[d] !== null) {
					if ((ak[d] !== aC) && (aL >= 0)) {
						aU.returnBinaryResponseBody(ak[d])
					}
					aC = ak[d]
				}
				if (aA !== null) {
					aA = !(!ak[F])
				}
			} catch (aZ) {
			}
		}
		function aM() {
			am();
			try {
				aU.reset()
			} catch (aZ) {
			}
			aE = null;
			aw = null;
			ac = null;
			ao = null;
			aa = null;
			aK = null;
			aB = L;
			aW();
			T = g;
			ax()
		}
		function aT(aZ) {
			if (aZ.checkPassed) {
				ag()
			} else {
				if (!aI) {
					aO(
							r.PLAYER_VERSION_ERROR,
							"flXHR: Insufficient Flash Player Version",
							"The Flash Player was either not detected, or the detected version ("
									+ aZ.playerVersionDetected
									+ ") was not at least the minimum version ("
									+ r.MIN_PLAYER_VERSION
									+ ") needed by the 'flXHR' library.")
				} else {
					q.UpdatePlayer()
				}
			}
		}
		function aq(aZ) {
			if (aZ.updateStatus === K.UPDATE_CANCELED) {
				aO(r.PLAYER_VERSION_ERROR,
						"flXHR: Flash Player Update Canceled",
						"The Flash Player was not updated.")
			} else {
				if (aZ.updateStatus === K.UPDATE_FAILED) {
					aO(r.PLAYER_VERSION_ERROR,
							"flXHR: Flash Player Update Failed",
							"The Flash Player was either not detected or could not be updated.")
				}
			}
		}
		function ap() {
			if (aG !== null && aG > 0) {
				X = w(W, aG)
			}
		}
		function am() {
			R();
			aP();
			ax();
			aL = 0;
			try {
				aU.abort()
			} catch (aZ) {
				aO(r.CALL_ERROR, "flXHR::abort(): Failed",
						"The abort() call failed to complete.")
			}
			aW()
		}
		function av() {
			ax();
			if (typeof arguments[0] === z || typeof arguments[1] === z) {
				aO(r.CALL_ERROR, "flXHR::open(): Failed",
						"The open() call requires 'method' and 'url' parameters.")
			} else {
				if (aL > 0 || aB) {
					aM()
				}
				if (ak[J] === 0) {
					al(1)
				} else {
					aL = 1
				}
				var a6 = arguments[0], a5 = arguments[1], aZ = (typeof arguments[2] !== z) ? arguments[2]
						: a, a9 = (typeof arguments[3] !== z) ? arguments[3]
						: g, a8 = (typeof arguments[4] !== z) ? arguments[4]
						: g;
				try {
					aU.autoNoCacheHeader(au);
					aU.open(a6, a5, aZ, a9, a8)
				} catch (a7) {
					aO(r.CALL_ERROR, "flXHR::open(): Failed",
							"The open() call failed to complete.")
				}
			}
		}
		function az() {
			ax();
			if (aL <= 1 && !aB) {
				var aZ = (typeof arguments[0] !== z) ? arguments[0] : g;
				if (ak[J] === 1) {
					al(2)
				} else {
					aL = 2
				}
				try {
					aU.autoNoCacheHeader(au);
					aU.send(aZ)
				} catch (a1) {
					aO(r.CALL_ERROR, "flXHR::send(): Failed",
							"The send() call failed to complete.")
				}
			} else {
				aO(r.CALL_ERROR, "flXHR::send(): Failed",
						"The send() call cannot be made at this time.")
			}
		}
		function aj() {
			ax();
			if (typeof arguments[0] === z || typeof arguments[1] === z) {
				aO(r.CALL_ERROR, "flXHR::setRequestHeader(): Failed",
						"The setRequestHeader() call requires 'name' and 'value' parameters.")
			} else {
				if (!aB) {
					var a2 = (typeof arguments[0] !== z) ? arguments[0] : g, aZ = (typeof arguments[1] !== z) ? arguments[1]
							: g;
					try {
						aU.setRequestHeader(a2, aZ)
					} catch (a3) {
						aO(r.CALL_ERROR, "flXHR::setRequestHeader(): Failed",
								"The setRequestHeader() call failed to complete.")
					}
				}
			}
		}
		function an() {
			ax();
			return g
		}
		function ar() {
			ax();
			return []
		}
		ak = {
			readyState : 0,
			responseBody : aa,
			responseText : ac,
			responseXML : ao,
			status : aE,
			statusText : aw,
			timeout : aG,
			open : function() {
				ax();
				if (ak[J] === 0) {
					ad(1)
				}
				if (!Z || aL < 0) {
					aY(av, "open", arguments);
					return
				}
				av.apply({}, arguments)
			},
			send : function() {
				ax();
				if (ak[J] === 1) {
					ad(2)
				}
				if (!Z || aL < 0) {
					aY(az, "send", arguments);
					return
				}
				az.apply({}, arguments)
			},
			abort : am,
			setRequestHeader : function() {
				ax();
				if (!Z || aL < 0) {
					aY(aj, "setRequestHeader", arguments);
					return
				}
				aj.apply({}, arguments)
			},
			getResponseHeader : an,
			getAllResponseHeaders : ar,
			onreadystatechange : aJ,
			ontimeout : aN,
			instanceId : aX,
			loadPolicyURL : T,
			noCacheHeader : au,
			binaryResponseBody : aC,
			xmlResponseText : aA,
			onerror : aD,
			Configure : function(aZ) {
				if (typeof aZ === o && aZ !== null) {
					if ((typeof aZ[O] !== z) && (aZ[O] !== null)
							&& (aZ[O] !== g)) {
						aX = aZ[O]
					}
					if (typeof aZ[b] !== z) {
						au = !(!aZ[b]);
						if (aL >= 0) {
							aU.autoNoCacheHeader(au)
						}
					}
					if (typeof aZ[d] !== z) {
						aC = !(!aZ[d]);
						if (aL >= 0) {
							aU.returnBinaryResponseBody(aC)
						}
					}
					if (typeof aZ[F] !== z) {
						aA = !(!aZ[F])
					}
					if ((typeof aZ[D] !== z) && (aZ[D] !== null)) {
						aJ = aZ[D]
					}
					if ((typeof aZ[C] !== z) && (aZ[C] !== null)) {
						aD = aZ[C]
					}
					if ((typeof aZ[M] !== z) && (aZ[M] !== null)) {
						aN = aZ[M]
					}
					if ((typeof aZ[p] !== z) && ((H = u(aZ[p], 10)) > 0)) {
						aG = H
					}
					if ((typeof aZ[I] !== z) && (aZ[I] !== null)
							&& (aZ[I] !== g) && (aZ[I] !== T)) {
						T = aZ[I];
						if (aL >= 0) {
							aU.loadPolicy(T)
						}
					}
					aW()
				}
			},
			Reset : aM,
			Destroy : aH
		};
		if (ab) {
			i[i.length] = ak
		}
		return ak
	};
	r = y.flXHR;
	r.HANDLER_ERROR = 10;
	r.CALL_ERROR = 11;
	r.TIMEOUT_ERROR = 12;
	r.DEPENDENCY_ERROR = 13;
	r.PLAYER_VERSION_ERROR = 14;
	r.SECURITY_ERROR = 15;
	r.COMMUNICATION_ERROR = 16;
	r.MIN_PLAYER_VERSION = "9.0.124";
	r.module_ready = function() {
	}
})(window);