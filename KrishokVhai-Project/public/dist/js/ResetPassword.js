(window.webpackJsonp=window.webpackJsonp||[]).push([[17],{"/Tqy":function(e,r,t){var s=t("TTEv");"string"==typeof s&&(s=[[e.i,s,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};t("aET+")(s,a);s.locals&&(e.exports=s.locals)},"2WYk":function(e,r,t){"use strict";var s=t("o0o1"),a=t.n(s);function i(e,r,t,s,a,i,o){try{var n=e[i](o),c=n.value}catch(e){return void t(e)}n.done?r(c):Promise.resolve(c).then(s,a)}function o(e){return function(){var r=this,t=arguments;return new Promise((function(s,a){var o=e.apply(r,t);function n(e){i(o,s,a,n,c,"next",e)}function c(e){i(o,s,a,n,c,"throw",e)}n(void 0)}))}}var n={name:"AddressSelectComponent",props:{address:String,errors:{type:Array|Object}},data:function(){return{countries:{},states:{},cities:{},userDetails:{country_id:"",state_id:"",city_id:"",address:""}}},watch:{"userDetails.country_id":function(e,r){e!=r&&(this.getStates(),this.$emit("updateAddressValues",this.userDetails))},"userDetails.state_id":function(e,r){e!=r&&(this.getCities(),this.$emit("updateAddressValues",this.userDetails))},"userDetails.city_id":function(e,r){e!=r&&this.$emit("updateAddressValues",this.userDetails)},"userDetails.address":function(e,r){e!=r&&this.$emit("updateAddressValues",this.userDetails)}},methods:{updateValue:function(e){this.$emit("input",e.trim())},getCountries:function(){var e=this;return o(a.a.mark((function r(){return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,axios.get("/api/countries").then((function(r){e.countries=r.data})).catch((function(e){dispatch("snackbar/addSnack",{color:"danger",msg:"Error fetching countries.",snakbarType:"Error"},{root:!0})}));case 2:case"end":return r.stop()}}),r)})))()},getStates:function(){var e=this;return o(a.a.mark((function r(){return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,axios.get("/api/states/".concat(e.userDetails.country_id)).then((function(r){e.states=r.data})).catch((function(e){dispatch("snackbar/addSnack",{color:"danger",msg:"Error fetching states.",snakbarType:"Error"},{root:!0})}));case 2:case"end":return r.stop()}}),r)})))()},getCities:function(){var e=this;return o(a.a.mark((function r(){return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,axios.get("/api/cities/".concat(e.userDetails.state_id)).then((function(r){e.cities=r.data})).catch((function(e){dispatch("snackbar/addSnack",{color:"danger",msg:"Error fetching cities.",snakbarType:"Error"},{root:!0})}));case 2:case"end":return r.stop()}}),r)})))()}},computed:{},mounted:function(){this.getCountries()}},c=(t("P42d"),t("KHd+")),l=Object(c.a)(n,(function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",[t("div",{staticClass:"form-group mb-3"},[t("label",{attrs:{for:"Country"}},[e._v("Country (*)")]),e._v(" "),t("select",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.country_id,expression:"userDetails.country_id"}],staticClass:"form-control form-control-sm",attrs:{name:"country",id:"Country",disabled:!e.countries.length},on:{change:function(r){var t=Array.prototype.filter.call(r.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.userDetails,"country_id",r.target.multiple?t:t[0])}}},[t("option",{attrs:{value:"",selected:""}},[e._v("---------")]),e._v(" "),e._l(e.countries,(function(r,s){return t("option",{key:s,domProps:{value:r.id}},[e._v(e._s(r.name))])}))],2),e._v(" "),(e.errors.country_id&&Array.isArray(e.errors.country_id)?e.errors.country_id[0]:e.errors.country_id)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.country_id&&Array.isArray(e.errors.country_id)?e.errors.country_id[0]:e.errors.country_id))])]:e._e()],2),e._v(" "),t("div",{staticClass:"form-group mb-3"},[t("label",{attrs:{for:"State"}},[e._v("State/Province (*)")]),e._v(" "),t("select",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.state_id,expression:"userDetails.state_id"}],staticClass:"form-control form-control-sm",attrs:{name:"state",id:"State",disabled:!e.states.length},on:{change:function(r){var t=Array.prototype.filter.call(r.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.userDetails,"state_id",r.target.multiple?t:t[0])}}},[t("option",{attrs:{value:"",selected:""}},[e._v("---------")]),e._v(" "),e._l(e.states,(function(r,s){return t("option",{key:s,domProps:{value:r.id}},[e._v(e._s(r.name))])}))],2),e._v(" "),(e.errors.state_id&&Array.isArray(e.errors.state_id)?e.errors.state_id[0]:e.errors.state_id)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.state_id&&Array.isArray(e.errors.state_id)?e.errors.state_id[0]:e.errors.state_id))])]:e._e()],2),e._v(" "),t("div",{staticClass:"form-group mb-3"},[t("label",{attrs:{for:"City"}},[e._v("City")]),e._v(" "),t("select",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.city_id,expression:"userDetails.city_id"}],staticClass:"form-control form-control-sm",attrs:{name:"city",id:"City",disabled:!e.cities.length},on:{change:function(r){var t=Array.prototype.filter.call(r.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.userDetails,"city_id",r.target.multiple?t:t[0])}}},[t("option",{attrs:{value:"",selected:""}},[e._v("---------")]),e._v(" "),e._l(e.cities,(function(r,s){return t("option",{key:s,domProps:{value:r.id}},[e._v(e._s(r.name))])}))],2),e._v(" "),(e.errors.city_id&&Array.isArray(e.errors.city_id)?e.errors.city_id[0]:e.errors.city_id)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.city_id&&Array.isArray(e.errors.city_id)?e.errors.city_id[0]:e.errors.city_id))])]:e._e()],2),e._v(" "),t("div",{staticClass:"form-group mb-3"},["agricultural-officer"==this.$route.params.usertype?t("label",{attrs:{for:"address"}},[e._v("Office Address (*)")]):t("label",{attrs:{for:"address"}},[e._v("Address (*)")]),e._v(" "),t("textarea",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.address,expression:"userDetails.address"}],staticClass:"form-control form-control-sm",attrs:{cols:"10",rows:"3",id:"address",name:"address"},domProps:{value:e.userDetails.address},on:{input:function(r){r.target.composing||e.$set(e.userDetails,"address",r.target.value)}}}),e._v(" "),(e.errors.address&&Array.isArray(e.errors.address)?e.errors.address[0]:e.errors.address)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.address&&Array.isArray(e.errors.address)?e.errors.address[0]:e.errors.address))])]:e._e()],2)])}),[],!1,null,"1d20d891",null);r.a=l.exports},FmS5:function(e,r,t){var s=t("s9A9");"string"==typeof s&&(s=[[e.i,s,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};t("aET+")(s,a);s.locals&&(e.exports=s.locals)},IVXm:function(e,r,t){"use strict";t.r(r);var s=t("o0o1"),a=t.n(s),i=t("2WYk"),o=t("L2JU");function n(e,r,t,s,a,i,o){try{var n=e[i](o),c=n.value}catch(e){return void t(e)}n.done?r(c):Promise.resolve(c).then(s,a)}function c(e,r){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);r&&(s=s.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),t.push.apply(t,s)}return t}function l(e){for(var r=1;r<arguments.length;r++){var t=null!=arguments[r]?arguments[r]:{};r%2?c(Object(t),!0).forEach((function(r){u(e,r,t[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):c(Object(t)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))}))}return e}function u(e,r,t){return r in e?Object.defineProperty(e,r,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[r]=t,e}var d={name:"Survey",components:{AddressSelectComponent:i.a},data:function(){return{userDetails:{userType:"",acres:"",address:"",country_id:"",state_id:"",city_id:"",farmerType:"",retailer_interest:"",office_name:"",job_title:"",certificate:null},certificateUrl:null,processing:!1,errors:[]}},computed:l({},Object(o.c)({user:"auth/user",roles:"auth/roles",getUserDetailsErrors:"user_state/userDetailsErrors",userDetailsStore:"user_state/userDetails"})),mounted:function(){var e=this;this.getUserDetails().finally((function(){Object.keys(e.userDetailsStore).length&&(e.$store.dispatch("snackbar/addSnack",{color:"info",msg:"User details already added.",snakbarType:"Information"},{root:!0}),window.location.href="/dashboard/@".concat(e.user.username,"/home"))})),this.checkCorrectUrl()},methods:l(l({},Object(o.b)({storeUserDetails:"user_state/storeUserDetails",clearUserDetailsError:"user_state/clearError",getUserDetails:"user_state/getUserDetails"})),{},{checkCorrectUrl:function(){for(var e=this.$route.params.usertype.split("_"),r=0,t=0;t<this.roles.length;t++)e.includes(this.roles[t])&&r++;return e.length==this.roles.length&&e.length==r&&r==this.roles.length?void(this.userDetails.userType=this.$route.params.usertype):this.$router.replace({name:"Index"})},updateAddressData:function(e){this.userDetails.address=e.address,this.userDetails.country_id=e.country_id,this.userDetails.state_id=e.state_id,this.userDetails.city_id=e.city_id},onFilePicked:function(e){var r=this,t=e.target.files,s=t[0].name;if(!/\.(pdf)$/i.test(s))return alert("Only pdf file can be uploaded."),!1;if(t.size>4511775)return alert("File size can not be bigger than 4 MB"),!1;var a=new FileReader;a.addEventListener("load",(function(){r.certificateUrl=a.result})),a.readAsDataURL(t[0]),this.userDetails.certificate=t[0]},uploadUserDetails:function(){var e,r=this;return(e=a.a.mark((function e(){var t,s;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if((t=r).processing=!0,t.$Progress.start(),t.clearUserDetailsError(),t.errors={},t.validateData(),!Object.keys(t.errors).length){e.next=10;break}return t.$Progress.fail(),t.processing=!1,e.abrupt("return");case 10:return(s=new FormData).append("userType",r.userDetails.userType),s.append("acres",r.userDetails.acres),s.append("address",r.userDetails.address),s.append("country_id",r.userDetails.country_id),s.append("state_id",r.userDetails.state_id),s.append("city_id",r.userDetails.city_id),s.append("farmerType",r.userDetails.farmerType),s.append("retailer_interest",r.userDetails.retailer_interest),s.append("office_name",r.userDetails.office_name),s.append("job_title",r.userDetails.job_title),s.append("certificate",r.userDetails.certificate),e.next=24,r.storeUserDetails(s).finally((function(){t.processing=!1}));case 24:if(null==r.getUserDetailsErrors){e.next=28;break}return t.$Progress.fail(),t.errors=r.getUserDetailsErrors,e.abrupt("return");case 28:t.$Progress.finish(),window.location.href="/dashboard/@".concat(r.user.username,"/home");case 30:case"end":return e.stop()}}),e)})),function(){var r=this,t=arguments;return new Promise((function(s,a){var i=e.apply(r,t);function o(e){n(i,s,a,o,c,"next",e)}function c(e){n(i,s,a,o,c,"throw",e)}o(void 0)}))})()},validateData:function(){this.userDetails.userType.trim()||(this.errors.userType="User type is required."),"farmer"==this.$route.params.usertype&&(this.userDetails.acres.toString().trim()?0==parseFloat(this.userDetails.acres)?this.errors.acres="Are you sure you don't have any land?":parseFloat(this.userDetails.acres)>500&&(this.errors.acres="You own too much land."):this.errors.acres="Acres is required.",this.userDetails.farmerType.trim()||(this.errors.farmerType="This field is required.")),"retailer"==this.$route.params.usertype&&(this.userDetails.retailer_interest.trim()||(this.errors.retailer_interest="Please add your product interest.")),"agricultural-officer"==this.$route.params.usertype&&(this.userDetails.certificate||(this.errors.certificate="Certificate is required."),this.userDetails.job_title||(this.errors.job_title="Job title is required."),this.userDetails.office_name||(this.errors.office_name="Office name is required.")),this.userDetails.address.trim()||(this.errors.address="Address is required."),this.userDetails.country_id.toString().trim()||(this.errors.country_id="Country is required."),this.userDetails.state_id.toString().trim()||(this.errors.state_id="State/province  is required.")}})},p=(t("QSFe"),t("KHd+")),f=Object(p.a)(d,(function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",{staticClass:"floatSurvey"},[t("div",{staticClass:"container surveyContainer"},[t("img",{staticClass:"logoImg",attrs:{src:"/frontend-assets/img/core-img/logo.png",alt:""}}),e._v(" "),t("div",{staticClass:"row"},[t("div",{staticClass:"col-12 col-lg-5"},[t("p",[e._v("Welcome to SmartAgro! Let us know what brings you to SmartAgro and we’ll help you get the most value from our service.")]),e._v(" "),"farmer"==this.$route.params.usertype?[t("h3",{staticClass:"text-muted"},[e._v("Farmer details")]),e._v(" "),t("div",{staticClass:"mb-3"},[t("label",{attrs:{for:"acres"}},[e._v("The number of acres I farm is: (*)")]),e._v(" "),t("div",{staticClass:"input-group"},[t("input",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.acres,expression:"userDetails.acres"}],staticClass:"form-control form-control-sm",attrs:{type:"number",id:"acres",minlength:"1",maxlength:"4"},domProps:{value:e.userDetails.acres},on:{input:function(r){r.target.composing||e.$set(e.userDetails,"acres",r.target.value)}}}),e._v(" "),e._m(0)]),e._v(" "),(e.errors.acres&&Array.isArray(e.errors.acres)?e.errors.acres[0]:e.errors.acres)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.acres&&Array.isArray(e.errors.acres)?e.errors.acres[0]:e.errors.acres))])]:e._e()],2),e._v(" "),t("div",{staticClass:"mb-3"},[t("label",{attrs:{for:"acres"}},[e._v("What kind of product do you produce? (*)")]),e._v(" "),t("select",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.farmerType,expression:"userDetails.farmerType"}],staticClass:"form-control form-control-sm",attrs:{name:"farmerType",id:"State"},on:{change:function(r){var t=Array.prototype.filter.call(r.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.userDetails,"farmerType",r.target.multiple?t:t[0])}}},[t("option",{attrs:{value:"",selected:"",disabled:""}},[e._v("Select")]),e._v(" "),t("option",{attrs:{value:"crops",selected:""}},[e._v("Crops")]),e._v(" "),t("option",{attrs:{value:"fruits & vegetables",selected:""}},[e._v("Fruits & Vegetables")]),e._v(" "),t("option",{attrs:{value:"live Stock",selected:""}},[e._v("Live Stock")]),e._v(" "),t("option",{attrs:{value:"aquaculture",selected:""}},[e._v("Aquaculture")])]),e._v(" "),(e.errors.farmerType&&Array.isArray(e.errors.farmerType)?e.errors.farmerType[0]:e.errors.farmerType)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.farmerType&&Array.isArray(e.errors.farmerType)?e.errors.farmerType[0]:e.errors.farmerType))])]:e._e()],2)]:e._e(),e._v(" "),"retailer"==this.$route.params.usertype?[t("h3",{staticClass:"text-muted"},[e._v("Retailer details")]),e._v(" "),t("div",{staticClass:"mb-3"},[t("label",{attrs:{for:"retailer_interest"}},[e._v("What products you are interested in? (*)")]),e._v(" "),t("div",{staticClass:"input-group"},[t("input",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.retailer_interest,expression:"userDetails.retailer_interest"}],staticClass:"form-control form-control-sm",attrs:{type:"text",id:"retailer_interest",placeholder:"Crops, Fruits, Vegetables, Fish"},domProps:{value:e.userDetails.retailer_interest},on:{input:function(r){r.target.composing||e.$set(e.userDetails,"retailer_interest",r.target.value)}}})]),e._v(" "),(e.errors.retailer_interest&&Array.isArray(e.errors.retailer_interest)?e.errors.retailer_interest[0]:e.errors.retailer_interest)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.retailer_interest&&Array.isArray(e.errors.retailer_interest)?e.errors.retailer_interest[0]:e.errors.retailer_interest))])]:e._e()],2)]:e._e(),e._v(" "),"agricultural-officer"==this.$route.params.usertype?[t("h3",{staticClass:"text-muted"},[e._v("Agriculture officer details")]),e._v(" "),t("div",{staticClass:"mb-3"},[t("label",{attrs:{for:"retailer_interest"}},[e._v("Office Name (*)")]),e._v(" "),t("div",{staticClass:"input-group"},[t("input",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.office_name,expression:"userDetails.office_name"}],staticClass:"form-control form-control-sm",attrs:{type:"text",id:"office_name"},domProps:{value:e.userDetails.office_name},on:{input:function(r){r.target.composing||e.$set(e.userDetails,"office_name",r.target.value)}}})]),e._v(" "),(e.errors.office_name&&Array.isArray(e.errors.office_name)?e.errors.office_name[0]:e.errors.office_name)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.office_name&&Array.isArray(e.errors.office_name)?e.errors.office_name[0]:e.errors.office_name))])]:e._e()],2),e._v(" "),t("div",{staticClass:"mb-3"},[t("label",{attrs:{for:"retailer_interest"}},[e._v("Job Title (*)")]),e._v(" "),t("div",{staticClass:"input-group"},[t("input",{directives:[{name:"model",rawName:"v-model",value:e.userDetails.job_title,expression:"userDetails.job_title"}],staticClass:"form-control form-control-sm",attrs:{type:"text",id:"job_title"},domProps:{value:e.userDetails.job_title},on:{input:function(r){r.target.composing||e.$set(e.userDetails,"job_title",r.target.value)}}})]),e._v(" "),(e.errors.job_title&&Array.isArray(e.errors.job_title)?e.errors.job_title[0]:e.errors.job_title)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.job_title&&Array.isArray(e.errors.job_title)?e.errors.job_title[0]:e.errors.job_title))])]:e._e()],2),e._v(" "),t("div",{staticClass:"mb-3"},[t("label",{staticClass:"form-label",attrs:{for:"certificate"}},[e._v("Certificate")]),e._v(" "),t("input",{ref:"certificateFileInput",staticClass:"form-control form-control-sm",attrs:{type:"file",id:"certificate",accept:"pdf/*"},on:{change:e.onFilePicked}}),e._v(" "),(e.errors.certificate&&Array.isArray(e.errors.certificate)?e.errors.certificate[0]:e.errors.certificate)?[t("p",{staticClass:"text-danger mt-1"},[e._v(e._s(e.errors.certificate&&Array.isArray(e.errors.certificate)?e.errors.certificate[0]:e.errors.certificate))])]:e._e()],2)]:e._e(),e._v(" "),t("address-select-component",{attrs:{address:e.userDetails.address,errors:this.errors},on:{updateAddressValues:function(r){return e.updateAddressData(r)}}}),e._v(" "),t("Custom_Loading_Button",{staticClass:"mb-2",attrs:{Add_Input_Class:"col-12",processing:e.processing},on:{button_clicked:e.uploadUserDetails}},[t("span",[e._v("Submit")])])],2),e._v(" "),t("div",{staticClass:"col-12 col-lg-7"},["farmer"==this.$route.params.usertype?t("img",{staticClass:"fullHeightImage rounded",attrs:{src:"//www.theindiaforum.in/sites/default/files/field/image/2019/10/01/Ramkumar%20Radhakrishnan%2C%20Wikimedia-1569929663.jpeg",alt:""}}):"retailer"==this.$route.params.usertype?t("img",{staticClass:"fullHeightImage rounded",attrs:{src:"//www.einfochips.com/blog/wp-content/uploads/2020/08/facial-recognition-transforming-retail-by-enhancing-in-store-customer-experience-improving-retailers-operational-efficiency-featured.jpg",alt:""}}):"agricultural-officer"==this.$route.params.usertype?t("img",{staticClass:"fullHeightImage rounded",attrs:{src:"//www.agriculture.com.ph/wp-content/uploads/2019/07/32Agricultural-Development-Officers_December-2018-744x426.png",alt:""}}):e._e()])])])])}),[function(){var e=this.$createElement,r=this._self._c||e;return r("div",{staticClass:"input-group-prepend"},[r("div",{staticClass:"input-group-text"},[this._v("ac")])])}],!1,null,"55f4f49c",null);r.default=f.exports},P42d:function(e,r,t){"use strict";t("/Tqy")},QSFe:function(e,r,t){"use strict";t("FmS5")},TTEv:function(e,r,t){(e.exports=t("I1BE")(!1)).push([e.i,"textarea[data-v-1d20d891]{resize:none}",""])},s9A9:function(e,r,t){(e.exports=t("I1BE")(!1)).push([e.i,".floatSurvey[data-v-55f4f49c]{position:absolute;top:0;left:0;bottom:0;right:0;z-index:1000;height:100%;width:100%;background:#fff}.surveyContainer[data-v-55f4f49c]{padding:4%}.logoImg[data-v-55f4f49c]{height:40px;width:auto}.fullHeightImage[data-v-55f4f49c]{height:100%;width:100%;-o-object-fit:cover;object-fit:cover;-o-object-position:center center;object-position:center center}",""])},xISs:function(e,r,t){"use strict";t.r(r);var s=t("o0o1"),a=t.n(s),i=t("sZ6p"),o=t("L2JU");function n(e,r,t,s,a,i,o){try{var n=e[i](o),c=n.value}catch(e){return void t(e)}n.done?r(c):Promise.resolve(c).then(s,a)}function c(e,r){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);r&&(s=s.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),t.push.apply(t,s)}return t}function l(e){for(var r=1;r<arguments.length;r++){var t=null!=arguments[r]?arguments[r]:{};r%2?c(Object(t),!0).forEach((function(r){u(e,r,t[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):c(Object(t)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))}))}return e}function u(e,r,t){return r in e?Object.defineProperty(e,r,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[r]=t,e}var d={data:function(){return{credentials:{email:"",password:"",password_confirmation:"",token:""},errors:{},processing:!1,btnDisabled:!1}},mounted:function(){this.$route.params.token?this.credentials.token=this.$route.params.token:(this.$store.dispatch("snackbar/addSnack",{color:"danger",msg:"Password reset token is missing.",snakbarType:"Error"},{root:!0}),this.$router.replace({name:"ForgotPassword"}))},methods:l(l({},Object(o.b)({resetPassword:"auth/resetPassword",clearAuthError:"auth/clearError"})),{},{resetPasswordSubmit:function(){var e,r=this;return(e=a.a.mark((function e(){var t;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if((t=r).processing=!0,t.$Progress.start(),t.errors={},t.clearAuthError(),t.credentials.email.trim()||(t.errors.email="Email is required!"),t.credentials.password.trim()?t.credentials.password.trim().length<8?t.errors.password="Password should be at least 8 characters!":t.credentials.password.trim()!==t.credentials.password_confirmation.trim()&&(t.errors.password="Password confirmation does not match!"):t.errors.password="Password is required!",!Object.keys(t.errors).length){e.next=11;break}return t.$Progress.fail(),t.processing=!1,e.abrupt("return");case 11:return e.next=13,r.resetPassword(r.credentials).finally((function(){t.processing=!1}));case 13:if(null==i.a.state.error){e.next=17;break}return t.$Progress.fail(),t.errors=i.a.state.error,e.abrupt("return");case 17:return t.formDisabled=!0,e.next=20,r.$router.replace({name:"Login"});case 20:case"end":return e.stop()}}),e)})),function(){var r=this,t=arguments;return new Promise((function(s,a){var i=e.apply(r,t);function o(e){n(i,s,a,o,c,"next",e)}function c(e){n(i,s,a,o,c,"throw",e)}o(void 0)}))})()}})},p=t("KHd+"),f=Object(p.a)(d,(function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",{staticClass:"container"},[t("div",{staticClass:"col-12 col-md-6 col-lg-4 m-auto mb-4"},[t("h3",{staticClass:"text-center mt-4 text-muted"},[e._v("Reset Password")]),e._v(" "),t("div",[t("div",{},[t("form",{attrs:{method:"post",autofocus:"autofocus"},on:{submit:function(r){return r.stopPropagation(),r.preventDefault(),e.resetPasswordSubmit(r)}}},[t("Custom_Text_Input",{staticClass:"mb-4",attrs:{label:"Email",id:"email",type:"email",placeholder:"example@email.com",error:e.errors.email&&Array.isArray(e.errors.email)?e.errors.email[0]:e.errors.email,Add_Input_Class:"h-10 dark:bg-gray-900"},model:{value:e.credentials.email,callback:function(r){e.$set(e.credentials,"email",r)},expression:"credentials.email"}}),e._v(" "),t("Custom_Text_Input",{staticClass:"mb-4",attrs:{label:"Password",id:"password",type:"password",placeholder:"********",error:e.errors.password&&Array.isArray(e.errors.password)?e.errors.password[0]:e.errors.password,Add_Input_Class:"h-10 dark:bg-gray-900"},model:{value:e.credentials.password,callback:function(r){e.$set(e.credentials,"password",r)},expression:"credentials.password"}}),e._v(" "),t("Custom_Text_Input",{staticClass:"mb-4",attrs:{label:"Password Confirmation",id:"password_confirmation",type:"password",placeholder:"********",Add_Input_Class:"h-10 dark:bg-gray-900"},model:{value:e.credentials.password_confirmation,callback:function(r){e.$set(e.credentials,"password_confirmation",r)},expression:"credentials.password_confirmation"}}),e._v(" "),t("Custom_Text_Input",{staticClass:"invisible",attrs:{id:"token",type:"text",placeholder:"token",hidden:!0},model:{value:e.credentials.token,callback:function(r){e.$set(e.credentials,"token",r)},expression:"credentials.token"}}),e._v(" "),t("Custom_Loading_Button",{attrs:{Add_Input_Class:"mb-4 mt-6 block mx-auto uppercase rounded",processing:e.processing,disabled:e.btnDisabled},on:{button_clicked:e.resetPasswordSubmit}},[t("span",[e._v("Reset password")])])],1)]),e._v(" "),t("div",{staticClass:"text-center mt-4 text-gray-800 dark:text-gray-300"},[e._v("\n                Back to "),t("router-link",{staticClass:"text-blue-500",attrs:{to:"/login"}},[e._v(" login.")])],1)])])])}),[],!1,null,null,null);r.default=f.exports}}]);