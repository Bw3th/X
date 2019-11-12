<template>
  <div class="scrollTop" :class="{'scrollTopright':showTop}" @click="toTop">
    <!-- <img src="../../../static/img/top.png" /> -->
    <i class="iconfont icontop"></i>
  </div>
</template>
<script>
export default {
  name: "scroll-top",
  data() {
    return {
      scrollTop: 0,
      time: 0,
      dParams: 20,
      scrollState: 0
    };
  },
  computed: {
    showTop: function() {
      let value = this.scrollTop > 200 ? true : false;
      return value;
    }
  },
  mounted() {
    window.addEventListener("scroll", this.getScrollTop);
  },
  methods: {
    toTop(e) {
      if (!!this.scrollState) {
        return;
      }
      this.scrollState = 1;
      e.preventDefault();
      let distance =
        document.documentElement.scrollTop || document.body.scrollTop;
      let _this = this;
      this.time = setInterval(function() {
        _this.gotoTop(_this.scrollTop - _this.dParams);
      }, 10);
    },
    gotoTop(distance) {
      this.dParams += 20;
      distance = distance > 0 ? distance : 0;
      document.documentElement.scrollTop = document.body.scrollTop = window.pageYOffset = distance;
      if (this.scrollTop < 10) {
        clearInterval(this.time);
        this.dParams = 20;
        this.scrollState = 0;
      }
    },
    getScrollTop() {
      this.scrollTop =
        window.pageYOffset ||
        document.documentElement.scrollTop ||
        document.body.scrollTop;
    }
  }
};
</script>
<style scoped>
.scrollTop {
  position: fixed;
  right: -32px;
  bottom: 30px;
  cursor: pointer;
  border: 1px solid #ff8c9d;
  width: 30px;
  height: 30px;
  text-align: center;
  line-height: 30px;
  border-radius: 50%;
  -o-transition: right 0.5s ease-in-out;
  -webkit-transition: right 0.5s ease-in-out;
  -moz-transition: right 0.5s ease-in-out;
  -ms-transition: right 0.5s ease-in-out;
  transition: right 0.5s ease-in-out;
  z-index: 99;
}
.scrollTop i{
    color: #ff8c9d;
    font-size: 20px;
}
.scrollTopright{
    right: 10px;
}
</style>