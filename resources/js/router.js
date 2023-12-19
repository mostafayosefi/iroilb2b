import {createWebHistory, createRouter} from 'vue-router';
// admin template
const AdminDashboard = () => import('./components/admin/index.vue')
const AdminPosts = () => import('./components/admin/blog-posts.vue')
const AdminNewPosts = () => import('./components/admin/blog-new-post.vue')
const AdminEditPosts = () => import('./components/admin/blog-edit-post.vue')
const AdminCategories = () => import('./components/admin/blog-categories.vue')
const AdminLabels = () => import('./components/admin/blog-labels.vue')
const AdminPages = () => import('./components/admin/pages.vue')
const AdminNewPages = () => import('./components/admin/page-new.vue')
const AdminEditPages = () => import('./components/admin/page-edit.vue')
const AdminFaqPages = () => import('./components/admin/page-faq.vue')
const AdminHomePages = () => import('./components/admin/page-home.vue')
const AdminB2bPlus = () => import('./components/admin/page-b2b-plus.vue')
const AdminContact = () => import('./components/admin/page-contact.vue')
const AdminProducts = () => import('./components/admin/products.vue')
const AdminCompanyFilter = () => import('./components/admin/filters.vue')
const AdminOperators = () => import('./components/admin/operators.vue')
const AdminTables = () => import('./components/admin/tables.vue')
const AdminTablesMaker = () => import('./components/admin/tables-maker.vue')
const AdminTablesEdit = () => import('./components/admin/tables-edit.vue')
const AdminTablesPdf = () => import('./components/admin/tables-pdf.vue')
const AdminForms = () => import('./components/admin/forms.vue')
const AdminSetting = () => import('./components/admin/setting.vue')
const AdminSettingHeader = () => import('./components/admin/setting-header.vue')
const AdminSettingSideBar = () => import('./components/admin/setting-side-bar.vue')
const AdminSettingFooter = () => import('./components/admin/setting-footer.vue')
const AdminUsers = () => import('./components/admin/users.vue')
const AdminRedirect = () => import('./components/admin/redirect.vue')
const AdminUsersMessageView = () => import('./components/admin/users-message.vue')
const AdminCompanies = () => import('./components/admin/companies.vue')
const AdminCompaniesEdit = () => import('./components/admin/companies-edit.vue')
const AdminAdvertisements = () => import('./components/admin/advertisements.vue')
const AdminSupport = () => import('./components/admin/support.vue')
const PageNotFound = () => import('./components/admin/not-found.vue')

// user template
const SiteHome = () => import('./components/site/component/home-page.vue')
const SiteAccount = () => import('./components/site/component/the-sign-in.vue')
const SiteSignUp = () => import('./components/site/component/the-sign-up.vue')
const SiteForgot = () => import('./components/site/component/forgot-password.vue')
const SitePage = () => import('./components/site/component/single-page.vue')
const SitePanel = () => import('./components/site/component/the-panel.vue')
const SiteProfile = () =>import('./components/site/component/the-panel-profile.vue')
const SiteFeedBack = () =>import('./components/site/component/the-feedback.vue')
const SitePanelAds = () =>import('./components/site/component/the-panel-ads.vue')
const SitePanelBookmark = () =>import('./components/site/component/the-panel-bookmark.vue')
const SiteSupport = () =>import('./components/site/component/the-support.vue')
const SitePanelCompany = () =>import('./components/site/component/the-panel-company.vue')
const SiteLivePrice = () =>import('./components/site/component/live-price.vue')
const SiteSearch = () =>import('./components/site/component/the-search.vue')
const SiteFilter = () =>import('./components/site/component/the-filter.vue')
const SiteAds = () =>import('./components/site/component/the-advertisements.vue')
const SiteB2bPlus = () => import('./components/site/component/b2b-plus.vue')
const SiteB2bPagePlus = () => import('./components/site/component/b2b-plus-page.vue')
const SiteContact = () => import('./components/site/component/contact-us.vue')
const SiteBlog = () => import('./components/site/component/the-blog.vue')
const SiteCompany = () => import('./components/site/component/the-company.vue')
const SitePanelCompanyEdit = () => import('./components/site/component/the-panel-company-edit.vue')
const SiteCoSingle = () => import('./components/site/component/single-company.vue')
const SiteAdsSingle = () => import('./components/site/component/single-advertise.vue')
const SiteLabels = () => import('./components/site/component/the-labels.vue')
const SiteCategories = () => import('./components/site/component/the-categories.vue')
const SitePost = () => import('./components/site/component/single-post.vue')
const SiteFaq = () => import('./components/site/component/the-faq.vue')
const SitePageNotFound = () => import('./components/site/component/not-found.vue')
const routes = [
    //admin link
    {
        path: '/fa/admin',
        component: AdminDashboard,
        name: 'indexAdmin',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/posts',
        component: AdminPosts,
        name: 'adminPosts',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/posts/add',
        component: AdminNewPosts,
        name: 'adminNewPosts',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/posts/edit/:id',
        component: AdminEditPosts,
        name: 'adminEditPosts',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/categories',
        component: AdminCategories,
        name: 'adminCategories',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/labels',
        alias: '/labels',
        component: AdminLabels,
        name: 'adminLabels',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/pages',
        component: AdminPages,
        name: 'adminPages',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/pages/add',
        component: AdminNewPages,
        name: 'adminNewPages',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/pages/edit/:id',
        component: AdminEditPages,
        name: 'adminEditPages',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/pages/faq',
        component: AdminFaqPages,
        name: 'adminFaqPages',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/pages/home',
        component: AdminHomePages,
        name: 'adminHomePages',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/pages/b2bplus',
        component: AdminB2bPlus,
        name: 'adminB2bPlus',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/pages/contact',
        component: AdminContact,
        name: 'adminContact',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/products',
        component: AdminProducts,
        name: 'adminProducts',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/filter',
        component: AdminCompanyFilter,
        name: 'adminCompanyFilter',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/operators',
        component: AdminOperators,
        name: 'adminOperators',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/tables',
        component: AdminTables,
        name: 'adminTables',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/tables/creator',
        component: AdminTablesMaker,
        name: 'adminTablesMaker',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/tables/edit/:id',
        component: AdminTablesEdit,
        name: 'adminTablesEdit',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/tables/pdf/:id',
        component: AdminTablesPdf,
        name: 'adminTablesPdf',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/forms',
        component: AdminForms,
        name: 'adminForms',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/setting',
        component: AdminSetting,
        name: 'adminSetting',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/setting/header',
        component: AdminSettingHeader,
        name: 'adminSettingHeader',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/setting/side-bar',
        component: AdminSettingSideBar,
        name: 'adminSettingSideBar',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/setting/footer',
        component: AdminSettingFooter,
        name: 'adminSettingFooter',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/users',
        component: AdminUsers,
        name: 'adminUsers',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/users/message',
        component: AdminUsersMessageView,
        name: 'adminUsersMessageView',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/companies',
        component: AdminCompanies,
        name: 'adminCompanies',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/companies/:co',
        component: AdminCompaniesEdit,
        name: 'adminCompaniesEdit',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/advertisements',
        component: AdminAdvertisements,
        name: 'adminAdvertisements',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/support',
        component: AdminSupport,
        name: 'adminSupport',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/redirect',
        component: AdminRedirect,
        name: 'adminRedirect',
        meta: {requireAuth: true}
    },
    {
        path: '/fa/admin/404',
        component: PageNotFound,
        name: 'not-found',
    },
    {
        path: "/fa/admin/:pathMatch(.*)*", redirect: to => {
            return {name: 'not-found'}
        },
    },

    // user link
    {
        path: '/:lang',
        component: SiteHome,
        name: 'siteHome'
    },
    {
        path: '/:lang/page/:page',
        component: SitePage,
        name: 'sitePage'
    },
    {
        path: '/:lang/account',
        component: SiteAccount,
        name: 'siteAccount'
    },
    {
        path: "/:lang/account",
        component: SiteSignUp,
        name: 'siteSignup',
        alias: '/:lang/signup'
    },
    {
        path: "/:lang/account",
        component: SiteForgot,
        name: 'siteForgot',
        alias: '/:lang/forgot'
    },
    {
        path: "/:lang/panel",
        component: SitePanel,
        name: 'sitePanel',
        meta: {requireAuth: true}
    },
    {
        path: "/:lang/panel/profile",
        component: SiteProfile,
        name: 'siteProfile',
        meta: {requireAuth: true}
    },
    {
        path: "/:lang/panel/feedback",
        component: SiteFeedBack,
        name: 'siteFeedBack',
        meta: {requireAuth: true}
    },
    {
        path: "/:lang/panel/ads",
        component: SitePanelAds,
        name: 'sitePanelAds',
        meta: {requireAuth: true}
    },
    {
        path: "/:lang/panel/bookmark",
        component: SitePanelBookmark,
        name: 'sitePanelBookmark',
        meta: {requireAuth: true}
    },
    {
        path: "/:lang/support",
        component: SiteSupport,
        name: 'siteSupport',
    },
    {
        path: "/:lang/company",
        component: SiteCompany,
        name: 'siteCompany',
    },
    {
        path: '/:lang/co/:slug',
        component: SiteCoSingle,
        name: 'siteCoSingle'
    },
    {
        path: '/:lang/ads/:slug',
        component: SiteAdsSingle,
        name: 'siteAdsSingle'
    },
    {
        path: "/:lang/filter",
        component: SiteSearch,
        name: 'siteSearch',
    },
    {
        path: "/:lang/filter/:slug",
        component: SiteFilter,
        name: 'siteFilter',
    },
    {
        path: "/:lang/ads",
        component: SiteAds,
        name: 'siteAds',
    },
    {
        path: "/:lang/panel/company",
        component: SitePanelCompany,
        name: 'sitePanelCompany',
        meta: {requireAuth: true}
    },
    {
        path: "/:lang/panel/company/:id",
        component: SitePanelCompanyEdit,
        name: 'sitePanelCompanyEdit',
        meta: {requireAuth: true}
    },
    {
        path: "/:lang/global-prices",
        component: SiteLivePrice,
        name: 'siteLivePrice',
    },
    {
        path: "/:lang/b2bplus",
        component: SiteB2bPlus,
        name: 'siteB2bPlus',
    },
    {
        path: "/:lang/b2bplus/:page",
        component: SiteB2bPagePlus,
        name: 'siteB2bPagePlus',
    },
    {
        path: "/:lang/b2bplus/contact",
        component: SiteContact,
        name: 'siteContact',
    },
    {
        path: "/:lang/b2bplus/faq",
        component: SiteFaq,
        name: 'siteFaq',
    },
    {
        path: '/:lang/blog',
        component: SiteBlog,
        name: 'siteBlog',
    },
    {
        path: '/:lang/blog/:cat',
        component: SiteCategories,
        name: 'siteCategories',
    },
    {
        path: '/:lang/tag/:tag',
        component: SiteLabels,
        name: 'siteLabels',
    },
    {
        path: '/:lang/post/:post',
        component: SitePost,
        name: 'sitePost',
    },
    {
        path: '/:lang/404',
        component: SitePageNotFound,
        name: 'siteNotFound',
    },
    {
        path: "/:lang/:pathMatch(.*)*", redirect: to => {
            return {path: `/${to.params.lang}/404`}
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'n-active',
    scrollBehavior(to, from, savedPosition) {
        // always scroll to top
        return {top: 0}
    },
});
import axios from "axios";
import {useCookies} from "vue3-cookies";

const {cookies} = useCookies();
router.beforeEach(function (to, from, next) {
    if (to.meta.requireAuth) {
        if (cookies.isKey('user')) {
            const sentData = {
                id:  parseInt(cookies.get('user').id),
                api_token: cookies.get('user').token
            };
            axios.post("login/check", sentData)
                .then((res) => {
                    if (res.status == 200) {
                        next()
                    } else {
                        cookies.remove('user');
                        if (to.params.lang) {
                            next({name: 'siteAccount', params: {lang: to.params.lang}})
                        } else {
                            next({name: 'siteAccount', params: {lang: 'en'}})
                        }
                    }
                })
        } else {
            if (to.params.lang) {
                next({name: 'siteAccount', params: {lang: to.params.lang}})
            } else {
                next({name: 'siteAccount', params: {lang: 'en'}})
            }
        }
    } else {
        next()
    }
})

export default router;
