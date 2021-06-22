(window.webpackJsonp=window.webpackJsonp||[]).push([[8],{"7GH9":function(e,t,r){"use strict";r.r(t);var n=r("o0o1"),s=r.n(n),o=r("L2JU"),a=r("sZ6p");function i(e,t,r,n,s,o,a){try{var i=e[o](a),c=i.value}catch(e){return void r(e)}i.done?t(c):Promise.resolve(c).then(n,s)}function c(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function l(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?c(Object(r),!0).forEach((function(t){u(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function u(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var d={name:"ForgetPassword",data:function(){return{credentials:{email:""},errors:{},emailSent:!1,formDisabled:!1,processing:!1,timerInterval:null,countdownTimer:null}},methods:l(l({},Object(o.b)({forgotPassword:"auth/forgotPassword",clearAuthError:"auth/clearError"})),{},{sendResetLink:function(){var e,t=this;return(e=s.a.mark((function e(){var r;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if((r=t).processing=!0,r.$Progress.start(),r.errors={},r.clearAuthError(),r.credentials.email.trim()||(r.errors.email="Email is required!"),!Object.keys(r.errors).length){e.next=10;break}return r.$Progress.fail(),r.processing=!1,e.abrupt("return");case 10:return e.next=12,t.forgotPassword(t.credentials).finally((function(){r.processing=!1}));case 12:if(null==a.a.state.error){e.next=16;break}return r.$Progress.fail(),r.errors=a.a.state.error,e.abrupt("return");case 16:r.formDisabled=!0,r.startTimer();case 18:case"end":return e.stop()}}),e)})),function(){var t=this,r=arguments;return new Promise((function(n,s){var o=e.apply(t,r);function a(e){i(o,n,s,a,c,"next",e)}function c(e){i(o,n,s,a,c,"throw",e)}a(void 0)}))})()},startTimer:function(){var e=this,t=0;this.countdownTimer=60,this.timerInterval=setInterval((function(){t+=1,e.countdownTimer=60-t,0==e.countdownTimer&&e.onTimesUp()}),1e3)},onTimesUp:function(){clearInterval(this.timerInterval),this.formDisabled=!1,this.countdownTimer=null,this.emailSent=!0}})},m=r("KHd+"),p=Object(m.a)(d,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"container"},[r("div",{staticClass:"col-12 col-md-6 col-lg-4 m-auto mb-4"},[r("h3",{staticClass:"text-center mt-4 text-muted"},[e._v("Forgot Password")]),e._v(" "),r("div",[r("div",{},[r("form",{attrs:{method:"post",autofocus:"autofocus"},on:{submit:function(t){return t.stopPropagation(),t.preventDefault(),e.sendResetLink(t)}}},[r("Custom_Text_Input",{staticClass:"mb-3",attrs:{label:"Email",id:"email",type:"email",placeholder:"example@email.com",error:e.errors.email&&Array.isArray(e.errors.email)?e.errors.email[0]:e.errors.email,disabled:e.formDisabled},model:{value:e.credentials.email,callback:function(t){e.$set(e.credentials,"email",t)},expression:"credentials.email"}}),e._v(" "),r("Custom_Loading_Button",{attrs:{Add_Input_Class:"mb-4 mt-6 block mx-auto uppercase rounded",processing:e.processing,disabled:e.formDisabled},on:{button_clicked:e.sendResetLink}},[e.emailSent?r("span",[e._v("Resend password reset link")]):r("span",[e._v("Send password reset link")])])],1),e._v(" "),e.countdownTimer?r("div",{staticClass:"text-center text-xs mt-2 text-gray-800 dark:text-gray-300"},[e._v("\n                    Email sent successfully. You can retry in "+e._s(e.countdownTimer)+" sec.\n                ")]):e._e()]),e._v(" "),r("div",{staticClass:"text-center mt-4 text-gray-800 dark:text-gray-300"},[e._v("\n                Back to\n                "),r("router-link",{staticClass:"text-blue-500",attrs:{to:"/login"}},[e._v(" login.")])],1)])])])}),[],!1,null,null,null);t.default=p.exports}}]);