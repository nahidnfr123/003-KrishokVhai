(window.webpackJsonp=window.webpackJsonp||[]).push([[12],{"5IKa":function(t,e,r){"use strict";r("BYaZ")},BYaZ:function(t,e,r){var a=r("U6b9");"string"==typeof a&&(a=[[t.i,a,""]]);var s={hmr:!0,transform:void 0,insertInto:void 0};r("aET+")(a,s);a.locals&&(t.exports=a.locals)},KdiG:function(t,e,r){"use strict";r("qfHW")},U6b9:function(t,e,r){(t.exports=r("I1BE")(!1)).push([t.i,".hoverActive[data-v-41acc222]:hover{background:hsla(0,0%,39.2%,.2);color:#282814}.hoverActive[data-v-41acc222]{cursor:pointer;padding:2px 4px;border-radius:4px}.hoverActive.active[data-v-41acc222]{background:#1e90ff;color:#fff}",""])},c5ef:function(t,e,r){"use strict";r.r(e);var a=r("o0o1"),s=r.n(a),o=r("L2JU"),i=r("2de+");function n(t,e,r,a,s,o,i){try{var n=t[o](i),c=n.value}catch(t){return void r(t)}n.done?e(c):Promise.resolve(c).then(a,s)}function c(t){return function(){var e=this,r=arguments;return new Promise((function(a,s){var o=t.apply(e,r);function i(t){n(o,a,s,i,c,"next",t)}function c(t){n(o,a,s,i,c,"throw",t)}i(void 0)}))}}function l(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,a)}return r}function d(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?l(Object(r),!0).forEach((function(e){u(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function u(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var p={name:"Blogs",components:{CategoryListFrontend:r("ynWN").a,Pagination:i.a},data:function(){return{loading:!1,posts:{},errors:[],postCategories:{},pagination:{current_page:1},postCategoryId:0,filters:{articles_type:"news",query:"",category_name:"",categories:[],limit:"8"}}},activated:function(){this.filters={articles_type:"news",query:"",category_name:"",categories:[],limit:"8"}},created:function(){this.getPosts(),this.getPostCategories()},watch:{$route:{handler:function(t,e){t!=e&&this.getPosts()},deep:!0,immediate:!0},"filters.query":function(){this.getPosts()},postCategoryId:function(){this.getPosts()}},computed:d({},Object(o.c)({postsFrontend:"post/postsFrontend",user:"auth/user"})),methods:d(d({},Object(o.b)({getPostsFrontend:"post/getPostsFrontend"})),{},{getPostCategories:function(){var t=this;return c(s.a.mark((function e(){return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,axios.get("api/post/category/view").then((function(e){t.postCategories=e.data.data}));case 2:case"end":return e.stop()}}),e)})))()},showAllCategory:function(){this.postCategoryId=0,this.filters.categories=[]},selectedCategories:function(t){if(this.postCategoryId=t.id,this.filters.categories=[],this.filters.categories.push(t.id),t.children)for(var e=0;e<t.children.length;e++)this.filters.categories.push(t.children[e].id)},getPosts:function(){var t=arguments,e=this;return c(s.a.mark((function r(){var a;return s.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return a=t.length>0&&void 0!==t[0]?t[0]:e.pagination.current_page,e.filters.articles_type="news",e.loading=!0,r.next=5,axios.get("api/post/frontend?page=".concat(a),{params:e.filters}).then((function(t){e.posts=t.data.data,e.pagination=t.data.meta})).catch((function(t){})).finally((function(){var t=e.$refs.ScrollPoint;t&&t.scrollIntoView({behavior:"smooth"}),e.loading=!1}));case 5:case"end":return r.stop()}}),r)})))()}})},g=(r("KdiG"),r("KHd+")),v=Object(g.a)(p,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("div",{staticClass:"breadcrumb-area bg-img bg-overlay jarallax",staticStyle:{"background-image":"url('/frontend-assets/img/bg-img/18.jpg')"}},[r("div",{staticClass:"container h-100"},[r("div",{staticClass:"row h-100 align-items-center"},[r("div",{staticClass:"col-12"},[r("div",{staticClass:"breadcrumb-text"},[r("h2",[t._v(t._s(t.filters.articles_type))])])])])])]),t._v(" "),r("div",{ref:"ScrollPoint",staticClass:"famie-breadcrumb"},[r("div",{staticClass:"container"},[r("nav",{attrs:{"aria-label":"breadcrumb"}},[r("ol",{staticClass:"breadcrumb"},[r("li",{staticClass:"breadcrumb-item"},[r("router-link",{attrs:{to:"/"}},[r("i",{staticClass:"fa fa-home"}),t._v(" Home")])],1),t._v(" "),r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(t.filters.articles_type))])])])])]),t._v(" "),r("section",{staticClass:"famie-blog-area"},[r("div",{staticClass:"container"},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-12 col-md-8"},[r("div",{staticClass:"posts-area"},[t.loading?r("div",{staticClass:"col-12"},[t.loading?r("loading",{attrs:{msg:"Loading posts ..."}}):t._e()],1):t._e(),t._v(" "),t.posts&&Object.keys(t.posts).length?t._l(t.posts,(function(e){return r("div",{staticClass:"single-blog-post-area mb-50 wow fadeInUp",attrs:{"data-wow-delay":"100ms"}},[r("h6",[t._v("Post on "),r("a",{staticClass:"post-date"},[t._v(t._s(t._f("dateFormatMDY")(e.created_at)))]),t._v("\n                                    /\n                                    "),t.user?t._e():r("router-link",{attrs:{to:"/login"}},[t._v(t._s(e.author))]),t._v(" "),t.user&&t.user.id==e.user_id?r("a",{attrs:{href:"dashboard/@"+t.user.username+"/profile",target:"_blank"}},[t._v(t._s(e.author))]):t.user?r("a",{staticClass:"post-author",attrs:{href:"/dashboard/@"+t.user.username+"/users/view-profile/"+e.user_id,target:"_blank"}},[t._v(t._s(e.author))]):t._e()],1),t._v(" "),r("router-link",{staticClass:"post-title",attrs:{to:{name:"Read Article",params:{articles_type:t.filters.articles_type,post_slug:e.slug}}}},[t._v("\n                                    "+t._s(e.title)+"\n                                ")]),t._v(" "),r("img",{staticClass:"post-thumb rounded",staticStyle:{width:"100%","max-height":"400px","object-fit":"cover","object-position":"center center"},attrs:{src:e.first_image?e.first_image:"/frontend-assets/placeholder.gif",alt:""}}),t._v(" "),r("div",{staticClass:"post-excerpt"},[t._v(t._s(t._f("truncate")(e.description,160)))])],1)})):r("div",{attrs:{role:"alert"}},[t.loading?t._e():r("div",{staticClass:"alert alert-danger"},[t._v("\n                                No blogs found ...\n                            ")])])],2),t._v(" "),t.posts&&Object.keys(t.posts).length?r("div",{staticClass:"paginationLink row"},[r("div",{staticClass:"col-12 col-md-6",staticStyle:{"margin-top":"10px"}},[t.pagination.last_page>1?r("pagination",{attrs:{pagination:t.pagination,offset:5},on:{paginate:function(e){return t.getPosts()}}}):t._e()],1)]):t._e()]),t._v(" "),r("div",{staticClass:"col-12 col-md-4"},[r("div",{staticClass:"sidebar-area"},[r("div",{staticClass:"single-widget-area"},[r("div",[r("label",{attrs:{for:"_search_"}},[t._v("Search")]),t._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.filters.query,expression:"filters.query"}],staticClass:"form-control",attrs:{type:"text",id:"_search_"},domProps:{value:t.filters.query},on:{input:function(e){e.target.composing||t.$set(t.filters,"query",e.target.value)}}})])]),t._v(" "),r("div",{staticClass:"single-widget-area"},[r("h5",{staticClass:"widget-title"},[t._v("Categories")]),t._v(" "),t.postCategories&&Object.keys(t.postCategories).length?r("div",{staticStyle:{"border-radius":"4px"}},[r("h6",{staticClass:"cursor-pointer hoverActive",class:[0==t.postCategoryId?"bg-primary text-white":""],on:{click:function(e){return e.stopPropagation(),e.preventDefault(),t.showAllCategory(e)}}},[t._v("All")]),t._v(" "),r("category-list-frontend",{attrs:{categoryProductCountFilter:"news",data:t.postCategories,id:"searchCategory",selectedCategory:t.postCategoryId},on:{nodeClicked:function(e){return t.selectedCategories(e)}}})],1):t._e()])])])])])])])}),[],!1,null,"695d60e3",null);e.default=v.exports},nj3Z:function(t,e,r){(t.exports=r("I1BE")(!1)).push([t.i,".hoverActive[data-v-695d60e3]:hover{background:hsla(0,0%,39.2%,.2);color:#282814}.hoverActive[data-v-695d60e3]{cursor:pointer;padding:2px 4px;border-radius:4px}.hoverActive.active[data-v-695d60e3]{background:#1e90ff;color:#fff}.truncate[data-v-695d60e3]{width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}",""])},qfHW:function(t,e,r){var a=r("nj3Z");"string"==typeof a&&(a=[[t.i,a,""]]);var s={hmr:!0,transform:void 0,insertInto:void 0};r("aET+")(a,s);a.locals&&(t.exports=a.locals)},ynWN:function(t,e,r){"use strict";var a={name:"category-list-frontend",data:function(){return{errors:[]}},props:{data:{type:[Object,Array]},selectedCategory:{type:[Number]},categoryProductCountFilter:{type:[String]}},methods:{nodeClicked:function(t){this.$emit("nodeClicked",t)}}},s=(r("5IKa"),r("KHd+")),o=Object(s.a)(a,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("ul",t._l(t.data,(function(e,a){return r("li",{key:e.id},[r("div",{staticClass:"cursor-pointer hoverActive",class:[t.selectedCategory==e.id?"active":""],on:{click:function(r){return r.stopPropagation(),r.preventDefault(),t.nodeClicked(e)}}},[t._v("\n            "+t._s(e.title)+"\n            "),r("span",{staticStyle:{"margin-left":"10px"}},[t.categoryProductCountFilter&&"news"==t.categoryProductCountFilter?r("span",[t._v("( "+t._s(e.news_count)+" )")]):t.categoryProductCountFilter&&"blog"==t.categoryProductCountFilter?r("span",[t._v("( "+t._s(e.blog_count)+" )")]):t.categoryProductCountFilter&&"farming-practice"==t.categoryProductCountFilter?r("span",[t._v("( "+t._s(e.practice_count)+" )")]):r("span",[t._v("( "+t._s(e.post_count)+" )")])])]),t._v(" "),e.children&&Object.keys(e.children).length?[r("category-list-frontend",{attrs:{categoryProductCountFilter:t.categoryProductCountFilter,data:e.children,selectedCategory:t.selectedCategory},on:{nodeClicked:function(e){return t.nodeClicked(e)}}})]:t._e()],2)})),0)}),[],!1,null,"41acc222",null);e.a=o.exports}}]);