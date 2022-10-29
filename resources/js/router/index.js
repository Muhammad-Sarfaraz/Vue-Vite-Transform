import { createRouter, createWebHistory } from "vue-router";

/** router define */
const routes = [{
    path: '',
    component: () => import('../views/admin/layout.vue'),
    beforeEnter: checkAuth,
    children: [
        // ------------------MENU PORTION------------------
        { path: '/frontMenu', name: 'frontMenu.index', meta: { title: 'Menu', nav: true }, component: () => import('./../views/admin/website/menu/index') },
        { path: '/frontMenu/create', name: 'frontMenu.create', component: () => import('./../views/admin/website/menu/create') },
        { path: '/frontMenu/:id', name: 'frontMenu.show', component: () => import('./../views/admin/website/menu/view') },
        { path: '/frontMenu/:id/edit', name: 'frontMenu.edit', component: () => import('./../views/admin/website/menu/create') },
        // ------------------CONTENT PORTION------------------
        { path: '/content/:slug', name: 'content.show', component: () => import('./../views/admin/website/content/view') },
        { path: '/content/:slug/create', name: 'content.create', component: () => import('./../views/admin/website/content/create') },
        { path: '/content-file/:slug', name: 'content.file', component: () => import('./../views/admin/website/content/createFile') },
        // ------------------SLIDER PORTION------------------
        { path: '/slider', name: 'slider.index', meta: { title: 'Slider', nav: true }, component: () => import('./../views/admin/website/gallery/slider/index') },
        { path: '/slider/create', name: 'slider.create', component: () => import('./../views/admin/website/gallery/slider/create') },
        { path: '/slider/:id', name: 'slider.show', component: () => import('./../views/admin/website/gallery/slider/view') },
        { path: '/slider/:id/edit', name: 'slider.edit', component: () => import('./../views/admin/website/gallery/slider/create') },
        // ------------------ALBUM PORTION------------------
        { path: '/album', name: 'album.index', meta: { title: 'Album', nav: true }, component: () => import('./../views/admin/website/gallery/album/index') },
        { path: '/album/create', name: 'album.create', component: () => import('./../views/admin/website/gallery/album/create') },
        { path: '/album/:id', name: 'album.show', component: () => import('./../views/admin/website/gallery/album/view') },
        { path: '/album/:id/edit', name: 'album.edit', component: () => import('./../views/admin/website/gallery/album/create') },
        // ------------------PHOTO PORTION------------------
        { path: '/photo', name: 'photo.index', meta: { title: 'Photo', nav: true }, component: () => import('./../views/admin/website/gallery/photo/index') },
        { path: '/photo/create', name: 'photo.create', component: () => import('./../views/admin/website/gallery/photo/create') },
        { path: '/photo/:id', name: 'photo.show', component: () => import('./../views/admin/website/gallery/photo/view') },
        { path: '/photo/:id/edit', name: 'photo.edit', component: () => import('./../views/admin/website/gallery/photo/edit') },
        // ------------------VIDEO PORTION------------------
        { path: '/video', name: 'video.index', meta: { title: 'Video', nav: true }, component: () => import('./../views/admin/website/gallery/video/index') },
        { path: '/video/create', name: 'video.create', component: () => import('./../views/admin/website/gallery/video/create') },
        { path: '/video/:id', name: 'video.show', component: () => import('./../views/admin/website/gallery/video/view') },
        { path: '/video/:id/edit', name: 'video.edit', component: () => import('./../views/admin/website/gallery/video/create') },
        // ------------------News portion------------------
        { path: '/news', name: 'news.index', meta: { title: 'News', nav: true }, component: () => import('./../views/admin/website/news/index') },
        { path: '/news/create', name: 'news.create', component: () => import('./../views/admin/website/news/create') },
        { path: '/news/:id', name: 'news.show', component: () => import('./../views/admin/website/news/view') },
        { path: '/news/:id/edit', name: 'news.edit', component: () => import('./../views/admin/website/news/create') },


        // ------------------ADMIN PORTION------------------
        { path: '/dashboard', name: 'dashboard', component: () => import('./../views/admin/dashboard.vue') },
        { path: '/admin', name: 'admin.index', component: () => import('./../views/admin/admin/index') },
        { path: '/admin/create', name: 'admin.create', component: () => import('./../views/admin/admin/create') },
        { path: '/admin/:id', name: 'admin.show', component: () => import('./../views/admin/admin/view') },
        { path: '/admin/:id/edit', name: 'admin.edit', component: () => import('./../views/admin/admin/create') },
        // ------------------ROLE PORTION------------------
        { path: '/role', name: 'role.index', component: () => import('./../views/admin/system/role/index') },
        { path: '/role/create', name: 'role.create', component: () => import('./../views/admin/system/role/create') },
        { path: '/role/:id', name: 'role.show', component: () => import('./../views/admin/system/role/view') },
        { path: '/role/:id/edit', name: 'role.edit', component: () => import('./../views/admin/system/role/create') },
        // ------------------MENU PORTION------------------
        { path: '/menu', name: 'menu.index', component: () => import('./../views/admin/system/menu/index') },
        { path: '/menu/create', name: 'menu.create', component: () => import('./../views/admin/system/menu/create') },
        { path: '/menu/:id', name: 'menu.show', component: () => import('./../views/admin/system/menu/view') },
        { path: '/menu/:id/edit', name: 'menu.edit', component: () => import('./../views/admin/system/menu/create') },
        // ------------------SITE SETTING PORTION------------------
        { path: '/siteSetting', name: 'siteSetting.index', component: () => import('./../views/admin/system/siteSettings/index') },
        { path: '/siteSetting/create', name: 'siteSetting.create', component: () => import('./../views/admin/system/siteSettings/create') },
        { path: '/siteSetting/:id', name: 'siteSetting.show', component: () => import('./../views/admin/system/siteSettings/view') },
        { path: '/siteSetting/:id/edit', name: 'siteSetting.edit', component: () => import('./../views/admin/system/siteSettings/create') },
        // ------------------MODULE PORTION------------------
        { path: '/module', name: 'module.index', component: () => import('./../views/admin/system/module/index') },
        { path: '/module/create', name: 'module.create', component: () => import('./../views/admin/system/module/create') },
        // ------------------ACTIVITY LOG PORTION------------------
        { path: '/activityLog', name: 'activityLog.index', component: () => import('./../views/admin/system/activityLog/index') },
        { path: '/activityLog/:id', name: 'activityLog.show', component: () => import('./../views/admin/system/activityLog/view') },


                // ------------------TEST PORTION------------------
            { path: '/test', name: 'test.index', component: () => import('./../views/admin/test/index')},
            { path: '/test/create', name: 'test.create', component: () => import('./../views/admin/test/create')},
            { path: '/test/:id', name: 'test.show', component: () => import('./../views/admin/test/view')},
            { path: '/test/:id/edit', name: 'test.edit', component: () => import('./../views/admin/test/create')},

    ],
}]

/** check auth login / not */
function checkAuth(to, from, next) {
    let role = localStorage.getItem('role')
    let user = localStorage.getItem('user')
    if (role && user) {
        next()
    } else {
        window.location.href = "/";
    }
}

/** router initial */
const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_VUE_ROUTER_BASE),
    scrollBehavior() {
        window.scrollTo(0, 0);
    },
    linkExactActiveClass: "active",
    routes
});

export default router;
