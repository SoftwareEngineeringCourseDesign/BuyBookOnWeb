webpackJsonp([21],{"+skl":function(e,n){},"2mV7":function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o=t("gNcp"),a={};o.keys().forEach(function(e){"./index.js"!==e&&(a[e.replace(/(\.\/|\.js)/g,"")]=o(e).default)}),n.default=a},"D+VX":function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});n.default={state:{authUser:{},token:""},getters:{},mutations:{SET_AUTH_USER:function(e,n){e.authUser=n},SET_API_TOKEN:function(e,n){e.token=n}},actions:{}}},NHnr:function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o=t("7+uW"),a={render:function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",{staticClass:"Footer"},[t("Row",{staticStyle:{height:"auto"}},e._l(e.List,function(n,o){return t("Col",{key:o,staticStyle:{"margin-top":"20px"},attrs:{name:n.name,span:"6"}},[t("div",[e._v(e._s(n.name))]),e._v(" "),e._l(n.subLink,function(n,o){return t("a",{key:o,attrs:{href:n.link,onclick:"false"}},[e._v("\n        "+e._s(n.name)+"\n      ")])})],2)})),e._v(" "),t("Row",{staticStyle:{height:"auto","margin-top":"20px"}},[t("Col",[t("div",[e._v("2018 © Qian Kaihua, Wu Beichen, Zhong Xiangjie")])])],1)],1)},staticRenderFns:[]};var i={name:"App",components:{iFooter:t("VU/8")({name:"Footer",components:{},data:function(){return{List:[{name:"关于我们",subLink:[{name:"留言板",link:"javascript:void(0);"},{name:"联系我们",link:"javascript:void(0);"},{name:"关于网站",link:"javascript:void(0);"}]},{name:"购物指南",subLink:[{name:"购物流程",link:"javascript:void(0);"},{name:"发票制度",link:"javascript:void(0);"},{name:"账户管理",link:"javascript:void(0);"},{name:"会员优惠",link:"javascript:void(0);"}]},{name:"快捷入口",subLink:[{name:"出版商管理",link:"/bookseller"},{name:"后台管理",link:"/admin"}]},{name:"帮助中心",subLink:[{name:"常见问题",link:"javascript:void(0);"},{name:"付款方式",link:"javascript:void(0)"}]}]}}},a,!1,function(e){t("ZfAB")},"data-v-dd6c1d64",null).exports},beforeMount:function(){this.$store.commit("SET_API_TOKEN",void 0===localStorage.token?"":JSON.parse(localStorage.token)),this.$store.commit("SET_AUTH_USER",void 0===localStorage.authUser?"":JSON.parse(localStorage.authUser)),console.log("-----------------------------\n若想申请成为bookseller\n或是想参与开发该网站\n请联系管理员\nGitHub: https://github.com/qiankaihua\n-----------------------------")},data:function(){return{}},computed:{key:function(){return console.log("re-generate key"),void 0!==this.$route.name?this.$route.name+ +new Date:this.$route+ +new Date}}},r={render:function(){var e=this.$createElement,n=this._self._c||e;return n("div",{attrs:{id:"app"}},[n("router-view",{key:this.key}),this._v(" "),n("i-footer"),this._v(" "),n("BackTop")],1)},staticRenderFns:[]};var l=t("VU/8")(i,r,!1,function(e){t("eXXd")},null,null).exports,c=t("/ocq");o.default.use(c.a);var u=new c.a({mode:"history",routes:[{path:"/",name:"Index",component:function(e){return Promise.all([t.e(0),t.e(9)]).then(function(){var n=[t("42Hy")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/login",name:"Login",component:function(e){return Promise.all([t.e(0),t.e(2)]).then(function(){var n=[t("xJsL")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/register",name:"Register",component:function(e){return Promise.all([t.e(0),t.e(1)]).then(function(){var n=[t("dIqY")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/select",name:"Select",component:function(e){return Promise.all([t.e(0),t.e(18)]).then(function(){var n=[t("wi0O")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/book/:book_id",name:"BookDetail",component:function(e){return Promise.all([t.e(0),t.e(11)]).then(function(){var n=[t("vKXr")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/user",name:"UserInfo",component:function(e){return Promise.all([t.e(0),t.e(3)]).then(function(){var n=[t("nC4d")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/create-order/:book_id",name:"CreateOrder",component:function(e){return Promise.all([t.e(0),t.e(12)]).then(function(){var n=[t("fzky")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/order/:order_id",name:"OrderDetail",component:function(e){return Promise.all([t.e(0),t.e(17)]).then(function(){var n=[t("PxWg")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/user/new-book-seller",name:"NewBookSeller",component:function(e){return Promise.all([t.e(0),t.e(14)]).then(function(){var n=[t("Rl75")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"/admin",component:function(e){return Promise.all([t.e(0),t.e(8)]).then(function(){var n=[t("5Nbq")];e.apply(null,n)}.bind(this)).catch(t.oe)},children:[{path:"/",name:"Dashboard",component:function(e){return t.e(4).then(function(){var n=[t("V0Xf")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"orderManager",name:"OrderManager",component:function(e){return t.e(16).then(function(){var n=[t("h3P3")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"bookManager",name:"BookManager",component:function(e){return t.e(13).then(function(){var n=[t("ToGb")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"booksellerManager",name:"BooksellerManager",component:function(e){return t.e(7).then(function(){var n=[t("O96J")];e.apply(null,n)}.bind(this)).catch(t.oe)}}]},{path:"/bookSeller",component:function(e){return Promise.all([t.e(0),t.e(10)]).then(function(){var n=[t("O7dw")];e.apply(null,n)}.bind(this)).catch(t.oe)},children:[{path:"/",name:"DashboardBookSeller",component:function(e){return t.e(5).then(function(){var n=[t("g87v")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"new-book",name:"NewBook",component:function(e){return t.e(15).then(function(){var n=[t("JYM2")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"orderManager",name:"BookSellerOrderManager",component:function(e){return Promise.all([t.e(0),t.e(19)]).then(function(){var n=[t("juVm")];e.apply(null,n)}.bind(this)).catch(t.oe)}},{path:"bookManager",name:"BookSellerBookManager",component:function(e){return Promise.all([t.e(0),t.e(6)]).then(function(){var n=[t("V0b2")];e.apply(null,n)}.bind(this)).catch(t.oe)}}]}]}),s=t("NYxO"),p=t("2mV7");o.default.use(s.a);var d=new s.a.Store({modules:p.default,strict:!1}),h=t("BTaQ"),f=t.n(h),m=(t("+skl"),t("M4fF")),v=t.n(m),k=t("mtWM"),b=t.n(k);o.default.use(f.a),o.default.config.productionTip=!1,b.a.defaults.baseURL="/api/",o.default._=o.default.prototype._=window._=Window.prototype._=v.a,o.default.$http=o.default.prototype.$http=b.a,window.title_suf="|网上书店",new o.default({el:"#app",router:u,store:d,components:{App:l},template:"<App/>"}).$mount("#app")},YDKd:function(e,n,t){(e.exports=t("FZ+f")(!1)).push([e.i,".Footer[data-v-dd6c1d64]{text-align:center;background-color:silver;height:250px;width:100%;font-size:150%;z-index:-1}a[data-v-dd6c1d64]{display:block;font-size:12px;height:24px;color:#6f6f6f}a[data-v-dd6c1d64]:hover{color:red;text-decoration:underline}",""])},ZfAB:function(e,n,t){var o=t("YDKd");"string"==typeof o&&(o=[[e.i,o,""]]),o.locals&&(e.exports=o.locals);t("rjj0")("05c2a54b",o,!0,{})},eXXd:function(e,n,t){var o=t("kpea");"string"==typeof o&&(o=[[e.i,o,""]]),o.locals&&(e.exports=o.locals);t("rjj0")("60b36e1f",o,!0,{})},gNcp:function(e,n,t){var o={"./auth.js":"D+VX","./index.js":"2mV7"};function a(e){return t(i(e))}function i(e){var n=o[e];if(!(n+1))throw new Error("Cannot find module '"+e+"'.");return n}a.keys=function(){return Object.keys(o)},a.resolve=i,e.exports=a,a.id="gNcp"},kpea:function(e,n,t){(e.exports=t("FZ+f")(!1)).push([e.i,"#app{font-family:Avenir,Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;color:#2c3e50}",""])}},["NHnr"]);
//# sourceMappingURL=app.fa7130de3e17fa7a9f49.js.map