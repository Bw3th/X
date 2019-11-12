import Vue from 'vue';
import App from './App';
import { router } from './router';
import filters from './filters';
import '../static/icon/iconfont.css';
import '../static/icon/iconfont.js';
import { Tabbar, TabbarItem } from 'vant';
import VideoPlayer from 'vue-video-player'
import 'videojs-contrib-hls';
require('video.js/dist/video-js.css');
require('vue-video-player/src/custom-theme.css');
Vue.use(Tabbar).use(TabbarItem);
Vue.use(VideoPlayer);
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

new Vue({
  router,
  el: '#app',
  render: h => h(App)
});
