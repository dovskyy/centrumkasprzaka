/* @ds-bundle: {"format":4,"namespace":"CMKasprzakaDesignSystem_10ef77","components":[{"name":"Badge","sourcePath":"components/core/Badge.jsx"},{"name":"Button","sourcePath":"components/core/Button.jsx"},{"name":"Card","sourcePath":"components/core/Card.jsx"},{"name":"Icon","sourcePath":"components/core/Icon.jsx"},{"name":"IconButton","sourcePath":"components/core/IconButton.jsx"},{"name":"Stat","sourcePath":"components/core/Stat.jsx"},{"name":"Tag","sourcePath":"components/core/Tag.jsx"},{"name":"Wordmark","sourcePath":"components/core/Wordmark.jsx"},{"name":"Alert","sourcePath":"components/feedback/Alert.jsx"},{"name":"Dialog","sourcePath":"components/feedback/Dialog.jsx"},{"name":"Spinner","sourcePath":"components/feedback/Spinner.jsx"},{"name":"Toast","sourcePath":"components/feedback/Toast.jsx"},{"name":"Tooltip","sourcePath":"components/feedback/Tooltip.jsx"},{"name":"Checkbox","sourcePath":"components/forms/Checkbox.jsx"},{"name":"FormField","sourcePath":"components/forms/FormField.jsx"},{"name":"Input","sourcePath":"components/forms/Input.jsx"},{"name":"Radio","sourcePath":"components/forms/Radio.jsx"},{"name":"Select","sourcePath":"components/forms/Select.jsx"},{"name":"Switch","sourcePath":"components/forms/Switch.jsx"},{"name":"Textarea","sourcePath":"components/forms/Textarea.jsx"},{"name":"Breadcrumbs","sourcePath":"components/navigation/Breadcrumbs.jsx"},{"name":"SiteFooter","sourcePath":"components/navigation/SiteFooter.jsx"},{"name":"SiteHeader","sourcePath":"components/navigation/SiteHeader.jsx"},{"name":"Tabs","sourcePath":"components/navigation/Tabs.jsx"},{"name":"AppointmentCard","sourcePath":"components/patterns/AppointmentCard.jsx"},{"name":"DoctorCard","sourcePath":"components/patterns/DoctorCard.jsx"},{"name":"PriceRow","sourcePath":"components/patterns/PriceRow.jsx"},{"name":"SectionHeading","sourcePath":"components/patterns/SectionHeading.jsx"},{"name":"ServiceCard","sourcePath":"components/patterns/ServiceCard.jsx"},{"name":"SlotPicker","sourcePath":"components/patterns/SlotPicker.jsx"},{"name":"StatBar","sourcePath":"components/patterns/StatBar.jsx"}],"sourceHashes":{"components/core/Badge.jsx":"04a0d4ed2fda","components/core/Button.jsx":"a875021c2ee3","components/core/Card.jsx":"9576ac80a925","components/core/Icon.jsx":"59a6ea608c2e","components/core/IconButton.jsx":"44c9b2b1d5b9","components/core/Stat.jsx":"954dec5d1aee","components/core/Tag.jsx":"1e1fb256d408","components/core/Wordmark.jsx":"d725112a785e","components/feedback/Alert.jsx":"fa94fb4d5af5","components/feedback/Dialog.jsx":"0b1e9c868772","components/feedback/Spinner.jsx":"53e19a1cd0f4","components/feedback/Toast.jsx":"c7b4cac9c9e6","components/feedback/Tooltip.jsx":"69a3d180f9d6","components/forms/Checkbox.jsx":"e80436d06485","components/forms/FormField.jsx":"63998b96afd6","components/forms/Input.jsx":"4317f8c287c7","components/forms/Radio.jsx":"4a0ac24d03da","components/forms/Select.jsx":"04611bfb5a1e","components/forms/Switch.jsx":"05a79578afc8","components/forms/Textarea.jsx":"1cceb1eda5af","components/navigation/Breadcrumbs.jsx":"57e5f6e7aaff","components/navigation/SiteFooter.jsx":"82e0690d884a","components/navigation/SiteHeader.jsx":"6101e9047c38","components/navigation/Tabs.jsx":"18699cd395ac","components/patterns/AppointmentCard.jsx":"5fa653aa0259","components/patterns/DoctorCard.jsx":"2f53b458b296","components/patterns/PriceRow.jsx":"0bed6cde1055","components/patterns/SectionHeading.jsx":"fb33d73eb8c8","components/patterns/ServiceCard.jsx":"fd89e0f976e0","components/patterns/SlotPicker.jsx":"f7a1072028f5","components/patterns/StatBar.jsx":"38a057e4c0b2","ui_kits/portal/Dashboard.jsx":"58a2002d6b98","ui_kits/portal/Shell.jsx":"5e5fddc5f0f2","ui_kits/portal/Visits.jsx":"48db407266a8","ui_kits/website/Booking.jsx":"9459c6ad0833","ui_kits/website/Home.jsx":"10ad52622caf","ui_kits/website/Specialty.jsx":"8a7dfe13762a"},"inlinedExternals":[],"unexposedExports":[]} */

(() => {

const __ds_ns = (window.CMKasprzakaDesignSystem_10ef77 = window.CMKasprzakaDesignSystem_10ef77 || {});

const __ds_scope = {};

(__ds_ns.__errors = __ds_ns.__errors || []);

// components/core/Card.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Surface container: white, 18px radius, hairline border, soft navy shadow. */
function Card({
  children,
  padding = 24,
  interactive = false,
  tone = 'default',
  style,
  ...rest
}) {
  const [h, setH] = React.useState(false);
  const tones = {
    default: {
      background: 'var(--surface-card)',
      border: '1px solid var(--border-subtle)',
      color: 'var(--text-body)'
    },
    subtle: {
      background: 'var(--surface-subtle)',
      border: '1px solid transparent',
      color: 'var(--text-body)'
    },
    navy: {
      background: 'var(--surface-inverse)',
      border: '1px solid transparent',
      color: 'rgba(255,255,255,.82)'
    },
    accent: {
      background: 'var(--surface-accent)',
      border: '1px solid var(--blue-200)',
      color: 'var(--text-body)'
    }
  };
  return /*#__PURE__*/React.createElement("div", _extends({
    onMouseEnter: () => setH(true),
    onMouseLeave: () => setH(false)
  }, rest, {
    style: {
      borderRadius: 'var(--radius-card)',
      padding,
      boxShadow: interactive && h ? 'var(--shadow-md)' : 'var(--shadow-xs)',
      transform: interactive && h ? 'translateY(-3px)' : 'none',
      transition: 'box-shadow var(--duration-base) var(--ease-standard),transform var(--duration-base) var(--ease-standard),border-color var(--duration-base) var(--ease-standard)',
      cursor: interactive ? 'pointer' : 'default',
      ...tones[tone],
      ...(interactive && h ? {
        borderColor: 'var(--blue-200)'
      } : null),
      ...style
    }
  }), children);
}
Object.assign(__ds_scope, { Card });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Card.jsx", error: String((e && e.message) || e) }); }

// components/core/Icon.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const BASE = 'https://unpkg.com/lucide-static@0.544.0/icons/';
/** Lucide icon rendered as a CSS mask so it inherits currentColor. */
function Icon({
  name = 'activity',
  size = 20,
  strokeWidth,
  color = 'currentColor',
  style,
  ...rest
}) {
  const url = `url("${BASE}${name}.svg")`;
  return /*#__PURE__*/React.createElement("span", _extends({
    "aria-hidden": "true"
  }, rest, {
    style: {
      display: 'inline-block',
      flex: '0 0 auto',
      width: size,
      height: size,
      backgroundColor: color,
      WebkitMaskImage: url,
      maskImage: url,
      WebkitMaskRepeat: 'no-repeat',
      maskRepeat: 'no-repeat',
      WebkitMaskSize: 'contain',
      maskSize: 'contain',
      WebkitMaskPosition: 'center',
      maskPosition: 'center',
      ...style
    }
  }));
}
Object.assign(__ds_scope, { Icon });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Icon.jsx", error: String((e && e.message) || e) }); }

// components/core/Badge.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const TONES = {
  neutral: {
    bg: 'var(--grey-100)',
    fg: 'var(--grey-700)'
  },
  brand: {
    bg: 'var(--blue-100)',
    fg: 'var(--blue-700)'
  },
  navy: {
    bg: 'var(--navy-100)',
    fg: 'var(--navy-800)'
  },
  success: {
    bg: 'var(--success-100)',
    fg: 'var(--success-600)'
  },
  warning: {
    bg: 'var(--warning-100)',
    fg: 'var(--warning-600)'
  },
  danger: {
    bg: 'var(--danger-100)',
    fg: 'var(--danger-600)'
  },
  teal: {
    bg: 'var(--teal-100)',
    fg: 'var(--teal-600)'
  }
};
/** Small status pill. */
function Badge({
  children,
  tone = 'neutral',
  icon,
  dot = false,
  style,
  ...rest
}) {
  const t = TONES[tone] || TONES.neutral;
  return /*#__PURE__*/React.createElement("span", _extends({}, rest, {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 6,
      padding: '5px 11px',
      borderRadius: 'var(--radius-pill)',
      background: t.bg,
      color: t.fg,
      fontFamily: 'var(--font-display)',
      fontSize: 12,
      fontWeight: 'var(--weight-semibold)',
      lineHeight: 1.4,
      letterSpacing: '.01em',
      ...style
    }
  }), dot && /*#__PURE__*/React.createElement("span", {
    style: {
      width: 6,
      height: 6,
      borderRadius: '50%',
      background: 'currentColor'
    }
  }), icon && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: 13
  }), children);
}
Object.assign(__ds_scope, { Badge });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Badge.jsx", error: String((e && e.message) || e) }); }

// components/core/Button.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const SIZES = {
  sm: {
    h: 38,
    px: 16,
    fs: 14,
    gap: 8
  },
  md: {
    h: 46,
    px: 22,
    fs: 15,
    gap: 9
  },
  lg: {
    h: 56,
    px: 30,
    fs: 17,
    gap: 10
  }
};
const VARIANTS = {
  primary: {
    background: 'var(--action-primary)',
    color: 'var(--white)',
    border: '1px solid transparent',
    boxShadow: 'var(--shadow-sm)'
  },
  navy: {
    background: 'var(--action-secondary)',
    color: 'var(--white)',
    border: '1px solid transparent',
    boxShadow: 'var(--shadow-navy)'
  },
  secondary: {
    background: 'var(--white)',
    color: 'var(--navy-800)',
    border: '1px solid var(--border-default)',
    boxShadow: 'var(--shadow-xs)'
  },
  ghost: {
    background: 'transparent',
    color: 'var(--navy-800)',
    border: '1px solid transparent',
    boxShadow: 'none'
  },
  onDark: {
    background: 'rgba(255,255,255,.14)',
    color: 'var(--white)',
    border: '1px solid rgba(255,255,255,.34)',
    backdropFilter: 'blur(14px)',
    boxShadow: 'none'
  }
};
const HOVER = {
  primary: 'var(--action-primary-hover)',
  navy: 'var(--navy-950)',
  secondary: 'var(--navy-050)',
  ghost: 'var(--navy-050)',
  onDark: 'rgba(255,255,255,.24)'
};
/** Primary call-to-action control. */
function Button({
  children,
  variant = 'primary',
  size = 'md',
  icon,
  iconAfter,
  fullWidth = false,
  disabled = false,
  as = 'button',
  style,
  ...rest
}) {
  const s = SIZES[size] || SIZES.md,
    v = VARIANTS[variant] || VARIANTS.primary;
  const [hover, setHover] = React.useState(false),
    [down, setDown] = React.useState(false);
  const Tag = as;
  return /*#__PURE__*/React.createElement(Tag, _extends({
    disabled: as === 'button' ? disabled : undefined,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => {
      setHover(false);
      setDown(false);
    },
    onMouseDown: () => setDown(true),
    onMouseUp: () => setDown(false)
  }, rest, {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      justifyContent: 'center',
      gap: s.gap,
      height: s.h,
      padding: `0 ${s.px}px`,
      width: fullWidth ? '100%' : undefined,
      fontFamily: 'var(--font-display)',
      fontSize: s.fs,
      fontWeight: 'var(--weight-semibold)',
      letterSpacing: '-0.005em',
      borderRadius: 'var(--radius-pill)',
      cursor: disabled ? 'not-allowed' : 'pointer',
      textDecoration: 'none',
      transition: 'var(--transition-control)',
      opacity: disabled ? .45 : 1,
      transform: down && !disabled ? 'scale(.975)' : 'none',
      ...v,
      ...(hover && !disabled ? {
        background: HOVER[variant]
      } : null),
      ...style
    }
  }), icon && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: size === 'lg' ? 20 : 18
  }), children, iconAfter && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: iconAfter,
    size: size === 'lg' ? 20 : 18
  }));
}
Object.assign(__ds_scope, { Button });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Button.jsx", error: String((e && e.message) || e) }); }

// components/core/IconButton.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const S = {
  sm: 34,
  md: 42,
  lg: 50
};
/** Circular icon-only control. */
function IconButton({
  icon = 'search',
  size = 'md',
  variant = 'secondary',
  label,
  style,
  ...rest
}) {
  const d = S[size] || S.md;
  const [h, setH] = React.useState(false);
  const v = variant === 'primary' ? {
    background: 'var(--action-primary)',
    color: 'var(--white)',
    border: '1px solid transparent'
  } : variant === 'onDark' ? {
    background: 'rgba(255,255,255,.14)',
    color: 'var(--white)',
    border: '1px solid rgba(255,255,255,.3)'
  } : variant === 'ghost' ? {
    background: 'transparent',
    color: 'var(--navy-800)',
    border: '1px solid transparent'
  } : {
    background: 'var(--white)',
    color: 'var(--navy-800)',
    border: '1px solid var(--border-subtle)'
  };
  return /*#__PURE__*/React.createElement("button", _extends({
    "aria-label": label,
    onMouseEnter: () => setH(true),
    onMouseLeave: () => setH(false)
  }, rest, {
    style: {
      width: d,
      height: d,
      display: 'inline-flex',
      alignItems: 'center',
      justifyContent: 'center',
      borderRadius: 'var(--radius-pill)',
      cursor: 'pointer',
      transition: 'var(--transition-control)',
      boxShadow: h ? 'var(--shadow-sm)' : 'none',
      ...v,
      ...(h && variant === 'secondary' ? {
        background: 'var(--navy-050)'
      } : null),
      ...style
    }
  }), /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: size === 'lg' ? 22 : 18
  }));
}
Object.assign(__ds_scope, { IconButton });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/IconButton.jsx", error: String((e && e.message) || e) }); }

// components/core/Stat.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Big number + caption, used in hero stat bars. */
function Stat({
  value,
  label,
  icon,
  tone = 'light',
  align = 'left',
  style,
  ...rest
}) {
  const fg = tone === 'light' ? 'var(--white)' : 'var(--navy-900)';
  const mut = tone === 'light' ? 'rgba(255,255,255,.74)' : 'var(--text-muted)';
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      textAlign: align,
      ...style
    }
  }), icon && /*#__PURE__*/React.createElement("span", {
    style: {
      width: 44,
      height: 44,
      borderRadius: 'var(--radius-pill)',
      display: 'grid',
      placeItems: 'center',
      flex: '0 0 auto',
      background: tone === 'light' ? 'rgba(255,255,255,.16)' : 'var(--blue-100)',
      color: tone === 'light' ? 'var(--white)' : 'var(--blue-600)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: 20
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontFamily: 'var(--font-display)',
      fontSize: 28,
      fontWeight: 'var(--weight-extrabold)',
      letterSpacing: '-0.02em',
      color: fg,
      lineHeight: 1.1
    }
  }, value), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontSize: 14,
      color: mut
    }
  }, label)));
}
Object.assign(__ds_scope, { Stat });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Stat.jsx", error: String((e && e.message) || e) }); }

// components/core/Tag.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Selectable filter chip. */
function Tag({
  children,
  selected = false,
  icon,
  onClick,
  style,
  ...rest
}) {
  const [h, setH] = React.useState(false);
  return /*#__PURE__*/React.createElement("button", _extends({
    onClick: onClick,
    onMouseEnter: () => setH(true),
    onMouseLeave: () => setH(false)
  }, rest, {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 7,
      padding: '8px 15px',
      borderRadius: 'var(--radius-pill)',
      cursor: 'pointer',
      fontFamily: 'var(--font-display)',
      fontSize: 14,
      fontWeight: 'var(--weight-medium)',
      transition: 'var(--transition-control)',
      background: selected ? 'var(--navy-800)' : h ? 'var(--navy-050)' : 'var(--white)',
      color: selected ? 'var(--white)' : 'var(--navy-800)',
      border: `1px solid ${selected ? 'var(--navy-800)' : 'var(--border-subtle)'}`,
      ...style
    }
  }), icon && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: 15
  }), children);
}
Object.assign(__ds_scope, { Tag });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Tag.jsx", error: String((e && e.message) || e) }); }

// components/core/Wordmark.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Typographic stand-in for the CMK lockup — the real logo file has not been supplied. */
function Wordmark({
  size = 20,
  tone = 'navy',
  style,
  ...rest
}) {
  const fg = tone === 'light' ? 'var(--white)' : 'var(--navy-900)';
  const sub = tone === 'light' ? 'rgba(255,255,255,.72)' : 'var(--blue-600)';
  return /*#__PURE__*/React.createElement("span", _extends({}, rest, {
    style: {
      display: 'inline-flex',
      flexDirection: 'column',
      lineHeight: 1.02,
      fontFamily: 'var(--font-display)',
      color: fg,
      ...style
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: size,
      fontWeight: 'var(--weight-extrabold)',
      letterSpacing: '-0.03em'
    }
  }, "Centrum Medyczne"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: size,
      fontWeight: 'var(--weight-extrabold)',
      letterSpacing: '-0.03em'
    }
  }, "Kasprzaka"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: Math.round(size * 0.44),
      fontWeight: 'var(--weight-semibold)',
      letterSpacing: '.22em',
      textTransform: 'uppercase',
      color: sub,
      marginTop: 4
    }
  }, "Warszawa"));
}
Object.assign(__ds_scope, { Wordmark });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Wordmark.jsx", error: String((e && e.message) || e) }); }

// components/feedback/Alert.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const T = {
  info: {
    bg: 'var(--blue-100)',
    fg: 'var(--blue-700)',
    icon: 'info'
  },
  success: {
    bg: 'var(--success-100)',
    fg: 'var(--success-600)',
    icon: 'circle-check'
  },
  warning: {
    bg: 'var(--warning-100)',
    fg: 'var(--warning-600)',
    icon: 'triangle-alert'
  },
  danger: {
    bg: 'var(--danger-100)',
    fg: 'var(--danger-600)',
    icon: 'circle-alert'
  }
};
/** Inline message banner. */
function Alert({
  tone = 'info',
  title,
  children,
  style,
  ...rest
}) {
  const t = T[tone] || T.info;
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'flex',
      gap: 12,
      padding: '14px 16px',
      borderRadius: 'var(--radius-md)',
      background: t.bg,
      color: 'var(--text-body)',
      ...style
    }
  }), /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: t.icon,
    size: 20,
    color: t.fg,
    style: {
      marginTop: 1
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      minWidth: 0
    }
  }, title && /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 15,
      fontWeight: 'var(--weight-semibold)',
      color: t.fg,
      marginBottom: children ? 3 : 0
    }
  }, title), children && /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14,
      lineHeight: 1.5
    }
  }, children)));
}
Object.assign(__ds_scope, { Alert });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/feedback/Alert.jsx", error: String((e && e.message) || e) }); }

// components/feedback/Dialog.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Centred modal over a navy scrim. */
function Dialog({
  open = true,
  title,
  description,
  children,
  footer,
  onClose,
  width = 520,
  style,
  ...rest
}) {
  if (!open) return null;
  return /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'fixed',
      inset: 0,
      zIndex: 60,
      display: 'grid',
      placeItems: 'center',
      padding: 24,
      background: 'rgba(10,19,48,.55)',
      backdropFilter: 'blur(4px)'
    },
    onClick: onClose
  }, /*#__PURE__*/React.createElement("div", _extends({
    onClick: e => e.stopPropagation()
  }, rest, {
    style: {
      width: '100%',
      maxWidth: width,
      background: 'var(--white)',
      borderRadius: 'var(--radius-lg)',
      boxShadow: 'var(--shadow-lg)',
      padding: 28,
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'flex-start',
      gap: 16,
      marginBottom: description ? 8 : 16
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, title && /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 22,
      fontWeight: 'var(--weight-bold)',
      letterSpacing: '-0.015em',
      color: 'var(--navy-900)'
    }
  }, title)), onClose && /*#__PURE__*/React.createElement("button", {
    onClick: onClose,
    "aria-label": "Zamknij",
    style: {
      border: 'none',
      background: 'var(--grey-100)',
      width: 34,
      height: 34,
      borderRadius: '50%',
      cursor: 'pointer',
      display: 'grid',
      placeItems: 'center'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "x",
    size: 17,
    color: "var(--grey-600)"
  }))), description && /*#__PURE__*/React.createElement("p", {
    style: {
      fontSize: 15,
      color: 'var(--text-muted)',
      marginBottom: 20
    }
  }, description), children, footer && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'flex-end',
      gap: 10,
      marginTop: 24
    }
  }, footer)));
}
Object.assign(__ds_scope, { Dialog });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/feedback/Dialog.jsx", error: String((e && e.message) || e) }); }

// components/feedback/Spinner.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Indeterminate loading ring. */
function Spinner({
  size = 24,
  color = 'var(--action-primary)',
  style,
  ...rest
}) {
  const id = 'cmk-spin';
  return /*#__PURE__*/React.createElement("span", _extends({}, rest, {
    style: {
      display: 'inline-block',
      width: size,
      height: size,
      ...style
    }
  }), /*#__PURE__*/React.createElement("style", null, `@keyframes ${id}{to{transform:rotate(360deg)}}`), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      width: '100%',
      height: '100%',
      borderRadius: '50%',
      border: `${Math.max(2, size / 10)}px solid var(--grey-200)`,
      borderTopColor: color,
      animation: `${id} .8s linear infinite`
    }
  }));
}
Object.assign(__ds_scope, { Spinner });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/feedback/Spinner.jsx", error: String((e && e.message) || e) }); }

// components/feedback/Toast.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Floating confirmation message. */
function Toast({
  tone = 'success',
  title,
  children,
  onClose,
  style,
  ...rest
}) {
  const fg = tone === 'danger' ? 'var(--danger-600)' : tone === 'warning' ? 'var(--warning-600)' : 'var(--success-600)';
  const icon = tone === 'danger' ? 'circle-alert' : tone === 'warning' ? 'triangle-alert' : 'circle-check';
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'flex',
      alignItems: 'flex-start',
      gap: 12,
      minWidth: 300,
      maxWidth: 420,
      padding: '14px 16px',
      borderRadius: 'var(--radius-md)',
      background: 'var(--white)',
      border: '1px solid var(--border-subtle)',
      boxShadow: 'var(--shadow-lg)',
      ...style
    }
  }), /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: 20,
    color: fg,
    style: {
      marginTop: 1
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, title && /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 15,
      fontWeight: 'var(--weight-semibold)',
      color: 'var(--navy-900)'
    }
  }, title), children && /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14,
      color: 'var(--text-muted)',
      marginTop: 2
    }
  }, children)), onClose && /*#__PURE__*/React.createElement("button", {
    onClick: onClose,
    "aria-label": "Zamknij",
    style: {
      border: 'none',
      background: 'transparent',
      cursor: 'pointer',
      padding: 2,
      lineHeight: 0
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "x",
    size: 16,
    color: "var(--grey-400)"
  })));
}
Object.assign(__ds_scope, { Toast });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/feedback/Toast.jsx", error: String((e && e.message) || e) }); }

// components/feedback/Tooltip.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Dark hover hint. */
function Tooltip({
  label,
  children,
  placement = 'top',
  style,
  ...rest
}) {
  const [show, setShow] = React.useState(false);
  const pos = placement === 'bottom' ? {
    top: 'calc(100% + 8px)'
  } : {
    bottom: 'calc(100% + 8px)'
  };
  return /*#__PURE__*/React.createElement("span", _extends({}, rest, {
    onMouseEnter: () => setShow(true),
    onMouseLeave: () => setShow(false),
    style: {
      position: 'relative',
      display: 'inline-flex',
      ...style
    }
  }), children, show && /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      left: '50%',
      transform: 'translateX(-50%)',
      ...pos,
      whiteSpace: 'nowrap',
      background: 'var(--navy-900)',
      color: 'var(--white)',
      fontSize: 13,
      fontFamily: 'var(--font-display)',
      fontWeight: 'var(--weight-medium)',
      padding: '6px 10px',
      borderRadius: 'var(--radius-xs)',
      boxShadow: 'var(--shadow-md)',
      zIndex: 40
    }
  }, label));
}
Object.assign(__ds_scope, { Tooltip });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/feedback/Tooltip.jsx", error: String((e && e.message) || e) }); }

// components/forms/Checkbox.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Square checkbox with label. */
function Checkbox({
  checked = false,
  onChange,
  label,
  disabled = false,
  style,
  ...rest
}) {
  return /*#__PURE__*/React.createElement("label", _extends({}, rest, {
    style: {
      display: 'inline-flex',
      alignItems: 'flex-start',
      gap: 10,
      cursor: disabled ? 'not-allowed' : 'pointer',
      opacity: disabled ? .5 : 1,
      ...style
    }
  }), /*#__PURE__*/React.createElement("input", {
    type: "checkbox",
    checked: checked,
    onChange: onChange,
    disabled: disabled,
    style: {
      position: 'absolute',
      opacity: 0,
      width: 0,
      height: 0
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      width: 20,
      height: 20,
      flex: '0 0 auto',
      marginTop: 2,
      borderRadius: 'var(--radius-xs)',
      display: 'grid',
      placeItems: 'center',
      background: checked ? 'var(--action-primary)' : 'var(--white)',
      border: `1px solid ${checked ? 'var(--action-primary)' : 'var(--border-default)'}`,
      transition: 'var(--transition-control)'
    }
  }, checked && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "check",
    size: 14,
    color: "var(--white)"
  })), label && /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: 15,
      color: 'var(--text-body)',
      lineHeight: 1.45
    }
  }, label));
}
Object.assign(__ds_scope, { Checkbox });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/forms/Checkbox.jsx", error: String((e && e.message) || e) }); }

// components/forms/FormField.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Label + hint + error wrapper for any control. */
function FormField({
  label,
  hint,
  error,
  required = false,
  htmlFor,
  children,
  style,
  ...rest
}) {
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 7,
      ...style
    }
  }), label && /*#__PURE__*/React.createElement("label", {
    htmlFor: htmlFor,
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 14,
      fontWeight: 'var(--weight-semibold)',
      color: 'var(--navy-800)'
    }
  }, label, required && /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--danger-600)',
      marginLeft: 3
    }
  }, "*")), children, (error || hint) && /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: 13,
      color: error ? 'var(--danger-600)' : 'var(--text-muted)'
    }
  }, error || hint));
}
Object.assign(__ds_scope, { FormField });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/forms/FormField.jsx", error: String((e && e.message) || e) }); }

// components/forms/Input.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const box = (focus, invalid, disabled) => ({
  display: 'flex',
  alignItems: 'center',
  gap: 10,
  height: 48,
  padding: '0 16px',
  borderRadius: 'var(--radius-sm)',
  background: disabled ? 'var(--surface-disabled)' : 'var(--white)',
  border: `1px solid ${invalid ? 'var(--danger-600)' : focus ? 'var(--border-focus)' : 'var(--border-default)'}`,
  boxShadow: focus ? 'var(--shadow-focus)' : 'none',
  transition: 'var(--transition-control)'
});
/** Single-line text field. */
function Input({
  icon,
  type = 'text',
  placeholder,
  value,
  onChange,
  invalid = false,
  disabled = false,
  suffix,
  style,
  ...rest
}) {
  const [focus, setFocus] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", {
    style: {
      ...box(focus, invalid, disabled),
      ...style
    }
  }, icon && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: 18,
    color: focus ? 'var(--blue-600)' : 'var(--grey-400)'
  }), /*#__PURE__*/React.createElement("input", _extends({
    type: type,
    placeholder: placeholder,
    value: value,
    onChange: onChange,
    disabled: disabled,
    onFocus: () => setFocus(true),
    onBlur: () => setFocus(false)
  }, rest, {
    style: {
      flex: 1,
      minWidth: 0,
      border: 'none',
      outline: 'none',
      background: 'transparent',
      fontFamily: 'var(--font-body)',
      fontSize: 16,
      color: 'var(--text-strong)'
    }
  })), suffix);
}
Object.assign(__ds_scope, { Input });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/forms/Input.jsx", error: String((e && e.message) || e) }); }

// components/forms/Radio.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Radio option with label. */
function Radio({
  checked = false,
  onChange,
  label,
  name,
  value,
  disabled = false,
  style,
  ...rest
}) {
  return /*#__PURE__*/React.createElement("label", _extends({}, rest, {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 10,
      cursor: disabled ? 'not-allowed' : 'pointer',
      opacity: disabled ? .5 : 1,
      ...style
    }
  }), /*#__PURE__*/React.createElement("input", {
    type: "radio",
    name: name,
    value: value,
    checked: checked,
    onChange: onChange,
    disabled: disabled,
    style: {
      position: 'absolute',
      opacity: 0,
      width: 0,
      height: 0
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      width: 20,
      height: 20,
      flex: '0 0 auto',
      borderRadius: '50%',
      display: 'grid',
      placeItems: 'center',
      background: 'var(--white)',
      border: `1px solid ${checked ? 'var(--action-primary)' : 'var(--border-default)'}`,
      transition: 'var(--transition-control)'
    }
  }, checked && /*#__PURE__*/React.createElement("span", {
    style: {
      width: 10,
      height: 10,
      borderRadius: '50%',
      background: 'var(--action-primary)'
    }
  })), label && /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: 15,
      color: 'var(--text-body)'
    }
  }, label));
}
Object.assign(__ds_scope, { Radio });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/forms/Radio.jsx", error: String((e && e.message) || e) }); }

// components/forms/Select.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Native select styled to match Input. */
function Select({
  options = [],
  value,
  onChange,
  placeholder,
  disabled = false,
  icon,
  style,
  ...rest
}) {
  const [focus, setFocus] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      height: 48,
      padding: '0 16px',
      borderRadius: 'var(--radius-sm)',
      background: disabled ? 'var(--surface-disabled)' : 'var(--white)',
      border: `1px solid ${focus ? 'var(--border-focus)' : 'var(--border-default)'}`,
      boxShadow: focus ? 'var(--shadow-focus)' : 'none',
      transition: 'var(--transition-control)',
      ...style
    }
  }, icon && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: 18,
    color: focus ? 'var(--blue-600)' : 'var(--grey-400)'
  }), /*#__PURE__*/React.createElement("select", _extends({
    value: value,
    onChange: onChange,
    disabled: disabled,
    onFocus: () => setFocus(true),
    onBlur: () => setFocus(false)
  }, rest, {
    style: {
      flex: 1,
      minWidth: 0,
      appearance: 'none',
      border: 'none',
      outline: 'none',
      background: 'transparent',
      fontFamily: 'var(--font-body)',
      fontSize: 16,
      color: value ? 'var(--text-strong)' : 'var(--grey-400)',
      cursor: disabled ? 'not-allowed' : 'pointer'
    }
  }), placeholder && /*#__PURE__*/React.createElement("option", {
    value: ""
  }, placeholder), options.map(o => {
    const v = typeof o === 'string' ? o : o.value,
      l = typeof o === 'string' ? o : o.label;
    return /*#__PURE__*/React.createElement("option", {
      key: v,
      value: v
    }, l);
  })), /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "chevron-down",
    size: 18,
    color: "var(--grey-500)"
  }));
}
Object.assign(__ds_scope, { Select });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/forms/Select.jsx", error: String((e && e.message) || e) }); }

// components/forms/Switch.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Binary toggle. */
function Switch({
  checked = false,
  onChange,
  label,
  disabled = false,
  style,
  ...rest
}) {
  return /*#__PURE__*/React.createElement("label", _extends({}, rest, {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 12,
      cursor: disabled ? 'not-allowed' : 'pointer',
      opacity: disabled ? .5 : 1,
      ...style
    }
  }), /*#__PURE__*/React.createElement("span", {
    onClick: () => !disabled && onChange && onChange(!checked),
    style: {
      width: 46,
      height: 26,
      borderRadius: 'var(--radius-pill)',
      padding: 3,
      background: checked ? 'var(--action-primary)' : 'var(--grey-300)',
      transition: 'background-color var(--duration-base) var(--ease-standard)',
      display: 'flex'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 20,
      height: 20,
      borderRadius: '50%',
      background: 'var(--white)',
      boxShadow: 'var(--shadow-xs)',
      transform: checked ? 'translateX(20px)' : 'none',
      transition: 'transform var(--duration-base) var(--ease-out)'
    }
  })), label && /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: 15,
      color: 'var(--text-body)'
    }
  }, label));
}
Object.assign(__ds_scope, { Switch });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/forms/Switch.jsx", error: String((e && e.message) || e) }); }

// components/forms/Textarea.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Multi-line text field. */
function Textarea({
  placeholder,
  value,
  onChange,
  rows = 4,
  invalid = false,
  disabled = false,
  style,
  ...rest
}) {
  const [focus, setFocus] = React.useState(false);
  return /*#__PURE__*/React.createElement("textarea", _extends({
    rows: rows,
    placeholder: placeholder,
    value: value,
    onChange: onChange,
    disabled: disabled,
    onFocus: () => setFocus(true),
    onBlur: () => setFocus(false)
  }, rest, {
    style: {
      width: '100%',
      padding: '14px 16px',
      borderRadius: 'var(--radius-sm)',
      background: disabled ? 'var(--surface-disabled)' : 'var(--white)',
      border: `1px solid ${invalid ? 'var(--danger-600)' : focus ? 'var(--border-focus)' : 'var(--border-default)'}`,
      boxShadow: focus ? 'var(--shadow-focus)' : 'none',
      outline: 'none',
      resize: 'vertical',
      fontFamily: 'var(--font-body)',
      fontSize: 16,
      lineHeight: 'var(--leading-snug)',
      color: 'var(--text-strong)',
      transition: 'var(--transition-control)',
      ...style
    }
  }));
}
Object.assign(__ds_scope, { Textarea });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/forms/Textarea.jsx", error: String((e && e.message) || e) }); }

// components/navigation/Breadcrumbs.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Path trail above page titles. */
function Breadcrumbs({
  items = [],
  tone = 'dark',
  style,
  ...rest
}) {
  const mut = tone === 'light' ? 'rgba(255,255,255,.7)' : 'var(--text-muted)';
  const cur = tone === 'light' ? 'var(--white)' : 'var(--navy-800)';
  return /*#__PURE__*/React.createElement("nav", _extends({}, rest, {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      fontSize: 14,
      ...style
    }
  }), items.map((it, i) => {
    const last = i === items.length - 1;
    const l = typeof it === 'string' ? it : it.label;
    return /*#__PURE__*/React.createElement(React.Fragment, {
      key: i
    }, i > 0 && /*#__PURE__*/React.createElement(__ds_scope.Icon, {
      name: "chevron-right",
      size: 14,
      color: mut
    }), /*#__PURE__*/React.createElement("span", {
      style: {
        color: last ? cur : mut,
        fontWeight: last ? 'var(--weight-semibold)' : 'var(--weight-regular)'
      }
    }, l));
  }));
}
Object.assign(__ds_scope, { Breadcrumbs });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/navigation/Breadcrumbs.jsx", error: String((e && e.message) || e) }); }

// components/navigation/SiteFooter.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Navy site footer with contact block and link columns. */
function SiteFooter({
  columns = [],
  style,
  ...rest
}) {
  return /*#__PURE__*/React.createElement("footer", _extends({}, rest, {
    style: {
      background: 'var(--surface-inverse)',
      color: 'rgba(255,255,255,.72)',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '56px var(--gutter) 28px',
      display: 'grid',
      gridTemplateColumns: '1.4fr repeat(3,1fr)',
      gap: 40
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(__ds_scope.Wordmark, {
    size: 17,
    tone: "light"
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 18,
      fontSize: 14.5,
      lineHeight: 1.6,
      maxWidth: 300
    }
  }, "Wielospecjalistyczna klinika prywatnej opieki medycznej na warszawskiej Woli."), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 9,
      marginTop: 18,
      fontSize: 14.5
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 9
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "map-pin",
    size: 16
  }), "ul. Kasprzaka 31 lok. U7, 01-255 Warszawa"), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 9,
      color: 'var(--white)',
      fontWeight: 'var(--weight-semibold)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "phone",
    size: 16
  }), "+48 727 500 085"), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 9
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "mail",
    size: 16
  }), "rejestracja@cmkasprzaka.pl"))), columns.map(c => /*#__PURE__*/React.createElement("div", {
    key: c.title
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 13,
      fontWeight: 'var(--weight-bold)',
      letterSpacing: 'var(--tracking-eyebrow)',
      textTransform: 'uppercase',
      color: 'var(--white)',
      marginBottom: 16
    }
  }, c.title), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 10,
      fontSize: 14.5
    }
  }, c.links.map(l => /*#__PURE__*/React.createElement("span", {
    key: l,
    style: {
      cursor: 'pointer'
    }
  }, l)))))), /*#__PURE__*/React.createElement("div", {
    style: {
      borderTop: '1px solid rgba(255,255,255,.12)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '18px var(--gutter)',
      display: 'flex',
      justifyContent: 'space-between',
      fontSize: 13.5
    }
  }, /*#__PURE__*/React.createElement("span", null, "\xA9 2026 Centrum Medyczne Kasprzaka"), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'flex',
      gap: 22
    }
  }, /*#__PURE__*/React.createElement("span", null, "RODO"), /*#__PURE__*/React.createElement("span", null, "Polityka prywatno\u015Bci")))));
}
Object.assign(__ds_scope, { SiteFooter });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/navigation/SiteFooter.jsx", error: String((e && e.message) || e) }); }

// components/navigation/SiteHeader.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Marketing site top bar: utility strip + nav + booking CTA. */
function SiteHeader({
  items = [],
  active,
  onNavigate,
  tone = 'light',
  phone = '+48 727 500 085',
  showUtility = true,
  style,
  ...rest
}) {
  const dark = tone === 'dark';
  const fg = dark ? 'var(--white)' : 'var(--navy-800)';
  return /*#__PURE__*/React.createElement("header", _extends({}, rest, {
    style: {
      width: '100%',
      ...style
    }
  }), showUtility && /*#__PURE__*/React.createElement("div", {
    style: {
      background: dark ? 'rgba(255,255,255,.08)' : 'var(--navy-900)',
      color: dark ? 'var(--white)' : 'rgba(255,255,255,.86)',
      fontSize: 13.5
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '9px var(--gutter)',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "map-pin",
    size: 15
  }), "ul. Kasprzaka 31 lok. U7, 01-255 Warszawa"), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 22
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "clock",
    size: 15
  }), "Pn\u2013Pt 8:00\u201320:00 \xB7 Sb 9:00\u201314:00"), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 8,
      fontWeight: 'var(--weight-semibold)',
      color: 'var(--white)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "phone",
    size: 15
  }), phone)))), /*#__PURE__*/React.createElement("div", {
    style: {
      background: dark ? 'transparent' : 'var(--white)',
      borderBottom: dark ? '1px solid rgba(255,255,255,.14)' : '1px solid var(--border-subtle)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '14px var(--gutter)',
      display: 'flex',
      alignItems: 'center',
      gap: 32
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Wordmark, {
    size: 15,
    tone: dark ? 'light' : 'navy'
  }), /*#__PURE__*/React.createElement("nav", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 4,
      marginLeft: 'auto'
    }
  }, items.map(it => {
    const v = typeof it === 'string' ? it : it.value,
      l = typeof it === 'string' ? it : it.label,
      on = v === active;
    return /*#__PURE__*/React.createElement("button", {
      key: v,
      onClick: () => onNavigate && onNavigate(v),
      style: {
        border: 'none',
        cursor: 'pointer',
        padding: '9px 16px',
        borderRadius: 'var(--radius-pill)',
        fontFamily: 'var(--font-display)',
        fontSize: 15,
        fontWeight: on ? 'var(--weight-semibold)' : 'var(--weight-medium)',
        color: on ? dark ? 'var(--navy-900)' : 'var(--white)' : fg,
        background: on ? dark ? 'var(--white)' : 'var(--navy-800)' : 'transparent',
        transition: 'var(--transition-control)'
      }
    }, l);
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.IconButton, {
    icon: "search",
    label: "Szukaj",
    variant: dark ? 'onDark' : 'secondary'
  }), /*#__PURE__*/React.createElement(__ds_scope.Button, {
    variant: dark ? 'onDark' : 'primary',
    icon: "calendar-check"
  }, "Zapisz si\u0119 online")))));
}
Object.assign(__ds_scope, { SiteHeader });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/navigation/SiteHeader.jsx", error: String((e && e.message) || e) }); }

// components/navigation/Tabs.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Underlined tab bar. */
function Tabs({
  items = [],
  value,
  onChange,
  style,
  ...rest
}) {
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'flex',
      gap: 28,
      borderBottom: '1px solid var(--border-subtle)',
      ...style
    }
  }), items.map(it => {
    const v = typeof it === 'string' ? it : it.value,
      l = typeof it === 'string' ? it : it.label,
      on = v === value;
    return /*#__PURE__*/React.createElement("button", {
      key: v,
      onClick: () => onChange && onChange(v),
      style: {
        border: 'none',
        background: 'transparent',
        padding: '0 0 14px',
        cursor: 'pointer',
        fontFamily: 'var(--font-display)',
        fontSize: 15,
        fontWeight: on ? 'var(--weight-bold)' : 'var(--weight-medium)',
        color: on ? 'var(--navy-900)' : 'var(--text-muted)',
        borderBottom: `2px solid ${on ? 'var(--action-primary)' : 'transparent'}`,
        marginBottom: -1,
        transition: 'var(--transition-control)'
      }
    }, l);
  }));
}
Object.assign(__ds_scope, { Tabs });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/navigation/Tabs.jsx", error: String((e && e.message) || e) }); }

// components/patterns/AppointmentCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Visit summary row in the patient portal. */
function AppointmentCard({
  date,
  time,
  doctor,
  specialty,
  mode = 'W klinice',
  status = 'confirmed',
  onCancel,
  onDetails,
  style,
  ...rest
}) {
  const tones = {
    confirmed: ['success', 'Potwierdzona'],
    pending: ['warning', 'Oczekuje'],
    done: ['neutral', 'Zrealizowana'],
    cancelled: ['danger', 'Odwołana']
  };
  const [tone, label] = tones[status] || tones.confirmed;
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 20,
      padding: '18px 20px',
      borderRadius: 'var(--radius-card)',
      background: 'var(--white)',
      border: '1px solid var(--border-subtle)',
      boxShadow: 'var(--shadow-xs)',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      width: 78,
      flex: '0 0 auto',
      textAlign: 'center',
      padding: '12px 6px',
      borderRadius: 'var(--radius-md)',
      background: 'var(--navy-050)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 22,
      fontWeight: 'var(--weight-extrabold)',
      color: 'var(--navy-900)',
      lineHeight: 1.1
    }
  }, date), /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 13.5,
      color: 'var(--blue-600)',
      fontWeight: 'var(--weight-semibold)'
    }
  }, time)), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 16.5,
      fontWeight: 'var(--weight-bold)',
      color: 'var(--navy-900)'
    }
  }, doctor), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 16,
      marginTop: 5,
      fontSize: 14,
      color: 'var(--text-muted)'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 6
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "stethoscope",
    size: 15
  }), specialty), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 6
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: mode === 'Online' ? 'video' : 'building-2',
    size: 15
  }), mode))), /*#__PURE__*/React.createElement(__ds_scope.Badge, {
    tone: tone,
    dot: true
  }, label), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8
    }
  }, onDetails && /*#__PURE__*/React.createElement("button", {
    onClick: onDetails,
    style: {
      border: '1px solid var(--border-subtle)',
      background: 'var(--white)',
      color: 'var(--navy-800)',
      fontFamily: 'var(--font-display)',
      fontWeight: 'var(--weight-semibold)',
      fontSize: 14,
      padding: '9px 15px',
      borderRadius: 'var(--radius-pill)',
      cursor: 'pointer'
    }
  }, "Szczeg\xF3\u0142y"), onCancel && /*#__PURE__*/React.createElement("button", {
    onClick: onCancel,
    style: {
      border: 'none',
      background: 'transparent',
      color: 'var(--text-muted)',
      fontSize: 14,
      padding: '9px 6px',
      borderRadius: 'var(--radius-pill)',
      cursor: 'pointer'
    }
  }, "Odwo\u0142aj")));
}
Object.assign(__ds_scope, { AppointmentCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/patterns/AppointmentCard.jsx", error: String((e && e.message) || e) }); }

// components/patterns/DoctorCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Specialist profile card with portrait, specialty and next free slot. */
function DoctorCard({
  name,
  specialty,
  photo,
  tags = [],
  nextSlot,
  onBook,
  style,
  ...rest
}) {
  const [h, setH] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({
    onMouseEnter: () => setH(true),
    onMouseLeave: () => setH(false)
  }, rest, {
    style: {
      borderRadius: 'var(--radius-card)',
      overflow: 'hidden',
      background: 'var(--white)',
      border: '1px solid var(--border-subtle)',
      boxShadow: h ? 'var(--shadow-md)' : 'var(--shadow-xs)',
      transform: h ? 'translateY(-3px)' : 'none',
      transition: 'var(--transition-control)',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      height: 230,
      background: 'var(--gradient-wash)',
      display: 'flex',
      alignItems: 'flex-end',
      justifyContent: 'center',
      overflow: 'hidden'
    }
  }, photo ? /*#__PURE__*/React.createElement("img", {
    src: photo,
    alt: name,
    style: {
      width: '100%',
      height: '100%',
      objectFit: 'contain',
      objectPosition: 'bottom',
      transform: h ? 'scale(1.03)' : 'none',
      transition: 'transform var(--duration-slow) var(--ease-out)'
    }
  }) : /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "user-round",
    size: 64,
    color: "var(--navy-200)",
    style: {
      marginBottom: 32
    }
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '18px 20px 20px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 17,
      fontWeight: 'var(--weight-bold)',
      color: 'var(--navy-900)'
    }
  }, name), /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14.5,
      color: 'var(--text-muted)',
      marginTop: 2
    }
  }, specialty), tags.length > 0 && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexWrap: 'wrap',
      gap: 6,
      marginTop: 12
    }
  }, tags.map(t => /*#__PURE__*/React.createElement(__ds_scope.Badge, {
    key: t,
    tone: "navy"
  }, t))), nextSlot && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 12,
      marginTop: 16,
      paddingTop: 14,
      borderTop: '1px solid var(--border-subtle)'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 7,
      fontSize: 14,
      color: 'var(--text-muted)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "calendar-clock",
    size: 16,
    color: "var(--blue-600)"
  }), nextSlot), /*#__PURE__*/React.createElement("button", {
    onClick: onBook,
    style: {
      border: 'none',
      background: 'var(--blue-100)',
      color: 'var(--blue-700)',
      fontFamily: 'var(--font-display)',
      fontWeight: 'var(--weight-semibold)',
      fontSize: 14,
      padding: '8px 14px',
      borderRadius: 'var(--radius-pill)',
      cursor: 'pointer',
      transition: 'var(--transition-control)'
    }
  }, "Um\xF3w"))));
}
Object.assign(__ds_scope, { DoctorCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/patterns/DoctorCard.jsx", error: String((e && e.message) || e) }); }

// components/patterns/PriceRow.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** One line of the cennik: service, optional note, price. */
function PriceRow({
  service,
  note,
  price,
  duration,
  style,
  ...rest
}) {
  const [h, setH] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({
    onMouseEnter: () => setH(true),
    onMouseLeave: () => setH(false)
  }, rest, {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 20,
      padding: '16px 20px',
      borderRadius: 'var(--radius-md)',
      background: h ? 'var(--navy-050)' : 'transparent',
      borderBottom: '1px solid var(--border-subtle)',
      transition: 'background-color var(--duration-base) var(--ease-standard)',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 16,
      fontWeight: 'var(--weight-semibold)',
      color: 'var(--navy-900)'
    }
  }, service), note && /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14,
      color: 'var(--text-muted)',
      marginTop: 3
    }
  }, note)), duration && /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 6,
      fontSize: 14,
      color: 'var(--text-muted)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: "clock",
    size: 15
  }), duration), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 18,
      fontWeight: 'var(--weight-bold)',
      color: 'var(--navy-900)',
      fontVariantNumeric: 'tabular-nums',
      minWidth: 110,
      textAlign: 'right'
    }
  }, price));
}
Object.assign(__ds_scope, { PriceRow });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/patterns/PriceRow.jsx", error: String((e && e.message) || e) }); }

// components/patterns/SectionHeading.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Eyebrow + title + lead, the standard section opener. */
function SectionHeading({
  eyebrow,
  title,
  lead,
  align = 'left',
  tone = 'dark',
  maxWidth = 680,
  style,
  ...rest
}) {
  const fg = tone === 'light' ? 'var(--white)' : 'var(--navy-900)';
  const mut = tone === 'light' ? 'rgba(255,255,255,.76)' : 'var(--text-muted)';
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      maxWidth,
      margin: align === 'center' ? '0 auto' : undefined,
      textAlign: align,
      ...style
    }
  }), eyebrow && /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 13,
      fontWeight: 'var(--weight-bold)',
      letterSpacing: 'var(--tracking-eyebrow)',
      textTransform: 'uppercase',
      color: tone === 'light' ? 'var(--blue-200)' : 'var(--blue-600)',
      marginBottom: 12
    }
  }, eyebrow), title && /*#__PURE__*/React.createElement("h2", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 'var(--text-h2)',
      fontWeight: 'var(--weight-extrabold)',
      letterSpacing: 'var(--tracking-display)',
      lineHeight: 'var(--leading-heading)',
      color: fg,
      margin: 0
    }
  }, title), lead && /*#__PURE__*/React.createElement("p", {
    style: {
      fontSize: 'var(--text-body-lg)',
      lineHeight: 'var(--leading-body)',
      color: mut,
      margin: '14px 0 0'
    }
  }, lead));
}
Object.assign(__ds_scope, { SectionHeading });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/patterns/SectionHeading.jsx", error: String((e && e.message) || e) }); }

// components/patterns/ServiceCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Specialty / service tile with icon, name and one-line description. */
function ServiceCard({
  icon = 'stethoscope',
  title,
  description,
  selected = false,
  onClick,
  style,
  ...rest
}) {
  const [h, setH] = React.useState(false);
  const on = selected;
  return /*#__PURE__*/React.createElement("div", _extends({
    onClick: onClick,
    onMouseEnter: () => setH(true),
    onMouseLeave: () => setH(false)
  }, rest, {
    style: {
      display: 'flex',
      gap: 16,
      padding: '22px 22px',
      borderRadius: 'var(--radius-card)',
      cursor: 'pointer',
      transition: 'var(--transition-control)',
      background: on ? 'var(--action-primary)' : 'var(--white)',
      border: `1px solid ${on ? 'var(--action-primary)' : h ? 'var(--blue-200)' : 'var(--border-subtle)'}`,
      boxShadow: h && !on ? 'var(--shadow-md)' : on ? 'var(--shadow-navy)' : 'var(--shadow-xs)',
      transform: h ? 'translateY(-3px)' : 'none',
      ...style
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      width: 46,
      height: 46,
      flex: '0 0 auto',
      borderRadius: 'var(--radius-md)',
      display: 'grid',
      placeItems: 'center',
      background: on ? 'rgba(255,255,255,.18)' : 'var(--blue-050)',
      color: on ? 'var(--white)' : 'var(--blue-600)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Icon, {
    name: icon,
    size: 23
  })), /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontFamily: 'var(--font-display)',
      fontSize: 17,
      fontWeight: 'var(--weight-bold)',
      letterSpacing: '-0.01em',
      color: on ? 'var(--white)' : 'var(--navy-900)'
    }
  }, title), description && /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      marginTop: 5,
      fontSize: 14.5,
      lineHeight: 1.5,
      color: on ? 'rgba(255,255,255,.82)' : 'var(--text-muted)'
    }
  }, description)));
}
Object.assign(__ds_scope, { ServiceCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/patterns/ServiceCard.jsx", error: String((e && e.message) || e) }); }

// components/patterns/SlotPicker.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Grid of bookable times for one day. */
function SlotPicker({
  slots = [],
  value,
  onChange,
  style,
  ...rest
}) {
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fill,minmax(88px,1fr))',
      gap: 10,
      ...style
    }
  }), slots.map(s => {
    const t = typeof s === 'string' ? s : s.time,
      dis = typeof s === 'object' && s.disabled,
      on = t === value;
    return /*#__PURE__*/React.createElement("button", {
      key: t,
      disabled: dis,
      onClick: () => onChange && onChange(t),
      style: {
        height: 44,
        borderRadius: 'var(--radius-sm)',
        cursor: dis ? 'not-allowed' : 'pointer',
        fontFamily: 'var(--font-display)',
        fontSize: 15,
        fontWeight: 'var(--weight-semibold)',
        transition: 'var(--transition-control)',
        background: on ? 'var(--action-primary)' : dis ? 'var(--grey-100)' : 'var(--white)',
        color: on ? 'var(--white)' : dis ? 'var(--grey-400)' : 'var(--navy-800)',
        border: `1px solid ${on ? 'var(--action-primary)' : dis ? 'transparent' : 'var(--border-default)'}`,
        textDecoration: dis ? 'line-through' : 'none'
      }
    }, t);
  }));
}
Object.assign(__ds_scope, { SlotPicker });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/patterns/SlotPicker.jsx", error: String((e && e.message) || e) }); }

// components/patterns/StatBar.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/** Row of metrics; glass over photography, or a white card on light sections. */
function StatBar({
  items = [],
  variant = 'glass',
  style,
  ...rest
}) {
  const glass = variant === 'glass';
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    style: {
      display: 'grid',
      gridTemplateColumns: `repeat(${items.length || 1},1fr)`,
      gap: 8,
      padding: '20px 28px',
      borderRadius: 'var(--radius-lg)',
      background: glass ? 'var(--glass-bg)' : 'var(--white)',
      border: glass ? 'var(--glass-border)' : '1px solid var(--border-subtle)',
      backdropFilter: glass ? 'var(--glass-blur)' : undefined,
      boxShadow: glass ? 'none' : 'var(--shadow-md)',
      ...style
    }
  }), items.map((it, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      paddingLeft: i ? 28 : 0,
      borderLeft: i ? `1px solid ${glass ? 'rgba(255,255,255,.22)' : 'var(--border-subtle)'}` : 'none'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Stat, _extends({}, it, {
    tone: glass ? 'light' : 'dark'
  })))));
}
Object.assign(__ds_scope, { StatBar });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/patterns/StatBar.jsx", error: String((e && e.message) || e) }); }

// ui_kits/portal/Dashboard.jsx
try { (() => {
const {
  Card,
  Button,
  Badge,
  Icon,
  Alert,
  AppointmentCard,
  Stat,
  SlotPicker
} = window.CMKasprzakaDesignSystem_10ef77;
function Dashboard({
  onBook,
  onNav
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '28px 32px',
      display: 'flex',
      flexDirection: 'column',
      gap: 22
    }
  }, /*#__PURE__*/React.createElement(Alert, {
    tone: "info",
    title: "Wyniki bada\u0144 laboratoryjnych s\u0105 gotowe"
  }, "Morfologia z 5 sierpnia \u2014 kliknij, aby pobra\u0107 PDF."), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 16
    }
  }, [['calendar-check', '2', 'Nadchodzące wizyty'], ['file-text', '5', 'Wyniki do odbioru'], ['pill', '1', 'Aktywna recepta'], ['wallet', '0 zł', 'Do zapłaty']].map(([i, v, l]) => /*#__PURE__*/React.createElement(Card, {
    key: l,
    padding: 20
  }, /*#__PURE__*/React.createElement(Stat, {
    icon: i,
    value: v,
    label: l,
    tone: "dark"
  })))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 340px',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 18,
      fontWeight: 700,
      color: 'var(--navy-900)'
    }
  }, "Nadchodz\u0105ce wizyty"), /*#__PURE__*/React.createElement(Button, {
    variant: "ghost",
    iconAfter: "arrow-right",
    size: "sm",
    onClick: () => onNav('Wizyty')
  }, "Wszystkie")), /*#__PURE__*/React.createElement(AppointmentCard, {
    date: "12 sie",
    time: "09:30",
    doctor: "dr n. med. Anna Kowalska",
    specialty: "Kardiologia",
    mode: "W klinice",
    status: "confirmed",
    onDetails: () => {},
    onCancel: () => {}
  }), /*#__PURE__*/React.createElement(AppointmentCard, {
    date: "26 sie",
    time: "17:00",
    doctor: "lek. Piotr Nowak",
    specialty: "Ortopedia",
    mode: "Online",
    status: "pending",
    onDetails: () => {},
    onCancel: () => {}
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 18,
      fontWeight: 700,
      color: 'var(--navy-900)',
      marginTop: 10
    }
  }, "Ostatnie wyniki"), /*#__PURE__*/React.createElement(Card, {
    padding: 8
  }, [['Morfologia krwi obwodowej', '5 sierpnia 2026', 'Gotowy'], ['USG jamy brzusznej', '22 lipca 2026', 'Gotowy'], ['Lipidogram', '2 lipca 2026', 'Gotowy']].map(([t, d, s], i) => /*#__PURE__*/React.createElement("div", {
    key: t,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 16,
      padding: '14px 16px',
      borderBottom: i < 2 ? '1px solid var(--border-subtle)' : 'none'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 38,
      height: 38,
      borderRadius: 'var(--radius-md)',
      background: 'var(--blue-050)',
      color: 'var(--blue-600)',
      display: 'grid',
      placeItems: 'center'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "file-text",
    size: 18
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontFamily: 'var(--font-display)',
      fontSize: 15.5,
      fontWeight: 600,
      color: 'var(--navy-900)'
    }
  }, t), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontSize: 13.5,
      color: 'var(--text-muted)'
    }
  }, d)), /*#__PURE__*/React.createElement(Badge, {
    tone: "success",
    dot: true
  }, s), /*#__PURE__*/React.createElement(Button, {
    variant: "secondary",
    size: "sm",
    icon: "download"
  }, "Pobierz"))))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement(Card, {
    padding: 22
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 17,
      fontWeight: 700,
      color: 'var(--navy-900)'
    }
  }, "Szybka rezerwacja"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14,
      color: 'var(--text-muted)',
      margin: '4px 0 16px'
    }
  }, "Wolne terminy na dzi\u015B, 7 sierpnia"), /*#__PURE__*/React.createElement(SlotPicker, {
    slots: ['14:00', {
      time: '14:30',
      disabled: true
    }, '15:00', '15:30'],
    value: "15:00",
    onChange: () => {}
  }), /*#__PURE__*/React.createElement(Button, {
    fullWidth: true,
    style: {
      marginTop: 16
    },
    onClick: onBook
  }, "Um\xF3w wizyt\u0119")), /*#__PURE__*/React.createElement(Card, {
    tone: "navy",
    padding: 22
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 17,
      fontWeight: 700,
      color: '#fff'
    }
  }, "Wizyty domowe"), /*#__PURE__*/React.createElement("p", {
    style: {
      fontSize: 14.5,
      margin: '8px 0 16px',
      lineHeight: 1.55
    }
  }, "Pediatra dojedzie do dziecka w tym samym dniu na terenie Woli i Bemowa."), /*#__PURE__*/React.createElement(Button, {
    variant: "onDark",
    size: "sm",
    iconAfter: "arrow-right"
  }, "Sprawd\u017A dost\u0119pno\u015B\u0107")))));
}
Object.assign(window, {
  Dashboard
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/portal/Dashboard.jsx", error: String((e && e.message) || e) }); }

// ui_kits/portal/Shell.jsx
try { (() => {
const {
  Icon,
  Badge,
  Wordmark,
  IconButton
} = window.CMKasprzakaDesignSystem_10ef77;
const NAV = [['layout-dashboard', 'Pulpit'], ['calendar-days', 'Wizyty'], ['file-text', 'Wyniki badań'], ['pill', 'Recepty'], ['file-heart', 'Dokumentacja'], ['settings', 'Ustawienia']];
function Sidebar({
  active,
  onNav
}) {
  return /*#__PURE__*/React.createElement("aside", {
    style: {
      width: 264,
      flex: '0 0 auto',
      minHeight: '100vh',
      background: 'var(--surface-inverse)',
      padding: '26px 18px',
      display: 'flex',
      flexDirection: 'column',
      gap: 26
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '0 8px'
    }
  }, /*#__PURE__*/React.createElement(Wordmark, {
    size: 15,
    tone: "light"
  })), /*#__PURE__*/React.createElement("nav", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 4
    }
  }, NAV.map(([i, l]) => {
    const on = l === active;
    return /*#__PURE__*/React.createElement("button", {
      key: l,
      onClick: () => onNav(l),
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 12,
        padding: '11px 14px',
        borderRadius: 'var(--radius-sm)',
        border: 'none',
        cursor: 'pointer',
        textAlign: 'left',
        fontFamily: 'var(--font-display)',
        fontSize: 15,
        fontWeight: on ? 600 : 500,
        color: on ? 'var(--white)' : 'rgba(255,255,255,.66)',
        background: on ? 'rgba(255,255,255,.12)' : 'transparent',
        transition: 'var(--transition-control)'
      }
    }, /*#__PURE__*/React.createElement(Icon, {
      name: i,
      size: 19
    }), l);
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 'auto',
      padding: 16,
      borderRadius: 'var(--radius-md)',
      background: 'rgba(255,255,255,.08)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 9,
      color: 'var(--white)',
      fontFamily: 'var(--font-display)',
      fontSize: 14.5,
      fontWeight: 600
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "phone",
    size: 16
  }), "Rejestracja"), /*#__PURE__*/React.createElement("div", {
    style: {
      color: 'rgba(255,255,255,.7)',
      fontSize: 14,
      marginTop: 6
    }
  }, "+48 727 500 085", /*#__PURE__*/React.createElement("br", null), "Pn\u2013Pt 8:00\u201320:00")));
}
function Topbar({
  title,
  subtitle,
  onBook
}) {
  const {
    Button
  } = window.CMKasprzakaDesignSystem_10ef77;
  return /*#__PURE__*/React.createElement("header", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 20,
      padding: '22px 32px',
      borderBottom: '1px solid var(--border-subtle)',
      background: 'var(--white)',
      position: 'sticky',
      top: 0,
      zIndex: 10
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 24,
      fontWeight: 800,
      letterSpacing: '-.02em',
      color: 'var(--navy-900)'
    }
  }, title), subtitle && /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14.5,
      color: 'var(--text-muted)',
      marginTop: 2
    }
  }, subtitle)), /*#__PURE__*/React.createElement(IconButton, {
    icon: "bell",
    label: "Powiadomienia"
  }), /*#__PURE__*/React.createElement(Button, {
    icon: "plus",
    onClick: onBook
  }, "Um\xF3w wizyt\u0119"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      paddingLeft: 16,
      borderLeft: '1px solid var(--border-subtle)'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 38,
      height: 38,
      borderRadius: '50%',
      background: 'var(--navy-100)',
      color: 'var(--navy-800)',
      display: 'grid',
      placeItems: 'center',
      fontFamily: 'var(--font-display)',
      fontWeight: 700,
      fontSize: 14
    }
  }, "MK"), /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontFamily: 'var(--font-display)',
      fontSize: 14.5,
      fontWeight: 600,
      color: 'var(--navy-900)'
    }
  }, "Maria Kaczmarek"), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontSize: 13,
      color: 'var(--text-muted)'
    }
  }, "Pacjent \xB7 ID 48120"))));
}
Object.assign(window, {
  Sidebar,
  Topbar
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/portal/Shell.jsx", error: String((e && e.message) || e) }); }

// ui_kits/portal/Visits.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const {
  Card,
  Button,
  Tabs,
  Tag,
  AppointmentCard,
  Icon
} = window.CMKasprzakaDesignSystem_10ef77;
function Visits({
  onBook
}) {
  const [tab, setTab] = React.useState('Nadchodzące');
  const [filter, setFilter] = React.useState('Wszystkie');
  const upcoming = [{
    date: '12 sie',
    time: '09:30',
    doctor: 'dr n. med. Anna Kowalska',
    specialty: 'Kardiologia',
    mode: 'W klinice',
    status: 'confirmed'
  }, {
    date: '26 sie',
    time: '17:00',
    doctor: 'lek. Piotr Nowak',
    specialty: 'Ortopedia',
    mode: 'Online',
    status: 'pending'
  }];
  const history = [{
    date: '22 lip',
    time: '10:00',
    doctor: 'lek. Magdalena Zielińska',
    specialty: 'Pediatria',
    mode: 'W klinice',
    status: 'done'
  }, {
    date: '02 lip',
    time: '08:15',
    doctor: 'dr Wiktoria Forosenko',
    specialty: 'Echo serca',
    mode: 'W klinice',
    status: 'done'
  }, {
    date: '19 cze',
    time: '16:30',
    doctor: 'lek. Piotr Nowak',
    specialty: 'Ortopedia',
    mode: 'W klinice',
    status: 'cancelled'
  }];
  const list = tab === 'Nadchodzące' ? upcoming : history;
  return /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '28px 32px',
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement(Tabs, {
    items: ['Nadchodzące', 'Historia'],
    value: tab,
    onChange: setTab
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8
    }
  }, ['Wszystkie', 'W klinice', 'Online', 'Wizyty domowe'].map(t => /*#__PURE__*/React.createElement(Tag, {
    key: t,
    selected: filter === t,
    onClick: () => setFilter(t)
  }, t))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 12
    }
  }, list.map((v, i) => /*#__PURE__*/React.createElement(AppointmentCard, _extends({
    key: i
  }, v, {
    onDetails: () => {},
    onCancel: v.status === 'confirmed' || v.status === 'pending' ? () => {} : undefined
  })))), tab === 'Nadchodzące' && /*#__PURE__*/React.createElement(Card, {
    tone: "subtle",
    padding: 26,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 44,
      height: 44,
      borderRadius: '50%',
      background: 'var(--white)',
      color: 'var(--blue-600)',
      display: 'grid',
      placeItems: 'center',
      boxShadow: 'var(--shadow-xs)'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "calendar-plus",
    size: 21
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 16.5,
      fontWeight: 700,
      color: 'var(--navy-900)'
    }
  }, "Potrzebujesz kolejnej wizyty?"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14.5,
      color: 'var(--text-muted)',
      marginTop: 2
    }
  }, "Wybierz specjalist\u0119 i termin bez dzwonienia do rejestracji.")), /*#__PURE__*/React.createElement(Button, {
    onClick: onBook,
    iconAfter: "arrow-right"
  }, "Um\xF3w wizyt\u0119")));
}
Object.assign(window, {
  Visits
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/portal/Visits.jsx", error: String((e && e.message) || e) }); }

// ui_kits/website/Booking.jsx
try { (() => {
const {
  Button,
  Card,
  Icon,
  Badge,
  Dialog,
  FormField,
  Input,
  Select,
  Checkbox,
  Radio,
  SlotPicker
} = window.CMKasprzakaDesignSystem_10ef77;
function BookingDialog({
  open,
  onClose,
  onDone
}) {
  const [step, setStep] = React.useState(0);
  const [spec, setSpec] = React.useState('Kardiologia');
  const [mode, setMode] = React.useState('klinika');
  const [slot, setSlot] = React.useState('09:30');
  const [consent, setConsent] = React.useState(false);
  React.useEffect(() => {
    if (open) setStep(0);
  }, [open]);
  const steps = ['Usługa', 'Termin', 'Dane'];
  return /*#__PURE__*/React.createElement(Dialog, {
    open: open,
    onClose: onClose,
    width: 620,
    title: "Um\xF3w wizyt\u0119"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8,
      marginBottom: 24
    }
  }, steps.map((s, i) => /*#__PURE__*/React.createElement("div", {
    key: s,
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      height: 4,
      borderRadius: 2,
      background: i <= step ? 'var(--action-primary)' : 'var(--grey-200)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 8,
      fontFamily: 'var(--font-display)',
      fontSize: 13,
      fontWeight: 600,
      color: i <= step ? 'var(--navy-900)' : 'var(--text-muted)'
    }
  }, i + 1, ". ", s)))), step === 0 && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement(FormField, {
    label: "Specjalizacja"
  }, /*#__PURE__*/React.createElement(Select, {
    icon: "stethoscope",
    value: spec,
    onChange: e => setSpec(e.target.value),
    options: ['Kardiologia', 'Pediatria', 'Ortopedia', 'USG jamy brzusznej', 'Okulistyka']
  })), /*#__PURE__*/React.createElement(FormField, {
    label: "Forma wizyty"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 20,
      paddingTop: 4
    }
  }, /*#__PURE__*/React.createElement(Radio, {
    name: "m",
    checked: mode === 'klinika',
    onChange: () => setMode('klinika'),
    label: "W klinice"
  }), /*#__PURE__*/React.createElement(Radio, {
    name: "m",
    checked: mode === 'online',
    onChange: () => setMode('online'),
    label: "Teleporada"
  }), /*#__PURE__*/React.createElement(Radio, {
    name: "m",
    checked: mode === 'dom',
    onChange: () => setMode('dom'),
    label: "Wizyta domowa"
  }))), /*#__PURE__*/React.createElement(FormField, {
    label: "Lekarz",
    hint: "Zostaw puste, aby zobaczy\u0107 wszystkie wolne terminy"
  }, /*#__PURE__*/React.createElement(Select, {
    icon: "user-round",
    placeholder: "Dowolny lekarz",
    options: ['dr n. med. Anna Kowalska', 'dr Wiktoria Forosenko']
  }))), step === 1 && /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8,
      marginBottom: 18
    }
  }, ['czw. 13.08', 'pt. 14.08', 'pon. 17.08', 'wt. 18.08'].map((d, i) => /*#__PURE__*/React.createElement("div", {
    key: d,
    style: {
      flex: 1,
      textAlign: 'center',
      padding: '10px 6px',
      borderRadius: 'var(--radius-sm)',
      fontFamily: 'var(--font-display)',
      fontSize: 14,
      fontWeight: 600,
      cursor: 'pointer',
      background: i === 1 ? 'var(--navy-800)' : 'var(--white)',
      color: i === 1 ? '#fff' : 'var(--navy-800)',
      border: '1px solid ' + (i === 1 ? 'var(--navy-800)' : 'var(--border-subtle)')
    }
  }, d))), /*#__PURE__*/React.createElement(SlotPicker, {
    slots: ['08:00', {
      time: '08:30',
      disabled: true
    }, '09:00', '09:30', '10:00', {
      time: '10:30',
      disabled: true
    }, '11:00', '11:30', '12:00', '12:30', {
      time: '13:00',
      disabled: true
    }, '13:30'],
    value: slot,
    onChange: setSlot
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      marginTop: 16,
      fontSize: 13.5,
      color: 'var(--text-muted)'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "info",
    size: 15,
    color: "var(--blue-600)"
  }), "Terminy od\u015Bwie\u017Camy co minut\u0119.")), step === 2 && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement(Card, {
    tone: "accent",
    padding: 16,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "calendar-check",
    size: 22,
    color: "var(--blue-600)"
  }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontWeight: 700,
      color: 'var(--navy-900)'
    }
  }, spec, " \xB7 pi\u0105tek 14 sierpnia, ", slot), /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14,
      color: 'var(--text-muted)',
      marginTop: 2
    }
  }, "ul. Kasprzaka 31 lok. U7, Warszawa"))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(FormField, {
    label: "Imi\u0119 i nazwisko",
    required: true
  }, /*#__PURE__*/React.createElement(Input, {
    icon: "user",
    placeholder: "Jan Kowalski"
  })), /*#__PURE__*/React.createElement(FormField, {
    label: "PESEL",
    required: true
  }, /*#__PURE__*/React.createElement(Input, {
    icon: "id-card",
    placeholder: "00000000000"
  })), /*#__PURE__*/React.createElement(FormField, {
    label: "Telefon",
    required: true
  }, /*#__PURE__*/React.createElement(Input, {
    icon: "phone",
    placeholder: "+48 000 000 000"
  })), /*#__PURE__*/React.createElement(FormField, {
    label: "E-mail"
  }, /*#__PURE__*/React.createElement(Input, {
    icon: "mail",
    placeholder: "jan@example.com"
  }))), /*#__PURE__*/React.createElement(Checkbox, {
    checked: consent,
    onChange: () => setConsent(!consent),
    label: "Zapozna\u0142em si\u0119 z regulaminem i wyra\u017Cam zgod\u0119 na przetwarzanie danych w celu realizacji wizyty."
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      gap: 10,
      marginTop: 26
    }
  }, /*#__PURE__*/React.createElement(Button, {
    variant: "ghost",
    onClick: () => step === 0 ? onClose() : setStep(step - 1)
  }, step === 0 ? 'Anuluj' : 'Wstecz'), step < 2 ? /*#__PURE__*/React.createElement(Button, {
    iconAfter: "arrow-right",
    onClick: () => setStep(step + 1)
  }, "Dalej") : /*#__PURE__*/React.createElement(Button, {
    icon: "check",
    disabled: !consent,
    onClick: () => onDone(spec + ' · piątek 14 sierpnia, ' + slot)
  }, "Potwierdzam rezerwacj\u0119")));
}
Object.assign(window, {
  BookingDialog
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/Booking.jsx", error: String((e && e.message) || e) }); }

// ui_kits/website/Home.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const {
  Button,
  IconButton,
  Badge,
  Tag,
  Card,
  Icon,
  Stat,
  Wordmark,
  SiteHeader,
  SiteFooter,
  SectionHeading,
  ServiceCard,
  DoctorCard,
  StatBar,
  PriceRow,
  Input,
  Select
} = window.CMKasprzakaDesignSystem_10ef77;
const SERVICES = [{
  icon: 'baby',
  title: 'Pediatria',
  description: 'Opieka od pierwszych dni życia, bilanse i szczepienia.'
}, {
  icon: 'heart-pulse',
  title: 'Kardiologia',
  description: 'Echo serca i EKG wykonywane na miejscu.'
}, {
  icon: 'scan-heart',
  title: 'USG dzieci i dorosłych',
  description: 'Voluson S8 — obrazowanie 3D i 4D.'
}, {
  icon: 'bone',
  title: 'Ortopedia i traumatologia',
  description: 'Leczenie narządu ruchu, zabiegi i blokady.'
}, {
  icon: 'eye',
  title: 'Okulistyka',
  description: 'Diagnostyka i leczenie chorób oczu, także u dzieci.'
}, {
  icon: 'venus',
  title: 'Ginekologia i położnictwo',
  description: 'Kompleksowa opieka, w tym prowadzenie ciąży.'
}, {
  icon: 'activity',
  title: 'Endokrynologia',
  description: 'Zaburzenia gruczołów wydzielania wewnętrznego.'
}, {
  icon: 'syringe',
  title: 'Punkt szczepień',
  description: 'Szczepienia ochronne i medycyna podróży.'
}, {
  icon: 'test-tube',
  title: 'Badania laboratoryjne',
  description: 'Punkt pobrań krwi czynny od 7:00.'
}];
function Hero({
  onBook
}) {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      position: 'relative',
      background: 'var(--gradient-hero)',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      right: '-4%',
      bottom: 0,
      width: 620,
      height: 600,
      pointerEvents: 'none'
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: "../../assets/photos/doctor-male-navy.webp",
    alt: "",
    style: {
      width: '100%',
      height: '100%',
      objectFit: 'contain',
      objectPosition: 'bottom'
    }
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      inset: 0,
      background: 'var(--scrim-photo)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement(SiteHeader, {
    tone: "dark",
    items: ['Specjalizacje', 'USG', 'Cennik', 'Zespół', 'Kontakt'],
    active: "Specjalizacje"
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '72px var(--gutter) 96px'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 9,
      padding: '8px 16px',
      borderRadius: 'var(--radius-pill)',
      background: 'rgba(255,255,255,.12)',
      border: '1px solid rgba(255,255,255,.26)',
      backdropFilter: 'blur(14px)',
      color: '#fff',
      fontFamily: 'var(--font-display)',
      fontSize: 14,
      fontWeight: 600
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 7,
      height: 7,
      borderRadius: '50%',
      background: 'var(--blue-400)'
    }
  }), "Prywatna opieka medyczna \xB7 Warszawa Wola"), /*#__PURE__*/React.createElement("h1", {
    style: {
      maxWidth: 660,
      margin: '22px 0 0',
      fontSize: 'var(--text-display-1)',
      fontWeight: 800,
      letterSpacing: 'var(--tracking-display)',
      lineHeight: 'var(--leading-tight)',
      color: '#fff'
    }
  }, "Zdrowie ca\u0142ej rodziny", /*#__PURE__*/React.createElement("br", null), /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--blue-400)'
    }
  }, "w jednym miejscu")), /*#__PURE__*/React.createElement("p", {
    style: {
      maxWidth: 520,
      marginTop: 22,
      fontSize: 'var(--text-body-lg)',
      lineHeight: 'var(--leading-body)',
      color: 'rgba(255,255,255,.78)'
    }
  }, "Wielospecjalistyczna klinika, w kt\xF3rej skorzystasz z konsultacji, diagnostyki USG i bada\u0144 laboratoryjnych \u2014 bez skierowania i bez kolejek."), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 16,
      marginTop: 34
    }
  }, /*#__PURE__*/React.createElement(Button, {
    size: "lg",
    variant: "primary",
    iconAfter: "arrow-right",
    onClick: onBook
  }, "Zapisz si\u0119 online"), /*#__PURE__*/React.createElement(Button, {
    size: "lg",
    variant: "onDark",
    icon: "phone"
  }, "+48 727 500 085")), /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 720,
      marginTop: 56
    }
  }, /*#__PURE__*/React.createElement(StatBar, {
    items: [{
      icon: 'users',
      value: '15 tys.+',
      label: 'Pacjentów rocznie'
    }, {
      icon: 'stethoscope',
      value: '30+',
      label: 'Specjalistów'
    }, {
      icon: 'scan-heart',
      value: '40+',
      label: 'Rodzajów badań USG'
    }]
  })))));
}
function QuickBook({
  onBook
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '-40px auto 0',
      padding: '0 var(--gutter)',
      position: 'relative',
      zIndex: 2
    }
  }, /*#__PURE__*/React.createElement(Card, {
    padding: 22,
    style: {
      boxShadow: 'var(--shadow-lg)',
      display: 'grid',
      gridTemplateColumns: '1.1fr 1.1fr 1fr auto',
      gap: 14,
      alignItems: 'end'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 13,
      fontWeight: 600,
      color: 'var(--navy-800)',
      marginBottom: 7
    }
  }, "Specjalizacja"), /*#__PURE__*/React.createElement(Select, {
    icon: "stethoscope",
    placeholder: "Wybierz specjalizacj\u0119",
    options: SERVICES.map(s => s.title)
  })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 13,
      fontWeight: 600,
      color: 'var(--navy-800)',
      marginBottom: 7
    }
  }, "Lekarz"), /*#__PURE__*/React.createElement(Select, {
    icon: "user-round",
    placeholder: "Dowolny lekarz",
    options: ['dr n. med. Anna Kowalska', 'lek. Piotr Nowak', 'dr Wiktoria Forosenko']
  })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 13,
      fontWeight: 600,
      color: 'var(--navy-800)',
      marginBottom: 7
    }
  }, "Termin"), /*#__PURE__*/React.createElement(Input, {
    icon: "calendar",
    placeholder: "Najbli\u017Cszy wolny"
  })), /*#__PURE__*/React.createElement(Button, {
    size: "lg",
    icon: "search",
    onClick: onBook
  }, "Szukaj terminu")));
}
function Services({
  onOpen
}) {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      padding: 'var(--section-y) 0'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '0 var(--gutter)'
    }
  }, /*#__PURE__*/React.createElement(SectionHeading, {
    align: "center",
    eyebrow: "Czym si\u0119 zajmujemy",
    title: "Specjalizacje i diagnostyka",
    lead: "Konsultacje, badania obrazowe i zabiegi dla dzieci i doros\u0142ych \u2014 wszystko pod jednym adresem przy Kasprzaka 31."
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(3,1fr)',
      gap: 16,
      marginTop: 44
    }
  }, SERVICES.map((s, i) => /*#__PURE__*/React.createElement(ServiceCard, _extends({
    key: s.title
  }, s, {
    selected: i === 1,
    onClick: () => onOpen(s.title)
  }))))));
}
function About() {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      background: 'var(--surface-subtle)',
      padding: 'var(--section-y) 0'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '0 var(--gutter)',
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 64,
      alignItems: 'center'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionHeading, {
    eyebrow: "O nas",
    title: "Klinika, w kt\xF3rej pacjent jest prowadzony od diagnozy do leczenia",
    lead: "Nasz zesp\xF3\u0142 tworz\u0105 wykwalifikowani i do\u015Bwiadczeni lekarze, kt\xF3rzy stanowi\u0105 gwarancj\u0119 \u015Bwiadczenia najwy\u017Cszej jako\u015Bci us\u0142ug medycznych w poczuciu bezpiecze\u0144stwa i przyjaznej atmosfery."
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 16,
      marginTop: 32
    }
  }, [['scan-heart', 'Aparat USG Voluson S8', 'Obrazowanie 3D i 4D na miejscu'], ['test-tube', 'Punkt pobrań', 'Badania laboratoryjne bez zapisów'], ['accessibility', 'Dostępność', 'Placówka przystosowana dla osób z niepełnosprawnościami'], ['house', 'Wizyty domowe', 'Pediatra dojedzie do dziecka']].map(([i, t, d]) => /*#__PURE__*/React.createElement("div", {
    key: t,
    style: {
      display: 'flex',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 38,
      height: 38,
      flex: '0 0 auto',
      borderRadius: 'var(--radius-md)',
      background: 'var(--white)',
      color: 'var(--blue-600)',
      display: 'grid',
      placeItems: 'center',
      boxShadow: 'var(--shadow-xs)'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: i,
    size: 19
  })), /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontFamily: 'var(--font-display)',
      fontSize: 15.5,
      fontWeight: 700,
      color: 'var(--navy-900)'
    }
  }, t), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'block',
      fontSize: 14,
      color: 'var(--text-muted)',
      marginTop: 2
    }
  }, d))))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 34
    }
  }, /*#__PURE__*/React.createElement(Button, {
    variant: "navy",
    iconAfter: "arrow-right"
  }, "Poznaj klinik\u0119"))), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      borderRadius: 'var(--radius-photo)',
      overflow: 'hidden',
      background: 'var(--gradient-wash)',
      height: 460,
      display: 'flex',
      alignItems: 'flex-end',
      justifyContent: 'center'
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: "../../assets/photos/doctor-female-navy.webp",
    alt: "",
    style: {
      height: '98%',
      objectFit: 'contain'
    }
  }), /*#__PURE__*/React.createElement(Card, {
    padding: 18,
    style: {
      position: 'absolute',
      left: 24,
      bottom: 24,
      width: 230,
      boxShadow: 'var(--shadow-lg)'
    }
  }, /*#__PURE__*/React.createElement(Stat, {
    icon: "star",
    value: "4,9 / 5",
    label: "\u015Arednia ocen pacjent\xF3w",
    tone: "dark"
  })))));
}
const TEAM = [{
  name: 'dr n. med. Anna Kowalska',
  specialty: 'Kardiolog · echo serca',
  photo: '../../assets/photos/doctor-female-navy.webp',
  tags: ['Dorośli', 'Echo serca'],
  nextSlot: 'pt. 8:30'
}, {
  name: 'lek. Piotr Nowak',
  specialty: 'Ortopeda — traumatolog',
  photo: '../../assets/photos/doctor-male-navy.webp',
  tags: ['USG ortopedyczne'],
  nextSlot: 'śr. 15:00'
}, {
  name: 'lek. Magdalena Zielińska',
  specialty: 'Pediatra · neonatolog',
  photo: '../../assets/photos/doctor-female-navy.webp',
  tags: ['Dzieci', 'Bilanse'],
  nextSlot: 'pon. 9:00'
}, {
  name: 'dr Wiktoria Forosenko',
  specialty: 'Kardiolog dziecięcy',
  photo: '../../assets/photos/doctor-female-navy.webp',
  tags: ['Dzieci'],
  nextSlot: 'czw. 11:20'
}];
function Team({
  onBook
}) {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      padding: 'var(--section-y) 0'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '0 var(--gutter)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'flex-end',
      justifyContent: 'space-between',
      gap: 32
    }
  }, /*#__PURE__*/React.createElement(SectionHeading, {
    eyebrow: "Nasz zesp\xF3\u0142",
    title: "Specjali\u015Bci, kt\xF3rzy prowadz\u0105 pacjenta",
    maxWidth: 520
  }), /*#__PURE__*/React.createElement(Button, {
    variant: "secondary",
    iconAfter: "arrow-right"
  }, "Zobacz wszystkich")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 18,
      marginTop: 40
    }
  }, TEAM.map(d => /*#__PURE__*/React.createElement(DoctorCard, _extends({
    key: d.name
  }, d, {
    onBook: onBook
  }))))));
}
function PriceTeaser({
  onOpen
}) {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      background: 'var(--surface-subtle)',
      padding: 'var(--section-y-tight) 0'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '0 var(--gutter)',
      display: 'grid',
      gridTemplateColumns: '340px 1fr',
      gap: 56,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement(SectionHeading, {
    eyebrow: "Cennik",
    title: "Przejrzyste ceny",
    lead: "Bez abonamentu i bez ukrytych koszt\xF3w. P\u0142atno\u015B\u0107 po wizycie."
  }), /*#__PURE__*/React.createElement(Card, {
    padding: 8
  }, /*#__PURE__*/React.createElement(PriceRow, {
    service: "Konsultacja pediatryczna",
    duration: "30 min",
    price: "250 z\u0142"
  }), /*#__PURE__*/React.createElement(PriceRow, {
    service: "Konsultacja kardiologiczna",
    note: "z badaniem EKG",
    duration: "40 min",
    price: "350 z\u0142"
  }), /*#__PURE__*/React.createElement(PriceRow, {
    service: "USG jamy brzusznej",
    note: "Doro\u015Bli \xB7 na czczo",
    duration: "20 min",
    price: "250 z\u0142"
  }), /*#__PURE__*/React.createElement(PriceRow, {
    service: "Echo serca u dzieci",
    duration: "30 min",
    price: "350 z\u0142",
    style: {
      borderBottom: 'none'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '14px 20px'
    }
  }, /*#__PURE__*/React.createElement(Button, {
    variant: "secondary",
    iconAfter: "arrow-right",
    onClick: onOpen
  }, "Pe\u0142ny cennik")))));
}
function ContactCta({
  onBook
}) {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      padding: '0 0 var(--section-y)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '0 var(--gutter)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      background: 'var(--gradient-hero)',
      borderRadius: 'var(--radius-xl)',
      padding: '56px 56px',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 48
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("h2", {
    style: {
      color: '#fff',
      fontSize: 'var(--text-display-2)',
      fontWeight: 800,
      letterSpacing: 'var(--tracking-display)',
      lineHeight: 1.1,
      margin: 0,
      maxWidth: 560
    }
  }, "Um\xF3w wizyt\u0119 online w dwie minuty"), /*#__PURE__*/React.createElement("p", {
    style: {
      color: 'rgba(255,255,255,.76)',
      fontSize: 'var(--text-body-lg)',
      marginTop: 16,
      maxWidth: 520
    }
  }, "Wybierz specjalist\u0119 i termin w Portalu Pacjenta albo zadzwo\u0144 do rejestracji.")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 12,
      flex: '0 0 auto'
    }
  }, /*#__PURE__*/React.createElement(Button, {
    size: "lg",
    variant: "primary",
    iconAfter: "arrow-right",
    onClick: onBook
  }, "Zapisz si\u0119 online"), /*#__PURE__*/React.createElement(Button, {
    size: "lg",
    variant: "onDark",
    icon: "phone"
  }, "Zadzwo\u0144 do rejestracji")))));
}
function Home({
  onBook,
  onOpen
}) {
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(Hero, {
    onBook: onBook
  }), /*#__PURE__*/React.createElement(QuickBook, {
    onBook: onBook
  }), /*#__PURE__*/React.createElement(Services, {
    onOpen: onOpen
  }), /*#__PURE__*/React.createElement(About, null), /*#__PURE__*/React.createElement(Team, {
    onBook: onBook
  }), /*#__PURE__*/React.createElement(PriceTeaser, {
    onOpen: onOpen
  }), /*#__PURE__*/React.createElement(ContactCta, {
    onBook: onBook
  }), /*#__PURE__*/React.createElement(SiteFooter, {
    columns: [{
      title: 'Specjalizacje',
      links: ['Pediatria', 'Kardiologia', 'Ortopedia', 'Okulistyka', 'Ginekologia']
    }, {
      title: 'Diagnostyka',
      links: ['USG dorośli', 'USG dzieci', 'Echo serca', 'EKG', 'Badania laboratoryjne']
    }, {
      title: 'Pacjent',
      links: ['Portal pacjenta', 'Cennik', 'Wizyty domowe', 'RODO', 'Polityka prywatności']
    }]
  }));
}
Object.assign(window, {
  Home,
  SERVICES,
  TEAM
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/Home.jsx", error: String((e && e.message) || e) }); }

// ui_kits/website/Specialty.jsx
try { (() => {
const {
  Button,
  Badge,
  Card,
  Icon,
  Tabs,
  Breadcrumbs,
  SiteHeader,
  SiteFooter,
  SectionHeading,
  DoctorCard,
  PriceRow,
  SlotPicker
} = window.CMKasprzakaDesignSystem_10ef77;
function Specialty({
  title = 'Kardiologia',
  onBack,
  onBook
}) {
  const [tab, setTab] = React.useState('Zakres');
  const [slot, setSlot] = React.useState('09:30');
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SiteHeader, {
    items: ['Specjalizacje', 'USG', 'Cennik', 'Zespół', 'Kontakt'],
    active: "Specjalizacje",
    onNavigate: onBack
  }), /*#__PURE__*/React.createElement("section", {
    style: {
      background: 'var(--surface-subtle)',
      padding: '34px 0 44px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '0 var(--gutter)'
    }
  }, /*#__PURE__*/React.createElement(Breadcrumbs, {
    items: ['Strona główna', 'Specjalizacje', title]
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'flex-end',
      justifyContent: 'space-between',
      gap: 40,
      marginTop: 20
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 640
    }
  }, /*#__PURE__*/React.createElement("h1", {
    style: {
      fontSize: 'var(--text-display-2)',
      fontWeight: 800,
      letterSpacing: 'var(--tracking-display)',
      lineHeight: 1.08,
      color: 'var(--navy-900)',
      margin: 0
    }
  }, title), /*#__PURE__*/React.createElement("p", {
    style: {
      fontSize: 'var(--text-body-lg)',
      color: 'var(--text-muted)',
      marginTop: 16
    }
  }, "Diagnostyka i leczenie chor\xF3b uk\u0142adu kr\u0105\u017Cenia u doros\u0142ych. Echo serca, EKG i Holter wykonujemy na miejscu, w dniu konsultacji."), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8,
      marginTop: 20
    }
  }, /*#__PURE__*/React.createElement(Badge, {
    tone: "brand",
    icon: "clock"
  }, "Termin w 3 dni"), /*#__PURE__*/React.createElement(Badge, {
    tone: "navy",
    icon: "file-text"
  }, "Bez skierowania"), /*#__PURE__*/React.createElement(Badge, {
    tone: "teal",
    icon: "scan-heart"
  }, "Echo na miejscu"))), /*#__PURE__*/React.createElement(Button, {
    size: "lg",
    iconAfter: "arrow-right",
    onClick: onBook
  }, "Um\xF3w konsultacj\u0119")))), /*#__PURE__*/React.createElement("section", {
    style: {
      padding: '40px 0 var(--section-y)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container-max)',
      margin: '0 auto',
      padding: '0 var(--gutter)',
      display: 'grid',
      gridTemplateColumns: '1fr 360px',
      gap: 56,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(Tabs, {
    items: ['Zakres', 'Przebieg wizyty', 'Cennik'],
    value: tab,
    onChange: setTab
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 28
    }
  }, tab === 'Zakres' && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 14
    }
  }, [['heart-pulse', 'Konsultacja kardiologiczna'], ['activity', 'EKG spoczynkowe'], ['scan-heart', 'Echo serca (UKG)'], ['gauge', 'Holter ciśnieniowy'], ['stethoscope', 'Kwalifikacja do zabiegu'], ['clipboard-list', 'Kontrola leczenia']].map(([i, t]) => /*#__PURE__*/React.createElement(Card, {
    key: t,
    padding: 18,
    style: {
      display: 'flex',
      gap: 12,
      alignItems: 'center'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 38,
      height: 38,
      borderRadius: 'var(--radius-md)',
      background: 'var(--blue-050)',
      color: 'var(--blue-600)',
      display: 'grid',
      placeItems: 'center',
      flex: '0 0 auto'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: i,
    size: 19
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 15.5,
      fontWeight: 600,
      color: 'var(--navy-900)'
    }
  }, t)))), tab === 'Przebieg wizyty' && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 0
    }
  }, [['Wywiad i badanie', 'Lekarz zbiera wywiad, osłuchuje i mierzy ciśnienie.'], ['Badania na miejscu', 'Jeśli trzeba — EKG lub echo serca w tym samym gabinecie.'], ['Omówienie wyników', 'Otrzymujesz opis badania i zalecenia jeszcze podczas wizyty.'], ['Plan leczenia', 'Recepta, skierowanie i termin kontroli w Portalu Pacjenta.']].map(([t, d], i) => /*#__PURE__*/React.createElement("div", {
    key: t,
    style: {
      display: 'flex',
      gap: 18,
      paddingBottom: 24
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 32,
      height: 32,
      borderRadius: '50%',
      background: 'var(--navy-800)',
      color: '#fff',
      display: 'grid',
      placeItems: 'center',
      fontFamily: 'var(--font-display)',
      fontWeight: 700,
      fontSize: 14
    }
  }, i + 1), i < 3 && /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      width: 1,
      background: 'var(--border-subtle)',
      marginTop: 6
    }
  })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 16.5,
      fontWeight: 700,
      color: 'var(--navy-900)'
    }
  }, t), /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 15,
      color: 'var(--text-muted)',
      marginTop: 4
    }
  }, d))))), tab === 'Cennik' && /*#__PURE__*/React.createElement(Card, {
    padding: 8
  }, /*#__PURE__*/React.createElement(PriceRow, {
    service: "Konsultacja kardiologiczna",
    duration: "40 min",
    price: "350 z\u0142"
  }), /*#__PURE__*/React.createElement(PriceRow, {
    service: "Echo serca (UKG)",
    duration: "30 min",
    price: "350 z\u0142"
  }), /*#__PURE__*/React.createElement(PriceRow, {
    service: "EKG spoczynkowe",
    note: "z opisem",
    duration: "15 min",
    price: "120 z\u0142"
  }), /*#__PURE__*/React.createElement(PriceRow, {
    service: "Holter ci\u015Bnieniowy",
    duration: "24 h",
    price: "250 z\u0142",
    style: {
      borderBottom: 'none'
    }
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 48
    }
  }, /*#__PURE__*/React.createElement(SectionHeading, {
    eyebrow: "Specjali\u015Bci",
    title: "Kto przyjmuje",
    maxWidth: 520
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 18,
      marginTop: 26
    }
  }, /*#__PURE__*/React.createElement(DoctorCard, {
    name: "dr n. med. Anna Kowalska",
    specialty: "Kardiolog \xB7 echo serca",
    photo: "../../assets/photos/doctor-female-navy.webp",
    tags: ['Dorośli'],
    nextSlot: "pt. 8:30",
    onBook: onBook
  }), /*#__PURE__*/React.createElement(DoctorCard, {
    name: "dr Wiktoria Forosenko",
    specialty: "Kardiolog dzieci\u0119cy",
    photo: "../../assets/photos/doctor-female-navy.webp",
    tags: ['Dzieci'],
    nextSlot: "czw. 11:20",
    onBook: onBook
  })))), /*#__PURE__*/React.createElement(Card, {
    padding: 24,
    style: {
      position: 'sticky',
      top: 24,
      boxShadow: 'var(--shadow-md)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 18,
      fontWeight: 700,
      color: 'var(--navy-900)'
    }
  }, "Najbli\u017Csze terminy"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontSize: 14,
      color: 'var(--text-muted)',
      marginTop: 4,
      marginBottom: 18
    }
  }, "pi\u0105tek, 14 sierpnia \xB7 dr Anna Kowalska"), /*#__PURE__*/React.createElement(SlotPicker, {
    slots: ['08:00', {
      time: '08:30',
      disabled: true
    }, '09:00', '09:30', '10:00', {
      time: '10:30',
      disabled: true
    }, '11:00', '11:30', '12:00'],
    value: slot,
    onChange: setSlot
  }), /*#__PURE__*/React.createElement(Button, {
    fullWidth: true,
    size: "lg",
    style: {
      marginTop: 20
    },
    onClick: onBook
  }, "Rezerwuj\u0119 ", slot), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      marginTop: 14,
      fontSize: 13.5,
      color: 'var(--text-muted)'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "shield-check",
    size: 15,
    color: "var(--success-600)"
  }), "Bezp\u0142atne odwo\u0142anie do 24 h przed wizyt\u0105")))), /*#__PURE__*/React.createElement(SiteFooter, {
    columns: [{
      title: 'Specjalizacje',
      links: ['Pediatria', 'Kardiologia', 'Ortopedia']
    }, {
      title: 'Diagnostyka',
      links: ['USG dorośli', 'USG dzieci', 'EKG']
    }, {
      title: 'Pacjent',
      links: ['Portal pacjenta', 'Cennik', 'RODO']
    }]
  }));
}
Object.assign(window, {
  Specialty
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/Specialty.jsx", error: String((e && e.message) || e) }); }

__ds_ns.Badge = __ds_scope.Badge;

__ds_ns.Button = __ds_scope.Button;

__ds_ns.Card = __ds_scope.Card;

__ds_ns.Icon = __ds_scope.Icon;

__ds_ns.IconButton = __ds_scope.IconButton;

__ds_ns.Stat = __ds_scope.Stat;

__ds_ns.Tag = __ds_scope.Tag;

__ds_ns.Wordmark = __ds_scope.Wordmark;

__ds_ns.Alert = __ds_scope.Alert;

__ds_ns.Dialog = __ds_scope.Dialog;

__ds_ns.Spinner = __ds_scope.Spinner;

__ds_ns.Toast = __ds_scope.Toast;

__ds_ns.Tooltip = __ds_scope.Tooltip;

__ds_ns.Checkbox = __ds_scope.Checkbox;

__ds_ns.FormField = __ds_scope.FormField;

__ds_ns.Input = __ds_scope.Input;

__ds_ns.Radio = __ds_scope.Radio;

__ds_ns.Select = __ds_scope.Select;

__ds_ns.Switch = __ds_scope.Switch;

__ds_ns.Textarea = __ds_scope.Textarea;

__ds_ns.Breadcrumbs = __ds_scope.Breadcrumbs;

__ds_ns.SiteFooter = __ds_scope.SiteFooter;

__ds_ns.SiteHeader = __ds_scope.SiteHeader;

__ds_ns.Tabs = __ds_scope.Tabs;

__ds_ns.AppointmentCard = __ds_scope.AppointmentCard;

__ds_ns.DoctorCard = __ds_scope.DoctorCard;

__ds_ns.PriceRow = __ds_scope.PriceRow;

__ds_ns.SectionHeading = __ds_scope.SectionHeading;

__ds_ns.ServiceCard = __ds_scope.ServiceCard;

__ds_ns.SlotPicker = __ds_scope.SlotPicker;

__ds_ns.StatBar = __ds_scope.StatBar;

})();
