<template>
  <div>
    <button @click="clearCookie">清除Cookies</button>
  </div>
</template>
<script>
import Cookies from 'js-cookie';
export default {
  name: "clearCookie",
  data() {
    return {};
  },
  methods: {
    clearCookie() {
      Cookies.remove("token");
    }
  }
};
</script>
<style scoped>
</style>
