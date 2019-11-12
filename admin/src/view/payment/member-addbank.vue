<template>
  <div>
    <Form :label-width="80" :rules="formRule" :model="form">
      <FormItem label="银行卡号" prop="bank_num">
        <i-input v-model="form.bank_n"></i-input>
      </FormItem>
      <FormItem label="开户行" prop="opening_bank">
        <i-input v-model="form.opening_b"></i-input>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="saves()">保存</Button>
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
    saves() {
      let method = "POST";
      let url = "api/cost/bank";
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