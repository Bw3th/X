<template>
  <div>
    <router-link tag="div" to="/home">
      <div class="header-padding">顶部菜单</div>
    </router-link>
  </div>
</template>
<script>
export default {
  name: "Header",
  data() {
    return {};
  }
};
</script>
<style scoped>
.header-padding {
  padding: 13px 0;
  box-shadow: 0 3px 5px #ddd;
  background: #fff;
  position: fixed;
  margin-bottom: 10px;
  top: 0;
  left: 0;
  z-index: 99;
  width: 100%;
  height: 20px;
  text-align: center;
}
</style>
