<template>
  <div class="footer-inner">
    <!-- <ul class="stand_flex">
      <li class="stand_flex">
        <img src="../../../static/img/foot1.png" alt />
        <span>诊疗</span>
      </li>
      <li class="stand_flex">
        <img src="../../../static/img/foot2.png" alt />
        <span>科室服务</span>
      </li>
      <li class="stand_flex">
        <img src="../../../static/img/foot4.png" alt />
        <span>知识讲堂</span>
      </li>
      <li class="stand_flex">
        <img src="../../../static/img/foot3.png" alt />
        <span>我的</span>
      </li>
    </ul>-->
    <van-tabbar
      v-model="active"
      inactive-color="#AFAFAF"
      active-color="#FF6079"
      route
      safe-area-inset-bottom
    >
      <van-tabbar-item name="home" to="/home" replace>
        <span>健康档案</span>
        <img slot="icon" slot-scope="props" :src="props.active ? icon1.active : icon1.normal" />
      </van-tabbar-item>
      <van-tabbar-item name="search" to="/z" replace>
        <span>诊疗服务</span>
        <img slot="icon" slot-scope="props" :src="props.active ? icon2.active : icon2.normal" />
      </van-tabbar-item>
      <!-- <van-tabbar-item name="/friends" replace>
        <span>知识讲堂</span>
        <img slot="icon" slot-scope="props" :src="props.active ? icon3.active : icon3.normal" />
      </van-tabbar-item>-->
      <van-tabbar-item name="patient" replace to="/patientList">
        <span>患者管理</span>
        <img slot="icon" slot-scope="props" :src="props.active ? icon5.active : icon5.normal" />
      </van-tabbar-item>
      <van-tabbar-item name="setting" replace to="/personalCenter">
        <span>个人中心</span>
        <img slot="icon" slot-scope="props" :src="props.active ? icon4.active : icon4.normal" />
        <!-- <div slot="icon">
          <i class="iconfont iconshoushudingdan"></i>
        </div>-->
      </van-tabbar-item>
    </van-tabbar>
  </div>
</template>
<script>
export default {
  name: "Footer",
  props: ["typedmsg"],
  data() {
    return {
      active: "home",
      icon1: {
        normal: require("../../../static/img/foot1_1.png"),
        active: require("../../../static/img/foot1.png")
      },
      icon2: {
        normal: require("../../../static/img/foot2_2.png"),
        active: require("../../../static/img/foot2.png")
      },
      icon3: {
        normal: require("../../../static/img/foot3_3.png"),
        active: require("../../../static/img/foot3.png")
      },
      icon4: {
        normal: require("../../../static/img/foot4_4.png"),
        active: require("../../../static/img/foot4.png")
      },
      icon5: {
        normal: require("../../../static/img/foot5_5.png"),
        active: require("../../../static/img/foot5.png")
      }
    };
  }
};
</script>
<style scoped>
.footer-inner {
  background: #fff;
  padding: 5px 0 2px 0;
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 99;
  box-shadow: inset 0 1px 0 0 rgba(238, 238, 238, 0.5);
}
.footer-inner ul li {
  flex-direction: column;
  width: 25%;
  flex-shrink: 0;
}
.footer-inner ul li img {
  width: 20px;
  display: block;
  margin-bottom: 3px;
}
.footer-inner ul li span {
  font-size: 12px;
  color: #afafaf;
  letter-spacing: 0.52px;
  text-align: justify;
}
</style>
