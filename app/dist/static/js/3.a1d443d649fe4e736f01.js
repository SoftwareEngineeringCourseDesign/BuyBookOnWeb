webpackJsonp([3],{"1Ksz":function(e,t,s){var a=s("MO3n");"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);s("rjj0")("68578906",a,!0,{})},DfZv:function(e,t,s){(e.exports=s("FZ+f")(!1)).push([e.i,".msg[data-v-2f8d7a27]{margin-top:20px;font-size:24px}.edit[data-v-2f8d7a27]{margin-left:30px;color:#2d8cf0;cursor:pointer}.password[data-v-2f8d7a27]{display:inline-block!important;width:400px!important;margin-right:20px;margin-left:20px}.error[data-v-2f8d7a27]{color:red;margin-left:20%;margin-top:5px;font-size:12px}",""])},"M+/E":function(e,t,s){var a=s("e+PU");"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);s("rjj0")("7f8128d4",a,!0,{})},MO3n:function(e,t,s){(e.exports=s("FZ+f")(!1)).push([e.i,".msg[data-v-94911a78]{margin-top:20px;font-size:24px}",""])},"P/X9":function(e,t,s){var a=s("iMbM");"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);s("rjj0")("0aadb5b1",a,!0,{})},SiKO:function(e,t,s){(e.exports=s("FZ+f")(!1)).push([e.i,"",""])},"e+PU":function(e,t,s){(e.exports=s("FZ+f")(!1)).push([e.i,".avatar-content[data-v-2676bcfe]{margin-left:40%;margin-top:50px}",""])},iMbM:function(e,t,s){(e.exports=s("FZ+f")(!1)).push([e.i,".order[data-v-25c7e4e1]{width:90%;margin-top:50px;margin-right:50px;margin-bottom:50px}.select-step[data-v-25c7e4e1]{margin-right:100px;width:200px}",""])},nC4d:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=s("BTaQ"),r=s.n(a),i=s("PJh5"),n=s.n(i),o=s("teIl"),c={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("h1",{staticStyle:{width:"100%","text-align":"center"}},[e._v("个人信息")]),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"ios-person",size:e.size}}),e._v(" "),s("span",[e._v("用户名: "+e._s(e.user.username))])],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"ios-email",size:e.size}}),e._v(" "),s("span",[e._v("邮箱： "+e._s(e.user.email))])],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"key",size:e.size}}),e._v(" "),s("span",[e._v("角色： "+e._s(e.user.role.name))])],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"social-yen",size:e.size}}),e._v(" "),s("span",[e._v("余额： "+e._s(e.user.money))])],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"ios-time",size:e.size}}),e._v(" "),s("span",[e._v("创建时间： "+e._s(e.user.createTime))])],1)])},staticRenderFns:[]};var l=s("VU/8")({name:"SelfInfo",props:["user"],data:function(){return{size:24}},computed:{},methods:{}},c,!1,function(e){s("1Ksz")},"data-v-94911a78",null).exports,d={props:["user"],name:"SafeCenter",data:function(){return{error:{non:!1,len:!1,beg:!1},size:24,oldPassword:"",newPassword:"",changePassword:!1}},computed:{},methods:{Change:function(){var e=this;if(this.validate()){this.$Loading.start();var t=s("BVsN")("sha1");t.update(this.oldPassword),this.oldPassword=t.digest("HEX");var a=s("BVsN")("sha1");a.update(this.newPassword),this.newPassword=a.digest("HEX"),console.log({token:this.$store.state.auth.token,password_new:this.newPassword,password_old:this.oldPassword}),this.$http.put("user/"+this.user.id,{token:this.$store.state.auth.token,password_new:this.newPassword,password_old:this.oldPassword}).then(function(t){localStorage.clear(),e.$store.commit("SET_API_TOKEN",""),e.$store.commit("SET_AUTH_USER",""),e.$Loading.finish(),e.$Notice.success({title:"密码修改成功，请重新登录"}),e.$router.push({name:"Login"})}).catch(function(t){switch(r.a.LoadingBar.error(),t.response.status){case 401:r.a.Notice.error({title:"您未登录或会话超时"}),e.$router.push({name:"Login"});break;case 403:r.a.Notice.error({title:"您没有权限"});break;case 444:r.a.Notice.error({title:"密码错误"})}e.oldPassword=e.newPassword=""})}},validate:function(){return this.error.non=this.error.len=this.error.beg=!1,""===this.newPassword?(this.error.non=!0,!1):/^[\x21-\x7e]{4,20}$/.test(this.newPassword)?!!/^[a-zA-Z]/.test(this.newPassword)||(this.error.beg=!0,!1):(this.error.len=!0,!1)}}},u={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("h1",{staticStyle:{width:"100%","text-align":"center"}},[e._v("安全中心")]),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"ios-person",size:e.size}}),e._v(" "),s("span",[e._v("用户名: "+e._s(e.user.username))])],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"ios-email",size:e.size}}),e._v(" "),s("span",[e._v("邮箱： "+e._s(e.user.email))])],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"key",size:e.size}}),e._v(" "),s("span",[e._v("角色： "+e._s(e.user.role.name))])],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"ios-locked",size:e.size}}),e._v(" "),s("span",{directives:[{name:"show",rawName:"v-show",value:!e.changePassword,expression:"!changePassword"}]},[e._v("密码：**********")]),e._v(" "),e.changePassword?s("span",[e._v("新密码：")]):e._e(),e._v(" "),e.changePassword?s("input",{directives:[{name:"model",rawName:"v-model",value:e.newPassword,expression:"newPassword"}],staticClass:"password ivu-input",attrs:{type:"password",placeholder:"输入新密码"},domProps:{value:e.newPassword},on:{blur:function(t){e.validate()},input:function(t){t.target.composing||(e.newPassword=t.target.value)}}}):e._e(),e._v(" "),s("p",{directives:[{name:"show",rawName:"v-show",value:e.error.non,expression:"error.non"}],staticClass:"error"},[e._v("新密码不能为空")]),e._v(" "),s("p",{directives:[{name:"show",rawName:"v-show",value:e.error.len,expression:"error.len"}],staticClass:"error"},[e._v("新密码长度必须在4到20位之间")]),e._v(" "),s("p",{directives:[{name:"show",rawName:"v-show",value:e.error.beg,expression:"error.beg"}],staticClass:"error"},[e._v("新密码必须由字母开头")]),e._v(" "),s("span",{on:{click:function(t){e.changePassword=!e.changePassword}}},[s("Icon",{directives:[{name:"show",rawName:"v-show",value:!e.changePassword,expression:"!changePassword"}],staticClass:"edit",attrs:{type:"edit",size:e.size}})],1)],1),e._v(" "),s("div",{staticClass:"msg"},[s("Icon",{attrs:{type:"ios-unlocked"}}),e._v(" "),s("span",[e._v("确认原密码:")]),e._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:e.oldPassword,expression:"oldPassword"}],staticClass:"password ivu-input",attrs:{type:"password",placeholder:"输入原密码"},domProps:{value:e.oldPassword},on:{input:function(t){t.target.composing||(e.oldPassword=t.target.value)}}})],1),e._v(" "),s("div",{staticStyle:{"text-align":"center","margin-top":"30px"}},[s("Button",{attrs:{type:"primary"},on:{click:function(t){e.Change()}}},[e._v("提交修改")])],1)])},staticRenderFns:[]};var p=s("VU/8")(d,u,!1,function(e){s("yMr0")},"data-v-2f8d7a27",null).exports,h={render:function(){this.$createElement;this._self._c;return this._m(0)},staticRenderFns:[function(){var e=this.$createElement,t=this._self._c||e;return t("div",[t("h1",{staticStyle:{width:"100%","text-align":"center"}},[this._v("设置中心")]),this._v("\n  暂无设置\n")])}]};var v=s("VU/8")({name:"SetCenter",data:function(){return{}},computed:{},methods:{}},h,!1,function(e){s("phfa")},"data-v-5ba1e25b",null).exports,m={props:["user"],name:"",data:function(){var e=this;return{T:!0,Loading:!0,orders:[],columns:[{title:"订单编号",fixed:"left",width:100,key:"id"},{title:"购买数量",width:120,key:"number"},{title:"总金额",width:130,key:"sum"},{title:"优惠方式",width:120,key:"discount"},{title:"创建时间",width:150,key:"createTime"},{title:"订单状态",key:"step",width:120,render:function(t,s){return t("div",e.GetStepMessage(s.row.step))}},{title:"操作",fixed:"right",width:100,render:function(t,s){return t("i-button",{props:{type:"primary",size:"small"},on:{click:function(){e.OrderDetail(s.row.id)}}},"查看详情")}}],Page:{cur:1,size:10,total:0,step:-1},Steps:[{step:-1,title:"查看全部"},{step:1,title:"未支付"},{step:2,title:"待发货"},{step:3,title:"已发货"},{step:4,title:"已收货"},{step:5,title:"已评分"}]}},created:function(){var e=(this.$route.query.page||"").split(",");this.Page.cur=+e[0]||1,this.Page.size=+e[1]||10,this.Page.step=+e[2]||-1,this.GetOrder()},computed:{},watch:{Page:{handler:function(e,t){var s=this.Page.cur+","+this.Page.size+","+this.Page.step,a=this.$route.query.now||"selfInfo";this.$router.push({query:{now:a,page:s}})},deep:!0}},methods:{GetStepMessage:function(e){var t="";switch(e){case 1:t="未支付";break;case 2:t="待发货";break;case 3:t="已发货";break;case 4:t="已收货";break;case 5:t="已评分";break;default:t="未知状态"}return t},toDecimal2:function(e){var t=(Math.round(100*e)/100).toString(),s=t.indexOf(".");for(s<0&&(s=t.length,t+=".");t.length<=s+2;)t+="0";return"￥"+t},OrderDetail:function(e){console.log(e),this.$router.push({name:"OrderDetail",params:{order_id:e}})},ChangeStep:function(){this.GetOrder()},GetOrder:function(){var e=this,t={token:this.$store.state.auth.token,user_id:this.user.id,limit:this.Page.size,offset:this.Page.size*(this.Page.cur-1)};-1!==this.Page.step&&(t.step=this.Page.step),this.$http.get("order",{params:t}).then(function(t){var s=void 0;for(s in e.orders=[],t.data){var a={};a.id=t.data[s].id,a.number=t.data[s].number,a.sum=e.toDecimal2(t.data[s].sum/100),a.createTime=n.a.unix(+t.data[s].created_at).format("YYYY-MM-DD"),a.discount="无优惠",a.step=t.data[s].step,e.orders.push(a)}e.Loading=!1,e.Page.total=+t.headers["x-total"]}).catch(function(e){})}}},f={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("h1",{staticStyle:{width:"100%","text-align":"center"}},[e._v("订单中心")]),e._v(" "),s("Row",{staticStyle:{"margin-top":"50px"}},[s("Col",{attrs:{span:24,align:"right"}},[s("Select",{staticClass:"select-step",on:{"on-change":e.ChangeStep},model:{value:e.Page.step,callback:function(t){e.$set(e.Page,"step",t)},expression:"Page.step"}},e._l(e.Steps,function(t){return s("Option",{key:t.step,attrs:{value:t.step,label:t.title}},[s("span",[e._v(e._s(t.title))])])}))],1)],1),e._v(" "),s("div",{staticClass:"order"},[s("Table",{attrs:{border:"",columns:e.columns,data:e.orders,"no-data-text":"暂无订单",stripe:e.T,loading:e.Loading}})],1),e._v(" "),s("Row",{staticStyle:{"margin-bottom":"50px","margin-right":"100px"}},[s("Col",{attrs:{span:24,align:"right"}},[s("Page",{attrs:{size:"small","show-elevator":"","show-sizer":"","show-total":"",current:e.Page.cur,"page-size":e.Page.size,total:e.Page.total},on:{"on-change":function(t){e.Page.cur=t},"on-page-size-change":function(t){e.Page.size=t}}})],1)],1)],1)},staticRenderFns:[]};var g=s("VU/8")(m,f,!1,function(e){s("P/X9")},"data-v-25c7e4e1",null).exports,w={name:"Information",components:{iHeader:o.a,iSelfInfo:l,iSafeCenter:p,iSetCenter:v,iOrderCenter:g},data:function(){return{select:"selfInfo",selectMenu:{selfInfo:!0,setCenter:!1,safeCenter:!1,orderCenter:!1},menu:[{title:"个人信息",icon:"ios-person",to:"selfInfo"},{title:"设置中心",icon:"settings",to:"setCenter"},{title:"安全中心",icon:"ios-locked",to:"safeCenter"},{title:"订单中心",icon:"ios-cart",to:"orderCenter"}],user:{id:0,name:"",email:"",created_at:0,role:{alias:"",name:"",id:0},createTime:"1970-01-01 08:00:00"}}},created:function(){var e=this,t=this.$route.query.now;this.changePage(t),this.$http.get("user/"+this.$store.state.auth.authUser,{params:{token:this.$store.state.auth.token}}).then(function(t){e.user=t.data,e.user.money=e.toDecimal2(e.user.money),e.user.createTime=n.a.unix(+t.data.created_at).format("YYYY-MM-DD HH:mm:ss")}).catch(function(t){r.a.Notice.error({title:"暂未登录"}),e.$router.push({name:"Login"})})},computed:{},watch:{select:{handler:function(e,t){var s=this.select,a=(this.$route.query.page||"").split(","),r={cur:1,size:10,step:-1};r.cur=+a[0]||1,r.size=+a[1]||10,r.step=+a[2]||-1,a=r.cur+","+r.size+","+r.step,this.$router.push({query:{now:s,page:a}})},deep:!0}},methods:{changePage:function(e){this.select=e;var t=void 0;for(t in this.selectMenu)this.selectMenu[t]=!1;for(t in this.selectMenu[e]=!0,this.menu)this.menu[t].to===e&&(document.title=this.menu[t].title+window.title_suf)},getHash:function(e){var t=""+e;t=t.replace(/^\s+|\s+$/g,"").toLowerCase();var a=s("BVsN")("md5");return a.update(t),"http://www.gravatar.com/avatar/"+(t=a.digest("HEX"))+"?d=retro"},toDecimal2:function(e){var t=(Math.round(100*e)/100).toString(),s=t.indexOf(".");for(s<0&&(s=t.length,t+=".");t.length<=s+2;)t+="0";return t}}},_={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("i-header"),e._v(" "),s("Row",[s("Col",{attrs:{xs:12,ms:8,md:8}},[s("div",{staticClass:"avatar-content"},[s("img",{attrs:{src:e.getHash(e.user.email),width:"100px;"}}),e._v(" "),s("p",{staticStyle:{"font-size":"24px","text-align":"center",width:"100px"}},[e._v(e._s(e.user.username))])]),e._v(" "),s("div",{staticStyle:{"margin-left":"20%",width:"150px"}},[s("Menu",{attrs:{theme:"light",mode:"vertical","active-name":e.select,"default-active":e.select,accordion:!0},on:{"on-select":function(t){e.changePage(t)}}},[s("div",{staticClass:"layout-nav"},e._l(e.menu,function(t,a){return s("MenuItem",{key:a,attrs:{name:t.to}},[s("Icon",{attrs:{type:t.icon}}),e._v("\n              "+e._s(t.title)+"\n            ")],1)}))])],1)]),e._v(" "),s("Col",{attrs:{xs:12,ms:16,md:16}},[s("i-self-info",{directives:[{name:"show",rawName:"v-show",value:e.selectMenu.selfInfo,expression:"selectMenu.selfInfo"}],attrs:{user:e.user}}),e._v(" "),s("i-order-center",{directives:[{name:"show",rawName:"v-show",value:e.selectMenu.orderCenter,expression:"selectMenu.orderCenter"}],attrs:{user:e.user}}),e._v(" "),s("i-safe-center",{directives:[{name:"show",rawName:"v-show",value:e.selectMenu.safeCenter,expression:"selectMenu.safeCenter"}],attrs:{user:e.user}}),e._v(" "),s("i-set-center",{directives:[{name:"show",rawName:"v-show",value:e.selectMenu.setCenter,expression:"selectMenu.setCenter"}],attrs:{user:e.user}})],1)],1)],1)},staticRenderFns:[]};var x=s("VU/8")(w,_,!1,function(e){s("M+/E")},"data-v-2676bcfe",null);t.default=x.exports},phfa:function(e,t,s){var a=s("SiKO");"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);s("rjj0")("044f11be",a,!0,{})},yMr0:function(e,t,s){var a=s("DfZv");"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);s("rjj0")("4767b208",a,!0,{})}});
//# sourceMappingURL=3.a1d443d649fe4e736f01.js.map