<template>
  <div>
    <Form :label-width="80" :rules="formRule" :model="form">
      <FormItem label="付款事由" prop="cause_name">
        <i-input v-model="form.cause_name" @click="mlist()"></i-input>
      </FormItem>
      <FormItem label="付款类型" prop="cause_type">
          <Select v-model="form.cause_type">
            <Option v-for="(item,i) in this.cause" :value="item.id" :key="i">{{ item.tag }}
            </Option>
          </Select>
      </FormItem>
      <FormItem label="活动时间" prop="begin_time">
        <DatePicker  type="date"  v-model="form.begin_time"></DatePicker>
      </FormItem>
      <FormItem label="当前状态">
        <RadioGroup v-model="form.final_status">
          <Radio :label="1">收集中</Radio>
          <Radio :label="2">已收集</Radio>
          <Radio  :label="6">已提交财务</Radio>
          <Radio v-show="false" :label="3">已提交支付</Radio>
          <Radio v-show="false" :label="4">已支付</Radio>
          <Radio v-show="false" :label="5">部分支付</Radio>
          
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
      form: { final_status:1 },
      flag:false,
      cause:{},
      formRule: {
        cause_name: [{ required: true, message: "事由名称", trigger: "blur" }],
        cause_type: [{ required: true, trigger: "blur" }],
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
      let url = "api/cost/consultations";
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
    },
    getCon() {
        axios
        .request({
          method: "get",
          url: "api/cost/tags",
          params: {
            page:this.page
          }
        })
        .then(res => {
          this.cause = res.data.data;
        });
    },
    isRole() {
      axios
        .request({
          method: "get",
          url: "api/cost/memberinfo",
          params: {
            page:this.page
          }
        })
        .then(res => {
            let role = ['admin'];
            for (var v = 0; v < role.length; v++) {
                    if (role[v] == res.data.successful) {
                        this.flag = true;
                        break;
                    }
                }
                if(this.flag){
                    let show = document.querySelectorAll('.role_show');
                    for(var i=0;i<show.length;i++){
                        show[i].style.display='inline';
                    }
                }
                
            });
            return this.flag;
    },
  },
  mounted() {
    this.getCon();
    this.isRole();
  }
};
</script>
<style scoped>
.info{
    color: #fff;
}
</style>