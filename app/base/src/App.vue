<template>
  <div id="app" :class="headerTop?'addpd_top':''">
    <app-header v-if="headerShow"></app-header>
    <router-view v-on:header="header" v-on:footer="footer" v-on:headTops="headTops" />
    <app-footer v-if="footerShow"></app-footer>
  </div>
</template>
<script>
import Header from "./view/common/header.vue";
import Footer from "./view/common/footer.vue";
import Cookies from "js-cookie";
export default {
  name: "App",
  data() {
    return {
      headerShow: true,
      footerShow: true,
      headerTop: true
    };
  },
  components: {
    "app-header": Header,
    "app-footer": Footer
  },
  methods: {
    header: function(bool) {
      // console.log(bool);
      this.headerShow = bool;
    },
    footer: function(bool) {
      // console.log(bool);
      this.footerShow = bool;
    },
    headTops: function(bool) {
      this.headerTop = bool;
    }
  }
};
</script>
<style>
body {
  font-size: 16px;
  background-color: #f8f8f8;
  -webkit-font-smoothing: antialiased;
}
#app {
  bottom: 75px;
}
#app.addpd_top {
  padding-top: 46px;
}
</style>
