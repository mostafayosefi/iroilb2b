<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('categories')"></header-admin>
        <div v-show="!user.role.category.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.category.show">
            <div class="flex mt-2">
                <div class="text-lg w-2/4 pl-5">
                    <form @submit.prevent="" class="mt-2 p-2" :class="!addBtn? 'border border-theme-15 rounded' : ''">
                        <div v-show="error"
                             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12"
                             role="alert">
                            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                            {{ $t('error-empty-fields') }}
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="parent">{{ $t('cat-parent') }}</label>
                            <select class="form-control mb-2 intro-y" id="parent" v-model="category.parentId">
                                <option value="null">{{ $t('main-cat') }}</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id"
                                        :selected="cat.id==category.parentId">
                                    {{ cat.titleFa }}
                                </option>
                                <option v-for="subCat in subCategories" :key="subCat.id" :value="subCat.id"
                                        :selected="subCat.id==category.parentId">
                                    {{ subCat.titleFa }}
                                </option>
                            </select>

                            <label for="slug">{{ $t('cat-slug') }}</label> *
                            <div class="input-group mb-2 intro-y">
                                <input dir="ltr" id="slug" type="text"
                                       class="form-control text-left "
                                       :placeholder="$t('cat-slug' )"
                                       v-model="category.slug">
                                <div id="input-group-price" class="input-group-text pb-0" dir="ltr">
                                    {{ $hostname + "{language}/cat/" }}
                                </div>
                            </div>

                            <label for="title-fa">{{ $t('cat-name-fa') }}</label> *
                            <input type="text" id="title-fa"
                                   class="form-control mb-2 intro-y"
                                   :placeholder="$t('cat-name-fa' )"
                                   v-model="category.titleFa">

                            <label for="des-fa">{{ $t('cat-des-fa') }}</label>
                            <textarea id="des-fa" class="form-control mb-2 intro-y" rows="4"
                                      v-model="category.descriptionFa">
                        </textarea>

                            <label for="title-en">{{ $t('cat-name-en') }}</label> *
                            <input type="text" id="title-en" dir="ltr"
                                   class="form-control mb-2 intro-y"
                                   :placeholder="$t('cat-name-en' )"
                                   v-model="category.titleEn">
                            <label for="des-en">{{ $t('cat-des-en') }}</label>
                            <textarea id="des-en" class="form-control mb-2 intro-y" rows="4"
                                      v-model="category.descriptionEn"
                                      dir="ltr">
                        </textarea>
                        </div>
                        <button @click="reset()"
                                type="button"
                                class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button v-show="!addBtn && user.role.category.edit" type="button" @click="updateCategory()"
                                class="btn btn-success w-20">
                            <div v-show="!showLoad">{{ $t('edit') }}</div>
                            <div v-show="showLoad">
                                <i data-loading-icon="puff" class="w-5"></i>
                            </div>
                        </button>
                        <button v-show="addBtn && user.role.category.add" type="button" @click="addCategory()"
                                class="btn btn-success w-20"
                                :disabled="showLoad">
                            <div v-show="!showLoad">{{ $t('add') }}</div>
                            <div v-show="showLoad">
                                <i data-loading-icon="puff" class="w-5"></i>
                            </div>
                        </button>
                    </form>
                </div>
                <div class="py-4 px-6 mt-2 text-xl w-2/4 box intro-y">
                    <div v-show="!categories[0]"
                         class="alert alert-success alert-dismissible show flex items-center col-span-12 intro-y"
                         role="alert">
                        <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                        {{ $t('empty') }}
                    </div>
                    <ul v-for="cat in categories" :key="cat.id" class="ul">
                        <li class="list">
                            {{ cat.titleFa + " (" + cat.titleEn + ") " }}
                            <div>
                                <button v-show="user.role.category.edit"
                                        @click.prevent="editCategory(cat.id)"
                                        class="btn btn-sm btn-outline-dark m-1">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-edit w-4 h-4">
                                        <path
                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path
                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button v-show="user.role.category.delete" @click.prevent="deleteCaregory(cat.id)"
                                        class="btn btn-sm btn-outline-danger m-1">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-trash w-4 h-4">
                                        <polyline
                                            points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                            <ul v-for="subCat in subCategories" :key="subCat.id" class="ul">
                                <li v-if="subCat.parentId==cat.id" class="list">
                                    {{ subCat.titleFa + " (" + subCat.titleEn + ") " }}
                                    <div>
                                        <button v-show="user.role.category.edit"
                                                @click.prevent="editCategory(subCat.id)"
                                                class="btn btn-sm btn-outline-dark m-1">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-edit w-4 h-4">
                                                <path
                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path
                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button v-show="user.role.category.delete"
                                                @click.prevent="deleteCaregory(subCat.id)"
                                                class="btn btn-sm btn-outline-danger m-1">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-trash w-4 h-4">
                                                <polyline
                                                    points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <ul v-for="aSubCat in subCategories" :key="aSubCat.id" class="ul">
                                        <li v-if="aSubCat.parentId==subCat.id" class="list">
                                            {{ aSubCat.titleFa + " (" + aSubCat.titleEn + ") " }}
                                            <div>
                                                <button v-show="user.role.category.edit"
                                                        @click.prevent="editCategory(aSubCat.id)"
                                                        class="btn btn-sm btn-outline-dark m-1">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-edit w-4 h-4">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path
                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                </button>
                                                <button v-show="user.role.category.delete"
                                                        @click.prevent="deleteCaregory(aSubCat.id)"
                                                        class="btn btn-sm btn-outline-danger m-1">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-trash w-4 h-4">
                                                        <polyline
                                                            points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <ul v-for="bSubCat in subCategories" :key="bSubCat.id" class="ul">
                                                <li v-if="bSubCat.parentId==aSubCat.id" class="list">
                                                    {{ bSubCat.titleFa + " (" + bSubCat.titleEn + ") " }}
                                                    <div>
                                                        <button v-show="user.role.category.edit"
                                                                @click.prevent="editCategory(bSubCat.id)"
                                                                class="btn btn-sm btn-outline-dark m-1">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-edit w-4 h-4">
                                                                <path
                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                            </svg>
                                                        </button>
                                                        <button v-show="user.role.category.delete"
                                                                @click.prevent="deleteCaregory(bSubCat.id)"
                                                                class="btn btn-sm btn-outline-danger m-1">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-trash w-4 h-4">
                                                                <polyline
                                                                    points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <ul v-for="cSubCat in subCategories" :key="cSubCat.id"
                                                        class="ul">
                                                        <li v-if="cSubCat.parentId==bSubCat.id" class="list">
                                                            {{
                                                                cSubCat.titleFa + " (" + cSubCat.titleEn + ") "
                                                            }}
                                                            <div>
                                                                <button v-show="user.role.category.edit"
                                                                        @click.prevent="editCategory(cSubCat.id)"
                                                                        class="btn btn-sm btn-outline-dark m-1">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24"
                                                                        height="24"
                                                                        viewBox="0 0 24 24"
                                                                        fill="none"
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        class="feather feather-edit w-4 h-4">
                                                                        <path
                                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                        <path
                                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                    </svg>
                                                                </button>
                                                                <button v-show="user.role.category.delete"
                                                                        @click.prevent="deleteCaregory(cSubCat.id)"
                                                                        class="btn btn-sm btn-outline-danger m-1">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24"
                                                                        height="24"
                                                                        viewBox="0 0 24 24"
                                                                        fill="none"
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        class="feather feather-trash w-4 h-4">
                                                                        <polyline
                                                                            points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <ul v-for="dSubCat in subCategories"
                                                                :key="dSubCat.id"
                                                                class="ul">
                                                                <li v-if="dSubCat.parentId==cSubCat.id"
                                                                    class="list">
                                                                    {{
                                                                        dSubCat.titleFa + " (" + dSubCat.titleEn + ") "
                                                                    }}
                                                                    <div>
                                                                        <button v-show="user.role.category.edit"
                                                                                @click.prevent="editCategory(dSubCat.id)"
                                                                                class="btn btn-sm btn-outline-dark m-1">
                                                                            <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24"
                                                                                height="24"
                                                                                viewBox="0 0 24 24"
                                                                                fill="none"
                                                                                stroke="currentColor"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-edit w-4 h-4">
                                                                                <path
                                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                                <path
                                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                            </svg>
                                                                        </button>
                                                                        <button v-show="user.role.category.delete"
                                                                                @click.prevent="deleteCaregory(dSubCat.id)"
                                                                                class="btn btn-sm btn-outline-danger m-1">
                                                                            <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24"
                                                                                height="24"
                                                                                viewBox="0 0 24 24"
                                                                                fill="none"
                                                                                stroke="currentColor"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-trash w-4 h-4">
                                                                                <polyline
                                                                                    points="3 6 5 6 21 6"></polyline>
                                                                                <path
                                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    <ul v-for="eSubCat in subCategories"
                                                                        :key="eSubCat.id"
                                                                        class="ul">
                                                                        <li v-if="eSubCat.parentId==dSubCat.id"
                                                                            class="list">
                                                                            {{
                                                                                eSubCat.titleFa + " (" + eSubCat.titleEn + ") "
                                                                            }}
                                                                            <div>
                                                                                <button v-show="user.role.category.edit"
                                                                                        @click.prevent="editCategory(eSubCat.id)"
                                                                                        class="btn btn-sm btn-outline-dark m-1">
                                                                                    <svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24"
                                                                                        height="24"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="1.5"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="feather feather-edit w-4 h-4">
                                                                                        <path
                                                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                                        <path
                                                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                                    </svg>
                                                                                </button>
                                                                                <button
                                                                                    v-show="user.role.category.delete"
                                                                                    @click.prevent="deleteCaregory(eSubCat.id)"
                                                                                    class="btn btn-sm btn-outline-danger m-1">
                                                                                    <svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24"
                                                                                        height="24"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="1.5"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="feather feather-trash w-4 h-4">
                                                                                        <polyline
                                                                                            points="3 6 5 6 21 6"></polyline>
                                                                                        <path
                                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                            <ul v-for="fSubCat in subCategories"
                                                                                :key="fSubCat.id" class="ul">
                                                                                <li v-if="fSubCat.parentId==eSubCat.id"
                                                                                    class="list">{{
                                                                                        fSubCat.titleFa + " (" + fSubCat.titleEn + ") "
                                                                                    }}
                                                                                    <div>
                                                                                        <button
                                                                                            v-show="user.role.category.edit"
                                                                                            @click.prevent="editCategory(fSubCat.id)"
                                                                                            class="btn btn-sm btn-outline-dark m-1">
                                                                                            <svg
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                width="24"
                                                                                                height="24"
                                                                                                viewBox="0 0 24 24"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="1.5"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                class="feather feather-edit w-4 h-4">
                                                                                                <path
                                                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                                                <path
                                                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                                            </svg>
                                                                                        </button>
                                                                                        <button
                                                                                            v-show="user.role.category.delete"
                                                                                            @click.prevent="deleteCaregory(fSubCat.id)"
                                                                                            class="btn btn-sm btn-outline-danger m-1">
                                                                                            <svg
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                width="24"
                                                                                                height="24"
                                                                                                viewBox="0 0 24 24"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="1.5"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                class="feather feather-trash w-4 h-4">
                                                                                                <polyline
                                                                                                    points="3 6 5 6 21 6"></polyline>
                                                                                                <path
                                                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                    <ul v-for="gSubCat in subCategories"
                                                                                        :key="gSubCat.id"
                                                                                        class="ul">
                                                                                        <li v-if="gSubCat.parentId==fSubCat.id"
                                                                                            class="list">{{
                                                                                                gSubCat.titleFa + " (" + gSubCat.titleEn + ") "
                                                                                            }}
                                                                                            <div>
                                                                                                <button
                                                                                                    v-show="user.role.category.edit"
                                                                                                    @click.prevent="editCategory(gSubCat.id)"
                                                                                                    class="btn btn-sm btn-outline-dark m-1">
                                                                                                    <svg
                                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                                        width="24"
                                                                                                        height="24"
                                                                                                        viewBox="0 0 24 24"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        stroke-width="1.5"
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        class="feather feather-edit w-4 h-4">
                                                                                                        <path
                                                                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                                                        <path
                                                                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                                                    </svg>
                                                                                                </button>
                                                                                                <button
                                                                                                    v-show="user.role.category.delete"
                                                                                                    @click.prevent="deleteCaregory(gSubCat.id)"
                                                                                                    class="btn btn-sm btn-outline-danger m-1">
                                                                                                    <svg
                                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                                        width="24"
                                                                                                        height="24"
                                                                                                        viewBox="0 0 24 24"
                                                                                                        fill="none"
                                                                                                        stroke="currentColor"
                                                                                                        stroke-width="1.5"
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        class="feather feather-trash w-4 h-4">
                                                                                                        <polyline
                                                                                                            points="3 6 5 6 21 6"></polyline>
                                                                                                        <path
                                                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                                    </svg>
                                                                                                </button>
                                                                                            </div>
                                                                                            <ul v-for="hSubCat in subCategories"
                                                                                                :key="hSubCat.id"
                                                                                                class="ul">
                                                                                                <li v-if="hSubCat.parentId==gSubCat.id"
                                                                                                    class="list">
                                                                                                    {{
                                                                                                        hSubCat.titleFa + " (" + hSubCat.titleEn + ") "
                                                                                                    }}
                                                                                                    <div>
                                                                                                        <button
                                                                                                            v-show="user.role.category.edit"
                                                                                                            @click.prevent="editCategory(hSubCat.id)"
                                                                                                            class="btn btn-sm btn-outline-dark m-1">
                                                                                                            <svg
                                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                                width="24"
                                                                                                                height="24"
                                                                                                                viewBox="0 0 24 24"
                                                                                                                fill="none"
                                                                                                                stroke="currentColor"
                                                                                                                stroke-width="1.5"
                                                                                                                stroke-linecap="round"
                                                                                                                stroke-linejoin="round"
                                                                                                                class="feather feather-edit w-4 h-4">
                                                                                                                <path
                                                                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                                                                <path
                                                                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                                                            </svg>
                                                                                                        </button>
                                                                                                        <button
                                                                                                            v-show="user.role.category.delete"
                                                                                                            @click.prevent="deleteCaregory(hSubCat.id)"
                                                                                                            class="btn btn-sm btn-outline-danger m-1">
                                                                                                            <svg
                                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                                width="24"
                                                                                                                height="24"
                                                                                                                viewBox="0 0 24 24"
                                                                                                                fill="none"
                                                                                                                stroke="currentColor"
                                                                                                                stroke-width="1.5"
                                                                                                                stroke-linecap="round"
                                                                                                                stroke-linejoin="round"
                                                                                                                class="feather feather-trash w-4 h-4">
                                                                                                                <polyline
                                                                                                                    points="3 6 5 6 21 6"></polyline>
                                                                                                                <path
                                                                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                                            </svg>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>

                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>

                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import headerAdmin from './../layout/header-admin.vue'
import axios from "axios";

export default {
    props: {
        user: Object
    },
    components: {
        "header-admin": headerAdmin,
    },
    data() {
        return {
            error: false,
            addBtn: true,
            showLoad: false,
            category: {
                id: '',
                parentId: null,
                slug: '',
                titleFa: '',
                titleEn: '',
                descriptionFa: '',
                descriptionEn: '',
            },
            categories: [],
            subCategories: [],
        }
    },
    methods: {
        deleteCaregory(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/category/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data.status == 200) {
                        this.getAll();
                        this.$emit('loadingHide');
                    }
                }).catch((error) => {
                    this.$emit('loadingHide');
                });
            }
        },
        getAll() {
            this.categories = [];
            this.subCategories = [];
            axios.get('/category',
                {
                    params: {
                        api_token: this.$cookies.get('user').token
                    }
                }).then(response => {
                for (const res of response.data.cat) {
                    this.categories.push({
                        id: res.id,
                        slug: res.slug,
                        titleFa: res.titleFa,
                        titleEn: res.titleEn,
                        descriptionFa: res.descriptionFa,
                        descriptionEn: res.descriptionEn,
                        child: []
                    });
                }
                for (const res of response.data.subCat) {
                    this.subCategories.push({
                        id: res.id,
                        parentId: res.parentId,
                        slug: res.slug,
                        titleFa: res.titleFa,
                        titleEn: res.titleEn,
                        descriptionFa: res.descriptionFa,
                        descriptionEn: res.descriptionEn,
                        child: []
                    });
                }
            }).catch((error) => {
            });
        },
        reset() {
            this.error = false
            this.addBtn = true;
            this.category.id = '';
            this.category.parentId = null;
            this.category.slug = '';
            this.category.titleFa = '';
            this.category.titleEn = '';
            this.category.descriptionFa = '';
            this.category.descriptionEn = '';
        },
        editCategory(id) {
            this.$emit('loading');
            axios.get('/category/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                this.addBtn = false;
                this.category.id = response.data.id;
                this.category.parentId = response.data.parent;
                this.category.slug = response.data.slug;
                this.category.titleFa = response.data.titleFa;
                this.category.titleEn = response.data.titleEn;
                this.category.descriptionFa = response.data.descriptionFa;
                this.category.descriptionEn = response.data.descriptionEn;
                this.$emit('loadingHide');
            }).catch((error) => {
                this.$emit('loadingHide');
            });
        }, addCategory() {
            if (this.category.titleFa != '' && this.category.titleEn != '' && this.category.slug != '') {
                this.showLoad = true;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    title_fa: this.category.titleFa,
                    title_en: this.category.titleEn,
                    parent_id: this.category.parentId,
                    slug: this.category.slug,
                    description_fa: this.category.descriptionFa,
                    description_en: this.category.descriptionEn
                };
                axios.post("/category/create", sentData).then((response) => {
                    if (response.data == 'success') {
                        this.reset()
                        this.getAll();
                        this.showLoad = false;
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                    this.showLoad = false;
                });
            } else {
                this.error = true;
            }
        },
        updateCategory() {
            if (this.category.titleFa != '' && this.category.titleEn != '' && this.category.slug != '') {
                this.showLoad = true;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    title_fa: this.category.titleFa,
                    title_en: this.category.titleEn,
                    parent_id: this.category.parentId,
                    slug: this.category.slug,
                    description_fa: this.category.descriptionFa,
                    description_en: this.category.descriptionEn
                };
                axios.put("/category/update/" + this.category.id, sentData).then((response) => {
                    if (response.status == 200) {
                        this.reset()
                        this.getAll();
                        this.showLoad = false;
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                    this.showLoad = false;
                });
            } else {
                this.error = true;
            }
        }
    },
    created() {
        axios.get('/category',
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            for (const res of response.data.cat) {
                this.categories.push({
                    id: res.id,
                    slug: res.slug,
                    titleFa: res.titleFa,
                    titleEn: res.titleEn,
                    descriptionFa: res.descriptionFa,
                    descriptionEn: res.descriptionEn,
                    child: []
                });
            }
            for (const res of response.data.subCat) {
                this.subCategories.push({
                    id: res.id,
                    parentId: res.parentId,
                    slug: res.slug,
                    titleFa: res.titleFa,
                    titleEn: res.titleEn,
                    descriptionFa: res.descriptionFa,
                    descriptionEn: res.descriptionEn,
                    child: []
                });
            }
            this.$emit('loadingHide');
        }).catch((error) => {
            this.$emit('loadingHide');
        });
    },
    name: 'App',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('categories') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
