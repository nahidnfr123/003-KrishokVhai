(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{uTL8:function(e,t,r){"use strict";r.r(t);var n=r("o0o1"),i=r.n(n),a=r("L2JU"),s=r("sZ6p");function o(e,t,r,n,i,a,s){try{var o=e[a](s),c=o.value}catch(e){return void r(e)}o.done?t(c):Promise.resolve(c).then(n,i)}function c(e){return function(){var t=this,r=arguments;return new Promise((function(n,i){var a=e.apply(t,r);function s(e){o(a,n,i,s,c,"next",e)}function c(e){o(a,n,i,s,c,"throw",e)}s(void 0)}))}}function u(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function l(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?u(Object(r),!0).forEach((function(t){f(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):u(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function f(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var v={name:"EmailVerification",data:function(){return{verificationLinkSent:!1,processing:!1,errors:{}}},beforeMount:function(){this.getUsed()},methods:l(l({},Object(a.b)({emailVerificationAction:"auth/emailVerification",clearAuthError:"auth/clearError",getMe:"auth/me"})),{},{getUsed:function(){var e=this;return c(i.a.mark((function t(){return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.getMe();case 2:if(null==e.$store.state.auth.user.email_verified_at){t.next=5;break}return t.next=5,e.$router.replace({name:"Home"});case 5:case"end":return t.stop()}}),t)})))()},sendEmailVerificationCode:function(){var e=this;return c(i.a.mark((function t(){var r;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return(r=e).processing=!0,r.$Progress.start(),r.errors={},t.next=6,e.clearAuthError();case 6:return t.next=8,e.emailVerificationAction().finally((function(){r.processing=!1,r.verificationLinkSent=!0}));case 8:if(null==s.a.state.error){t.next=12;break}return r.$Progress.fail(),r.errors=s.a.state.error,t.abrupt("return");case 12:r.$Progress.finish();case 13:case"end":return t.stop()}}),t)})))()}})},d=r("KHd+"),p=Object(d.a)(v,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("transition",{attrs:{"leave-active-class":"duration-200"}},[r("transition",{attrs:{"enter-active-class":"ease-out duration-300"}},[r("div",{staticClass:"container mt-4 mb-4"},[r("div",{staticClass:"flex flex-col justify-center align-middle items-center text-center"},[r("h3",{staticClass:"text-muted"},[e._v("Email verification")]),e._v(" "),r("div",{staticClass:"mb-4 text-muted"},[e._v("\n                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just e-mailed to you? If you haven't receive the email, we will gladly send you another.\n                ")]),e._v(" "),e.verificationLinkSent?r("div",{staticClass:"mb-4 text-success"},[e._v("\n                    A new verification link has been sent to the email address you provided during registration.\n                ")]):e._e(),e._v(" "),r("div",{staticClass:"text-xs"},[r("p",[e._v("Please verify your email first.\n                        ( "),r("a",{staticClass:"cursor-pointer pb-2",attrs:{href:"#"},on:{click:function(t){return t.stopPropagation(),t.preventDefault(),e.sendEmailVerificationCode(t)}}},[e._v(" "+e._s(e.verificationLinkSent?"Resend email ?":"Send email ?")+" ")]),e._v(" )")]),e._v(" "),e.processing?r("div",{staticClass:"mt-4 inline-flex"},[r("span",{staticClass:"spinner-border spinner-border-sm",attrs:{role:"status","aria-hidden":"true"}}),e._v(" "),r("span",{staticClass:"text-sm"},[e._v("Sending Email. Please wait ...")])]):e._e()])])])])],1)}),[],!1,null,null,null);t.default=p.exports}}]);