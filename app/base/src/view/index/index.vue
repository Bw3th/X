<template>
  <div class="text-center">
    <h4 class="text-center">{{tip}}</h4>
    <router-link :to="{name:'children',params:{id:1}}" tag="button">Click me to children</router-link>
  </div>
</template>

<script>
export default {
  name: "home",
  data() {
    return {
      tip: "Hollow Word"
    };
  },
  methods: {
    getDemo() {
      let that = this;
      this.axios
        .request({
          url: ""
        })
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          // catch 指请求出错的处理
          console.log(error);
        });
      //
    }
  },
  created() {
    // 头部菜单
    this.$emit("header", true);
    // 尾部菜单
    this.$emit("footer", true);
    // 头部菜单存在时，顶部空开距离，防止内容重叠
    this.$emit("headTops", true);
    // init
  }
};
</script>

<style scoped>
.text-center {
  text-align: center;
}
button {
  background: #4a90e2;
  padding: 5px 15px;
  border: 0;
  border-radius: 5px;
  color: #fff;
}
</style>
