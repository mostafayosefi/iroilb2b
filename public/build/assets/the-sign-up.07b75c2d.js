import{_ as V,h as x,i as _,R as T,j as y,o as h,c,b as f,a as t,w as i,v as g,t as a,m as L,n as d,q as m,s as U,x as v,d as j,l as O,e as b,F as $,k as P,r as w,p as z,g as M}from"./app.c6c6a3cb.js";const q={props:{site:Object,user:Object},emits:["getUser"],components:{accountHeader:x(()=>_(()=>import("./account-header.5b9985a6.js"),["assets/account-header.5b9985a6.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css"])),accountFooter:x(()=>_(()=>import("./account-footer.88d063a8.js"),["assets/account-footer.88d063a8.js","assets/app.c6c6a3cb.js","assets/app.c39a63c1.css"])),VueTelInput:T},data(){return{csrf:document.querySelector('meta[name="csrf-token"]').getAttribute("content"),isLoading:!1,name:"",step:1,phone:"",email:"",password:"",setting:{postemail:!0,advsms:!0},repeatPassword:"",messageAlert:[],stateAlert:!1,bindProps:{validCharactersOnly:!0,ignoredCountries:["IL"],enabledCountryCode:!0,autoFormat:!1,inputOptions:{placeholder:this.$t("phone-input",this.$route.params.lang)+" "+this.$t("required",this.$route.params.lang)}},country:null,passwordState:!1,passwordMessage:this.$t("password-wrong",this.$route.params.lang),countDown:120,emailCode:"",phoneCode:"",placeHolderCode:this.$route.params.lang=="fa"?"tel98547":""}},methods:{countryChanged(e){this.country=e.dialCode},sendCode(){if(this.validData()){this.isLoading=!0;const e={lang:this.$route.params.lang,name:this.name,phone:this.country+this.phone,email:this.email,password:this.password,setting:this.setting};y.post("/register",e).then(s=>{s.status==200&&(this.isLoading=!1,this.countDownTimer(),this.step=2)}).catch(s=>{if(this.isLoading=!1,s.response.data.errors.email){let r=this.$t("email-exist",this.$route.params.lang);this.messageAlert.push(r),setTimeout(()=>this.messageAlert=this.messageAlert.filter(n=>n!=r),4e3)}if(s.response.data.errors.phone){let r=this.$t("phone-exist",this.$route.params.lang);this.messageAlert.push(r),setTimeout(()=>this.messageAlert=this.messageAlert.filter(n=>n!=r),4e3)}})}},validData(){let e=0,s=this.$t("field-error",this.$route.params.lang),r=this.$t("phone-error",this.$route.params.lang);return this.name.length<2?(this.messageAlert.push(s),e++,setTimeout(()=>this.messageAlert=this.messageAlert.filter(n=>n!=s),4e3)):(e=0,this.messageAlert=this.messageAlert.filter(n=>n!=s)),this.phone.length<10?(this.messageAlert.push(r),e++,setTimeout(()=>this.messageAlert=this.messageAlert=this.messageAlert.filter(n=>n!=r),4e3)):(e=0,this.messageAlert=this.messageAlert.filter(n=>n!=r)),this.emailCheck(),this.passwordMatch(),!!(e==0&&this.passwordMatch()&&this.emailCheck())},passwordMatch(){if(this.password.length>3)return this.password.length>0&&this.password==this.repeatPassword?(this.passwordState=!1,!0):(this.passwordState=!0,!1);{let e=this.$t("password-less",this.$route.params.lang);return this.messageAlert.push(e),setTimeout(()=>this.messageAlert=this.messageAlert.filter(s=>s!=e),4e3),!1}},emailCheck(){var e=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;if(this.email.match(e))return!0;{let s=this.$t("email-check",this.$route.params.lang);return this.messageAlert.push(s),setTimeout(()=>this.messageAlert=this.messageAlert.filter(r=>r!=s),4e3),!1}},countDownTimer(){this.countDown>0&&setTimeout(()=>{this.countDown-=1,this.countDownTimer()},1e3)},setCountDown(e){this.countDown=e},sentAgain(){this.isLoading=!0;let e={email:this.email,phone:this.country+this.phone};y.post("/register/auth",e).then(s=>{s.status==200&&(this.setCountDown(120),this.countDownTimer()),this.isLoading=!1}).catch(s=>{this.isLoading=!1})},authenticate(){this.isLoading=!0;let e={email:this.email,phone:this.country+this.phone,phonecode:this.phoneCode,emailcode:this.emailCode};y.post("/register/done",e).then(s=>{if(s.data.status==200){this.$router.push({name:"sitePanel"});const r={id:s.data.data.id,token:s.data.data.token,role:s.data.data.role,session:"25j_7Sl6xDq2Kc3ym0fmrSSk2xV2XkUkX"};this.$cookies.set("user",r,"180d"),this.$emit("getUser")}else{let r=this.$t("not-valied",this.$route.params.lang);this.messageAlert.push(r),setTimeout(()=>this.messageAlert=this.messageAlert.filter(n=>n!=r),4e3)}this.isLoading=!1}).catch(s=>{this.isLoading=!1})}},watch:{$route:{immediate:!0,handler(e,s){document.title=this.$t("signup",this.$route.params.lang)+" - "+this.$t("user-account",this.$route.params.lang)+" | "+document.title}}}},u=e=>(z("data-v-74d3b09e"),e=e(),M(),e),I={class:"md:flex justify-center py-5 w-full lg:w-4/5 xl:w-2/3 m-auto md:mt-10"},F={class:"w-full md:w-2/4 relative"},E={class:"blur-login"},H=u(()=>t("img",{class:"loader",src:"/images/loading.svg",alt:"loading"},null,-1)),N=[H],R={class:"w-full rounded-lg shadow-lg pb-10 px-4"},B={class:"font-bold text-xl"},G={class:"relative flex w-full flex-wrap items-stretch"},K=u(()=>t("i",{class:"fe fe-user text-xl"},null,-1)),X=[K],J=["placeholder"],Q={dir:"ltr",class:"relative mt-5 flex w-full flex-wrap items-stretch"},W=u(()=>t("span",{class:"z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400"},[t("i",{class:"fe fe-mail text-xl"})],-1)),Y=["placeholder"],Z={dir:"ltr",class:"relative mt-5 flex w-full flex-wrap items-stretch"},ee=u(()=>t("span",{class:"z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400"},[t("i",{class:"fe fe-lock text-xl"})],-1)),te=["placeholder"],se={dir:"ltr",class:"relative mt-5 flex w-full flex-wrap items-stretch"},le=u(()=>t("span",{class:"z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400"},[t("i",{class:"fe fe-lock text-xl"})],-1)),oe=["placeholder"],re={class:"text-justify"},ae={for:"email"},ne={class:"text-justify"},ie={for:"phone"},ue={class:"w-full shadow-md p-10"},de={key:0,class:"py-5"},pe={class:"text-center text-red-700 text-xl bold"},me={key:1,class:"py-5"},he={class:"float-left mt-5 text-slate-400"},ce={dir:"ltr",class:"relative flex w-full flex-wrap items-stretch"},ge=u(()=>t("span",{class:"z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400"},[t("i",{class:"fe fe-smartphone text-xl"})],-1)),fe=["placeholder"],we={class:"float-left mt-5 text-slate-400"},ye={dir:"ltr",class:"relative flex w-full flex-wrap items-stretch"},be=u(()=>t("span",{class:"z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400"},[t("i",{class:"fe fe-mail text-xl"})],-1)),xe=["placeholder"],_e={class:"w-full md:w-1/2 text-sm p-5"},ve={class:"text-dark-primary"},$e={class:"mt-2"},ke={class:"text-dark-primary"},Ce={class:"mt-2"},Ae={class:"text-red-600 relative m-4"},De={class:"inline-block w-full align-middle bg-red-50 border-red-600 my-1 p-3 border-2 rounded-lg"},Se=u(()=>t("span",{class:"text-xl inline-block mx-2 align-middle"},[t("i",{class:"fe fe-lock"})],-1)),Ve={class:"text-red-600 relative m-4"},Te=u(()=>t("span",{class:"text-xl inline-block mx-2 align-middle"},[t("i",{class:"fe fe-bell"})],-1));function Le(e,s,r,n,l,p){const k=w("accountHeader"),C=w("vue-tel-input"),A=w("router-link"),D=w("accountFooter");return h(),c($,null,[f(k,{site:r.site},null,8,["site"]),t("div",I,[t("div",F,[i(t("div",E,N,512),[[g,l.isLoading]]),i(t("div",R,[t("h2",B,a(e.$t("free-join",e.$route.params.lang)),1),t("form",{class:"mt-10",onSubmit:s[9]||(s[9]=L(()=>{},["prevent"]))},[t("div",G,[t("span",{class:d([e.$route.params.lang=="fa"?"left-5":"","z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400"])},X,2),i(t("input",{type:"text","onUpdate:modelValue":s[0]||(s[0]=o=>l.name=o),placeholder:e.$t("fullname",e.$route.params.lang)+" "+e.$t("required",e.$route.params.lang),class:d([e.$route.params.lang=="fa"?"placeholder:text-right":"","py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"])},null,10,J),[[m,l.name]])]),f(C,U({dir:"ltr",modelValue:l.phone,"onUpdate:modelValue":s[1]||(s[1]=o=>l.phone=o),styleClasses:"p-2 border w-full mt-5 block w-full focus:text-sky-500",onCountryChanged:p.countryChanged,item:l.placeHolderCode},l.bindProps),null,16,["modelValue","onCountryChanged","item"]),t("div",Q,[W,i(t("input",{dir:"ltr",type:"email","onUpdate:modelValue":s[2]||(s[2]=o=>l.email=o),placeholder:e.$t("email",e.$route.params.lang)+" "+e.$t("required",e.$route.params.lang),class:d([e.$route.params.lang=="fa"?"placeholder:text-right":"","py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"]),pattern:"[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$"},null,10,Y),[[m,l.email]])]),t("div",Z,[ee,i(t("input",{dir:"ltr",type:"password","onUpdate:modelValue":s[3]||(s[3]=o=>l.password=o),placeholder:e.$t("password",e.$route.params.lang)+" "+e.$t("required",e.$route.params.lang),class:d(["py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14",[l.passwordState?"ring ring-red-600":"",e.$route.params.lang=="fa"?"placeholder:text-right":""]])},null,10,te),[[m,l.password]])]),t("div",se,[le,i(t("input",{dir:"ltr",type:"password","onUpdate:modelValue":s[4]||(s[4]=o=>l.repeatPassword=o),placeholder:e.$t("password-again",e.$route.params.lang)+" "+e.$t("required",e.$route.params.lang),class:d(["py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14",[l.passwordState?"ring ring-red-600":"",e.$route.params.lang=="fa"?"placeholder:text-right":""]]),onKeyup:s[5]||(s[5]=(...o)=>p.passwordMatch&&p.passwordMatch(...o))},null,42,oe),[[m,l.repeatPassword]])]),t("div",re,[i(t("input",{"onUpdate:modelValue":s[6]||(s[6]=o=>l.setting.postemail=o),type:"checkbox",class:"mx-2 accent-dark-primary",id:"email"},null,512),[[v,l.setting.postemail]]),t("label",ae,a(e.$t("email-notificate",e.$route.params.lang)),1)]),t("div",ne,[i(t("input",{"onUpdate:modelValue":s[7]||(s[7]=o=>l.setting.advsms=o),type:"checkbox",class:"mx-2 accent-dark-primary",id:"phone"},null,512),[[v,l.setting.advsms]]),t("label",ie,a(e.$t("phone-notificate",e.$route.params.lang)),1)]),t("button",{onClick:s[8]||(s[8]=o=>p.sendCode()),class:"bg-dark-primary text-white font-bold uppercase text-xs py-3 rounded-full outline-none my-5 w-full hover:bg-slate-500",type:"button"},a(e.$t("signup-btn",e.$route.params.lang)),1)],32),t("span",null,a(e.$t("login-now",e.$route.params.lang)+" "),1),f(A,{to:{name:"siteAccount"},class:"text-blue-500"},{default:j(()=>[b(a(e.$t("login",e.$route.params.lang)),1)]),_:1})],512),[[g,l.step==1]]),i(t("div",ue,[l.countDown>0?(h(),c("div",de,[t("p",pe,a(l.countDown+" "+e.$t("seconds",e.$route.params.lang)),1)])):l.countDown==0?(h(),c("div",me,[t("p",{onClick:s[10]||(s[10]=o=>p.sentAgain()),class:"text-center text-slate-400",style:{cursor:"pointer"}},a(e.$t("sent-again-code",e.$route.params.lang)),1)])):O("",!0),t("p",null," 1- "+a(e.$t("authenticate-message",e.$route.params.lang)),1),t("p",null," 2- "+a(e.$t("authenticate-force",e.$route.params.lang)),1),t("span",he,a(l.phone),1),t("div",ce,[ge,i(t("input",{dir:"ltr",type:"number","onUpdate:modelValue":s[11]||(s[11]=o=>l.phoneCode=o),placeholder:e.$t("submit-code",e.$route.params.lang),class:"py-3 placeholder-slate-400 text-blueGray-600 relative border border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 w-full px-14 rounded-md focus:ring-1 h-full focus:text-sky-500"},null,8,fe),[[m,l.phoneCode]])]),t("span",we,a(l.email),1),t("div",ye,[be,i(t("input",{dir:"ltr",type:"number","onUpdate:modelValue":s[12]||(s[12]=o=>l.emailCode=o),placeholder:e.$t("submit-code",e.$route.params.lang),class:"py-3 placeholder-slate-400 text-blueGray-600 relative border border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 w-full px-14 rounded-md focus:ring-1 h-full focus:text-sky-500"},null,8,xe),[[m,l.emailCode]])]),t("button",{onClick:s[13]||(s[13]=o=>p.authenticate()),class:"bg-dark-primary text-white font-bold uppercase text-xs py-3 rounded-full outline-none my-5 w-full hover:bg-slate-500",type:"button"},a(e.$t("authenticate",e.$route.params.lang)),1)],512),[[g,l.step==2]])]),t("div",_e,[t("section",{class:d(["w-full mt-4 text-center",e.$route.params.lang=="fa"?"sm:text-right":"sm:text-left"])},[t("strong",ve,a(e.$t("login-top-header",e.$route.params.lang)),1),t("p",$e,a(e.$t("login-top-text",e.$route.params.lang)),1)],2),t("section",{class:d(["w-full mt-4 text-center",e.$route.params.lang=="fa"?"sm:text-right":"sm:text-left"])},[t("strong",ke,a(e.$t("login-bottom-header",e.$route.params.lang)),1),t("p",Ce,a(e.$t("login-bottom-text",e.$route.params.lang)),1)],2),i(t("section",Ae,[t("strong",De,[Se,b(" "+a(l.passwordMessage),1)])],512),[[g,l.passwordState]]),i(t("section",Ve,[(h(!0),c($,null,P(l.messageAlert,(o,S)=>(h(),c("strong",{class:"inline-block w-full align-middle bg-red-50 border-red-600 my-1 p-3 border-2 rounded-lg",key:S},[Te,b(" "+a(o),1)]))),128))],512),[[g,l.messageAlert[0]]])])]),f(D,{site:r.site},null,8,["site"])],64)}const je=V(q,[["render",Le],["__scopeId","data-v-74d3b09e"]]);export{je as default};