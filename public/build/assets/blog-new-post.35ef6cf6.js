import{_ as B,h as K,i as Q,j as U,o as l,c as i,b as w,w as d,v as E,a as e,e as x,t as n,q as D,n as T,s as A,u as H,F as y,k as f,r as O,x as v,l as k,p as L,g as q}from"./app.c6c6a3cb.js";import{Q as z}from"./vue-quill.esm-bundler.7c8d11ac.js";/* empty css                       */import{s as R}from"./multiselect.d432e60a.js";/* empty css                                                         */const G={emits:["loadingHide","loading"],props:{loading:Boolean,user:Object},components:{"header-admin":K(()=>Q(()=>import("./header-admin.6f180bbb.js"),["assets/header-admin.6f180bbb.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css"])),QuillEditor:z,Multiselect:R},data(){return{error:!1,post:{title:"",slug:"",language:"fa",status:"draft",image:"",userId:this.$cookies.get("user").id,category:[],label:[],body:"",seoDescription:"",seoKayword:[]},multiOption:{mode:"tags",closeOnSelect:!1,searchable:!0,createOption:!0},categories:[],subCategories:[],labels:{en:[],fa:[]}}},methods:{onChangeImage(){this.post.image=this.$refs.image.files[0]},savePost(){if(this.post.title!=""&&this.post.slug!=""){this.$emit("loading"),this.error=!1,this.post.body=this.$refs.myEditor.getHTML();let s=new FormData;s.append("api_token",this.$cookies.get("user").token),s.append("title",this.post.title),s.append("slug",this.post.slug),s.append("language",this.post.language),s.append("status",this.post.status),s.append("images",this.post.image),s.append("user_id",this.post.userId),s.append("categories",this.post.category),s.append("labels",this.post.label),s.append("body",this.post.body),s.append("seo_description",this.post.seoDescription),s.append("seo_kaywords",this.post.seoKayword),U.post("/post/create",s,{headers:{"Content-Type":"multipart/form-data"}}).then(t=>{t.data.status==200&&(this.$router.push({name:"adminPosts"}),this.$emit("loadingHide"))}).catch(t=>{this.$emit("loadingHide")})}else this.error=!0}},created(){U.get("/category",{params:{api_token:this.$cookies.get("user").token}}).then(s=>{for(const t of s.data.cat)this.categories.push({id:t.id,slug:t.slug,titleFa:t.titleFa,titleEn:t.titleEn,descriptionFa:t.descriptionFa,descriptionEn:t.descriptionEn,child:[]});for(const t of s.data.subCat)this.subCategories.push({id:t.id,parentId:t.parentId,slug:t.slug,titleFa:t.titleFa,titleEn:t.titleEn,descriptionFa:t.descriptionFa,descriptionEn:t.descriptionEn,child:[]});this.$emit("loadingHide")}).catch(s=>{this.$emit("loadingHide")}),U.get("/label",{params:{api_token:this.$cookies.get("user").token}}).then(s=>{for(const t of s.data.data)t.lang=="en"?this.labels.en.push(t.title):this.labels.fa.push(t.title)}).catch(s=>{this.$emit("loadingHide")})},name:"App",watch:{$route:{immediate:!0,handler(s,t){document.title=this.$t("add")+" "+this.$t("post")+" | "+this.$t("adminTitlePage")}}}},V=s=>(L("data-v-4c0083f3"),s=s(),q(),s),J={class:"content"},W={class:"alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold",role:"alert"},X=V(()=>e("i",{"data-feather":"alert-octagon",class:"w-6 h-6 ml-2"},null,-1)),Y={class:"pos intro-y grid grid-cols-12 gap-5 mt-5"},Z={class:"intro-y col-span-12 lg:col-span-9"},$={class:"alert alert-outline-danger alert-dismissible show flex items-center col-span-12 mb-4 bg-white",role:"alert"},C=V(()=>e("i",{"data-feather":"alert-octagon",class:"w-6 h-6 ml-2"},null,-1)),S=["dir","placeholder"],ee={class:"box p-2"},te={class:"input-group intro-y"},oe=["placeholder"],se={id:"input-group-price",class:"input-group-text pb-0",dir:"ltr"},le={class:"post intro-y overflow-hidden box mt-5"},ie={class:"post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600",role:"tablist"},ne=["title"],re=V(()=>e("i",{"data-feather":"file-text",class:"w-4 h-4 ml-2"},null,-1)),de=["title"],pe=V(()=>e("i",{"data-feather":"code",class:"w-4 h-4 ml-2"},null,-1)),ae={class:"post__content tab-content"},ue={id:"content",class:"tab-pane p-5 active",role:"tabpanel"},ce={id:"meta-title",role:"tabpanel",class:"tab-pane p-5"},ge={for:"desc",class:"mt-3"},he=["placeholder"],me={class:"mt-2 mb-4"},_e={class:"intro-y col-span-12 lg:col-span-3 text-left"},ye={class:"box p-2 text-right"},fe={class:"bg-light-2 p-2 font-bold rounded mb-2"},ve={value:"fa"},be={value:"en"},ke={value:"draft"},Ee={value:"publish"},we={class:"box p-2 text-right mt-6"},xe={class:"bg-light-2 p-2 font-bold rounded mb-2"},Ve={class:"box p-2 text-right mt-6"},Fe={class:"bg-light-2 p-2 font-bold rounded mb-2"},Ie=["id","value"],Ue=["for"],De={key:0},Oe=["id","value"],Pe=["for"],Te={key:0},He=["id","value"],Me=["for"],Ne={key:0},je=["id","value"],Be=["for"],Ke={key:0},Qe=["id","value"],Ae=["for"],Le={key:0},qe=["id","value"],ze=["for"],Re={key:0},Ge=["id","value"],Je=["for"],We={key:0},Xe=["id","value"],Ye=["for"],Ze={key:0},$e=["id","value"],Ce=["for"],Se={key:0},et=["id","value"],tt=["for"],ot={class:"box p-2 text-right mt-6"},st={class:"bg-light-2 p-2 font-bold rounded mb-2"};function lt(s,t,F,it,o,I){const M=O("header-admin"),N=O("QuillEditor"),P=O("Multiselect");return l(),i("div",J,[w(M,{user:F.user,title:s.$t("add")+" "+s.$t("post")},null,8,["user","title"]),d(e("div",W,[X,x(" "+n(s.$t("access-message")),1)],512),[[E,!F.user.role.post.add]]),d(e("div",null,[e("div",Y,[e("div",Z,[d(e("div",$,[C,x(" "+n(s.$t("error-empty-post-fields")),1)],512),[[E,o.error]]),d(e("input",{dir:o.post.language=="fa"?"rtl":"ltr",type:"text",class:"form-control py-3 px-4 box placeholder-theme-8 mb-4",placeholder:s.$t("title"),"onUpdate:modelValue":t[0]||(t[0]=r=>o.post.title=r)},null,8,S),[[D,o.post.title]]),e("div",ee,[e("div",te,[d(e("input",{dir:"ltr",id:"slug",type:"text",class:"form-control text-left",placeholder:s.$t("post-slug"),"onUpdate:modelValue":t[1]||(t[1]=r=>o.post.slug=r)},null,8,oe),[[D,o.post.slug]]),e("div",se,n(s.$hostname+o.post.language+"/post/"),1)])]),e("div",le,[e("div",ie,[e("a",{title:s.$t("body"),"data-toggle":"tab","data-target":"#content",href:"javascript:;",class:"tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center active",id:"content-tab",role:"tab"},[re,x(" "+n(s.$t("body")),1)],8,ne),e("a",{title:s.$t("seo-tools"),"data-toggle":"tab","data-target":"#meta-title",href:"javascript:;",class:"tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center",id:"meta-title-tab",role:"tab"},[pe,x(" "+n(s.$t("seo-tools")),1)],8,de)]),e("div",ae,[e("div",ue,[w(N,{content:o.post.body,"onUpdate:content":t[2]||(t[2]=r=>o.post.body=r),theme:"snow",toolbar:"full",ref:"myEditor"},null,8,["content"])]),e("div",ce,[e("label",ge,n(s.$t("descriptions")+" "+s.$t("seo")),1),e("span",{class:T(["mx-2 px-2 rounded-full bg-theme-21 text-xs text-white",o.post.seoDescription.length<160?"bg-theme-":"bg-theme-20"])},n(o.post.seoDescription.length),3),d(e("textarea",{id:"desc",class:"form-control mt-3",rows:"3",placeholder:s.$t("descriptions")+" "+s.$t("seo"),"onUpdate:modelValue":t[3]||(t[3]=r=>o.post.seoDescription=r),maxlength:"320"},`
                            `,8,he),[[D,o.post.seoDescription]]),e("div",me,[w(P,A({id:"kay",class:"mt-2.5 mb-3",modelValue:o.post.seoKayword,"onUpdate:modelValue":t[4]||(t[4]=r=>o.post.seoKayword=r),rtl:!0,placeholder:s.$t("insert-kaywords"),noOptionsText:s.$t("empty")},o.multiOption),null,16,["modelValue","placeholder","noOptionsText"])])])])])]),e("div",_e,[e("button",{class:T(["btn mb-4 btn-lg border-0",o.post.status=="publish"?"btn-green":"btn-dark"]),onClick:t[5]||(t[5]=r=>I.savePost())},[d(e("span",null,n(s.$t("save")+" "+s.$t("draft")),513),[[E,o.post.status=="draft"]]),d(e("span",null,n(s.$t("public")),513),[[E,o.post.status=="publish"]])],2),e("div",ye,[e("p",fe,n(s.$t("setting")),1),d(e("select",{id:"lang",class:"form-control","onUpdate:modelValue":t[6]||(t[6]=r=>o.post.language=r)},[e("option",ve,n(s.$t("persian")),1),e("option",be,n(s.$t("english")),1)],512),[[H,o.post.language]]),d(e("select",{id:"lang",class:"form-control mt-2","onUpdate:modelValue":t[7]||(t[7]=r=>o.post.status=r)},[e("option",ke,n(s.$t("draft")),1),e("option",Ee,n(s.$t("publish")),1)],512),[[H,o.post.status]])]),e("div",we,[e("p",xe,n(s.$t("post-image")),1),e("input",{type:"file",ref:"image",onChange:t[8]||(t[8]=(...r)=>I.onChangeImage&&I.onChangeImage(...r))},null,544)]),e("div",Ve,[e("p",Fe,n(s.$t("categories")),1),(l(!0),i(y,null,f(o.categories,r=>(l(),i("ul",{key:r.id,class:"label"},[e("li",null,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[9]||(t[9]=p=>o.post.category=p),id:r.titleEn,value:r.id},null,8,Ie),[[v,o.post.category]]),e("label",{for:r.titleEn},n(r.titleFa+" ("+r.titleEn+") "),9,Ue),(l(!0),i(y,null,f(o.subCategories,p=>(l(),i("ul",{key:p.id,class:"ul"},[p.parentId==r.id?(l(),i("li",De,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[10]||(t[10]=a=>o.post.category=a),id:p.titleEn,value:p.id},null,8,Oe),[[v,o.post.category]]),e("label",{for:p.titleEn},n(p.titleFa+" ("+p.titleEn+") "),9,Pe),(l(!0),i(y,null,f(o.subCategories,a=>(l(),i("ul",{key:a.id,class:"ul"},[a.parentId==p.id?(l(),i("li",Te,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[11]||(t[11]=u=>o.post.category=u),id:a.titleEn,value:a.id},null,8,He),[[v,o.post.category]]),e("label",{for:a.titleEn},n(a.titleFa+" ("+a.titleEn+") "),9,Me),(l(!0),i(y,null,f(o.subCategories,u=>(l(),i("ul",{key:u.id,class:"ul"},[u.parentId==a.id?(l(),i("li",Ne,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[12]||(t[12]=c=>o.post.category=c),id:u.titleEn,value:u.id},null,8,je),[[v,o.post.category]]),e("label",{for:u.titleEn},n(u.titleFa+" ("+u.titleEn+") "),9,Be),(l(!0),i(y,null,f(o.subCategories,c=>(l(),i("ul",{key:c.id,class:"ul"},[c.parentId==u.id?(l(),i("li",Ke,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[13]||(t[13]=g=>o.post.category=g),id:c.titleEn,value:c.id},null,8,Qe),[[v,o.post.category]]),e("label",{for:c.titleEn},n(c.titleFa+" ("+c.titleEn+") "),9,Ae),(l(!0),i(y,null,f(o.subCategories,g=>(l(),i("ul",{key:g.id,class:"ul"},[g.parentId==c.id?(l(),i("li",Le,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[14]||(t[14]=h=>o.post.category=h),id:g.titleEn,value:g.id},null,8,qe),[[v,o.post.category]]),e("label",{for:g.titleEn},n(g.titleFa+" ("+g.titleEn+") "),9,ze),(l(!0),i(y,null,f(o.subCategories,h=>(l(),i("ul",{key:h.id,class:"ul"},[h.parentId==g.id?(l(),i("li",Re,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[15]||(t[15]=m=>o.post.category=m),id:h.titleEn,value:h.id},null,8,Ge),[[v,o.post.category]]),e("label",{for:h.titleEn},n(h.titleFa+" ("+h.titleEn+") "),9,Je),(l(!0),i(y,null,f(o.subCategories,m=>(l(),i("ul",{key:m.id,class:"ul"},[m.parentId==h.id?(l(),i("li",We,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[16]||(t[16]=_=>o.post.category=_),id:m.titleEn,value:m.id},null,8,Xe),[[v,o.post.category]]),e("label",{for:m.titleEn},n(m.titleFa+" ("+m.titleEn+") "),9,Ye),(l(!0),i(y,null,f(o.subCategories,_=>(l(),i("ul",{key:_.id,class:"ul"},[_.parentId==m.id?(l(),i("li",Ze,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[17]||(t[17]=b=>o.post.category=b),id:_.titleEn,value:_.id},null,8,$e),[[v,o.post.category]]),e("label",{for:_.titleEn},n(_.titleFa+" ("+_.titleEn+") "),9,Ce),(l(!0),i(y,null,f(o.subCategories,b=>(l(),i("ul",{key:b.id,class:"ul"},[b.parentId==_.id?(l(),i("li",Se,[d(e("input",{type:"checkbox","onUpdate:modelValue":t[18]||(t[18]=j=>o.post.category=j),id:b.titleEn,value:b.id},null,8,et),[[v,o.post.category]]),e("label",{for:b.titleEn},n(b.titleFa+" ("+b.titleEn+") "),9,tt)])):k("",!0)]))),128))])):k("",!0)]))),128))])):k("",!0)]))),128))])):k("",!0)]))),128))])):k("",!0)]))),128))])):k("",!0)]))),128))])):k("",!0)]))),128))])):k("",!0)]))),128))])):k("",!0)]))),128))])]))),128))]),e("div",ot,[e("p",st,n(s.$t("labels")),1),w(P,{id:"kay",class:"mt-2.5 mb-3",modelValue:o.post.label,"onUpdate:modelValue":t[19]||(t[19]=r=>o.post.label=r),rtl:"true",placeholder:s.$t("insert-kaywords"),noOptionsText:s.$t("empty"),mode:"tags",searchable:!0,options:o.post.language=="en"?o.labels.en:o.labels.fa},null,8,["modelValue","placeholder","noOptionsText","options"])])])])],512),[[E,F.user.role.post.add]])])}const ut=B(G,[["render",lt],["__scopeId","data-v-4c0083f3"]]);export{ut as default};
