import{_ as C,h as x,i as w,j as b,o as i,c as r,N as u,d as c,U as D,b as p,a as e,t as l,F as m,k as g,w as h,v as _,n as y,e as v,r as f}from"./app.c6c6a3cb.js";/* empty css                 */const R={data(){return{language:this.$route.params.lang,post:{id:"",title:"",image:"",text:"",seoDescription:"",seoKeyword:[],time:"",created:"",view:""},cat:[],labels:[],related:[],relatedShow:!1,rate:"",count:"",score:"",rateState:!1}},props:{site:Object,user:Object},emits:["getUser"],components:{siteHeader:x(()=>w(()=>import("./site-header.7b088332.js"),["assets/site-header.7b088332.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css","assets/site-header.1dc29b9e.css"])),siteFooter:x(()=>w(()=>import("./site-footer.ca28a09a.js"),["assets/site-footer.ca28a09a.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css"]))},methods:{onAfterRate(s){this.rateState=!0;const a={post:this.post.id,rate:s};b.post("/blog/rate",a).then(n=>{n.data.status==200})}},beforeCreate(){b.get("/blog/post/"+this.$route.params.post,{params:{lang:this.$route.params.lang}}).then(s=>{if(s.data=="null"&&window.location.replace(this.$sitename+this.$route.params.lang+"/404"),s.data.post.images&&(this.post.image=this.$sitename+"upload/post/"+s.data.post.images.toLowerCase()),s.data.cat!=null)for(const a of s.data.cat)this.cat.push({title:a.title,slug:a.slug});if(s.data.label!=null)for(const a of s.data.label)this.labels.push({title:a.title,slug:a.slug});if(s.data.related!=null){this.relatedShow=!0;for(const a of s.data.related){let n="";a.image?n=this.$sitename+"upload/post/"+a.image.toLowerCase():n=!1,this.related.push({image:n,title:a.title,text:a.text,slug:a.slug,time:a.time})}}this.post.id=s.data.post.id,this.post.title=s.data.post.title,this.post.text=s.data.post.body,this.post.time=s.data.time,this.post.created=s.data.created,this.post.view=s.data.post.views,this.score=s.data.rate,this.count=s.data.count,this.post.seoDescription=s.data.post.seoDes,this.post.seoKeyword=s.data.post.seoKay,document.title=s.data.post.title+" | "+this.site.title,document.querySelector('meta[name="description"]').setAttribute("content",this.post.seoDescription),document.querySelector('meta[name="keywords"]').setAttribute("content",this.post.seoKeyword)})}},L={class:"bg-dark-primary text-white-primary pt-6 md:pt-10 pb-24 md:pb-32 text-center"},V={class:"flex flex-col-reverse md:flex-row items-center justify-center"},E={class:"rounded text-sm text-dark-primary bg-white-primary mx-3 px-1 pt-1"},F=e("i",{class:"mx-1 fe fe-eye"},null,-1),H={class:"pt-1 px-1"},T={class:"text-3xl font-bold py-6 leading-[3rem]"},N={class:"hidden md:block"},B={class:"flex items-center justify-center"},K={class:"text-sm"},M={class:"text-sm mx-2"},O={class:"text-white-primary text-sm"},P={class:"text-white-primary text-sm"},U={class:"w-full md:w-3/4 -mt-12 md:mx-auto"},q={class:"mx-2 border rounded-lg p-4 bg-white"},z={class:"w-full flex justify-center mb-6"},I=["src"],W=["innerHTML"],G={class:"block md:hidden mt-4"},J={class:"w-full text-sm"},Q={class:"w-full text-sm"},X={class:"text-dark-primary text-sm"},Y={class:"text-white-primary text-sm"},Z={class:"w-full md:w-1/3 mx-auto border rounded-lg p-5 mt-8 text-center"},$={class:"bg-white-primary text-center text-dark-primary my-6 py-10"},tt={class:"text-xl"},et={class:"w-full md:w-3/4 mx-auto mt-2 md:mt-4 md:p-4 flex flex-wrap"},st={class:"w-full md:w-[calc(33%-13px)] p-2 mx-2 mb-4 border rounded-lg md:flex flex-col justify-between"},ot=["src","alt"],lt={class:"text-[1rem] md:text-lg font-bold text-dark-primary md:my-2 w-2/3 md:w-full"},at=["innerHTML"],it={class:"hidden md:flex flex-row-reverse justify-between items-end"},nt=e("i",{class:"text-dark-primary text-lg fe fe-more-horizontal"},null,-1),rt={class:"text-sm text-slate-400"};function ct(s,a,n,dt,t,k){const S=f("siteHeader"),d=f("router-link"),j=f("rate"),A=f("siteFooter");return i(),r(m,null,[(i(),u(D("script"),{type:"application/ld+json"},{default:c(()=>[v(' { "@context": "https://schema.org/", "@type": "CreativeWorkSeries", "name": "'+l(t.post.title)+'", "aggregateRating": { "@type": "AggregateRating", "itemReviewed":"'+l(t.post.title)+'", "ratingValue": "'+l(Number(t.score).toFixed(1))+'", "bestRating": "5", "ratingCount": "'+l(t.count)+'" } } ',1)]),_:1})),p(S,{site:n.site,user:n.user},null,8,["site","user"]),e("div",L,[e("div",V,[e("p",E,[F,e("span",H,l(t.post.view),1)]),e("h1",T,l(t.post.title),1)]),e("div",N,[e("div",B,[e("span",K,l(s.$t("published",t.language)+": "+t.post.created),1),e("span",M,l(s.$t("last-update",t.language)+": "+t.post.time),1),(i(!0),r(m,null,g(t.cat,o=>(i(),u(d,{class:"mx-1",to:{path:"/"+t.language+"/blog/"+o.slug}},{default:c(()=>[e("span",O," #"+l(o.title),1)]),_:2},1032,["to"]))),256)),(i(!0),r(m,null,g(t.labels,o=>(i(),u(d,{class:"mx-1",to:{path:"/"+t.language+"/tag/"+o.slug}},{default:c(()=>[e("span",P," #"+l(o.title),1)]),_:2},1032,["to"]))),256))])])]),e("div",U,[e("div",q,[h(e("div",z,[e("img",{src:t.post.image},null,8,I)],512),[[_,t.post.image.length>10]]),e("div",{class:"page leading-8",innerHTML:t.post.text},null,8,W),e("div",G,[e("div",{class:y(t.language=="fa"?"text-right":"text-left")},[e("p",J,l(s.$t("published",t.language)+": "+t.post.created),1),e("p",Q,l(s.$t("last-update",t.language)+": "+t.post.time),1),(i(!0),r(m,null,g(t.cat,o=>(i(),u(d,{class:"mx-1",to:{path:"/"+t.language+"/blog/"+o.slug}},{default:c(()=>[e("span",X," #"+l(o.title),1)]),_:2},1032,["to"]))),256)),(i(!0),r(m,null,g(t.labels,o=>(i(),u(d,{class:"mx-1",to:{path:"/"+t.language+"/tag/"+o.slug}},{default:c(()=>[e("span",Y," #"+l(o.title),1)]),_:2},1032,["to"]))),256))],2)]),e("div",Z,[h(e("span",null,l(s.$t("rate-post",t.language)),513),[[_,!t.rateState]]),h(e("span",null,l(s.$t("rate-message",t.language)),513),[[_,t.rateState]]),v(" ("+l(Number(t.score).toFixed(1))+") - "+l(t.count)+" ",1),p(j,{length:5,value:4,showcount:!0,modelValue:t.rate,"onUpdate:modelValue":a[0]||(a[0]=o=>t.rate=o),onAfterRate:k.onAfterRate,disabled:t.rateState},null,8,["modelValue","onAfterRate","disabled"])])])]),h(e("div",$,[e("strong",tt,l(s.$t("similar-content",t.language)),1)],512),[[_,t.relatedShow]]),e("div",et,[(i(!0),r(m,null,g(t.related,o=>(i(),r("section",st,[p(d,{class:"flex content-start justify-start items-start md:block",to:{path:"/"+t.language+"/post/"+o.slug}},{default:c(()=>[h(e("img",{src:o.image,alt:o.title,class:y(["rounded h-auto md:h-64 object-cover w-1/3 md:w-full",t.language=="fa"?"ml-2":"mr-2"])},null,10,ot),[[_,o.image]]),e("h3",lt,l(o.title),1)]),_:2},1032,["to"]),e("p",{class:"hidden md:block text-slate-500 mb-4",innerHTML:o.text+" ..."},null,8,at),e("div",it,[p(d,{class:"text-dark-secondary text-sm",to:{path:"/"+t.language+"/post/"+o.slug}},{default:c(()=>[nt]),_:2},1032,["to"]),e("span",rt,l(s.$t("last-update",t.language))+" "+l(o.time),1)])]))),256))]),p(A,{site:n.site},null,8,["site"])],64)}const pt=C(R,[["render",ct]]);export{pt as default};