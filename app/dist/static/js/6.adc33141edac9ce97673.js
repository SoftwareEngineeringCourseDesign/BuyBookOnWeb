webpackJsonp([6],{"2ru4":function(t,e,a){(t.exports=a("FZ+f")(!1)).push([t.i,".layout-header-bar[data-v-c4b9ed66]{background:#fff;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.1);box-shadow:0 1px 1px rgba(0,0,0,.1)}.book[data-v-c4b9ed66]{width:90%;margin-top:50px;margin-right:50px;margin-bottom:50px}.select-step[data-v-c4b9ed66]{margin-right:100px;width:200px}",""])},NAvl:function(t,e,a){var o=a("2ru4");"string"==typeof o&&(o=[[t.i,o,""]]),o.locals&&(t.exports=o.locals);a("rjj0")("76a74cb6",o,!0,{})},"O+0w":function(t,e,a){var o=a("cIe4");"string"==typeof o&&(o=[[t.i,o,""]]),o.locals&&(t.exports=o.locals);a("rjj0")("f0406ea0",o,!0,{})},V0b2:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=a("PJh5"),s=a.n(o),r=a("BTaQ"),i=a.n(r),n={props:["book"],components:{iStar:a("OChx").a},name:"iListBook",data:function(){return{}},computed:{},methods:{}},c={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"book-detail"},[a("Row",[a("Col",{attrs:{span:"8"}},[t.book.cover?a("img",{attrs:{src:t.book.cover,width:"100%"}}):a("div",{staticStyle:{height:"500px"}},[t._v("该书暂无封面")])]),t._v(" "),a("Col",{attrs:{span:"16"}},[a("p",{staticStyle:{"font-size":"18px","margin-top":"10px"}},[t._v("作者： "+t._s(t.book.author))]),t._v(" "),a("p",{staticStyle:{"font-size":"12px","margin-top":"10px"}},[t._v("出版社： "+t._s(t.book.publisher))]),t._v(" "),a("p",{staticStyle:{width:"60%","font-size":"14px","word-break":"break-all","word-wrap":"break-word","margin-top":"10px"}},[t._v("简介："+t._s(t.book.introduction))]),t._v(" "),a("p",{staticStyle:{"margin-top":"10px"}},[t._v("评分： "),a("i-star",{attrs:{score:t.book.score}}),t._v(" "),a("span",[t._v("(共 "+t._s(t.book.peopleNumber)+" 人评分) ")])],1),t._v(" "),a("p",{staticStyle:{"margin-top":"10px"}},[t._v("销量: "+t._s(t.book.sellNumber)+" 本")]),t._v(" "),a("p",{staticStyle:{"margin-top":"20px"}},[t._v("价格： "),a("span",{staticStyle:{"font-size":"24px",color:"red"}},[t._v(t._s(t.book.price))])])])],1)],1)},staticRenderFns:[]};var d=a("VU/8")(n,c,!1,function(t){a("O+0w")},"data-v-06eb997e",null).exports,p={components:{iListBook:d},name:"",data:function(){var t=this;return{T:!0,Loading:!0,orders:[],columns:[{type:"expand",width:50,render:function(t,e){return t(d,{props:{book:e.row}})}},{title:"书籍编号",key:"id"},{title:"书籍名称",key:"name"},{title:"书籍分类",render:function(t,e){return t("div",e.row.category.name)}},{title:"上传时间",key:"createTime"},{title:"通过时间",key:"updateTime"},{title:"书籍状态",render:function(e,a){return e("div",t.GetPassedMessage(a.row.passed))}}],Page:{cur:1,size:10,total:0,passed:-1,category:-1},Passed:[{passed:-1,name:"查看全部"},{passed:1,name:"未通过"},{passed:2,name:"已通过"}],user:[],Books:[],Category:[{name:"查看全部",id:-1}]}},created:function(){var t=this,e=(this.$route.query.page||"").split(",");this.Page.cur=+e[0]||1,this.Page.size=+e[1]||10,this.Page.passed=+e[2]||-1,this.Page.category=+e[3]||-1,this.$http.get("user/"+this.$store.state.auth.authUser,{params:{token:this.$store.state.auth.token}}).then(function(e){t.user=e.data,"bookseller"!==t.user.role.alias&&(t.$Notice.error({title:"您暂未成为书商"}),t.$router.push({name:"Index"})),t.GetBook(),t.GetCategory()}).catch(function(e){i.a.Notice.error({title:"暂未登录"}),t.$router.push({name:"Login"})}),document.title="书籍管理"+window.title_suf},computed:{},watch:{Page:{handler:function(t,e){var a=this.Page.cur+","+this.Page.size+","+this.Page.passed+","+this.Page.category;this.$router.push({query:{page:a}})},deep:!0}},methods:{GetPassedMessage:function(t){return 0==+t?"暂未通过":"已通过"},GetCategory:function(){var t=this;this.$http.get("category").then(function(e){var a=void 0;for(a in e.data)t.Category.push({name:e.data[a].name,id:e.data[a].id})}).catch(function(t){})},toDecimal2:function(t){var e=(Math.round(100*t)/100).toString(),a=e.indexOf(".");for(a<0&&(a=e.length,e+=".");e.length<=a+2;)e+="0";return"￥"+e},BookDetail:function(t){this.$router.push({name:"BookDetail",params:{book_id:t}})},ChangeStep:function(){this.GetBook()},GetBook:function(){var t=this,e={token:this.$store.state.auth.token,user_id:this.user.id,limit:this.Page.size,offset:this.Page.size*(this.Page.cur-1)};-1!==this.Page.category&&(e.category_id=this.Page.category),-1!==this.Page.passed&&(e.passed=this.Page.passed-1),this.$http.get("book",{params:e}).then(function(e){var a=void 0;for(a in t.Books=[],e.data){var o={};o.id=e.data[a].id,o.name=e.data[a].name,o.author=e.data[a].author,o.createTime=s.a.unix(+e.data[a].created_at).format("YYYY-MM-DD"),1===e.data[a].passed?o.updateTime=s.a.unix(+e.data[a].updated_at).format("YYYY-MM-DD"):o.updateTime="-",o.price=t.toDecimal2(e.data[a].price/100),o.introduction=e.data[a].introduction,o.publisher=e.data[a].publisher,o.score=e.data[a].score,o.sellNumber=e.data[a].sell_number,o.peopleNumber=e.data[a].people_number,o.cover=e.data[a].cover,o.user=e.data[a].user,o.category=e.data[a].category,o.passed=e.data[a].passed,t.Books.push(o)}t.Loading=!1,t.Page.total=+e.headers["x-total"],console.log(t.Books)}).catch(function(t){})}}},u={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("Header",{staticClass:"layout-header-bar"},[a("Breadcrumb",[a("BreadcrumbItem",{attrs:{href:"/bookseller"}},[t._v("Home")]),t._v(" "),a("BreadcrumbItem",[t._v("书籍管理")])],1)],1),t._v(" "),a("i-content",{style:{margin:"20px",background:"#fff",minHeight:"500px"}},[a("h1",{staticStyle:{width:"100%","text-align":"center"}},[t._v("书籍中心")]),t._v(" "),a("Row",{staticStyle:{"margin-top":"50px"}},[a("Col",{attrs:{span:24,align:"right"}},[t._v("\n        选择分类：\n        "),a("Select",{staticClass:"select-step",on:{"on-change":t.ChangeStep},model:{value:t.Page.category,callback:function(e){t.$set(t.Page,"category",e)},expression:"Page.category"}},t._l(t.Category,function(e){return a("Option",{key:e.id,attrs:{value:e.id,label:e.name}},[a("span",[t._v(t._s(e.name))])])})),t._v("\n        书籍状态：\n        "),a("Select",{staticClass:"select-step",on:{"on-change":t.ChangeStep},model:{value:t.Page.passed,callback:function(e){t.$set(t.Page,"passed",e)},expression:"Page.passed"}},t._l(t.Passed,function(e){return a("Option",{key:e.passed,attrs:{value:e.passed,label:e.name}},[a("span",[t._v(t._s(e.name))])])}))],1)],1),t._v(" "),a("div",{staticClass:"book"},[a("Table",{attrs:{border:"",columns:t.columns,data:t.Books,"no-data-text":"暂无书籍",stripe:t.T,loading:t.Loading}})],1),t._v(" "),a("Row",{staticStyle:{"margin-bottom":"50px","margin-right":"100px"}},[a("Col",{attrs:{span:24,align:"right"}},[a("Page",{attrs:{size:"small","show-elevator":"","show-sizer":"","show-total":"",current:t.Page.cur,"page-size":t.Page.size,total:t.Page.total},on:{"on-change":function(e){t.Page.cur=e},"on-page-size-change":function(e){t.Page.size=e}}})],1)],1)],1)],1)},staticRenderFns:[]};var l=a("VU/8")(p,u,!1,function(t){a("NAvl")},"data-v-c4b9ed66",null);e.default=l.exports},cIe4:function(t,e,a){(t.exports=a("FZ+f")(!1)).push([t.i,"",""])}});
//# sourceMappingURL=6.adc33141edac9ce97673.js.map