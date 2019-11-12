<template>
  <div>
    <Form :label-width="90" :rules="formRule" :model="form">
      <FormItem label="当前状态">
        <RadioGroup v-model="form.status">
          <Radio :label="0">默认状态</Radio>
          <Radio :label="4">已提交支付</Radio>
          <Radio :label="1">已支付</Radio>
          <Radio :label="2">退回</Radio>
          <Radio :label="3">已更新</Radio>
        </RadioGroup>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="save()">保存</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
/* eslint-disable */
import axios from "@/libs/api.request";
export default {
  tag: "",
  components: {
  },
  props: {
    value: {
      type: Object,
      default: () => {
        return {};
      }
    }
  },
  data() {
    return {
      form: {  },
      formRule: {
      }
    };
  },
  watch: {
    value(data) {
      this.form = Object.assign({}, data);
    }
    
  },
  mounted() {
    if (this.value) {
      this.form = Object.assign({}, this.value);
    }
  },
  methods: {
    save() {
      let method = "POST";
      let url = "api/cost/status";
      if (this.form.id) {
        method = "PUT";
        url += "/" + this.form.id;
      }
      axios
        .request({
          url: url,
          method: method,
          data: this.form
        })
        .then(res => {
          if (res.data.successful) {
            this.$emit("saved");
          } else {
            this.$Notice.warning({
              title: "提示",
              desc: res.data.error_msg
            });
          }
        });
    }
  }
};
</script>
<style scoped>
.info{
    color: #fff;
}

</style>