<template>
  <Submenu :class="parentItem.meta.role" :name="`${parentName}`">
    <template  slot="title">
      <common-icon :type="parentItem.icon || ''"/>
      <span>{{ showTitle(parentItem) }}</span>
    </template>
    <template v-for="item in children">
      <template v-if="item.children && item.children.length === 1">
        <side-menu-item v-if="showChildren(item)" :key="`menu-${item.name}`" :parent-item="item"></side-menu-item>
        <menu-item v-else :name="getNameOrHref(item, true)" :key="`menu-${item.children[0].name}`"><common-icon :type="item.children[0].icon || ''"/><span>{{ showTitle(item.children[0]) }}</span></menu-item>
      </template>
      <template v-else>
        <side-menu-item  class="123" v-if="showChildren(item)" :key="`menu-${item.name}`" :parent-item="item"></side-menu-item>
        <menu-item  v-else :name="getNameOrHref(item)" :key="`menu-${item.name}`" :class="item.meta.role"><common-icon :type="item.icon || ''"/><span>{{ showTitle(item) }}</span></menu-item>
      </template>
    </template>
  </Submenu>
</template>
<script>
import mixin from './mixin'
import itemMixin from './item-mixin'
import axios from "@/libs/api.request";
export default {
  name: 'SideMenuItem',
  mixins: [ mixin, itemMixin ],
  data() {
    return {
      flag:false,
      roles:'',
    };
  },
  methods: {
    
    meminifo(){
      axios.request({
          method: "get",
          url: "api/cost/memberinfo",
          params: {
            page:this.page
          }
        })
        .then(res => {
          this.roles = res.data.successful;
          let disnone = '.' + this.roles;
          let li = document.querySelectorAll(disnone)
          for (var v = 0; v < li.length; v++) {
              li[v].style.display = 'none'
          }
        });
    }
  },
  mounted(){
    this.meminifo();

  }
}
</script>
<style>

</style>
