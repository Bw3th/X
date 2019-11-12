import Vue from 'vue';
import Router from 'vue-router';
import instance from './api.request.js';
import VueAxios from 'vue-axios';
Vue.use(Router);
Vue.use(VueAxios, instance);
const routes = [
  {
    path: '*',
    redirect: '/home'
  },
  {
    name: 'home',
    component: () => import('./view/index'),
    meta: {
      title: '首页'
    }
  },
  {
    path: "/children/:id",
    name: 'children',
    component: () => import('./view/index/children'),
    meta: {
      title: '分页面'
    }
  },
  {
    name: 'clearCookie',
    component: () => import('./view/common/clearCookie'),
    meta: {
      title: '清除Cookies'
    }
  }
];

// add route path
routes.forEach(route => {
  route.path = route.path || '/' + (route.name || '');
});

const router = new Router({ routes });

router.beforeEach((to, from, next) => {
  const title = to.meta && to.meta.title;
  if (title) {
    document.title = title;
  }
  next();
});

export {
  router
};
