import k, { useState as f, useRef as $, useCallback as E, useEffect as d } from "react";
const z = (e) => {
  const [t, n] = f(0), [r, a] = f(!1), o = $(null), s = E(() => {
    o.current && n(o.current.height);
  }, []);
  return d(() => {
    const u = () => {
      a(!0), s();
    }, h = o.current;
    return h && (h.complete ? u() : h.addEventListener("load", u)), typeof window < "u" && window.addEventListener("resize", s), () => {
      h && h.removeEventListener("load", u), typeof window < "u" && window.removeEventListener("resize", s);
    };
  }, [e, s]), [o, t, r];
};
class v {
  constructor() {
    this.observer = null, this.callbacks = /* @__PURE__ */ new Map(), this.visibilityStates = /* @__PURE__ */ new Map();
  }
  initializeObserver() {
    typeof window > "u" || this.observer || (this.observer = new IntersectionObserver(
      (t) => {
        t.forEach((n) => {
          const r = n.target, a = this.callbacks.get(r), o = this.visibilityStates.get(r), s = n.isIntersecting;
          a && o !== s && (this.visibilityStates.set(r, s), a(s));
        });
      },
      {
        threshold: 0,
        rootMargin: "16px"
      }
    ));
  }
  static getInstance() {
    return v.instance || (v.instance = new v()), v.instance;
  }
  observe(t, n) {
    this.initializeObserver(), this.observer && (this.callbacks.set(t, n), this.visibilityStates.set(t, !1), this.observer.observe(t));
  }
  unobserve(t) {
    this.callbacks.delete(t), this.visibilityStates.delete(t), this.observer && this.observer.unobserve(t);
  }
  disconnect() {
    this.observer && this.observer.disconnect(), this.callbacks.clear(), this.visibilityStates.clear();
  }
}
const L = v.getInstance(), P = () => {
  const [e, t] = f(!1), [n, r] = f(!1), a = $(null), o = $();
  return d(() => {
    r(!0);
  }, []), d(() => {
    o.current = (s) => {
      t(s);
    };
  }), d(() => {
    if (!n) return;
    const s = a.current;
    if (!(!s || !o.current))
      return L.observe(s, o.current), () => {
        s && (L.unobserve(s), L.disconnect());
      };
  }, [n]), [a, e];
};
class I {
  constructor() {
    this.currentScrollY = 0, this.isScrolling = !1, this.scrollTimeoutId = null, this.scrollingListener = null, this.handleScroll = () => {
      typeof window > "u" || (this.currentScrollY = window.scrollY, this.isScrolling || (this.isScrolling = !0, this.notifyScrollingState(!0)), this.scrollTimeoutId !== null && clearTimeout(this.scrollTimeoutId), this.scrollTimeoutId = window.setTimeout(() => {
        this.isScrolling = !1, this.notifyScrollingState(!1);
      }, 100));
    }, typeof window < "u" && (window.addEventListener("scroll", this.handleScroll, { passive: !0 }), this.currentScrollY = window.scrollY);
  }
  static getInstance() {
    return I.instance || (I.instance = new I()), I.instance;
  }
  notifyScrollingState(t) {
    this.scrollingListener && this.scrollingListener(t);
  }
  onScrollingChange(t) {
    this.scrollingListener = t, t(this.isScrolling);
  }
  getScrollY() {
    return this.currentScrollY;
  }
}
const H = I.getInstance();
class y {
  constructor() {
    this.callbacks = /* @__PURE__ */ new Set(), this.animationFrameId = null, this.visibleElementsCount = 0, this.isScrolling = !1, H.onScrollingChange((t) => {
      this.isScrolling = t, this.updateRAFState();
    });
  }
  static getInstance() {
    return y.instance || (y.instance = new y()), y.instance;
  }
  register(t) {
    this.callbacks.add(t), this.visibleElementsCount++, this.updateRAFState();
  }
  unregister(t) {
    this.callbacks.has(t) && (this.callbacks.delete(t), this.visibleElementsCount = Math.max(0, this.visibleElementsCount - 1), this.updateRAFState());
  }
  updateRAFState() {
    const t = this.isScrolling && this.visibleElementsCount > 0;
    t && this.animationFrameId === null ? this.startRAF() : !t && this.animationFrameId !== null && this.stopRAF();
  }
  startRAF() {
    if (typeof window > "u") return;
    const t = () => {
      this.callbacks.forEach((n) => n()), this.animationFrameId = requestAnimationFrame(t);
    };
    this.animationFrameId = requestAnimationFrame(t);
  }
  stopRAF() {
    typeof window < "u" && this.animationFrameId !== null && (cancelAnimationFrame(this.animationFrameId), this.animationFrameId = null);
  }
}
const A = y.getInstance(), N = (e, t) => e * t - e, B = (e, t) => Math.ceil(e / 100 * t - t / 2), O = (e, t) => {
  const { top: n, height: r } = e;
  let a = -r;
  const o = t;
  if (n < a)
    return 0;
  if (n > o)
    return 100;
  const s = (n - a) / (o - a) * 100;
  return Math.round(Math.min(Math.max(s, 0), 100) * 100) / 100;
}, j = (e, t) => {
  switch (t) {
    case "up":
      return `0, ${e}px, 0`;
    case "right":
      return `${-e}px, 0, 0`;
    case "down":
      return `0, ${-e}px, 0`;
    case "left":
      return `${e}px, 0, 0`;
    case "up left":
      return `${e}px, ${e}px, 0`;
    case "up right":
      return `${-e}px, ${e}px, 0`;
    case "down left":
      return `${e}px, ${-e}px, 0`;
    case "down right":
      return `${-e}px, ${-e}px, 0`;
    default:
      return `0, ${e}px, 0`;
  }
}, q = () => {
  const [e, t] = f(null);
  return d(() => {
    const n = () => {
      t(window.innerHeight);
    };
    if (typeof window < "u")
      return t(window.innerHeight), window.addEventListener("resize", n), () => {
        window.removeEventListener("resize", n);
      };
  }, []), e;
}, G = ({
  isLoaded: e,
  imageHeight: t,
  scale: n,
  boundingClientRect: r,
  orientation: a,
  maxTransition: o
}) => {
  const [s, u] = f(""), h = $({
    rangeMax: 0,
    lastImageHeight: 0,
    lastScale: 0,
    lastTranslateValue: -999999,
    lastTransformString: ""
  }), l = q();
  return d(() => {
    if (!e || !r || !l)
      return;
    const i = h.current;
    (i.lastImageHeight !== t || i.lastScale !== n) && (i.rangeMax = N(t, n), i.lastImageHeight = t, i.lastScale = n);
    let g = O(r, l);
    o && (g = Math.min(g, 100 - o));
    const m = B(g, i.rangeMax);
    if (i.lastTranslateValue !== m) {
      const p = j(m, a);
      p !== i.lastTransformString && (i.lastTranslateValue = m, i.lastTransformString = p, u(p));
    }
  }, [
    e,
    t,
    n,
    r,
    a,
    o,
    l
  ]), s;
}, W = () => {
  const [e, t] = f(!1);
  return d(() => {
    if (typeof window > "u")
      return;
    const n = window.matchMedia("(prefers-reduced-motion: reduce)");
    t(n.matches);
    const r = (a) => {
      t(a.matches);
    };
    return n.addEventListener("change", r), () => {
      n.removeEventListener("change", r);
    };
  }, []), e;
}, D = ({
  scale: e,
  overflow: t,
  delay: n,
  transition: r,
  orientation: a,
  maxTransition: o,
  isVisible: s,
  isLoaded: u,
  imageHeight: h,
  imageRef: l
}) => {
  const [i, g] = f(!1), [m, p] = f(0), [F, T] = f(
    null
  ), [x, Y] = f(!1), c = W(), b = E(() => {
    var V;
    if (c || i && !s)
      return;
    const w = H.getScrollY();
    if (i && w === m)
      return;
    const S = (V = l.current) == null ? void 0 : V.getBoundingClientRect();
    S && T(S), i || setTimeout(() => {
      Y(!0), g(!0);
    }, 50), p(w);
  }, [c, s, i, m, l]), M = G({
    isLoaded: u,
    imageHeight: h,
    scale: e,
    boundingClientRect: F,
    orientation: a,
    maxTransition: o
  }), C = E(
    (w) => {
      if (!l.current || c || !w) return;
      let S = `translate3d(${w})`;
      t || (S += ` scale(${e})`), l.current.style.transform = S;
    },
    [l, e, t, c]
  ), R = E(() => {
    if (!l.current || c) return;
    const w = typeof navigator < "u" && /^((?!chrome|android).)*safari/i.test(navigator.userAgent), S = n > 0 && !w ? `all ${n}s ${r}` : "";
    l.current.style.transition = S;
  }, [l, n, r, c]);
  d(() => (s && !c ? A.register(b) : A.unregister(b), () => {
    A.unregister(b);
  }), [s, c, b]), d(() => {
    u && l.current && !c && !i && b();
  }, [u, c, i, b]), d(() => {
    M && (s || !i) && (C(M), i || g(!0));
  }, [M, s, i, C]), d(() => {
    !t && u && l.current && !c && (l.current.style.transform = `scale(${e})`);
  }, [e, t, u, c]), d(() => {
    x && R();
  }, [x, R]), d(() => {
    c && l.current && (l.current.style.transform = "", l.current.style.transition = "");
  }, [c]);
};
var Q = "/Users/geoffrey/Desktop/perso/simpleParallax.js/src/react/index.tsx";
const J = ({
  delay: e = 0.4,
  orientation: t = "up",
  scale: n = 1.4,
  overflow: r = !1,
  transition: a = "cubic-bezier(0,0,0,1)",
  maxTransition: o = null,
  children: s
}) => {
  var x;
  const u = t ?? "up", h = n ?? 1.2, l = (x = s == null ? void 0 : s.props) == null ? void 0 : x.src, [i, g, m] = z(l), [p, F] = P();
  D({
    scale: h,
    overflow: r,
    delay: e,
    transition: a,
    orientation: u,
    maxTransition: o,
    isVisible: F,
    isLoaded: m,
    imageHeight: g,
    imageRef: i
  });
  const T = k.isValidElement(s) ? k.cloneElement(s, {
    ref: i
  }) : null;
  return /* @__PURE__ */ k.createElement("div", { ref: p, style: {
    overflow: r ? "visible" : "hidden"
  }, __self: void 0, __source: {
    fileName: Q,
    lineNumber: 43,
    columnNumber: 3
  } }, T);
};
export {
  J as default
};
