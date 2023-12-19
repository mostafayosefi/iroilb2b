import{_ as S,h as T,i as j,j as C,o as c,c as h,b as x,d as V,w as o,v as b,a as e,e as $,t as d,n as B,q as g,u as R,F as f,k as v,r as H,p as D,g as N}from"./app.c6c6a3cb.js";import{d as P}from"./vuedraggable.umd.16f25545.js";var p=0,_=0;const A={emits:["loadingHide","loading"],props:{loading:Boolean,user:Object},components:{"header-admin":T(()=>j(()=>import("./header-admin.6f180bbb.js"),["assets/header-admin.6f180bbb.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css"])),draggable:P},data(){return{loading:!0,header:[],data:[],dragging:!1,table:{id:"",title:"",language:"",detail:{description:""}},error:!1}},methods:{addHeader(){this.header.push({id:p,title:""}),p++},addRow(){this.data.push({col:[]})},addCol(t){this.data[t].col.push({id:_,title:""}),_++},removeRow(t){this.data=this.data.filter((a,l,n)=>l!==t)},removeCol(t,a){this.data[t].col=this.data[t].col.filter((l,n,i)=>n!==a)},removeHeader(t){this.header=this.header.filter((a,l,n)=>l!==t)},updateTable(){if(this.table.title!=""&&this.table.key!=""){if(confirm(this.$t("update-message"))){this.$emit("loading"),this.error=!1;const t={api_token:this.$cookies.get("user").token,title:this.table.title,language:this.table.language,header:this.header,detail:this.table.detail,data:this.data};C.put("/table/update/"+this.$route.params.id,t).then(a=>{a.data=="success"&&(this.table.title="",this.table.language="",this.header=[],this.data=[],this.table.detail.description="",p=0,_=0),this.$emit("loadingHide")}).catch(()=>{this.$emit("loadingHide")})}}else this.error=!0}},computed:{draggingInfo(){return this.dragging?"under drag":""}},beforeCreate(){C.get("/table/id/"+this.$route.params.id,{params:{api_token:this.$cookies.get("user").token}}).then(t=>{this.table.id=t.data.id,this.table.title=t.data.title,this.table.language=t.data.language,this.table.detail.description=t.data.detail.description;for(const l of t.data.header)this.header.push({id:l.id,title:l.title}),p=l.id+1;var a=0;for(const l of t.data.data){this.data.push({col:[]});for(const n of l.col)this.data[a].col.push({id:n.id,title:n.title}),_=l.id+1;a++}this.$emit("loadingHide")}).catch(()=>{this.$emit("loadingHide")})},watch:{$route:{immediate:!0,handler(t,a){document.title=this.$t("tables")+" | "+this.$t("adminTitlePage")}}}},k=t=>(D("data-v-2b1c9a5e"),t=t(),N(),t),F={class:"content"},L={class:"alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold",role:"alert"},M=k(()=>e("i",{"data-feather":"alert-octagon",class:"w-6 h-6 ml-2"},null,-1)),O={class:"box intro-y p-4"},q={class:"alert alert-outline-danger alert-dismissible show flex items-center col-span-12 mb-2",role:"alert"},z=k(()=>e("i",{"data-feather":"alert-octagon",class:"w-6 h-6 ml-2"},null,-1)),G=["placeholder"],J=["placeholder"],K={value:"all"},Q={value:"fa"},W={value:"en"},X={dir:"ltr"},Y={class:"mt-2"},Z={class:"float-left"},tt={class:"inline"},et=["onUpdate:modelValue"],at=["onClick"],lt={class:"bg-white py-2 rounded"},st={class:"flex align-items-center"},it={class:"inline"},ot=["onUpdate:modelValue"],dt=["onClick"],nt=["onClick"],rt=["onClick"],ct=k(()=>e("button",{class:"btn handle"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round",class:"feather feather-align-justify block mx-auto"},[e("line",{x1:"21",y1:"10",x2:"3",y2:"10"}),e("line",{x1:"21",y1:"6",x2:"3",y2:"6"}),e("line",{x1:"21",y1:"14",x2:"3",y2:"14"}),e("line",{x1:"21",y1:"18",x2:"3",y2:"18"})])],-1));function ht(t,a,l,n,i,r){const E=H("header-admin"),U=H("draggable");return c(),h("div",F,[x(E,{user:l.user,title:t.$t("edit-table")},{default:V(()=>[o(e("button",{type:"button",onClick:a[0]||(a[0]=s=>r.addHeader()),class:"btn btn-sm font-bold btn-success ml-2"},d(t.$t("add-header")),513),[[b,l.user.role.table.edit]]),o(e("button",{type:"button",onClick:a[1]||(a[1]=s=>r.addRow()),class:"btn btn-sm font-bold btn-success ml-2"},d(t.$t("add-data")),513),[[b,l.user.role.table.edit]]),o(e("button",{type:"button",onClick:a[2]||(a[2]=s=>r.updateTable()),class:"btn btn-sm font-bold btn-dark ml-2"},d(t.$t("edit")),513),[[b,l.user.role.table.edit]])]),_:1},8,["user","title"]),o(e("div",L,[M,$(" "+d(t.$t("access-message")),1)],512),[[b,!l.user.role.table.edit]]),o(e("div",O,[o(e("div",q,[z,$(" "+d(t.$t("error-empty-fields")),1)],512),[[b,i.error]]),o(e("input",{dir:"rtl",type:"text",class:B(["form-control",i.error&&i.table.title==""?"alert-outline-danger":""]),placeholder:t.$t("title"),"onUpdate:modelValue":a[3]||(a[3]=s=>i.table.title=s)},null,10,G),[[g,i.table.title]]),o(e("input",{dir:"ltr",type:"text",class:"form-control mt-2",placeholder:t.$t("description"),"onUpdate:modelValue":a[4]||(a[4]=s=>i.table.detail.description=s)},null,8,J),[[g,i.table.detail.description]]),o(e("select",{id:"lang",class:"form-control mt-2","onUpdate:modelValue":a[5]||(a[5]=s=>i.table.language=s)},[e("option",K,d(t.$t("all")),1),e("option",Q,d(t.$t("persian")),1),e("option",W,d(t.$t("english")),1)],512),[[R,i.table.language]]),e("div",X,[e("table",Y,[e("thead",Z,[e("tr",tt,[(c(!0),h(f,null,v(i.header,(s,m)=>(c(),h("th",null,[o(e("input",{type:"text","onUpdate:modelValue":u=>s.title=u,class:"border-2 p-2 rounded border-solid border-theme-15 font-bold"},null,8,et),[[g,s.title]]),e("button",{class:"btn btn-danger mx-1",onClick:u=>r.removeHeader(m)}," - ",8,at)]))),256))])]),e("tbody",null,[x(U,{tag:"ul",list:i.data,class:"list-group",handle:".handle","item-key":"name"},{item:V(({element:s,index:m})=>[e("li",lt,[e("tr",st,[(c(!0),h(f,null,v(s,u=>(c(),h("div",it,[(c(!0),h(f,null,v(u,(y,I)=>(c(),h("td",null,[o(e("input",{type:"text","onUpdate:modelValue":w=>y.title=w,class:"border p-2 rounded"},null,8,ot),[[g,y.title]]),e("button",{class:"btn btn-danger mx-1",onClick:w=>r.removeCol(m,I)}," - ",8,dt)]))),256))]))),256)),e("button",{class:"btn btn-success mx-1",onClick:u=>r.addCol(m)}," + ",8,nt),e("button",{class:"btn btn-dark mx-1",onClick:u=>r.removeRow(m)}," - ",8,rt),ct])])]),_:1},8,["list"])])])])],512),[[b,l.user.role.table.edit]])])}const mt=S(A,[["render",ht],["__scopeId","data-v-2b1c9a5e"]]);export{mt as default};