(window.webpackJsonp=window.webpackJsonp||[]).push([[18],{t5YM:function(t,e,r){"use strict";r.r(e);var a=r("L2JU");function n(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,a)}return r}function o(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?n(Object(r),!0).forEach((function(e){c(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):n(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function c(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var i={name:"SocialLogin",data:function(){return{loading:!0,errors:{},timer:null}},computed:o({},Object(a.c)({authenticated:"auth/authenticated",user:"auth/user"})),methods:o(o({},Object(a.b)({socialAuthCallbackAction:"auth/socialAuthCallback",addSnack:"snackbar/addSnack"})),{},{socialAuthCallback:function(){var t=this;this.socialAuthCallbackAction({code:this.$route.query.code,provider:this.$route.params.provider}).then((function(e){e&&e.data.user?t.$nextTick().then((function(){t.timer=setInterval((function(){t.user&&t.$router.push({name:"Home"})}),t.user)})):(t.loading=!1,t.$store.dispatch("snackbar/addSnack",{color:"red-500",msg:"Failed to authenticate user account. Please try again later"},{root:!0}),t.$router.replace({name:"Login"}))})).catch((function(){t.$store.dispatch("snackbar/addSnack",{color:"red-500",msg:"Failed to authenticate user account. Please try again later"},{root:!0}),t.$router.replace({name:"Login"})}))}}),created:function(){this.socialAuthCallback()},beforeDestroy:function(){this.loading=!1,clearInterval(this.timer)}},s=r("KHd+"),u=Object(s.a)(i,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"w-24 min-w-max mx-auto max-w-prose bg-gray-200 shadow-xl rounded my-10 place-content-center lg:min-w-max md:w-auto dark:bg-gray-800",staticStyle:{"min-width":"340px!important"}},[e("p",{staticClass:"text-center text-gray-800 py-4 mt-2 dark:text-gray-300"},[this._v("Login with "+this._s(this.$route.params.provider)+" please wait.")]),this._v(" "),1==this.loading?e("Loading"):this._e()],1)}),[],!1,null,null,null);e.default=u.exports}}]);