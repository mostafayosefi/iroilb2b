import{_ as c,o as h,c as v,a as e,w as i,v as n,b as m,d as _,e as r,t as l,f,r as g}from"./app.c6c6a3cb.js";const b={data(){return{}},props:{user:Object},methods:{message(a){if(this.$route.name!=a)return this.$emit("loading")}}},w={class:"mobile-menu md:hidden bg-meno-mobile"},C=f('<div class="mobile-menu-bar"><a href="" class="flex ml-auto"><img alt="iroilb2b" class="w-30" src="/images/logo/iroilb2b-trans-mobile.png"></a><a href="javascript:;" id="mobile-menu-toggler"><i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-270"></i></a></div>',1),k={class:"mobile-menu-box py-5 hidden"},S=e("div",{class:"menu__icon"},[e("i",{"data-feather":"home"})],-1),y={class:"menu__title"},V={href:"javascript:;",class:"menu"},j=e("div",{class:"menu__icon"},[e("i",{"data-feather":"box"})],-1),P={class:"menu__title"},B=e("i",{"data-feather":"chevron-down",class:"menu__sub-icon"},null,-1),U={class:""},A=e("div",{class:"menu__icon"},[e("i",{"data-feather":"file-text"})],-1),M={class:"menu__title"},N=e("div",{class:"menu__icon"},[e("i",{"data-feather":"list"})],-1),F={class:"menu__title"},O=e("div",{class:"menu__icon"},[e("i",{"data-feather":"tag"})],-1),T={class:"menu__title"},D=e("div",{class:"menu__icon"},[e("i",{"data-feather":"layers"})],-1),H={class:"menu__title"},L=e("div",{class:"menu__icon"},[e("i",{"data-feather":"shield"})],-1),R={class:"menu__title"},q=e("div",{class:"menu__icon"},[e("i",{"data-feather":"database"})],-1),E={class:"menu__title"},z=e("div",{class:"menu__icon"},[e("i",{"data-feather":"inbox"})],-1),G={class:"menu__title"},I={href:"javascript:;",class:"menu"},J=e("div",{class:"menu__icon"},[e("i",{"data-feather":"tool"})],-1),K={class:"menu__title"},Q=e("i",{"data-feather":"chevron-down",class:"menu__sub-icon"},null,-1),W={class:""},X=e("div",{class:"menu__icon"},[e("i",{"data-feather":"settings"})],-1),Y={class:"menu__title"},Z=e("div",{class:"menu__icon"},[e("i",{"data-feather":"sliders"})],-1),$={class:"menu__title"},x=e("div",{class:"menu__icon"},[e("i",{"data-feather":"sliders"})],-1),p={class:"menu__title"},ee=e("div",{class:"menu__icon"},[e("i",{"data-feather":"external-link"})],-1),se={class:"menu__title"},te=e("li",{class:"menu__devider my-6"},null,-1),ae={href:"javascript:;",class:"menu"},ie=e("div",{class:"menu__icon"},[e("i",{"data-feather":"star"})],-1),ne={class:"menu__title"},le=e("i",{"data-feather":"chevron-down",class:"menu__sub-icon"},null,-1),oe={class:""},de=e("div",{class:"menu__icon"},[e("i",{"data-feather":"users"})],-1),me={class:"menu__title"},_e=e("div",{class:"menu__icon"},[e("i",{"data-feather":"message-circle"})],-1),ue={class:"menu__title"},re={href:"javascript:;",class:"menu"},ce=e("div",{class:"menu__icon"},[e("i",{"data-feather":"package"})],-1),he={class:"menu__title"},ve=e("div",{class:"menu__sub-icon"},[e("i",{"data-feather":"chevron-down"})],-1),fe={class:""},ge=e("div",{class:"menu__icon"},[e("i",{"data-feather":"archive"})],-1),be={class:"menu__title"},we=e("div",{class:"menu__icon"},[e("i",{"data-feather":"filter"})],-1),Ce={class:"menu__title"},ke=e("div",{class:"menu__icon"},[e("i",{"data-feather":"briefcase"})],-1),Se={class:"menu__title"},ye=e("div",{class:"menu__icon"},[e("i",{"data-feather":"paperclip"})],-1),Ve={class:"menu__title"},je=e("div",{class:"menu__icon"},[e("i",{"data-feather":"message-square"})],-1),Pe={class:"menu__title"};function Be(a,s,t,Ue,Ae,o){const d=g("router-link");return h(),v("div",w,[C,e("ul",k,[i(e("li",null,[m(d,{onClick:s[0]||(s[0]=u=>o.message("home")),to:{name:"indexAdmin"},class:"menu"},{default:_(()=>[S,e("div",y,l(a.$t("dashboard")),1)]),_:1})],512),[[n,t.user.role.dashboard.show]]),i(e("li",null,[e("a",V,[j,e("div",P,[r(l(a.$t("blog"))+" ",1),B])]),e("ul",U,[i(e("li",null,[m(d,{onClick:s[1]||(s[1]=u=>o.message("adminPosts")),to:{name:"adminPosts"},class:"menu"},{default:_(()=>[A,e("div",M,l(a.$t("posts")),1)]),_:1})],512),[[n,t.user.role.post.show]]),i(e("li",null,[m(d,{onClick:s[2]||(s[2]=u=>o.message("adminCategories")),to:{name:"adminCategories"},class:"menu"},{default:_(()=>[N,e("div",F,l(a.$t("categories")),1)]),_:1})],512),[[n,t.user.role.category.show]]),i(e("li",null,[m(d,{onClick:s[3]||(s[3]=u=>o.message("adminLabels")),to:{name:"adminLabels"},class:"menu"},{default:_(()=>[O,e("div",T,l(a.$t("labels")),1)]),_:1})],512),[[n,t.user.role.label.show]])])],512),[[n,t.user.role.post.show||t.user.role.category.show||t.user.role.label.show]]),i(e("li",null,[m(d,{onClick:s[4]||(s[4]=u=>o.message("adminPages")),to:{name:"adminPages"},class:"menu"},{default:_(()=>[D,e("div",H,l(a.$t("pages")),1)]),_:1})],512),[[n,t.user.role.page.show]]),i(e("li",null,[m(d,{onClick:s[5]||(s[5]=u=>o.message("adminOperators")),to:{name:"adminOperators"},class:"menu"},{default:_(()=>[L,e("div",R,l(a.$t("operators")),1)]),_:1})],512),[[n,t.user.role.operator.show]]),i(e("li",null,[m(d,{onClick:s[6]||(s[6]=u=>o.message("adminTables")),to:{name:"adminTables"},class:"menu"},{default:_(()=>[q,e("div",E,l(a.$t("tables")),1)]),_:1})],512),[[n,t.user.role.table.show]]),i(e("li",null,[m(d,{onClick:s[7]||(s[7]=u=>o.message("adminForms")),to:{name:"adminForms"},class:"menu"},{default:_(()=>[z,e("div",G,l(a.$t("forms")),1)]),_:1})],512),[[n,t.user.role.forms.show]]),i(e("li",null,[e("a",I,[J,e("div",K,[r(l(a.$t("setting"))+" ",1),Q])]),e("ul",W,[i(e("li",null,[m(d,{onClick:s[8]||(s[8]=u=>o.message("adminSetting")),to:{name:"adminSetting"},class:"menu"},{default:_(()=>[X,e("div",Y,l(a.$t("site-settings")),1)]),_:1})],512),[[n,t.user.role.settings.site]]),i(e("li",null,[m(d,{onClick:s[9]||(s[9]=u=>o.message("adminSettingHeader")),to:{name:"adminSettingHeader"},class:"menu"},{default:_(()=>[Z,e("div",$,l(a.$t("header")),1)]),_:1})],512),[[n,t.user.role.settings.header]]),i(e("li",null,[m(d,{onClick:s[10]||(s[10]=u=>o.message("adminSettingSideBar")),to:{name:"adminSettingSideBar"},class:"menu"},{default:_(()=>[x,e("div",p,l(a.$t("side-bar")),1)]),_:1})],512),[[n,t.user.role.settings.sidebar]])])],512),[[n,t.user.role.settings.site||t.user.role.settings.header||t.user.role.settings.sidebar||t.user.role.settings.footer]]),i(e("li",null,[m(d,{onClick:s[11]||(s[11]=u=>o.message("adminRedirect")),to:{name:"adminRedirect"},class:"menu"},{default:_(()=>[ee,e("div",se,l(a.$t("redirects")),1)]),_:1})],512),[[n,t.user.role.redirect.show]]),te,i(e("li",null,[e("a",ae,[ie,e("div",ne,l(a.$t("management-customers")),1),le]),e("ul",oe,[i(e("li",null,[m(d,{onClick:s[12]||(s[12]=u=>o.message("adminUsers")),to:{name:"adminUsers"},class:"menu"},{default:_(()=>[de,e("div",me,l(a.$t("users")),1)]),_:1})],512),[[n,t.user.role.users.show]]),i(e("li",null,[m(d,{onClick:s[13]||(s[13]=u=>o.message("adminUsersMessageView")),to:{name:"adminUsersMessageView"},class:"menu"},{default:_(()=>[_e,e("div",ue,l(a.$t("messages-management")),1)]),_:1})],512),[[n,t.user.role.notificate.show]])])],512),[[n,t.user.role.users.show||t.user.role.notificate.show]]),i(e("li",null,[e("a",re,[ce,e("div",he,[r(l(a.$t("management-companies"))+" ",1),ve])]),e("ul",fe,[i(e("li",null,[m(d,{onClick:s[14]||(s[14]=u=>o.message("adminProducts")),to:{name:"adminProducts"},class:"menu"},{default:_(()=>[ge,e("div",be,l(a.$t("products")),1)]),_:1})],512),[[n,t.user.role.product.show]]),i(e("li",null,[m(d,{onClick:s[15]||(s[15]=u=>o.message("adminUsersMessageView")),to:{name:"adminCompanyFilter"},class:"menu"},{default:_(()=>[we,e("div",Ce,l(a.$t("filters")),1)]),_:1})],512),[[n,t.user.role.tag.show]]),i(e("li",null,[m(d,{onClick:s[16]||(s[16]=u=>o.message("adminCompanies")),to:{name:"adminCompanies"},class:"menu"},{default:_(()=>[ke,e("div",Se,l(a.$t("companies")),1)]),_:1})],512),[[n,t.user.role.company.show]])])],512),[[n,t.user.role.company.show||t.user.role.product.show||t.user.role.tag.show]]),i(e("li",null,[m(d,{onClick:s[17]||(s[17]=u=>o.message("adminAdvertisements")),to:{name:"adminAdvertisements"},class:"menu"},{default:_(()=>[ye,e("div",Ve,l(a.$t("advertisements")),1)]),_:1})],512),[[n,t.user.role.ads.show]]),i(e("li",null,[m(d,{onClick:s[18]||(s[18]=u=>o.message("adminSupport")),to:{name:"adminSupport"},class:"menu"},{default:_(()=>[je,e("div",Pe,l(a.$t("support")),1)]),_:1})],512),[[n,t.user.role.support.show]])])])}const Ne=c(b,[["render",Be]]);export{Ne as default};
