import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/product",
        name: "product",
        //meta: { requiresAuth: true }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return savedPosition || { left: 0, top: 0 };
    },
});

router.beforeEach(async (to, from, next) => {

})


export default router;