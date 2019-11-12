<template>
  <div>
    <Form :label-width="90" :rules="formRule" :model="form">
      <FormItem label="金额" prop="cost">
        <i-input v-model="form.cost" ></i-input>
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
        remarks: [{ required: true, message: "备注", trigger: "blur" }],
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
      let url = "api/cost/charges";
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