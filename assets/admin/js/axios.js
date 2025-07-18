!(function (e, t) {
    "object" == typeof exports && "undefined" != typeof module
        ? (module.exports = t())
        : "function" == typeof define && define.amd
        ? define(t)
        : ((e =
              "undefined" != typeof globalThis ? globalThis : e || self).axios =
              t());
})(this, function () {
    "use strict";
    function e(t) {
        return (
            (e =
                "function" == typeof Symbol &&
                "symbol" == typeof Symbol.iterator
                    ? function (e) {
                          return typeof e;
                      }
                    : function (e) {
                          return e &&
                              "function" == typeof Symbol &&
                              e.constructor === Symbol &&
                              e !== Symbol.prototype
                              ? "symbol"
                              : typeof e;
                      }),
            e(t)
        );
    }
    function t(e, t) {
        if (!(e instanceof t))
            throw new TypeError("Cannot call a class as a function");
    }
    function n(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            (r.enumerable = r.enumerable || !1),
                (r.configurable = !0),
                "value" in r && (r.writable = !0),
                Object.defineProperty(e, r.key, r);
        }
    }
    function r(e, t, r) {
        return (
            t && n(e.prototype, t),
            r && n(e, r),
            Object.defineProperty(e, "prototype", { writable: !1 }),
            e
        );
    }
    function o(e, t) {
        return function () {
            return e.apply(t, arguments);
        };
    }
    var i,
        s = Object.prototype.toString,
        a = Object.getPrototypeOf,
        u =
            ((i = Object.create(null)),
            function (e) {
                var t = s.call(e);
                return i[t] || (i[t] = t.slice(8, -1).toLowerCase());
            }),
        c = function (e) {
            return (
                (e = e.toLowerCase()),
                function (t) {
                    return u(t) === e;
                }
            );
        },
        f = function (t) {
            return function (n) {
                return e(n) === t;
            };
        },
        l = Array.isArray,
        d = f("undefined");
    var h = c("ArrayBuffer");
    var p = f("string"),
        m = f("function"),
        v = f("number"),
        y = function (t) {
            return null !== t && "object" === e(t);
        },
        b = function (e) {
            if ("object" !== u(e)) return !1;
            var t = a(e);
            return !(
                (null !== t &&
                    t !== Object.prototype &&
                    null !== Object.getPrototypeOf(t)) ||
                Symbol.toStringTag in e ||
                Symbol.iterator in e
            );
        },
        g = c("Date"),
        E = c("File"),
        w = c("Blob"),
        O = c("FileList"),
        S = c("URLSearchParams");
    function R(t, n) {
        var r,
            o,
            i =
                arguments.length > 2 && void 0 !== arguments[2]
                    ? arguments[2]
                    : {},
            s = i.allOwnKeys,
            a = void 0 !== s && s;
        if (null != t)
            if (("object" !== e(t) && (t = [t]), l(t)))
                for (r = 0, o = t.length; r < o; r++) n.call(null, t[r], r, t);
            else {
                var u,
                    c = a ? Object.getOwnPropertyNames(t) : Object.keys(t),
                    f = c.length;
                for (r = 0; r < f; r++) (u = c[r]), n.call(null, t[u], u, t);
            }
    }
    var A,
        j =
            ((A = "undefined" != typeof Uint8Array && a(Uint8Array)),
            function (e) {
                return A && e instanceof A;
            }),
        T = c("HTMLFormElement"),
        x = (function (e) {
            var t = Object.prototype.hasOwnProperty;
            return function (e, n) {
                return t.call(e, n);
            };
        })(),
        C = c("RegExp"),
        N = function (e, t) {
            var n = Object.getOwnPropertyDescriptors(e),
                r = {};
            R(n, function (n, o) {
                !1 !== t(n, o, e) && (r[o] = n);
            }),
                Object.defineProperties(e, r);
        },
        P = {
            isArray: l,
            isArrayBuffer: h,
            isBuffer: function (e) {
                return (
                    null !== e &&
                    !d(e) &&
                    null !== e.constructor &&
                    !d(e.constructor) &&
                    m(e.constructor.isBuffer) &&
                    e.constructor.isBuffer(e)
                );
            },
            isFormData: function (e) {
                var t = "[object FormData]";
                return (
                    e &&
                    (("function" == typeof FormData && e instanceof FormData) ||
                        s.call(e) === t ||
                        (m(e.toString) && e.toString() === t))
                );
            },
            isArrayBufferView: function (e) {
                return "undefined" != typeof ArrayBuffer && ArrayBuffer.isView
                    ? ArrayBuffer.isView(e)
                    : e && e.buffer && h(e.buffer);
            },
            isString: p,
            isNumber: v,
            isBoolean: function (e) {
                return !0 === e || !1 === e;
            },
            isObject: y,
            isPlainObject: b,
            isUndefined: d,
            isDate: g,
            isFile: E,
            isBlob: w,
            isRegExp: C,
            isFunction: m,
            isStream: function (e) {
                return y(e) && m(e.pipe);
            },
            isURLSearchParams: S,
            isTypedArray: j,
            isFileList: O,
            forEach: R,
            merge: function e() {
                for (
                    var t = {},
                        n = function (n, r) {
                            b(t[r]) && b(n)
                                ? (t[r] = e(t[r], n))
                                : b(n)
                                ? (t[r] = e({}, n))
                                : l(n)
                                ? (t[r] = n.slice())
                                : (t[r] = n);
                        },
                        r = 0,
                        o = arguments.length;
                    r < o;
                    r++
                )
                    arguments[r] && R(arguments[r], n);
                return t;
            },
            extend: function (e, t, n) {
                var r =
                        arguments.length > 3 && void 0 !== arguments[3]
                            ? arguments[3]
                            : {},
                    i = r.allOwnKeys;
                return (
                    R(
                        t,
                        function (t, r) {
                            n && m(t) ? (e[r] = o(t, n)) : (e[r] = t);
                        },
                        { allOwnKeys: i }
                    ),
                    e
                );
            },
            trim: function (e) {
                return e.trim
                    ? e.trim()
                    : e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
            },
            stripBOM: function (e) {
                return 65279 === e.charCodeAt(0) && (e = e.slice(1)), e;
            },
            inherits: function (e, t, n, r) {
                (e.prototype = Object.create(t.prototype, r)),
                    (e.prototype.constructor = e),
                    Object.defineProperty(e, "super", { value: t.prototype }),
                    n && Object.assign(e.prototype, n);
            },
            toFlatObject: function (e, t, n, r) {
                var o,
                    i,
                    s,
                    u = {};
                if (((t = t || {}), null == e)) return t;
                do {
                    for (
                        i = (o = Object.getOwnPropertyNames(e)).length;
                        i-- > 0;

                    )
                        (s = o[i]),
                            (r && !r(s, e, t)) ||
                                u[s] ||
                                ((t[s] = e[s]), (u[s] = !0));
                    e = !1 !== n && a(e);
                } while (e && (!n || n(e, t)) && e !== Object.prototype);
                return t;
            },
            kindOf: u,
            kindOfTest: c,
            endsWith: function (e, t, n) {
                (e = String(e)),
                    (void 0 === n || n > e.length) && (n = e.length),
                    (n -= t.length);
                var r = e.indexOf(t, n);
                return -1 !== r && r === n;
            },
            toArray: function (e) {
                if (!e) return null;
                if (l(e)) return e;
                var t = e.length;
                if (!v(t)) return null;
                for (var n = new Array(t); t-- > 0; ) n[t] = e[t];
                return n;
            },
            forEachEntry: function (e, t) {
                for (
                    var n, r = (e && e[Symbol.iterator]).call(e);
                    (n = r.next()) && !n.done;

                ) {
                    var o = n.value;
                    t.call(e, o[0], o[1]);
                }
            },
            matchAll: function (e, t) {
                for (var n, r = []; null !== (n = e.exec(t)); ) r.push(n);
                return r;
            },
            isHTMLForm: T,
            hasOwnProperty: x,
            hasOwnProp: x,
            reduceDescriptors: N,
            freezeMethods: function (e) {
                N(e, function (t, n) {
                    var r = e[n];
                    m(r) &&
                        ((t.enumerable = !1),
                        "writable" in t
                            ? (t.writable = !1)
                            : t.set ||
                              (t.set = function () {
                                  throw Error(
                                      "Can not read-only method '" + n + "'"
                                  );
                              }));
                });
            },
            toObjectSet: function (e, t) {
                var n = {},
                    r = function (e) {
                        e.forEach(function (e) {
                            n[e] = !0;
                        });
                    };
                return l(e) ? r(e) : r(String(e).split(t)), n;
            },
            toCamelCase: function (e) {
                return e
                    .toLowerCase()
                    .replace(/[_-\s]([a-z\d])(\w*)/g, function (e, t, n) {
                        return t.toUpperCase() + n;
                    });
            },
            noop: function () {},
            toFiniteNumber: function (e, t) {
                return (e = +e), Number.isFinite(e) ? e : t;
            },
        };
    function _(e, t, n, r, o) {
        Error.call(this),
            Error.captureStackTrace
                ? Error.captureStackTrace(this, this.constructor)
                : (this.stack = new Error().stack),
            (this.message = e),
            (this.name = "AxiosError"),
            t && (this.code = t),
            n && (this.config = n),
            r && (this.request = r),
            o && (this.response = o);
    }
    P.inherits(_, Error, {
        toJSON: function () {
            return {
                message: this.message,
                name: this.name,
                description: this.description,
                number: this.number,
                fileName: this.fileName,
                lineNumber: this.lineNumber,
                columnNumber: this.columnNumber,
                stack: this.stack,
                config: this.config,
                code: this.code,
                status:
                    this.response && this.response.status
                        ? this.response.status
                        : null,
            };
        },
    });
    var B = _.prototype,
        D = {};
    [
        "ERR_BAD_OPTION_VALUE",
        "ERR_BAD_OPTION",
        "ECONNABORTED",
        "ETIMEDOUT",
        "ERR_NETWORK",
        "ERR_FR_TOO_MANY_REDIRECTS",
        "ERR_DEPRECATED",
        "ERR_BAD_RESPONSE",
        "ERR_BAD_REQUEST",
        "ERR_CANCELED",
        "ERR_NOT_SUPPORT",
        "ERR_INVALID_URL",
    ].forEach(function (e) {
        D[e] = { value: e };
    }),
        Object.defineProperties(_, D),
        Object.defineProperty(B, "isAxiosError", { value: !0 }),
        (_.from = function (e, t, n, r, o, i) {
            var s = Object.create(B);
            return (
                P.toFlatObject(
                    e,
                    s,
                    function (e) {
                        return e !== Error.prototype;
                    },
                    function (e) {
                        return "isAxiosError" !== e;
                    }
                ),
                _.call(s, e.message, t, n, r, o),
                (s.cause = e),
                (s.name = e.name),
                i && Object.assign(s, i),
                s
            );
        });
    var F =
        "object" == ("undefined" == typeof self ? "undefined" : e(self))
            ? self.FormData
            : window.FormData;
    function U(e) {
        return P.isPlainObject(e) || P.isArray(e);
    }
    function k(e) {
        return P.endsWith(e, "[]") ? e.slice(0, -2) : e;
    }
    function L(e, t, n) {
        return e
            ? e
                  .concat(t)
                  .map(function (e, t) {
                      return (e = k(e)), !n && t ? "[" + e + "]" : e;
                  })
                  .join(n ? "." : "")
            : t;
    }
    var z = P.toFlatObject(P, {}, null, function (e) {
        return /^is[A-Z]/.test(e);
    });
    function q(t, n, r) {
        if (!P.isObject(t)) throw new TypeError("target must be an object");
        n = n || new (F || FormData)();
        var o,
            i = (r = P.toFlatObject(
                r,
                { metaTokens: !0, dots: !1, indexes: !1 },
                !1,
                function (e, t) {
                    return !P.isUndefined(t[e]);
                }
            )).metaTokens,
            s = r.visitor || l,
            a = r.dots,
            u = r.indexes,
            c =
                (r.Blob || ("undefined" != typeof Blob && Blob)) &&
                (o = n) &&
                P.isFunction(o.append) &&
                "FormData" === o[Symbol.toStringTag] &&
                o[Symbol.iterator];
        if (!P.isFunction(s)) throw new TypeError("visitor must be a function");
        function f(e) {
            if (null === e) return "";
            if (P.isDate(e)) return e.toISOString();
            if (!c && P.isBlob(e))
                throw new _("Blob is not supported. Use a Buffer instead.");
            return P.isArrayBuffer(e) || P.isTypedArray(e)
                ? c && "function" == typeof Blob
                    ? new Blob([e])
                    : Buffer.from(e)
                : e;
        }
        function l(t, r, o) {
            var s = t;
            if (t && !o && "object" === e(t))
                if (P.endsWith(r, "{}"))
                    (r = i ? r : r.slice(0, -2)), (t = JSON.stringify(t));
                else if (
                    (P.isArray(t) &&
                        (function (e) {
                            return P.isArray(e) && !e.some(U);
                        })(t)) ||
                    P.isFileList(t) ||
                    (P.endsWith(r, "[]") && (s = P.toArray(t)))
                )
                    return (
                        (r = k(r)),
                        s.forEach(function (e, t) {
                            !P.isUndefined(e) &&
                                null !== e &&
                                n.append(
                                    !0 === u
                                        ? L([r], t, a)
                                        : null === u
                                        ? r
                                        : r + "[]",
                                    f(e)
                                );
                        }),
                        !1
                    );
            return !!U(t) || (n.append(L(o, r, a), f(t)), !1);
        }
        var d = [],
            h = Object.assign(z, {
                defaultVisitor: l,
                convertValue: f,
                isVisitable: U,
            });
        if (!P.isObject(t)) throw new TypeError("data must be an object");
        return (
            (function e(t, r) {
                if (!P.isUndefined(t)) {
                    if (-1 !== d.indexOf(t))
                        throw Error(
                            "Circular reference detected in " + r.join(".")
                        );
                    d.push(t),
                        P.forEach(t, function (t, o) {
                            !0 ===
                                (!(P.isUndefined(t) || null === t) &&
                                    s.call(
                                        n,
                                        t,
                                        P.isString(o) ? o.trim() : o,
                                        r,
                                        h
                                    )) && e(t, r ? r.concat(o) : [o]);
                        }),
                        d.pop();
                }
            })(t),
            n
        );
    }
    function I(e) {
        var t = {
            "!": "%21",
            "'": "%27",
            "(": "%28",
            ")": "%29",
            "~": "%7E",
            "%20": "+",
            "%00": "\0",
        };
        return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g, function (e) {
            return t[e];
        });
    }
    function M(e, t) {
        (this._pairs = []), e && q(e, this, t);
    }
    var J = M.prototype;
    function H(e) {
        return encodeURIComponent(e)
            .replace(/%3A/gi, ":")
            .replace(/%24/g, "$")
            .replace(/%2C/gi, ",")
            .replace(/%20/g, "+")
            .replace(/%5B/gi, "[")
            .replace(/%5D/gi, "]");
    }
    function V(e, t, n) {
        if (!t) return e;
        var r,
            o = (n && n.encode) || H,
            i = n && n.serialize;
        if (
            (r = i
                ? i(t, n)
                : P.isURLSearchParams(t)
                ? t.toString()
                : new M(t, n).toString(o))
        ) {
            var s = e.indexOf("#");
            -1 !== s && (e = e.slice(0, s)),
                (e += (-1 === e.indexOf("?") ? "?" : "&") + r);
        }
        return e;
    }
    (J.append = function (e, t) {
        this._pairs.push([e, t]);
    }),
        (J.toString = function (e) {
            var t = e
                ? function (t) {
                      return e.call(this, t, I);
                  }
                : I;
            return this._pairs
                .map(function (e) {
                    return t(e[0]) + "=" + t(e[1]);
                }, "")
                .join("&");
        });
    var W,
        K = (function () {
            function e() {
                t(this, e), (this.handlers = []);
            }
            return (
                r(e, [
                    {
                        key: "use",
                        value: function (e, t, n) {
                            return (
                                this.handlers.push({
                                    fulfilled: e,
                                    rejected: t,
                                    synchronous: !!n && n.synchronous,
                                    runWhen: n ? n.runWhen : null,
                                }),
                                this.handlers.length - 1
                            );
                        },
                    },
                    {
                        key: "eject",
                        value: function (e) {
                            this.handlers[e] && (this.handlers[e] = null);
                        },
                    },
                    {
                        key: "clear",
                        value: function () {
                            this.handlers && (this.handlers = []);
                        },
                    },
                    {
                        key: "forEach",
                        value: function (e) {
                            P.forEach(this.handlers, function (t) {
                                null !== t && e(t);
                            });
                        },
                    },
                ]),
                e
            );
        })(),
        X = {
            silentJSONParsing: !0,
            forcedJSONParsing: !0,
            clarifyTimeoutError: !1,
        },
        $ = "undefined" != typeof URLSearchParams ? URLSearchParams : M,
        Q = FormData,
        G =
            ("undefined" == typeof navigator ||
                ("ReactNative" !== (W = navigator.product) &&
                    "NativeScript" !== W &&
                    "NS" !== W)) &&
            "undefined" != typeof window &&
            "undefined" != typeof document,
        Y = {
            isBrowser: !0,
            classes: { URLSearchParams: $, FormData: Q, Blob: Blob },
            isStandardBrowserEnv: G,
            protocols: ["http", "https", "file", "blob", "url", "data"],
        };
    function Z(e) {
        function t(e, n, r, o) {
            var i = e[o++],
                s = Number.isFinite(+i),
                a = o >= e.length;
            return (
                (i = !i && P.isArray(r) ? r.length : i),
                a
                    ? (P.hasOwnProp(r, i) ? (r[i] = [r[i], n]) : (r[i] = n), !s)
                    : ((r[i] && P.isObject(r[i])) || (r[i] = []),
                      t(e, n, r[i], o) &&
                          P.isArray(r[i]) &&
                          (r[i] = (function (e) {
                              var t,
                                  n,
                                  r = {},
                                  o = Object.keys(e),
                                  i = o.length;
                              for (t = 0; t < i; t++) r[(n = o[t])] = e[n];
                              return r;
                          })(r[i])),
                      !s)
            );
        }
        if (P.isFormData(e) && P.isFunction(e.entries)) {
            var n = {};
            return (
                P.forEachEntry(e, function (e, r) {
                    t(
                        (function (e) {
                            return P.matchAll(/\w+|\[(\w*)]/g, e).map(function (
                                e
                            ) {
                                return "[]" === e[0] ? "" : e[1] || e[0];
                            });
                        })(e),
                        r,
                        n,
                        0
                    );
                }),
                n
            );
        }
        return null;
    }
    var ee = Y.isStandardBrowserEnv
        ? {
              write: function (e, t, n, r, o, i) {
                  var s = [];
                  s.push(e + "=" + encodeURIComponent(t)),
                      P.isNumber(n) &&
                          s.push("expires=" + new Date(n).toGMTString()),
                      P.isString(r) && s.push("path=" + r),
                      P.isString(o) && s.push("domain=" + o),
                      !0 === i && s.push("secure"),
                      (document.cookie = s.join("; "));
              },
              read: function (e) {
                  var t = document.cookie.match(
                      new RegExp("(^|;\\s*)(" + e + ")=([^;]*)")
                  );
                  return t ? decodeURIComponent(t[3]) : null;
              },
              remove: function (e) {
                  this.write(e, "", Date.now() - 864e5);
              },
          }
        : {
              write: function () {},
              read: function () {
                  return null;
              },
              remove: function () {},
          };
    function te(e, t) {
        return e && !/^([a-z][a-z\d+\-.]*:)?\/\//i.test(t)
            ? (function (e, t) {
                  return t
                      ? e.replace(/\/+$/, "") + "/" + t.replace(/^\/+/, "")
                      : e;
              })(e, t)
            : t;
    }
    var ne = Y.isStandardBrowserEnv
        ? (function () {
              var e,
                  t = /(msie|trident)/i.test(navigator.userAgent),
                  n = document.createElement("a");
              function r(e) {
                  var r = e;
                  return (
                      t && (n.setAttribute("href", r), (r = n.href)),
                      n.setAttribute("href", r),
                      {
                          href: n.href,
                          protocol: n.protocol
                              ? n.protocol.replace(/:$/, "")
                              : "",
                          host: n.host,
                          search: n.search ? n.search.replace(/^\?/, "") : "",
                          hash: n.hash ? n.hash.replace(/^#/, "") : "",
                          hostname: n.hostname,
                          port: n.port,
                          pathname:
                              "/" === n.pathname.charAt(0)
                                  ? n.pathname
                                  : "/" + n.pathname,
                      }
                  );
              }
              return (
                  (e = r(window.location.href)),
                  function (t) {
                      var n = P.isString(t) ? r(t) : t;
                      return n.protocol === e.protocol && n.host === e.host;
                  }
              );
          })()
        : function () {
              return !0;
          };
    function re(e, t, n) {
        _.call(this, null == e ? "canceled" : e, _.ERR_CANCELED, t, n),
            (this.name = "CanceledError");
    }
    P.inherits(re, _, { __CANCEL__: !0 });
    var oe = P.toObjectSet([
            "age",
            "authorization",
            "content-length",
            "content-type",
            "etag",
            "expires",
            "from",
            "host",
            "if-modified-since",
            "if-unmodified-since",
            "last-modified",
            "location",
            "max-forwards",
            "proxy-authorization",
            "referer",
            "retry-after",
            "user-agent",
        ]),
        ie = Symbol("internals"),
        se = Symbol("defaults");
    function ae(e) {
        return e && String(e).trim().toLowerCase();
    }
    function ue(e) {
        return !1 === e || null == e ? e : P.isArray(e) ? e.map(ue) : String(e);
    }
    function ce(e, t, n, r) {
        return P.isFunction(r)
            ? r.call(this, t, n)
            : P.isString(t)
            ? P.isString(r)
                ? -1 !== t.indexOf(r)
                : P.isRegExp(r)
                ? r.test(t)
                : void 0
            : void 0;
    }
    function fe(e, t) {
        t = t.toLowerCase();
        for (var n, r = Object.keys(e), o = r.length; o-- > 0; )
            if (t === (n = r[o]).toLowerCase()) return n;
        return null;
    }
    function le(e, t) {
        e && this.set(e), (this[se] = t || null);
    }
    function de(e, t) {
        var n = 0,
            r = (function (e, t) {
                e = e || 10;
                var n,
                    r = new Array(e),
                    o = new Array(e),
                    i = 0,
                    s = 0;
                return (
                    (t = void 0 !== t ? t : 1e3),
                    function (a) {
                        var u = Date.now(),
                            c = o[s];
                        n || (n = u), (r[i] = a), (o[i] = u);
                        for (var f = s, l = 0; f !== i; )
                            (l += r[f++]), (f %= e);
                        if (
                            ((i = (i + 1) % e) === s && (s = (s + 1) % e),
                            !(u - n < t))
                        ) {
                            var d = c && u - c;
                            return d ? Math.round((1e3 * l) / d) : void 0;
                        }
                    }
                );
            })(50, 250);
        return function (o) {
            var i = o.loaded,
                s = o.lengthComputable ? o.total : void 0,
                a = i - n,
                u = r(a);
            n = i;
            var c = {
                loaded: i,
                total: s,
                progress: s ? i / s : void 0,
                bytes: a,
                rate: u || void 0,
                estimated: u && s && i <= s ? (s - i) / u : void 0,
            };
            (c[t ? "download" : "upload"] = !0), e(c);
        };
    }
    function he(e) {
        return new Promise(function (t, n) {
            var r,
                o = e.data,
                i = le.from(e.headers).normalize(),
                s = e.responseType;
            function a() {
                e.cancelToken && e.cancelToken.unsubscribe(r),
                    e.signal && e.signal.removeEventListener("abort", r);
            }
            P.isFormData(o) && Y.isStandardBrowserEnv && i.setContentType(!1);
            var u = new XMLHttpRequest();
            if (e.auth) {
                var c = e.auth.username || "",
                    f = e.auth.password
                        ? unescape(encodeURIComponent(e.auth.password))
                        : "";
                i.set("Authorization", "Basic " + btoa(c + ":" + f));
            }
            var l = te(e.baseURL, e.url);
            function d() {
                if (u) {
                    var r = le.from(
                        "getAllResponseHeaders" in u &&
                            u.getAllResponseHeaders()
                    );
                    !(function (e, t, n) {
                        var r = n.config.validateStatus;
                        n.status && r && !r(n.status)
                            ? t(
                                  new _(
                                      "Request failed with status code " +
                                          n.status,
                                      [_.ERR_BAD_REQUEST, _.ERR_BAD_RESPONSE][
                                          Math.floor(n.status / 100) - 4
                                      ],
                                      n.config,
                                      n.request,
                                      n
                                  )
                              )
                            : e(n);
                    })(
                        function (e) {
                            t(e), a();
                        },
                        function (e) {
                            n(e), a();
                        },
                        {
                            data:
                                s && "text" !== s && "json" !== s
                                    ? u.response
                                    : u.responseText,
                            status: u.status,
                            statusText: u.statusText,
                            headers: r,
                            config: e,
                            request: u,
                        }
                    ),
                        (u = null);
                }
            }
            if (
                (u.open(
                    e.method.toUpperCase(),
                    V(l, e.params, e.paramsSerializer),
                    !0
                ),
                (u.timeout = e.timeout),
                "onloadend" in u
                    ? (u.onloadend = d)
                    : (u.onreadystatechange = function () {
                          u &&
                              4 === u.readyState &&
                              (0 !== u.status ||
                                  (u.responseURL &&
                                      0 === u.responseURL.indexOf("file:"))) &&
                              setTimeout(d);
                      }),
                (u.onabort = function () {
                    u &&
                        (n(new _("Request aborted", _.ECONNABORTED, e, u)),
                        (u = null));
                }),
                (u.onerror = function () {
                    n(new _("Network Error", _.ERR_NETWORK, e, u)), (u = null);
                }),
                (u.ontimeout = function () {
                    var t = e.timeout
                            ? "timeout of " + e.timeout + "ms exceeded"
                            : "timeout exceeded",
                        r = e.transitional || X;
                    e.timeoutErrorMessage && (t = e.timeoutErrorMessage),
                        n(
                            new _(
                                t,
                                r.clarifyTimeoutError
                                    ? _.ETIMEDOUT
                                    : _.ECONNABORTED,
                                e,
                                u
                            )
                        ),
                        (u = null);
                }),
                Y.isStandardBrowserEnv)
            ) {
                var h =
                    (e.withCredentials || ne(l)) &&
                    e.xsrfCookieName &&
                    ee.read(e.xsrfCookieName);
                h && i.set(e.xsrfHeaderName, h);
            }
            void 0 === o && i.setContentType(null),
                "setRequestHeader" in u &&
                    P.forEach(i.toJSON(), function (e, t) {
                        u.setRequestHeader(t, e);
                    }),
                P.isUndefined(e.withCredentials) ||
                    (u.withCredentials = !!e.withCredentials),
                s && "json" !== s && (u.responseType = e.responseType),
                "function" == typeof e.onDownloadProgress &&
                    u.addEventListener(
                        "progress",
                        de(e.onDownloadProgress, !0)
                    ),
                "function" == typeof e.onUploadProgress &&
                    u.upload &&
                    u.upload.addEventListener(
                        "progress",
                        de(e.onUploadProgress)
                    ),
                (e.cancelToken || e.signal) &&
                    ((r = function (t) {
                        u &&
                            (n(!t || t.type ? new re(null, e, u) : t),
                            u.abort(),
                            (u = null));
                    }),
                    e.cancelToken && e.cancelToken.subscribe(r),
                    e.signal &&
                        (e.signal.aborted
                            ? r()
                            : e.signal.addEventListener("abort", r)));
            var p,
                m = ((p = /^([-+\w]{1,25})(:?\/\/|:)/.exec(l)) && p[1]) || "";
            m && -1 === Y.protocols.indexOf(m)
                ? n(
                      new _(
                          "Unsupported protocol " + m + ":",
                          _.ERR_BAD_REQUEST,
                          e
                      )
                  )
                : u.send(o || null);
        });
    }
    Object.assign(le.prototype, {
        set: function (e, t, n) {
            var r = this;
            function o(e, t, n) {
                var o = ae(t);
                if (!o)
                    throw new Error("header name must be a non-empty string");
                var i = fe(r, o);
                (!i || !0 === n || (!1 !== r[i] && !1 !== n)) &&
                    (r[i || t] = ue(e));
            }
            return (
                P.isPlainObject(e)
                    ? P.forEach(e, function (e, n) {
                          o(e, n, t);
                      })
                    : o(t, e, n),
                this
            );
        },
        get: function (e, t) {
            if ((e = ae(e))) {
                var n = fe(this, e);
                if (n) {
                    var r = this[n];
                    if (!t) return r;
                    if (!0 === t)
                        return (function (e) {
                            for (
                                var t,
                                    n = Object.create(null),
                                    r = /([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;
                                (t = r.exec(e));

                            )
                                n[t[1]] = t[2];
                            return n;
                        })(r);
                    if (P.isFunction(t)) return t.call(this, r, n);
                    if (P.isRegExp(t)) return t.exec(r);
                    throw new TypeError(
                        "parser must be boolean|regexp|function"
                    );
                }
            }
        },
        has: function (e, t) {
            if ((e = ae(e))) {
                var n = fe(this, e);
                return !(!n || (t && !ce(0, this[n], n, t)));
            }
            return !1;
        },
        delete: function (e, t) {
            var n = this,
                r = !1;
            function o(e) {
                if ((e = ae(e))) {
                    var o = fe(n, e);
                    !o || (t && !ce(0, n[o], o, t)) || (delete n[o], (r = !0));
                }
            }
            return P.isArray(e) ? e.forEach(o) : o(e), r;
        },
        clear: function () {
            return Object.keys(this).forEach(this.delete.bind(this));
        },
        normalize: function (e) {
            var t = this,
                n = {};
            return (
                P.forEach(this, function (r, o) {
                    var i = fe(n, o);
                    if (i) return (t[i] = ue(r)), void delete t[o];
                    var s = e
                        ? (function (e) {
                              return e
                                  .trim()
                                  .toLowerCase()
                                  .replace(
                                      /([a-z\d])(\w*)/g,
                                      function (e, t, n) {
                                          return t.toUpperCase() + n;
                                      }
                                  );
                          })(o)
                        : String(o).trim();
                    s !== o && delete t[o], (t[s] = ue(r)), (n[s] = !0);
                }),
                this
            );
        },
        toJSON: function (e) {
            var t = Object.create(null);
            return (
                P.forEach(
                    Object.assign({}, this[se] || null, this),
                    function (n, r) {
                        null != n &&
                            !1 !== n &&
                            (t[r] = e && P.isArray(n) ? n.join(", ") : n);
                    }
                ),
                t
            );
        },
    }),
        Object.assign(le, {
            from: function (e) {
                return P.isString(e)
                    ? new this(
                          ((i = {}),
                          (t = e) &&
                              t.split("\n").forEach(function (e) {
                                  (o = e.indexOf(":")),
                                      (n = e
                                          .substring(0, o)
                                          .trim()
                                          .toLowerCase()),
                                      (r = e.substring(o + 1).trim()),
                                      !n ||
                                          (i[n] && oe[n]) ||
                                          ("set-cookie" === n
                                              ? i[n]
                                                  ? i[n].push(r)
                                                  : (i[n] = [r])
                                              : (i[n] = i[n]
                                                    ? i[n] + ", " + r
                                                    : r));
                              }),
                          i)
                      )
                    : e instanceof this
                    ? e
                    : new this(e);
                var t, n, r, o, i;
            },
            accessor: function (e) {
                var t = (this[ie] = this[ie] = { accessors: {} }).accessors,
                    n = this.prototype;
                function r(e) {
                    var r = ae(e);
                    t[r] ||
                        (!(function (e, t) {
                            var n = P.toCamelCase(" " + t);
                            ["get", "set", "has"].forEach(function (r) {
                                Object.defineProperty(e, r + n, {
                                    value: function (e, n, o) {
                                        return this[r].call(this, t, e, n, o);
                                    },
                                    configurable: !0,
                                });
                            });
                        })(n, e),
                        (t[r] = !0));
                }
                return P.isArray(e) ? e.forEach(r) : r(e), this;
            },
        }),
        le.accessor([
            "Content-Type",
            "Content-Length",
            "Accept",
            "Accept-Encoding",
            "User-Agent",
        ]),
        P.freezeMethods(le.prototype),
        P.freezeMethods(le);
    var pe = { http: he, xhr: he },
        me = function (e) {
            if (P.isString(e)) {
                var t = pe[e];
                if (!e)
                    throw Error(
                        P.hasOwnProp(e)
                            ? "Adapter '".concat(
                                  e,
                                  "' is not available in the build"
                              )
                            : "Can not resolve adapter '".concat(e, "'")
                    );
                return t;
            }
            if (!P.isFunction(e))
                throw new TypeError("adapter is not a function");
            return e;
        },
        ve = { "Content-Type": "application/x-www-form-urlencoded" };
    var ye,
        be = {
            transitional: X,
            adapter:
                ("undefined" != typeof XMLHttpRequest
                    ? (ye = me("xhr"))
                    : "undefined" != typeof process &&
                      "process" === P.kindOf(process) &&
                      (ye = me("http")),
                ye),
            transformRequest: [
                function (e, t) {
                    var n,
                        r = t.getContentType() || "",
                        o = r.indexOf("application/json") > -1,
                        i = P.isObject(e);
                    if (
                        (i && P.isHTMLForm(e) && (e = new FormData(e)),
                        P.isFormData(e))
                    )
                        return o && o ? JSON.stringify(Z(e)) : e;
                    if (
                        P.isArrayBuffer(e) ||
                        P.isBuffer(e) ||
                        P.isStream(e) ||
                        P.isFile(e) ||
                        P.isBlob(e)
                    )
                        return e;
                    if (P.isArrayBufferView(e)) return e.buffer;
                    if (P.isURLSearchParams(e))
                        return (
                            t.setContentType(
                                "application/x-www-form-urlencoded;charset=utf-8",
                                !1
                            ),
                            e.toString()
                        );
                    if (i) {
                        if (r.indexOf("application/x-www-form-urlencoded") > -1)
                            return (function (e, t) {
                                return q(
                                    e,
                                    new Y.classes.URLSearchParams(),
                                    Object.assign(
                                        {
                                            visitor: function (e, t, n, r) {
                                                return Y.isNode && P.isBuffer(e)
                                                    ? (this.append(
                                                          t,
                                                          e.toString("base64")
                                                      ),
                                                      !1)
                                                    : r.defaultVisitor.apply(
                                                          this,
                                                          arguments
                                                      );
                                            },
                                        },
                                        t
                                    )
                                );
                            })(e, this.formSerializer).toString();
                        if (
                            (n = P.isFileList(e)) ||
                            r.indexOf("multipart/form-data") > -1
                        ) {
                            var s = this.env && this.env.FormData;
                            return q(
                                n ? { "files[]": e } : e,
                                s && new s(),
                                this.formSerializer
                            );
                        }
                    }
                    return i || o
                        ? (t.setContentType("application/json", !1),
                          (function (e, t, n) {
                              if (P.isString(e))
                                  try {
                                      return (t || JSON.parse)(e), P.trim(e);
                                  } catch (e) {
                                      if ("SyntaxError" !== e.name) throw e;
                                  }
                              return (n || JSON.stringify)(e);
                          })(e))
                        : e;
                },
            ],
            transformResponse: [
                function (e) {
                    var t = this.transitional || be.transitional,
                        n = t && t.forcedJSONParsing,
                        r = "json" === this.responseType;
                    if (
                        e &&
                        P.isString(e) &&
                        ((n && !this.responseType) || r)
                    ) {
                        var o = !(t && t.silentJSONParsing) && r;
                        try {
                            return JSON.parse(e);
                        } catch (e) {
                            if (o) {
                                if ("SyntaxError" === e.name)
                                    throw _.from(
                                        e,
                                        _.ERR_BAD_RESPONSE,
                                        this,
                                        null,
                                        this.response
                                    );
                                throw e;
                            }
                        }
                    }
                    return e;
                },
            ],
            timeout: 0,
            xsrfCookieName: "XSRF-TOKEN",
            xsrfHeaderName: "X-XSRF-TOKEN",
            maxContentLength: -1,
            maxBodyLength: -1,
            env: { FormData: Y.classes.FormData, Blob: Y.classes.Blob },
            validateStatus: function (e) {
                return e >= 200 && e < 300;
            },
            headers: {
                common: { Accept: "application/json, text/plain, */*" },
            },
        };
    function ge(e, t) {
        var n = this || be,
            r = t || n,
            o = le.from(r.headers),
            i = r.data;
        return (
            P.forEach(e, function (e) {
                i = e.call(n, i, o.normalize(), t ? t.status : void 0);
            }),
            o.normalize(),
            i
        );
    }
    function Ee(e) {
        return !(!e || !e.__CANCEL__);
    }
    function we(e) {
        if (
            (e.cancelToken && e.cancelToken.throwIfRequested(),
            e.signal && e.signal.aborted)
        )
            throw new re();
    }
    function Oe(e) {
        return (
            we(e),
            (e.headers = le.from(e.headers)),
            (e.data = ge.call(e, e.transformRequest)),
            (e.adapter || be.adapter)(e).then(
                function (t) {
                    return (
                        we(e),
                        (t.data = ge.call(e, e.transformResponse, t)),
                        (t.headers = le.from(t.headers)),
                        t
                    );
                },
                function (t) {
                    return (
                        Ee(t) ||
                            (we(e),
                            t &&
                                t.response &&
                                ((t.response.data = ge.call(
                                    e,
                                    e.transformResponse,
                                    t.response
                                )),
                                (t.response.headers = le.from(
                                    t.response.headers
                                )))),
                        Promise.reject(t)
                    );
                }
            )
        );
    }
    function Se(e, t) {
        t = t || {};
        var n = {};
        function r(e, t) {
            return P.isPlainObject(e) && P.isPlainObject(t)
                ? P.merge(e, t)
                : P.isPlainObject(t)
                ? P.merge({}, t)
                : P.isArray(t)
                ? t.slice()
                : t;
        }
        function o(n) {
            return P.isUndefined(t[n])
                ? P.isUndefined(e[n])
                    ? void 0
                    : r(void 0, e[n])
                : r(e[n], t[n]);
        }
        function i(e) {
            if (!P.isUndefined(t[e])) return r(void 0, t[e]);
        }
        function s(n) {
            return P.isUndefined(t[n])
                ? P.isUndefined(e[n])
                    ? void 0
                    : r(void 0, e[n])
                : r(void 0, t[n]);
        }
        function a(n) {
            return n in t ? r(e[n], t[n]) : n in e ? r(void 0, e[n]) : void 0;
        }
        var u = {
            url: i,
            method: i,
            data: i,
            baseURL: s,
            transformRequest: s,
            transformResponse: s,
            paramsSerializer: s,
            timeout: s,
            timeoutMessage: s,
            withCredentials: s,
            adapter: s,
            responseType: s,
            xsrfCookieName: s,
            xsrfHeaderName: s,
            onUploadProgress: s,
            onDownloadProgress: s,
            decompress: s,
            maxContentLength: s,
            maxBodyLength: s,
            beforeRedirect: s,
            transport: s,
            httpAgent: s,
            httpsAgent: s,
            cancelToken: s,
            socketPath: s,
            responseEncoding: s,
            validateStatus: a,
        };
        return (
            P.forEach(Object.keys(e).concat(Object.keys(t)), function (e) {
                var t = u[e] || o,
                    r = t(e);
                (P.isUndefined(r) && t !== a) || (n[e] = r);
            }),
            n
        );
    }
    P.forEach(["delete", "get", "head"], function (e) {
        be.headers[e] = {};
    }),
        P.forEach(["post", "put", "patch"], function (e) {
            be.headers[e] = P.merge(ve);
        });
    var Re = "1.1.3",
        Ae = {};
    ["object", "boolean", "number", "function", "string", "symbol"].forEach(
        function (t, n) {
            Ae[t] = function (r) {
                return e(r) === t || "a" + (n < 1 ? "n " : " ") + t;
            };
        }
    );
    var je = {};
    Ae.transitional = function (e, t, n) {
        function r(e, t) {
            return (
                "[Axios v1.1.3] Transitional option '" +
                e +
                "'" +
                t +
                (n ? ". " + n : "")
            );
        }
        return function (n, o, i) {
            if (!1 === e)
                throw new _(
                    r(o, " has been removed" + (t ? " in " + t : "")),
                    _.ERR_DEPRECATED
                );
            return (
                t &&
                    !je[o] &&
                    ((je[o] = !0),
                    console.warn(
                        r(
                            o,
                            " has been deprecated since v" +
                                t +
                                " and will be removed in the near future"
                        )
                    )),
                !e || e(n, o, i)
            );
        };
    };
    var Te = {
            assertOptions: function (t, n, r) {
                if ("object" !== e(t))
                    throw new _(
                        "options must be an object",
                        _.ERR_BAD_OPTION_VALUE
                    );
                for (var o = Object.keys(t), i = o.length; i-- > 0; ) {
                    var s = o[i],
                        a = n[s];
                    if (a) {
                        var u = t[s],
                            c = void 0 === u || a(u, s, t);
                        if (!0 !== c)
                            throw new _(
                                "option " + s + " must be " + c,
                                _.ERR_BAD_OPTION_VALUE
                            );
                    } else if (!0 !== r)
                        throw new _("Unknown option " + s, _.ERR_BAD_OPTION);
                }
            },
            validators: Ae,
        },
        xe = Te.validators,
        Ce = (function () {
            function e(n) {
                t(this, e),
                    (this.defaults = n),
                    (this.interceptors = {
                        request: new K(),
                        response: new K(),
                    });
            }
            return (
                r(e, [
                    {
                        key: "request",
                        value: function (e, t) {
                            "string" == typeof e
                                ? ((t = t || {}).url = e)
                                : (t = e || {});
                            var n = (t = Se(this.defaults, t)),
                                r = n.transitional,
                                o = n.paramsSerializer;
                            void 0 !== r &&
                                Te.assertOptions(
                                    r,
                                    {
                                        silentJSONParsing: xe.transitional(
                                            xe.boolean
                                        ),
                                        forcedJSONParsing: xe.transitional(
                                            xe.boolean
                                        ),
                                        clarifyTimeoutError: xe.transitional(
                                            xe.boolean
                                        ),
                                    },
                                    !1
                                ),
                                void 0 !== o &&
                                    Te.assertOptions(
                                        o,
                                        {
                                            encode: xe.function,
                                            serialize: xe.function,
                                        },
                                        !0
                                    ),
                                (t.method = (
                                    t.method ||
                                    this.defaults.method ||
                                    "get"
                                ).toLowerCase());
                            var i =
                                t.headers &&
                                P.merge(t.headers.common, t.headers[t.method]);
                            i &&
                                P.forEach(
                                    [
                                        "delete",
                                        "get",
                                        "head",
                                        "post",
                                        "put",
                                        "patch",
                                        "common",
                                    ],
                                    function (e) {
                                        delete t.headers[e];
                                    }
                                ),
                                (t.headers = new le(t.headers, i));
                            var s = [],
                                a = !0;
                            this.interceptors.request.forEach(function (e) {
                                ("function" == typeof e.runWhen &&
                                    !1 === e.runWhen(t)) ||
                                    ((a = a && e.synchronous),
                                    s.unshift(e.fulfilled, e.rejected));
                            });
                            var u,
                                c = [];
                            this.interceptors.response.forEach(function (e) {
                                c.push(e.fulfilled, e.rejected);
                            });
                            var f,
                                l = 0;
                            if (!a) {
                                var d = [Oe.bind(this), void 0];
                                for (
                                    d.unshift.apply(d, s),
                                        d.push.apply(d, c),
                                        f = d.length,
                                        u = Promise.resolve(t);
                                    l < f;

                                )
                                    u = u.then(d[l++], d[l++]);
                                return u;
                            }
                            f = s.length;
                            var h = t;
                            for (l = 0; l < f; ) {
                                var p = s[l++],
                                    m = s[l++];
                                try {
                                    h = p(h);
                                } catch (e) {
                                    m.call(this, e);
                                    break;
                                }
                            }
                            try {
                                u = Oe.call(this, h);
                            } catch (e) {
                                return Promise.reject(e);
                            }
                            for (l = 0, f = c.length; l < f; )
                                u = u.then(c[l++], c[l++]);
                            return u;
                        },
                    },
                    {
                        key: "getUri",
                        value: function (e) {
                            return V(
                                te((e = Se(this.defaults, e)).baseURL, e.url),
                                e.params,
                                e.paramsSerializer
                            );
                        },
                    },
                ]),
                e
            );
        })();
    P.forEach(["delete", "get", "head", "options"], function (e) {
        Ce.prototype[e] = function (t, n) {
            return this.request(
                Se(n || {}, { method: e, url: t, data: (n || {}).data })
            );
        };
    }),
        P.forEach(["post", "put", "patch"], function (e) {
            function t(t) {
                return function (n, r, o) {
                    return this.request(
                        Se(o || {}, {
                            method: e,
                            headers: t
                                ? { "Content-Type": "multipart/form-data" }
                                : {},
                            url: n,
                            data: r,
                        })
                    );
                };
            }
            (Ce.prototype[e] = t()), (Ce.prototype[e + "Form"] = t(!0));
        });
    var Ne = (function () {
        function e(n) {
            if ((t(this, e), "function" != typeof n))
                throw new TypeError("executor must be a function.");
            var r;
            this.promise = new Promise(function (e) {
                r = e;
            });
            var o = this;
            this.promise.then(function (e) {
                if (o._listeners) {
                    for (var t = o._listeners.length; t-- > 0; )
                        o._listeners[t](e);
                    o._listeners = null;
                }
            }),
                (this.promise.then = function (e) {
                    var t,
                        n = new Promise(function (e) {
                            o.subscribe(e), (t = e);
                        }).then(e);
                    return (
                        (n.cancel = function () {
                            o.unsubscribe(t);
                        }),
                        n
                    );
                }),
                n(function (e, t, n) {
                    o.reason || ((o.reason = new re(e, t, n)), r(o.reason));
                });
        }
        return (
            r(
                e,
                [
                    {
                        key: "throwIfRequested",
                        value: function () {
                            if (this.reason) throw this.reason;
                        },
                    },
                    {
                        key: "subscribe",
                        value: function (e) {
                            this.reason
                                ? e(this.reason)
                                : this._listeners
                                ? this._listeners.push(e)
                                : (this._listeners = [e]);
                        },
                    },
                    {
                        key: "unsubscribe",
                        value: function (e) {
                            if (this._listeners) {
                                var t = this._listeners.indexOf(e);
                                -1 !== t && this._listeners.splice(t, 1);
                            }
                        },
                    },
                ],
                [
                    {
                        key: "source",
                        value: function () {
                            var t;
                            return {
                                token: new e(function (e) {
                                    t = e;
                                }),
                                cancel: t,
                            };
                        },
                    },
                ]
            ),
            e
        );
    })();
    var Pe = (function e(t) {
        var n = new Ce(t),
            r = o(Ce.prototype.request, n);
        return (
            P.extend(r, Ce.prototype, n, { allOwnKeys: !0 }),
            P.extend(r, n, null, { allOwnKeys: !0 }),
            (r.create = function (n) {
                return e(Se(t, n));
            }),
            r
        );
    })(be);
    return (
        (Pe.Axios = Ce),
        (Pe.CanceledError = re),
        (Pe.CancelToken = Ne),
        (Pe.isCancel = Ee),
        (Pe.VERSION = Re),
        (Pe.toFormData = q),
        (Pe.AxiosError = _),
        (Pe.Cancel = Pe.CanceledError),
        (Pe.all = function (e) {
            return Promise.all(e);
        }),
        (Pe.spread = function (e) {
            return function (t) {
                return e.apply(null, t);
            };
        }),
        (Pe.isAxiosError = function (e) {
            return P.isObject(e) && !0 === e.isAxiosError;
        }),
        (Pe.formToJSON = function (e) {
            return Z(P.isHTMLForm(e) ? new FormData(e) : e);
        }),
        Pe
    );
});
//# sourceMappingURL=axios.min.js.map
