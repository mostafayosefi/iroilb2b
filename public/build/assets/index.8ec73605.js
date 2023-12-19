import{_ as g,h as p,i as b,j as v,o as _,c as x,b as d,w as i,v as n,a as e,e as l,t as o,d as h,F as k,k as y,f as C,r as w}from"./app.c6c6a3cb.js";const B={emits:["loadingHide","loading"],props:{loading:Boolean,user:Object},components:{"header-admin":p(()=>b(()=>import("./header-admin.6f180bbb.js"),["assets/header-admin.6f180bbb.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css"]))},data(){return{count:{post:0,company:0,user:0,ad:0},notficate:[]}},methods:{message(t){if(this.$route.name!=t)return this.$emit("loading")}},beforeCreate(){v.get("/admin/get",{params:{api_token:this.$cookies.get("user").token}}).then(t=>{this.count.post=t.data.count.posts,this.count.company=t.data.count.companies,this.count.user=t.data.count.users,this.count.ad=t.data.count.ads,this.$emit("loadingHide")}).catch(()=>{this.$emit("loadingHide")}),v.get("/admin/notficate",{params:{api_token:this.$cookies.get("user").token}}).then(t=>{for(const s of t.data.notficate)this.notficate.push({text:s.text,time:s.time})})},watch:{$route:{immediate:!0,handler(t,s){document.title=this.$t("dashboard")+" | "+this.$t("adminTitlePage")}}}},V={class:"content"},M={class:"alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold",role:"alert"},P=e("i",{"data-feather":"alert-octagon",class:"w-6 h-6 ml-2"},null,-1),j={class:"intro-y mt-2 flex"},A={class:"box p-5 w-1/4 mx-2"},$={class:"flex"},F=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",class:"feather feather-box","data-v-bf726dba":""},[e("path",{d:"M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"}),e("polyline",{points:"3.27 6.96 12 12.01 20.73 6.96"}),e("line",{x1:"12",y1:"22.08",x2:"12",y2:"12"})],-1),S={class:"mr-auto"},E={class:"report-box__indicator text-lg bg-theme-20 px-2 text-white rounded"},H={class:"text-base text-gray-600 mt-1"},N={class:"box p-5 w-1/4 mx-2"},D={class:"flex"},T=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",class:"feather feather-briefcase","data-v-bf726dba":""},[e("rect",{x:"2",y:"7",width:"20",height:"14",rx:"2",ry:"2"}),e("path",{d:"M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"})],-1),U={class:"mr-auto"},L={class:"report-box__indicator text-lg bg-theme-24 px-2 text-white rounded"},O={class:"text-base text-gray-600 mt-1"},z={class:"box p-5 w-1/4 mx-2"},I={class:"flex"},R=C('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users" data-v-bf726dba=""><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',1),q={class:"mr-auto"},G={class:"report-box__indicator text-lg bg-theme-1 px-2 text-white rounded"},J={class:"text-base text-gray-600 mt-1"},K={class:"box p-5 w-1/4 mx-2"},Q={class:"flex"},W=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",class:"feather feather-paperclip","data-v-bf726dba":""},[e("path",{d:"M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"})],-1),X={class:"mr-auto"},Y={class:"report-box__indicator text-lg bg-theme-21 px-2 text-white rounded"},Z={class:"text-base text-gray-600 mt-1"},ee={class:"mt-6 mx-2 intro-y flex font-bold"},te={class:"mx-2 py-4 intro-y flex font-bold"},se={class:"mt-4 flex"},oe={class:"w-1/2 mx-2 box p-2 border-b2b"},ae={class:"py-2 px-2 font-bold"},ie={class:"relative flex items-center py-2 border-t b"},ne={class:"mr-2 overflow-hidden"},re={class:"flex items-center"},de={class:"text-xs text-gray-500 right-0 whitespace-nowrap"},le={class:"w-full truncate left-0 text-gray-600 mt-0.5"};function ce(t,s,a,me,u,c){const f=w("header-admin"),m=w("router-link");return _(),x("div",V,[d(f,{user:a.user,title:t.$t("dashboard")},null,8,["user","title"]),i(e("div",M,[P,l(" "+o(t.$t("access-message")),1)],512),[[n,!a.user.role.dashboard.show]]),i(e("div",j,[i(e("div",A,[e("div",$,[F,e("div",S,[e("div",E,o(u.count.post),1)])]),e("div",H,o(t.$t("articles")),1)],512),[[n,a.user.role.post.show]]),i(e("div",N,[e("div",D,[T,e("div",U,[e("div",L,o(u.count.company),1)])]),e("div",O,o(t.$t("companies")),1)],512),[[n,a.user.role.company.show]]),i(e("div",z,[e("div",I,[R,e("div",q,[e("div",G,o(u.count.user),1)])]),e("div",J,o(t.$t("users")),1)],512),[[n,a.user.role.users.show]]),i(e("div",K,[e("div",Q,[W,e("div",X,[e("div",Y,o(u.count.ad),1)])]),e("div",Z,o(t.$t("ads")),1)],512),[[n,a.user.role.ads.show]])],512),[[n,a.user.role.dashboard.show]]),e("div",ee,[i(d(m,{onClick:s[0]||(s[0]=r=>c.message("adminPosts")),to:{name:"adminPosts"},class:"box p-4 mx-2 border-theme-1 w-1/4"},{default:h(()=>[l(o(t.$t("posts")),1)]),_:1},512),[[n,a.user.role.post.show]]),i(d(m,{onClick:s[1]||(s[1]=r=>c.message("adminPages")),to:{name:"adminPages"},class:"box p-4 mx-2 w-1/4"},{default:h(()=>[l(o(t.$t("pages")),1)]),_:1},512),[[n,a.user.role.page.show]]),i(d(m,{onClick:s[2]||(s[2]=r=>c.message("adminCompanies")),to:{name:"adminCompanies"},class:"box p-4 mx-2 w-1/4"},{default:h(()=>[l(o(t.$t("companies")),1)]),_:1},512),[[n,a.user.role.company.show]]),i(d(m,{onClick:s[3]||(s[3]=r=>c.message("adminAdvertisements")),to:{name:"adminAdvertisements"},class:"box p-4 mx-2 w-1/4"},{default:h(()=>[l(o(t.$t("advertisements")),1)]),_:1},512),[[n,a.user.role.ads.show]])]),e("div",te,[i(d(m,{onClick:s[4]||(s[4]=r=>c.message("adminUsers")),to:{name:"adminUsers"},class:"box p-4 mx-2 w-1/4"},{default:h(()=>[l(o(t.$t("users")),1)]),_:1},512),[[n,a.user.role.users.show]]),i(d(m,{onClick:s[5]||(s[5]=r=>c.message("adminUsersMessageView")),to:{name:"adminCompanyFilter"},class:"box p-4 mx-2 w-1/4"},{default:h(()=>[l(o(t.$t("filters")),1)]),_:1},512),[[n,a.user.role.tag.show]]),i(d(m,{onClick:s[6]||(s[6]=r=>c.message("adminForms")),to:{name:"adminForms"},class:"box p-4 mx-2 w-1/4"},{default:h(()=>[l(o(t.$t("forms")),1)]),_:1},512),[[n,a.user.role.forms.show]]),i(d(m,{onClick:s[7]||(s[7]=r=>c.message("adminSupport")),to:{name:"adminSupport"},class:"box p-4 mx-2 w-1/4"},{default:h(()=>[l(o(t.$t("support")),1)]),_:1},512),[[n,a.user.role.support.show]])]),i(e("div",se,[i(e("div",oe,[e("p",ae,o(t.$t("notficate")),1),(_(!0),x(k,null,y(u.notficate,r=>(_(),x("div",ie,[e("div",ne,[e("div",re,[e("div",de,o(r.time),1)]),e("div",le,o(r.text),1)])]))),256))],512),[[n,u.notficate[0]]])],512),[[n,a.user.role.notificate.show]])])}const ue=g(B,[["render",ce]]);export{ue as default};
