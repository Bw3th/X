<template>
  <div class="heightScroll">
    <h4 class="text-center">{{tip}}</h4>
    <video-player
      class="video-player vjs-custom-skin"
      ref="videoPlayer"
      :playsinline="playsinline"
      :options="playerOptions"
      @canplay="onPlayerCanplay($event)"
    ></video-player>
    <h6 class="text-center">向下滑动</h6>
    <!-- 滚动 -->
    <scroll-top></scroll-top>
  </div>
</template>

<script>
import $ from "jquery";
import scrollTop from "../common/backTop";
export default {
  name: "home",
  data() {
    return {
      tip: "滑动组件，视屏播放",
      playerOptions: {
        playbackRates: [0.5, 1.0, 1.5, 2.0], //可选择的播放速度
        autoplay: false, //如果true,浏览器准备好时开始回放。
        muted: false, // 默认情况下将会消除任何音频。
        loop: false, // 视频一结束就重新开始。
        preload: "auto", // 建议浏览器在<video>加载元素后是否应该开始下载视频数据。auto浏览器选择最佳行为,立即开始加载视频（如果浏览器支持）
        language: "zh-CN",
        aspectRatio: "15:7", // 将播放器置于流畅模式，并在计算播放器的动态大小时使用该值。值应该代表一个比例 - 用冒号分隔的两个数字（例如"16:9"或"4:3"）
        fluid: true, // 当true时，Video.js player将拥有流体大小。换句话说，它将按比例缩放以适应其容器。
        sources: [
          {
            type: "",
            src: "https://video.xoncology.com/mdt/20190910.mp4" //url地址
          }
        ],
        poster: "", //你的封面地址
        // width: document.documentElement.clientWidth,
        notSupportedMessage: "此视频暂无法播放，请稍后再试", //允许覆盖Video.js无法播放媒体源时显示的默认信息。
        controlBar: {
          timeDivider: true, //当前时间和持续时间的分隔符
          durationDisplay: true, //显示持续时间
          remainingTimeDisplay: false, //是否显示剩余时间功能
          fullscreenToggle: true //全屏按钮
        }
      }
    };
  },
  components: {
    "scroll-top": scrollTop
  },
  computed: {
    player() {
      return this.$refs.videoPlayer.player; //自定义播放
    },
    playsinline() {
      var ua = navigator.userAgent.toLocaleLowerCase();
      //x5内核
      if (ua.match(/tencenttraveler/) != null || ua.match(/qqbrowse/) != null) {
        return false;
      } else {
        //ios端
        return true;
      }
    }
  },
  methods: {
    onPlayerCanplay(player) {
      // console.log('player Canplay!', player)
      //解决自动全屏
      var ua = navigator.userAgent.toLocaleLowerCase();
      //x5内核
      if (ua.match(/tencenttraveler/) != null || ua.match(/qqbrowse/) != null) {
        $("body")
          .find("video")
          .attr("x-webkit-airplay", true)
          .attr("x5-playsinline", true)
          .attr("webkit-playsinline", true)
          .attr("playsinline", true);
      } else {
        //ios端
        $("body")
          .find("video")
          .attr("webkit-playsinline", "true")
          .attr("playsinline", "true");
      }
    }
  },
  created() {
    this.$emit("header", true);
    this.$emit("footer", false);
    this.$emit("headTops", true);
  }
};
</script>

<style scoped>
.text-center {
  text-align: center;
}
.heightScroll {
  height: 1000px;
}
</style>
