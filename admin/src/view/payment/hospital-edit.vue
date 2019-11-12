<template>
  <div>
    <Form :label-width="80" :rules="formRule" :model="form">
      <FormItem label="医院名称" prop="hospital_name">
        <i-input v-model="form.hospital_name"></i-input>
      </FormItem>
      <FormItem label="介绍" prop="introduce">
        <i-input v-model="form.introduce"></i-input>
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
        hospital_name: [{ required: true, message: "医院名称", trigger: "blur" }],
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
      let url = "api/cost/hospitals";
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