webpackJsonp([19],{NKoK:function(t,e,a){(t.exports=a("FZ+f")(!1)).push([t.i,".layout-header-bar[data-v-155ac1e3]{background:#fff;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.1);box-shadow:0 1px 1px rgba(0,0,0,.1)}.order[data-v-155ac1e3]{width:90%;margin-top:50px;margin-right:50px;margin-bottom:50px}.select-step[data-v-155ac1e3]{margin-right:100px;width:200px}",""])},juVm:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=a("PJh5"),i=a.n(s),r=a("BTaQ"),o=a.n(r),n={name:"",data:function(){var t=this;return{T:!0,Loading:!0,orders:[],columns:[{title:"订单编号",fixed:"left",width:100,key:"id"},{title:"购买数量",width:120,key:"number"},{title:"总金额",width:130,key:"sum"},{title:"优惠方式",width:120,key:"discount"},{title:"创建时间",width:150,key:"createTime"},{title:"订单状态",key:"step",width:120,render:function(e,a){return e("div",t.GetStepMessage(a.row.step))}},{title:"操作",fixed:"right",width:100,render:function(e,a){return e("i-button",{props:{type:"primary",size:"small"},on:{click:function(){t.OrderDetail(a.row.id)}}},"查看详情")}}],Page:{cur:1,size:10,total:0,step:-1,book:-1},Steps:[{step:-1,title:"查看全部"},{step:1,title:"未支付"},{step:2,title:"待发货"},{step:3,title:"已发货"},{step:4,title:"已收货"},{step:5,title:"已评分"}],user:[],Books:[{name:"查看全部",id:-1}]}},created:function(){var t=this,e=(this.$route.query.page||"").split(",");this.Page.cur=+e[0]||1,this.Page.size=+e[1]||10,this.Page.step=+e[2]||-1,this.Page.book=+e[3]||-1,this.$http.get("user/"+this.$store.state.auth.authUser,{params:{token:this.$store.state.auth.token}}).then(function(e){t.user=e.data,"bookseller"!==t.user.role.alias&&(t.$Notice.error({title:"您暂未成为书商"}),t.$router.push({name:"Index"})),t.GetOrder(),t.GetBook()}).catch(function(e){o.a.Notice.error({title:"暂未登录"}),t.$router.push({name:"Login"})}),document.title="订单管理"+window.title_suf},computed:{},watch:{Page:{handler:function(t,e){var a=this.Page.cur+","+this.Page.size+","+this.Page.step+","+this.Page.book;this.$router.push({query:{page:a}})},deep:!0}},methods:{GetBook:function(){var t=this;this.$http.get("book",{params:{token:this.$store.state.auth.token,user_id:this.user.id}}).then(function(e){var a=void 0;for(a in e.data)1===e.data[a].passed&&t.Books.push({name:e.data[a].name,id:e.data[a].id})}).catch(function(t){})},GetStepMessage:function(t){var e="";switch(t){case 1:e="未支付";break;case 2:e="待发货";break;case 3:e="已发货";break;case 4:e="已收货";break;case 5:e="已评分";break;default:e="未知状态"}return e},toDecimal2:function(t){var e=(Math.round(100*t)/100).toString(),a=e.indexOf(".");for(a<0&&(a=e.length,e+=".");e.length<=a+2;)e+="0";return"￥"+e},OrderDetail:function(t){this.$router.push({name:"OrderDetail",params:{order_id:t}})},ChangeStep:function(){this.GetOrder()},GetOrder:function(){var t=this,e={token:this.$store.state.auth.token,user_id:this.user.id,limit:this.Page.size,offset:this.Page.size*(this.Page.cur-1),bookseller:1};-1!==this.Page.step&&(e.step=this.Page.step),-1!==this.Page.book&&(e.bookseller=0,e.book_id=this.Page.book),this.$http.get("order",{params:e}).then(function(e){var a=void 0;for(a in t.orders=[],e.data){var s={};s.id=e.data[a].id,s.number=e.data[a].number,s.sum=t.toDecimal2(e.data[a].sum/100),s.createTime=i.a.unix(+e.data[a].created_at).format("YYYY-MM-DD"),s.discount="无优惠",s.step=e.data[a].step,t.orders.push(s)}t.Loading=!1,t.Page.total=+e.headers["x-total"]}).catch(function(t){})}}},u={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("Header",{staticClass:"layout-header-bar"},[a("Breadcrumb",[a("BreadcrumbItem",{attrs:{href:"/bookseller"}},[t._v("Home")]),t._v(" "),a("BreadcrumbItem",[t._v("订单管理")])],1)],1),t._v(" "),a("i-content",{style:{margin:"20px",background:"#fff",minHeight:"500px"}},[a("h1",{staticStyle:{width:"100%","text-align":"center"}},[t._v("订单中心")]),t._v(" "),a("Row",{staticStyle:{"margin-top":"50px"}},[a("Col",{attrs:{span:24,align:"right"}},[t._v("\n        选择书籍：\n        "),a("Select",{staticClass:"select-step",on:{"on-change":t.ChangeStep},model:{value:t.Page.book,callback:function(e){t.$set(t.Page,"book",e)},expression:"Page.book"}},t._l(t.Books,function(e){return a("Option",{key:e.id,attrs:{value:e.id,label:e.name}},[a("span",[t._v(t._s(e.name))])])})),t._v("\n        订单状态：\n        "),a("Select",{staticClass:"select-step",on:{"on-change":t.ChangeStep},model:{value:t.Page.step,callback:function(e){t.$set(t.Page,"step",e)},expression:"Page.step"}},t._l(t.Steps,function(e){return a("Option",{key:e.step,attrs:{value:e.step,label:e.title}},[a("span",[t._v(t._s(e.title))])])}))],1)],1),t._v(" "),a("div",{staticClass:"order"},[a("Table",{attrs:{border:"",columns:t.columns,data:t.orders,"no-data-text":"暂无订单",stripe:t.T,loading:t.Loading}})],1),t._v(" "),a("Row",{staticStyle:{"margin-bottom":"50px","margin-right":"100px"}},[a("Col",{attrs:{span:24,align:"right"}},[a("Page",{attrs:{size:"small","show-elevator":"","show-sizer":"","show-total":"",current:t.Page.cur,"page-size":t.Page.size,total:t.Page.total},on:{"on-change":function(e){t.Page.cur=e},"on-page-size-change":function(e){t.Page.size=e}}})],1)],1)],1)],1)},staticRenderFns:[]};var c=a("VU/8")(n,u,!1,function(t){a("pnTm")},"data-v-155ac1e3",null);e.default=c.exports},pnTm:function(t,e,a){var s=a("NKoK");"string"==typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);a("rjj0")("4185b888",s,!0,{})}});
//# sourceMappingURL=19.a0bdc814e00f95602993.js.map