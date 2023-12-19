<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
    <!--        Loader       -->
    <div v-show="isLoading" class="h-screen w-screen fixed flex items-center justify-center !z-50">
        <section
            class="w-[200px] h-[100px] bg-dark-primary-trans p-5 rounded-2xl flex justify-center items-center blur-panel">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </section>
    </div>
    <section class="flex mb-14">
        <aside
            class="bg-dark-primary md:w-2/6 xl:w-1/6 min-h-[calc(100vh-140px)] hidden md:flex flex-wrap content-between">
            <panelSideBar :site="site" :user="user"></panelSideBar>
        </aside>
        <div class="w-full md:mx-7 md:w-4/6 xl:w-5/6">
            <section v-show="user.step=='tow'"
                     class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                    <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize"> {{ $t('step', language) }} (2/3) :</b>
                        {{ $t('step-tow', language) }}
                    </span>
                </div>
                <router-link :to="{name:'sitePanelAds'}"
                             class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                    {{ $t('ad-step', language) }}
                </router-link>
            </section>
            <section v-show="user.step=='three'"
                     class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                    <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize"> {{ $t('step', language) }} (3/3) :</b>
                        {{ $t('step-three', language) }}
                    </span>
                </div>
                <router-link :to="{name:'siteFeedBack'}"
                             class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                    {{ $t('feed-step', language) }}
                </router-link>
            </section>
            <div v-show="user.step=='one'" class="mx-2 md:mx-4 mt-2">
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row md:space-x-2"
                            :class="language=='fa'?'md:space-x-reverse':''">
                            <li class="flex-auto text-center">
                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded-lg block leading-normal mx-2 cursor-pointer"
                                   @click="toggleTabs(1)"
                                   :class="{'text-emerald-600 bg-white': openTab !== 1, 'text-white bg-dark-primary': openTab === 1}">
                                    <i class="fi fi-ir mx-1"></i>
                                    {{ $t('persian-data', language) }}
                                </a>
                            </li>
                            <li class="flex-auto text-center">
                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded-lg block leading-normal mx-2 cursor-pointer"
                                   @click="toggleTabs(2)"
                                   :class="{'text-emerald-600 bg-white': openTab !== 2, 'text-white bg-dark-primary': openTab === 2}">
                                    <i class="fi fi-us mx-1"></i>
                                    {{ $t('english-data', language) }}
                                </a>
                            </li>
                        </ul>
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 rounded">
                            <div class="px-4 flex-auto">
                                <div class="tab-content tab-space">
                                    <!--          persian form                 -->
                                    <div :class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                        <!--          Tab step              -->
                                        <section class="flex justify-between items-center">
                                            <div v-show="tab.fa==1">
                                                <small class="text-gray-400 text-xs font-bold">
                                                    {{ $t('step-number', language, {one: '1', tow: '3'}) }}
                                                </small>
                                                <p class="font-bold">
                                                    {{ $t('company-data', language) }}
                                                </p>
                                            </div>
                                            <div v-show="tab.fa==2">
                                                <small class="text-gray-400 text-xs font-bold">
                                                    {{ $t('step-number', language, {one: '2', tow: '3'}) }}
                                                </small>
                                                <p class="font-bold">
                                                    {{ $t('contact-data', language) }}
                                                </p>
                                            </div>
                                            <div v-show="tab.fa==3">
                                                <small class="text-gray-400 text-xs font-bold">
                                                    {{ $t('step-number', language, {one: '3', tow: '3'}) }}
                                                </small>
                                                <p class="font-bold">
                                                    {{ $t('member-data', language) }}
                                                </p>
                                            </div>
                                            <!--           Show error desktop    -->
                                            <div
                                                v-show="error.fa.stepOne ||  error.fa.stepTow || error.fa.stepThree"
                                                class="text-red-500 border rounded-lg bg-red-50 border-red-500 py-1 px-2 hidden md:inline">
                                                {{ $t('error-empty-fields', language) }}
                                            </div>
                                            <section class="flex space-x-2"
                                                     :class="language=='fa'?'space-x-reverse':''">
                                                <button v-show="tab.fa>1" @click="tabManager('fa','prev')"
                                                        class="btn bg-white-secondary rounded-lg px-4 py-2 text-dark-primary">
                                                    {{ $t('prev', language) }}
                                                </button>
                                                <button v-show="tab.fa<3" @click="tabManager('fa','next')"
                                                        class="btn bg-dark-primary rounded-lg px-4 py-2 text-white">
                                                    {{ $t('next', language) }}
                                                </button>
                                                <button v-show="tab.fa==3" @click="tabManager('fa','next')"
                                                        class="btn bg-dark-primary rounded-lg px-4 py-2 text-white">
                                                    {{ $t('submit-company', language) }}
                                                </button>
                                            </section>
                                        </section>
                                        <!--           Show error mobile    -->
                                        <div
                                            v-show="error.fa.stepOne ||  error.fa.stepTow || error.fa.stepThree"
                                            class="text-red-500 border rounded-lg bg-red-50 border-red-500 py-1 px-2 my-1 w-full block md:hidden">
                                            {{ $t('error-empty-fields', language) }}
                                        </div>
                                        <!--         Body form          -->
                                        <form>
                                            <!--         step one             -->
                                            <div v-show="tab.fa==1">
                                                <div class="my-2 pb-2 space-y-2">
                                                    <div class="space-x-0 md:space-x-2 space-y-2 md:space-y-0"
                                                         :class="language=='fa'?'md:space-x-reverse':''">
                                                        <button type="button" @click="toggleModal()"
                                                                class="btn bg-white-primary p-2 rounded-full z-10">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'space-x-reverse':''">
                                                                <label for="upload-logo" class="cursor-pointer">
                                                                    {{ $t('upload-logo', language) }}
                                                                </label>
                                                                <span v-show="company.data.logo!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1 z-30">
                                                                     ({{ $t('file', language) }})
                                                                    <button type="button" class="flex items-center"
                                                                            @click="company.data.logo = ''; selectedFile = ''; $refs.cropper.value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                        <input id="upload-logo" ref="FileInput" type="file"
                                                               style="display: none;" @change="onFileSelect"/>
                                                        <button type="button"
                                                                class="btn bg-white-primary p-2 rounded-full">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'space-x-reverse':''">
                                                                <label for="document-one" class="cursor-pointer">
                                                                    {{
                                                                        $t('upload', language) + " " + $t('ceo-pass', language)
                                                                    }}
                                                                </label>
                                                                <span v-show="company.data.documentOne!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1">
                                                                    ({{ company.data.documentOne.name }})
                                                                    <button type="button" class="flex items-center"
                                                                            @click="company.data.documentOne = ''; selectedFile = ''; $refs['document-one'].value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                        <input id="document-one" ref="document-one" type="file"
                                                               style="display: none;" @change="onChangeDocOne()"/>
                                                        <button type="button"
                                                                class="btn bg-white-primary p-2 rounded-full">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'space-x-reverse':''">
                                                                <label for="document-tow" class="cursor-pointer">
                                                                    {{
                                                                        $t('upload', language) + " " + $t('statute', language)
                                                                    }}
                                                                </label>
                                                                <span v-show="company.data.documentTow!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1">
                                                                    ({{ company.data.documentTow.name }})
                                                                    <button type="button" class="flex items-center"
                                                                            @click="company.data.documentTow = ''; $refs['document-tow'].value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                        <input id="document-tow" ref="document-tow" type="file"
                                                               style="display: none;" @change="onChangeDocTow()"/>
                                                        <button type="button"
                                                                class="btn bg-white-primary p-2 rounded-full">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'space-x-reverse':''">
                                                                <label for="document-three" class="cursor-pointer">
                                                                    {{
                                                                        $t('upload', language) + " " + $t('statute', language)
                                                                    }}
                                                                </label>
                                                                <span v-show="company.data.documentThree!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1">
                                                                    ({{ company.data.documentThree.name }})
                                                                      <button type="button" class="flex items-center"
                                                                              @click="company.data.documentThree = ''; $refs['document-three'].value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                        <input id="document-three" ref="document-three" type="file"
                                                               style="display: none;" @change="onChangeDocThree()"/>
                                                    </div>
                                                    <div
                                                        class="text-blue-500 border rounded-lg mb-4 bg-blue-100 border-blue-500 py-1 px-2 mt-2 flex">
                                                        <i class="verified pr-2 md:mx-2 md:pr-0"
                                                           :style="language=='fa'?'float:right;':'float:left;'"></i>
                                                        <span class="inline-block align-middle">
                                                          {{ $t('verified-message', language) }}
                                                         </span>
                                                    </div>
                                                    <div class="mt-4 space-y-2">
                                                        <div>
                                                            <label class="text-sm font-bold text-gray-700" for="filter">{{
                                                                    $t('field-of-activity', language)
                                                                }}</label>
                                                            <Multiselect id="filter" v-model="company.data.filter"
                                                                         :rtl="language=='fa'?true:false"
                                                                         :noOptionsText="$t('empty',language)"
                                                                         mode="tags" :searchable="false"
                                                                         :options="language=='fa'?filter.fa:filter.en"
                                                                         :class="error.fa.stepOne && !company.data.filter[0]?'ring ring-red-600' : ''"/>
                                                        </div>
                                                        <div>
                                                            <label class="text-sm font-bold text-gray-700" for="tags">
                                                                {{ $t('products', language) }}</label>
                                                            <Multiselect id="tags"
                                                                         v-model="company.data.tags"
                                                                         :rtl="language=='fa'?true:false"
                                                                         :noOptionsText="$t('empty',language)"
                                                                         mode="tags" :searchable="true"
                                                                         :options="language=='fa'?tags.fa:tags.en"
                                                                         :class="error.fa.stepOne && !company.data.tags[0]? 'ring ring-red-600' : ''"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <legend class="text-sm font-bold text-gray-700 mx-2 px-2">
                                                        {{ $t('base-data', language) }}
                                                    </legend>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700" for="fa-name">{{
                                                                $t('company-name', language)
                                                            }}</label>
                                                        <input v-model="company.fa.name" type="text" id="fa-name"
                                                               dir="rtl"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               :class="error.fa.stepOne && company.fa.name==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700" for="fa-des">
                                                            {{ $t('intro-company', language) }}
                                                        </label>
                                                        <textarea id="fa-des" v-model="company.fa.description"
                                                                  dir="rtl"
                                                                  class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                                  :class="error.fa.stepOne && company.fa.description==''?'ring ring-red-600':''"
                                                        ></textarea>
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-local">{{ $t('local-work', language) }}</label>
                                                        <select id="fa-local" v-model="company.fa.local"
                                                                class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                                                            <option v-for="data in countries" :value="data.name">
                                                                {{ language == 'fa' ? data.fa : data.name }}
                                                            </option>
                                                        </select>
                                                    </section>
                                                </fieldset>
                                            </div>
                                            <!--            step tow           -->
                                            <div v-show="tab.fa==2">
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-phone">{{ $t('tell', language) }}</label>
                                                        <input v-model="company.fa.tell" type="tel" id="fa-phone"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.fa.stepTow && company.fa.tell==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-adress">{{ $t('adress', language) }}</label>
                                                        <textarea v-model="company.fa.adress" id="fa-adress"
                                                                  dir="rtl"
                                                                  class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                                  :class="error.fa.stepTow && company.fa.adress==''?'ring ring-red-600':''"></textarea>
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-instagram">
                                                            {{ $t('instagram-id', language) }}</label>
                                                        <input v-model="company.fa.instagram" type="text"
                                                               id="fa-instagram"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.fa.stepTow && company.fa.instagram==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-facebook">
                                                            {{ $t('facebook-id', language) }}
                                                        </label>
                                                        <input v-model="company.fa.facebook" type="text"
                                                               id="fa-facebook"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-linkedin">
                                                            {{ $t('linkedin-id', language) }}
                                                        </label>
                                                        <input v-model="company.fa.linkedin" type="text"
                                                               id="fa-linkedin"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                </fieldset>
                                            </div>
                                            <!--                step three            -->
                                            <div v-show="tab.fa==3">
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <legend class="text-sm font-bold text-gray-700 mx-2 px-2">
                                                        {{ $t('ceo', language) }}
                                                    </legend>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-ceo-name">
                                                            {{ $t('name', language) }}
                                                        </label>
                                                        <input v-model="company.fa.ceo.name" type="text"
                                                               id="fa-ceo-name"
                                                               dir="rtl"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               :class="error.fa.stepThree && company.fa.ceo.name==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-ceo-tell">
                                                            {{ $t('phone', language) }}
                                                        </label>
                                                        <input v-model="company.fa.ceo.phone" type="tel"
                                                               id="fa-ceo-tell"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.fa.stepThree && company.fa.ceo.phone==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-ceo-email">
                                                            {{ $t('email', language) }}
                                                        </label>
                                                        <input v-model="company.fa.ceo.email" type="email"
                                                               id="fa-ceo-email"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.fa.stepThree && company.fa.ceo.email==''?'ring ring-red-600':''">
                                                    </section>
                                                </fieldset>
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <legend class="text-sm font-bold text-gray-700 mx-2 px-2">
                                                        {{ $t('sales-manager', language) }}
                                                    </legend>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-manager-name">
                                                            {{ $t('name', language) }}
                                                        </label>
                                                        <input v-model="company.fa.manager.name" type="text"
                                                               id="fa-manager-name"
                                                               dir="rtl"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-manager-tell">
                                                            {{ $t('phone', language) }}
                                                        </label>
                                                        <input v-model="company.fa.manager.phone" type="tel"
                                                               id="fa-manager-tell"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-manager-email">
                                                            {{ $t('email', language) }}
                                                        </label>
                                                        <input v-model="company.fa.manager.email" type="email"
                                                               id="fa-manager-email"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                </fieldset>
                                            </div>
                                        </form>
                                    </div>
                                    <!--         english tab          -->
                                    <div :class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                                        <!--          Tab step              -->
                                        <section class="flex justify-between items-center">
                                            <div v-show="tab.en==1">
                                                <small class="text-gray-400 text-xs font-bold">
                                                    {{ $t('step-number', language, {one: '1', tow: '3'}) }}
                                                </small>
                                                <p class="font-bold">
                                                    {{ $t('company-data', language) }}
                                                </p>
                                            </div>
                                            <div v-show="tab.en==2">
                                                <small class="text-gray-400 text-xs font-bold">
                                                    {{ $t('step-number', language, {one: '2', tow: '3'}) }}
                                                </small>
                                                <p class="font-bold">
                                                    {{ $t('contact-data', language) }}
                                                </p>
                                            </div>
                                            <div v-show="tab.en==3">
                                                <small class="text-gray-400 text-xs font-bold">
                                                    {{ $t('step-number', language, {one: '3', tow: '3'}) }}
                                                </small>
                                                <p class="font-bold">
                                                    {{ $t('member-data', language) }}
                                                </p>
                                            </div>
                                            <!--           Show error     -->
                                            <div
                                                v-show="error.en.stepOne ||  error.en.stepTow || error.en.stepThree"
                                                class="text-red-500 border rounded-lg bg-red-50 border-red-500 py-1 px-2 hidden md:inline">
                                                {{ $t('error-empty-fields', language) }}
                                            </div>
                                            <section class="flex space-x-2"
                                                     :class="language=='fa'?'space-x-reverse':''">
                                                <button v-show="tab.en>1" @click="tabManager('en','prev')"
                                                        class="btn bg-white-secondary rounded-lg px-4 py-2 text-dark-primary">
                                                    {{ $t('prev', language) }}
                                                </button>
                                                <button v-show="tab.en<3" @click="tabManager('en','next')"
                                                        class="btn bg-dark-primary rounded-lg px-4 py-2 text-white">

                                                    {{ $t('next', language) }}
                                                </button>
                                                <button v-show="tab.en==3" @click="tabManager('en','next')"
                                                        class="btn bg-dark-primary rounded-lg px-4 py-2 text-white">
                                                    {{ $t('submit-company', language) }}
                                                </button>
                                            </section>
                                        </section>
                                        <!--           Show error mobile    -->
                                        <div
                                            v-show="error.en.stepOne ||  error.en.stepTow || error.en.stepThree"
                                            class="text-red-500 border rounded-lg bg-red-50 border-red-500 py-1 px-2 my-1 w-full block md:hidden">
                                            {{ $t('error-empty-fields', language) }}
                                        </div>
                                        <form>
                                            <!--         step one                   -->
                                            <div v-show="tab.en==1">
                                                <div class="my-2 pb-2 space-y-2">
                                                    <div class="space-x-0 md:space-x-2 space-y-2 md:space-y-0"
                                                         :class="language=='fa'?'md:space-x-reverse':''">
                                                        <button type="button" @click="toggleModal()"
                                                                class="btn bg-white-primary p-2 rounded-full z-10">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'md:space-x-reverse':''">
                                                                <label for="upload-logo" class="cursor-pointer">
                                                                    {{ $t('upload-logo', language) }}
                                                                </label>
                                                                <span v-show="company.data.logo!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1 z-30">
                                                                     ({{ $t('file', language) }})
                                                                    <button type="button" class="flex items-center"
                                                                            @click="company.data.logo = ''; selectedFile = ''; $refs.cropper.value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                        <button type="button"
                                                                class="btn bg-white-primary p-2 rounded-full">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'md:space-x-reverse':''">
                                                                <label for="document-one" class="cursor-pointer">
                                                                    {{
                                                                        $t('upload', language) + " " + $t('ceo-pass', language)
                                                                    }}
                                                                </label>
                                                                <span v-show="company.data.documentOne!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1">
                                                                    ({{ company.data.documentOne.name }})
                                                                    <button type="button" class="flex items-center"
                                                                            @click="company.data.documentOne = ''; selectedFile = ''; $refs['document-one'].value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                        <button type="button"
                                                                class="btn bg-white-primary p-2 rounded-full">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'md:space-x-reverse':''">
                                                                <label for="document-tow" class="cursor-pointer">
                                                                    {{
                                                                        $t('upload', language) + " " + $t('statute', language)
                                                                    }}
                                                                </label>
                                                                <span v-show="company.data.documentTow!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1">
                                                                    ({{ company.data.documentTow.name }})
                                                                    <button type="button" class="flex items-center"
                                                                            @click="company.data.documentTow = ''; $refs['document-tow'].value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                        <button type="button"
                                                                class="btn bg-white-primary p-2 rounded-full">
                                                            <section class="flex space-x-2"
                                                                     :class="language=='fa'?'md:space-x-reverse':''">
                                                                <label for="document-three" class="cursor-pointer">
                                                                    {{
                                                                        $t('upload', language) + " " + $t('statute', language)
                                                                    }}
                                                                </label>
                                                                <span v-show="company.data.documentThree!=''"
                                                                      class="bg-white-secondary rounded-full flex items-center px-1">
                                                                    ({{ company.data.documentThree.name }})
                                                                      <button type="button" class="flex items-center"
                                                                              @click="company.data.documentThree = ''; $refs['document-three'].value = null">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </span>
                                                            </section>
                                                        </button>
                                                    </div>
                                                    <div
                                                        class="text-blue-500 border rounded-lg mb-4 bg-blue-100 border-blue-500 py-1 px-2 mt-2 flex">
                                                        <i class="verified pr-2 md:mx-2 md:pr-0"
                                                           :style="language=='fa'?'float:right;':'float:left;'"></i>
                                                        <span class="inline-block align-middle">
                                                          {{ $t('verified-message', language) }}
                                                         </span>
                                                    </div>
                                                    <div class="mt-4 space-y-2">
                                                        <div>
                                                            <label class="text-sm font-bold text-gray-700"
                                                                   for="en-filter">
                                                                {{ $t('field-of-activity', language) }}
                                                            </label>
                                                            <Multiselect id="en-filter" v-model="company.data.filter"
                                                                         :rtl="language=='fa'?true:false"
                                                                         :noOptionsText="$t('empty',language)"
                                                                         mode="tags" :searchable="false"
                                                                         :options="language=='fa'?filter.fa:filter.en"
                                                                         :class="error.en.stepOne && !company.data.filter[0]?'ring ring-red-600' : ''"/>
                                                        </div>
                                                        <div>
                                                            <label class="text-sm font-bold text-gray-700"
                                                                   for="en-tags">
                                                                {{ $t('products', language) }}</label>
                                                            <Multiselect id="en-tags"
                                                                         v-model="company.data.tags"
                                                                         :rtl="language=='fa'?true:false"
                                                                         :noOptionsText="$t('empty',language)"
                                                                         mode="tags" :searchable="true"
                                                                         :options="language=='fa'?tags.fa:tags.en"
                                                                         :class="error.en.stepOne && !company.data.tags[0]? 'ring ring-red-600' : ''"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <legend class="text-sm font-bold text-gray-700 mx-2 px-2">
                                                        {{ $t('base-data', language) }}
                                                    </legend>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700" for="en-name">
                                                            {{ $t('company-name', language) }}
                                                        </label>
                                                        <input v-model="company.en.name" type="text" id="en-name"
                                                               dir="ltr"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               :class="error.en.stepOne && company.en.name==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700" for="en-des">
                                                            {{ $t('intro-company', language) }}
                                                        </label>
                                                        <textarea id="en-des" v-model="company.en.description"
                                                                  dir="ltr"
                                                                  class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                                  :class="error.en.stepOne && company.en.description==''?'ring ring-red-600':''"
                                                        ></textarea>
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-local">{{ $t('local-work', language) }}</label>
                                                        <select id="en-local" v-model="company.en.local"
                                                                class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                                                            <option v-for="data in countries" :value="data.name">
                                                                {{ language == 'fa' ? data.fa : data.name }}
                                                            </option>
                                                        </select>
                                                    </section>
                                                </fieldset>
                                            </div>
                                            <!--            step tow           -->
                                            <div v-show="tab.en==2">
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-phone">{{ $t('tell', language) }}</label>
                                                        <input v-model="company.en.tell" type="tel" id="en-phone"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.en.stepTow && company.en.tell==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-adress">{{ $t('adress', language) }}</label>
                                                        <textarea v-model="company.en.adress" id="en-adress"
                                                                  dir="ltr"
                                                                  class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                                  :class="error.en.stepTow && company.en.adress==''?'ring ring-red-600':''"></textarea>
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-instagram">
                                                            {{ $t('instagram-id', language) }}</label>
                                                        <input v-model="company.en.instagram" type="text"
                                                               id="en-instagram"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.en.stepTow && company.en.instagram==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-facebook">
                                                            {{ $t('facebook-id', language) }}
                                                        </label>
                                                        <input v-model="company.en.facebook" type="text"
                                                               id="en-facebook"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-linkedin">
                                                            {{ $t('linkedin-id', language) }}
                                                        </label>
                                                        <input v-model="company.en.linkedin" type="text"
                                                               id="en-linkedin"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                </fieldset>
                                            </div>
                                            <!--                step three            -->
                                            <div v-show="tab.en==3">
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <legend class="text-sm font-bold text-gray-700 mx-2 px-2">
                                                        {{ $t('ceo', language) }}
                                                    </legend>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-ceo-name">
                                                            {{ $t('name', language) }}
                                                        </label>
                                                        <input v-model="company.en.ceo.name" type="text"
                                                               id="en-ceo-name"
                                                               dir="ltr"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               :class="error.en.stepThree && company.en.ceo.name==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-ceo-tell">
                                                            {{ $t('phone', language) }}
                                                        </label>
                                                        <input v-model="company.en.ceo.phone" type="tel"
                                                               id="en-ceo-tell"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.en.stepThree && company.en.ceo.phone==''?'ring ring-red-600':''">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="fa-ceo-email">
                                                            {{ $t('email', language) }}
                                                        </label>
                                                        <input v-model="company.en.ceo.email" type="email"
                                                               id="en-ceo-email"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr"
                                                               :class="error.en.stepThree && company.en.ceo.email==''?'ring ring-red-600':''">
                                                    </section>
                                                </fieldset>
                                                <fieldset
                                                    class="border-2 border-solid border-gray-300 p-3 rounded-lg my-2 space-y-2">
                                                    <legend class="text-sm font-bold text-gray-700 mx-2 px-2">
                                                        {{ $t('sales-manager', language) }}
                                                    </legend>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-manager-name">
                                                            {{ $t('name', language) }}
                                                        </label>
                                                        <input v-model="company.en.manager.name" type="text"
                                                               id="en-manager-name"
                                                               dir="ltr"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-manager-tell">
                                                            {{ $t('phone', language) }}
                                                        </label>
                                                        <input v-model="company.en.manager.phone" type="tel"
                                                               id="en-manager-tell"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                    <section>
                                                        <label class="text-sm font-bold text-gray-700"
                                                               for="en-manager-email">
                                                            {{ $t('email', language) }}
                                                        </label>
                                                        <input v-model="company.en.manager.email" type="email"
                                                               id="en-manager-email"
                                                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                                               dir="ltr">
                                                    </section>
                                                </fieldset>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-show="user.step=='tow' || user.step=='three' || user.step=='four'">
                <section v-for="item in companyList" :key="item.id"
                         class="border-2 border-slate-200 border-solid rounded-lg p-4 m-2 text-sm block md:flex justify-between items-center shadow-md">
                    <section class="flex space-x-1" :class="language=='fa'?'space-x-reverse':''">
                        <section>
                        <span class="bg-purple-100 px-2 text-purple-500 rounded-lg"
                              v-show="item.status=='draft'">{{ $t('check', language) }}</span>
                            <span class="bg-slate-100 px-2 text-slate-500 rounded-lg"
                                  v-show="item.status=='timeout'">{{ $t('timeout', language) }}</span>
                            <span class="bg-orange-100 px-2 text-orange-500 rounded-lg"
                                  v-show="item.status=='reject'">{{ $t('reject', language) }}</span>
                            <span class="bg-green-100 px-2 text-green-500 rounded-lg"
                                  v-show="item.status=='active'">{{ $t('active', language) }}</span>
                        </section>
                        <div class="mb-2 md:mb-0 " v-show="language==='fa'">
                            <strong v-show="item.nameFa!=null">{{ item.nameFa }}</strong>
                            <strong v-show="item.nameFa==null">{{ item.nameEn }}</strong>
                        </div>
                        <div class="mb-2 md:mb-0" v-show="language==='en'">
                            <strong v-show="item.nameEn!=null">{{ item.nameEn }}</strong>
                            <strong v-show="item.nameEn==null">{{ item.nameFa }}</strong>
                        </div>
                    </section>
                    <section class="flex mt-2 md:mt-0 space-x-1" :class="language=='fa'?'space-x-reverse':''">
                        <router-link v-show="item.status=='active'"
                                     class="px-4 py-1 font-semibold text-sm bg-dark-primary text-white rounded-full shadow-sm"
                                     :to="{path:'/fa/co/'+item.slug}">
                            {{ $t('persian', language) }}
                        </router-link>
                        <router-link v-show="item.status=='active'"
                                     class="px-4 py-1 font-semibold text-sm bg-dark-primary text-white rounded-full shadow-sm"
                                     :to="{path:'/en/co/'+item.slug}">
                            {{ $t('english', language) }}
                        </router-link>
                        <router-link
                            class="px-4 py-1 font-semibold text-sm bg-dark-primary text-white rounded-full shadow-sm"
                            :to="{path:'/'+language +'/panel/company/'+item.id}">
                            {{ $t('edit', language) }}
                        </router-link>
                    </section>
                </section>
            </div>
        </div>
    </section>

    <div v-show="showModal"
         class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
        <div class="relative md:my-6 px-2 md:px-0 mx-auto w-full md:w-1/2">
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white">
                <div class="flex items-center justify-between p-3 border-b border-solid border-blueGray-200 rounded-t">
                    <h3 class="text-l">
                        {{ $t('upload-logo', language) }}
                    </h3>
                    <button @click="selectedFile = '' ; toggleModal() ; company.data.logo=''" ref="close"
                            class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button">
                        {{ $t('close', language) }}
                    </button>
                </div>
                <VueCropper :modal="true" v-show="selectedFile" ref="cropper" :src="selectedFile"
                            alt="Source Image">
                </VueCropper>
                <label v-show="selectedFile == ''" for="upload-logo"
                       class=" rounded-xl m-4 p-3 border-white-primary border-dotted border-4 text-center cursor-pointer">
                    <i class="fe fe-upload text-6xl"></i>
                </label>
                <!--footer-->
                <div class="flex items-center justify-end p-3 border-t border-solid border-blueGray-200 rounded-b">
                    <button v-show="selectedFile != ''"
                            class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" @click="toggleModal()">
                        {{ $t('crop', language) }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div v-show="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
</template>
<script>
import {defineAsyncComponent} from "vue";
import "/node_modules/flag-icons/css/flag-icons.min.css";
import countries from './../../../../../public/js/countries.json'
import Multiselect from "@vueform/multiselect";
import axios from "axios";
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';

export default {
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        Multiselect,
        "panelSideBar": defineAsyncComponent(() => import('./../layout/side-bar-panel.vue')),
        VueCropper
    },
    emits: ['getUser'],
    data() {
        return {
            show: true,
            isLoading: false,
            language: this.$route.params.lang,
            openTab: '',
            countries: countries,
            showModal: false,
            error: {
                fa: {
                    stepOne: false,
                    stepTow: false,
                    stepThree: false
                },
                en: {
                    stepOne: false,
                    stepTow: false,
                    stepThree: false
                }
            },
            selectedFile: '',
            multiOption: {
                mode: 'tags',
                closeOnSelect: false,
                searchable: true,
                createOption: true
            },
            tab: {
                fa: 1,
                en: 1
            },
            tags: {
                en: [],
                fa: []
            },
            filter: {
                en: [],
                fa: []
            },
            companyList: [],
            company: {
                fa: {
                    name: '',
                    tell: '',
                    instagram: '',
                    facebook: '',
                    linkedin: '',
                    local: 'Iran',
                    adress: '',
                    description: '',
                    ceo: {
                        name: '',
                        phone: '',
                        email: '',
                    },
                    manager: {
                        name: '',
                        phone: '',
                        email: '',
                    }
                },
                en: {
                    name: '',
                    tell: '',
                    instagram: '',
                    facebook: '',
                    linkedin: '',
                    local: 'United Arab Emirates',
                    adress: '',
                    description: '',
                    ceo: {
                        name: '',
                        phone: '',
                        email: '',
                    },
                    manager: {
                        name: '',
                        phone: '',
                        email: '',
                    }
                },
                data: {
                    logo: '',
                    documentOne: '',
                    documentTow: '',
                    documentThree: '',
                    tags: [],
                    filter: []
                }
            }
        }
    },
    methods: {
        loading() {
            this.show = false;
        },
        toggleTabs: function (tabNumber) {
            this.openTab = tabNumber
        },
        toggleModal: function () {
            this.showModal = !this.showModal;
            this.company.data.logo = this.$refs.cropper.getCroppedCanvas().toDataURL();
        },
        onFileSelect(e) {
            var file = e.target.files[0]
            if (typeof FileReader === 'function') {
                const reader = new FileReader()
                reader.onload = (event) => {
                    this.selectedFile = event.target.result
                    this.$refs.cropper.replace(this.selectedFile)
                    this.$refs.cropper.setAspectRatio(1)
                }
                reader.readAsDataURL(file)

            } else {
                alert('retry')
            }
        },
        onChangeDocOne() {
            this.company.data.documentOne = this.$refs["document-one"].files[0];
        },
        onChangeDocTow() {
            this.company.data.documentTow = this.$refs["document-tow"].files[0];
        },
        onChangeDocThree() {
            this.company.data.documentThree = this.$refs["document-three"].files[0];
        },
        getCompany() {
            axios.get('/company/user', {
                params: {
                    'api_token': this.$cookies.get('user').token,
                    'id': this.$cookies.get('user').id
                }
            }).then(response => {
                this.companyList = [];
                for (const responseElement of response.data) {
                    this.companyList.push({
                        id: responseElement.data.id,
                        slug: responseElement.data.slug,
                        status: responseElement.data.status,
                        nameFa: responseElement.fa.name,
                        nameEn: responseElement.en.name,
                    });
                }
            }).catch(() => {
            });

        },
        tabManager(lang, move) {
            if (lang == 'fa') {
                this.error.fa.stepOne = false;
                this.error.fa.stepTow = false;
                this.error.fa.stepThree = false;
                let i = 0;
                let j = 0;
                let k = 0;
                if (this.tab.fa == 1) {
                    if (this.company.data.filter == '') {
                        this.error.fa.stepOne = true;
                        i++;
                    }
                    if (this.company.data.tags == '') {
                        this.error.fa.stepOne = true;
                        i++;
                    }
                    if (this.company.fa.description == '') {
                        this.error.fa.stepOne = true;
                        i++;
                    }
                    if (move == 'next' && i == 0) {
                        this.tab.fa = this.tab.fa + 1
                    }
                } else if (this.tab.fa == 2) {
                    if (this.company.fa.tell == '') {
                        this.error.fa.stepTow = true;
                        j++;
                    }
                    if (this.company.fa.adress == '') {
                        this.error.fa.stepTow = true;
                        j++;
                    }
                    if (this.company.fa.instagram == '') {
                        this.error.fa.stepTow = true;
                        j++;
                    }
                    if (move == 'next' && j == 0) {
                        this.tab.fa = this.tab.fa + 1
                    }
                } else {
                    if (this.company.fa.ceo.name == '') {
                        this.error.fa.stepThree = true;
                        k++;
                    }
                    if (this.company.fa.ceo.email == '') {
                        this.error.fa.stepThree = true;
                        k++;
                    }
                    if (this.company.fa.ceo.phone == '') {
                        this.error.fa.stepThree = true;
                        k++;
                    }

                    if (move == 'next' && k == 0) {
                        this.submitForm();
                    }
                }

                if (move == 'prev') {
                    this.tab.fa = this.tab.fa - 1
                }
            } else if (lang == 'en') {
                this.error.en.stepOne = false;
                this.error.en.stepTow = false;
                this.error.en.stepThree = false;
                let i = 0;
                let j = 0;
                let k = 0;
                if (this.tab.en == 1) {
                    if (this.company.data.filter == '') {
                        this.error.en.stepOne = true;
                        i++;
                    }
                    if (this.company.data.tags == '') {
                        this.error.en.stepOne = true;
                        i++;
                    }
                    if (this.company.en.description == '') {
                        this.error.en.stepOne = true;
                        i++;
                    }
                    if (move == 'next' && i == 0) {
                        this.tab.en = this.tab.en + 1
                    }
                } else if (this.tab.en == 2) {
                    if (this.company.en.tell == '') {
                        this.error.en.stepTow = true;
                        j++;
                    }
                    if (this.company.en.adress == '') {
                        this.error.en.stepTow = true;
                        j++;
                    }
                    if (this.company.en.instagram == '') {
                        this.error.en.stepTow = true;
                        j++;
                    }
                    if (move == 'next' && j == 0) {
                        this.tab.en = this.tab.en + 1
                    }
                } else {
                    if (this.company.en.ceo.name == '') {
                        this.error.en.stepThree = true;
                        k++;
                    }
                    if (this.company.en.ceo.email == '') {
                        this.error.en.stepThree = true;
                        k++;
                    }
                    if (this.company.en.ceo.phone == '') {
                        this.error.en.stepThree = true;
                        k++;
                    }

                    if (move == 'next' && k == 0) {
                        this.submitForm();
                    }
                }
                if (move == 'prev') {
                    this.tab.en = this.tab.en - 1
                }
            }
        },
        submitForm() {
            this.isLoading = true;
            const user = {
                0: this.$cookies.get('user').id,
            }
            let formData = new FormData();
            formData.append('api_token', this.$cookies.get('user').token);
            formData.append('user_management', JSON.stringify(user));
            formData.append('body_fa', JSON.stringify(this.company.fa));
            formData.append('body_en', JSON.stringify(this.company.en));
            formData.append('filters', JSON.stringify(this.company.data.filter));
            formData.append('tags', JSON.stringify(this.company.data.tags));
            formData.append('languages', this.language);
            formData.append('logo', this.company.data.logo)
            formData.append('document_one', this.company.data.documentOne)
            formData.append('document_tow', this.company.data.documentTow)
            formData.append('document_three', this.company.data.documentThree)
            axios.post('/company/create',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((res) => {
                if (res.data == 'success') {
                    this.company.fa.name = '';
                    this.company.fa.tell = '';
                    this.company.fa.instagram = '';
                    this.company.fa.facebook = '';
                    this.company.fa.linkedin = '';
                    this.company.fa.adress = '';
                    this.company.fa.description = '';
                    this.company.fa.ceo.name = '';
                    this.company.fa.ceo.phone = '';
                    this.company.fa.ceo.email = '';
                    this.company.fa.manager.name = '';
                    this.company.fa.manager.phone = '';
                    this.company.fa.manager.email = '';
                    this.company.en.name = '';
                    this.company.en.tell = '';
                    this.company.en.instagram = '';
                    this.company.en.facebook = '';
                    this.company.en.linkedin = '';
                    this.company.en.adress = '';
                    this.company.en.description = '';
                    this.company.en.ceo.name = '';
                    this.company.en.ceo.phone = '';
                    this.company.en.ceo.email = '';
                    this.company.en.manager.name = '';
                    this.company.en.manager.phone = '';
                    this.company.en.manager.email = '';
                    this.company.data.logo = '';
                    this.company.data.documentOne = '';
                    this.company.data.documentTow = '';
                    this.company.data.documentThree = '';
                    this.company.data.tags = [];
                    this.company.data.filter = [];
                    this.$emit('getUser');
                    this.getCompany();
                }
                this.isLoading = false;
            }).catch(error => {
                this.isLoading = false;
            });

        },
    },
    created() {
        if (this.user.step == 'tow' || this.user.step == 'three') {
            this.getCompany();
        }
        if (this.language == 'fa') {
            countries.sort((a, b) => {
                let fa = a.fa.toLowerCase(),
                    fb = b.fa.toLowerCase();

                if (fa < fb) {
                    return -1;
                }
                if (fa > fb) {
                    return 1;
                }
                return 0;
            });
        }

        if (this.language == 'en') {
            countries.sort((a, b) => {
                let fa = a.name.toLowerCase(),
                    fb = b.name.toLowerCase();

                if (fa < fb) {
                    return -1;
                }
                if (fa > fb) {
                    return 1;
                }
                return 0;
            });
        }
    },
    async beforeCreate() {
        await axios.get('/product', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            this.tags.en = [];
            this.tags.fa = [];
            for (const responseElement of response.data.data) {
                this.tags.fa.push(responseElement.name_fa);
                this.tags.en.push(responseElement.name_en);
            }
        }).catch(() => {
        });
        await axios.get('/filter', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            this.filter.en = [];
            this.filter.fa = [];
            for (const responseElement of response.data.data) {
                this.filter.fa.push(responseElement.name_fa);
                this.filter.en.push(responseElement.name_en);
            }
        }).catch(() => {
        });

        await axios.get('/company/user', {
            params: {
                'api_token': this.$cookies.get('user').token,
                'id': this.$cookies.get('user').id,
            }
        }).then(response => {
            this.companyList = [];
            for (const responseElement of response.data) {
                this.companyList.push({
                    id: responseElement.data.id,
                    slug: responseElement.data.slug,
                    status: responseElement.data.status,
                    nameFa: responseElement.fa.name,
                    nameEn: responseElement.en.name,
                });
            }
        }).catch(() => {
        });
        this.openTab = this.language == 'fa' ? 1 : 2
        document.title = this.$t('company-managment', this.language) + " | " + this.site.title
        this.loading()
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
@media (min-width: 920px) {
    .verified {
        background: url("/images/verified.svg") no-repeat;
        background-size: 25px;
        width: 25px;
        height: 25px;
    }
}

@media (max-width: 920px) {
    .verified {
        background: url("/images/verified.svg") no-repeat;
        background-size: 25px;
        width: 50px;
        height: 25px;
    }
}

.multiselect {
    border-radius: 0.5rem;
    padding: 0.25rem;
}

.multiselect-tag {
    background: #495464;
}

span.multiselect-clear {
    display: none;
}

span.multiselect-caret {
    margin: 0 !important;
    padding: 10px !important;
    width: 37px;
}
</style>
