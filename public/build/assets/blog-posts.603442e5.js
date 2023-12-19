import{_ as b,h as k,i as v,j as u,o as n,c as i,b as f,w as l,v as r,a as t,e as x,t as d,d as $,r as g,F as y,k as C,l as h,n as P,m as L}from"./app.c6c6a3cb.js";const V={props:{user:Object},components:{"header-admin":k(()=>v(()=>import("./header-admin.6f180bbb.js"),["assets/header-admin.6f180bbb.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css"]))},data(){return{posts:[],columns:[{label:this.$t("title"),field:"title"},{label:this.$t("category"),field:"cat"},{label:this.$t("information"),field:"info"},{label:this.$t("the-operation"),field:"after"}]}},methods:{deletePost(e){confirm(this.$t("delete-message"))&&(this.$emit("loading"),u.delete("/post/delete/"+e,{params:{api_token:this.$cookies.get("user").token}}).then(s=>{s.data=="successfully deleted"&&(this.posts=this.posts.filter(a=>a.id!=e),this.$emit("loadingHide"))}).catch(()=>{this.$emit("loadingHide")}))}},created(){u.get("/post",{params:{api_token:this.$cookies.get("user").token}}).then(e=>{if(e.data!="null")for(const s of e.data)this.posts.push({id:s.id,title:s.title,slug:s.slug,language:s.language,status:s.status,time:s.time,categories:s.categories});this.$emit("loadingHide")}).catch(e=>{this.$emit("loadingHide")})},name:"App",watch:{$route:{immediate:!0,handler(e,s){document.title=this.$t("posts")+" | "+this.$t("adminTitlePage")}}}},B={class:"content"},H={class:"alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold",role:"alert"},j=t("i",{"data-feather":"alert-octagon",class:"w-6 h-6 ml-2"},null,-1),E={class:"box intro-y"},M={key:0},N={class:"py-1 px-2 mx-1 rounded-full text-xs bg-dark text-white"},T={key:1},z={class:"py-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white"},A=["textContent"],D={key:2},F=["href"],O=t("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",class:"feather feather-eye block w-4 h-4"},[t("path",{d:"M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"}),t("circle",{cx:"12",cy:"12",r:"3"})],-1),S=[O],I=["href"],R=t("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",class:"feather feather-edit w-4 h-4"},[t("path",{d:"M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"}),t("path",{d:"M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"})],-1),q=[R],G=["onClick"],J=t("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",class:"feather feather-trash w-4 h-4"},[t("polyline",{points:"3 6 5 6 21 6"}),t("path",{d:"M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"})],-1),K=[J];function Q(e,s,a,U,c,_){const w=g("header-admin"),p=g("vue-good-table");return n(),i("div",B,[f(w,{user:a.user,title:e.$t("posts"),element:a.user.role.post.add,elementText:e.$t("add"),linkElement:!0,link:"adminNewPosts"},null,8,["user","title","element","elementText"]),l(t("div",H,[j,x(" "+d(e.$t("access-message")),1)],512),[[r,!a.user.role.post.show]]),l(t("div",E,[f(p,{class:"p-2",columns:c.columns,rows:c.posts,rtl:!0,theme:"polar-bear","line-numbers":!0,"fixed-header":!0,"pagination-options":{enabled:!0,mode:"records",perPage:10,nextLabel:e.$t("next"),prevLabel:e.$t("prev"),rowsPerPageLabel:"",ofLabel:e.$t("of"),allLabel:e.$t("all")},"search-options":{enabled:!0,placeholder:e.$t("search")}},{"table-row":$(o=>[o.column.field=="cat"?(n(),i("div",M,[(n(!0),i(y,null,C(o.row.categories,m=>(n(),i("span",N,d(" "+m+" "),1))),256))])):h("",!0),o.column.field=="info"?(n(),i("div",T,[t("span",z,d(o.row.time),1),t("span",{class:P(["py-1 px-2 rounded-full text-xs font-medium",o.row.status=="draft"?"bg-theme-15 text-dark":"bg-theme-11 text-white"]),textContent:d(o.row.status=="draft"?e.$t("draft"):e.$t("publish"))},null,10,A)])):h("",!0),o.column.field=="after"?(n(),i("span",D,[t("a",{target:"_blank",class:"btn btn-sm btn-outline-primary m-1",href:e.$hostname+o.row.language+"/post/"+o.row.slug},S,8,F),l(t("a",{target:"_blank",class:"btn btn-sm btn-outline-dark m-1",href:e.$hostname+"fa/admin/posts/edit/"+o.row.id},q,8,I),[[r,a.user.role.post.edit]]),l(t("button",{onClick:L(m=>_.deletePost(o.row.id),["prevent"]),class:"btn btn-sm btn-outline-danger m-1"},K,8,G),[[r,a.user.role.post.delete]])])):h("",!0)]),_:1},8,["columns","rows","pagination-options","search-options"])],512),[[r,a.user.role.post.show]])])}const X=b(V,[["render",Q]]);export{X as default};
