<template>
  <div class="mBox">
    <Form :label-width="100" :rules="formRule" :model="form">
      <FormItem label="名字" prop="name">
        <i-input v-model="form.name"></i-input>
      </FormItem>
      <FormItem label="性别">
        <RadioGroup v-model="form.sex">
          <Radio :label="1">男</Radio>
          <Radio :label="2">女</Radio>
        </RadioGroup>
      </FormItem>
      <FormItem label="单位名称" prop="hospital_name">
        <i-input v-model="form.hospital_name" @input="getCon()"></i-input>
      </FormItem>
      <ul class="searchSelect" id="searchSelect" v-show="showSelect">
          <li v-for="(item,i) in this.companys" :value="item.id" :key="i" @click="getName(item.id,item.hospital_name)">{{ item.hospital_name }}</li>
      </ul>
      <!-- <FormItem label="所在单位" prop="company">
          <Select v-model="form.company">
            <Option v-for="(item,i) in this.companys" :value="item.id" :key="i">{{ item.hospital_name }}
            </Option>
          </Select>
      </FormItem> -->
      <FormItem label="电话号码" prop="mobile">
        <i-input v-model="form.mobile"></i-input>
      </FormItem>
      <FormItem label="身份证号码" prop="IDcard">
        <i-input v-model="form.IDcard"></i-input>
      </FormItem>
      <FormItem label="银行卡号" prop="bank_num">
        <i-input v-model="form.bank_num"></i-input>
      </FormItem>
      <FormItem label="开户行(支行)" prop="opening_bank">
        <i-input v-model="form.opening_bank"></i-input>
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
  name: "",
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
      showSelect:false,
      companys:{},
      form: { sex:1 },
      formRule: {
        name: [{ required: true,message: "姓名不能为空", trigger: "blur" }],
        sex: [{ required: true, trigger: "blur" }],
        hospital_name: [{ required: true,message: "所在单位不能为空", trigger: "blur" }],
        mobile: [
                  { required: true,message: "电话号码不能为空", trigger: "blur" },
                  {
                    pattern: /^1\d{10}$/,
                    message: "请输入正确的电话号码",
                    trigger: "blur"
                  }
                ],
        IDcard: [
                  { required: true,message: "身份证号码不能为空", trigger: "blur" },
                  {
                    pattern: /^[1-9]\d{5}(18|19|20|(3\d))\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/,
                    message: "请输入正确的身份证号码",
                    trigger: "blur"
                  }
                ],
        bank_num: [
                  { required: true,message: "银行卡号不能为空", trigger: "blur" },
                  {
                    pattern:  /^[0-9]*$/,
                    message: "请输入正确的银行卡号码",
                    trigger: "blur"
                  }
                ],
        opening_bank: [{ required: true,message: "开户行不能为空", trigger: "blur" }],
      }
    };
  },
  watch: {
    value(data) {
      this.form = Object.assign({}, data);
      console.log(this.form);
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
      let url = "api/cost/members";
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
    // nameChange() {
    //   let method = "GET";
    //   let url = "api/cost/msearch/";
    //       url += this.form.name?this.form.name:1;
    //   axios
    //     .request({
    //       url: url,
    //       method: method,
    //     })
    //     .then(res => {
    //       if (res.data.successful) {
    //         this.members = res.data.successful,
    //         this.bank = {},
    //         this.showSelect = true
    //       } else {
    //         this.showSelect = false,
    //         this.showMember = false,
    //         this.$Notice.warning({
    //           title: "提示",
    //           desc: res.data.error_msg,
    //         });
    //       }
    //     });
    // },
    getCon() {
      let url = "api/cost/hsearch/";
          url += this.form.hospital_name?this.form.hospital_name:1
        axios
        .request({
          method: "get",
          url: url,
          params: {
            page:this.page
          }
        })
        .then(res => {
          this.showSelect = true
          this.companys = res.data.data;
        });
    },
    getName(id,name) {
        this.showSelect = false;
        this.form.company = id;
        this.form.hospital_name = name;
    }
  },
  mounted() {
    
  }
};
</script>
<style scoped>
.info{
    color: #fff;
}
.mBox{
  position: relative;
}
.searchSelect{
    margin-bottom: 50px;
    z-index: 1;
    width: 375px;
    max-height: 100px;
    position: absolute;
    overflow: auto;
    left: 100px;
    top: 145px;
    list-style:none;
    background-color: #ccc;
    border: #ccc solid 1px;
}
.searchSelect li{
    padding-left: 10px;
    background-color: #ffffff;
}
</style>