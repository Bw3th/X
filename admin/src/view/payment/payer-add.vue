<template>
  <div class="box">
    <Form :label-width="90" :rules="formRule" :model="form">
      <!-- <FormItem label="所在单位" prop="company" >
          <Select v-model="form.company"  @input="getMembers()">
            <Option v-for="(item,i) in this.companys" :value="item.id" :key="i">{{ item.hospital_name }}
            </Option>
          </Select>
      </FormItem> -->
      <FormItem label="单位名称" prop="hospital_name">
        <i-input v-model="form.hospital_name" @input="getCon()"></i-input>
      </FormItem>
      <ul class="searchSelect" id="searchSelect" v-show="showSelect">
          <li v-for="(item,i) in this.companys" :key="i" @click="getName(item.id,item.hospital_name)">{{ item.hospital_name }}</li>
      </ul>
     <!-- <Checkbox-group  class="chebox" v-show="showMember">
        <Checkbox class="cheboxs" v-for="(item,i) in this.members" value="item.id"  :key="i" @input="getnum(item.id)" :checked='true'>
            <span class="cheboxss">{{item.name_bank}}</span>
        </Checkbox>
    </Checkbox-group> -->
    <label class="cheboxs" v-for="(item,i) in this.members"   :key="i" @input="getnum(item.id)" v-show="showMember">
      <div style="display:inline-block; width:250px;"> 
        <input type="checkbox" class="chebox">
      <span class="cheboxss">{{item.name_bank}}</span>
      </div>
      
    </label>
      <!-- <FormItem label="收款人名称" prop="name">
        <i-input v-model="form.name" @input="nameChange()"></i-input>
      </FormItem>
      <FormItem label="收款人ID" prop="memberID" v-show="false">
        <i-input v-model="form.memberID"></i-input>
      </FormItem>
      <ul class="searchSelect" id="searchSelect" v-show="showSelect">
          <li v-for="(item,i) in this.members" :value="item.id" :key="i" @click="getName(item.id,item.name)">{{ item.name }}</li>
      </ul>
      <div class="memberinfo" v-show="showMember">
          <p>性别 ：{{member.sexs}}</p>
          <p>身份证号码 ：{{member.IDcard}}</p>
          <p>电话号码 ：{{member.mobile}}</p>
          <p>所在单位 ：{{member.company}}</p>
      </div>
      <FormItem label="银行账号" prop="bankID">
          <Select v-model="form.newbank">
            <Option v-for="(item,i) in this.bank" :value="item.id" :key="i">{{ item.newbank }}
            </Option>
          </Select>
      </FormItem> -->
      <FormItem label="金额" prop="cost">
            <i-input v-model="form.cost"></i-input>
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
      putmember:[],
      form: {},
      members:{},
      companys:{},
      member:{},
      bank:{},
      showMember:false,
      showSelect:false,
      formRule: {
      }
    };
  }, 
  watch: {
    value(data) {
      // console.log(data);
      
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
        let cheboxss = document.querySelectorAll('.chebox');
        for(var i=0;i<cheboxss.length;i++){
            cheboxss[i].checked = false

        }      
        this.form.company = '';
        let method = "POST";
        let url = "api/cost/charge" ;
        url += "/" + this.form.causeId;
      axios
        .request({
          url: url,
          method: method,
          data: this.form
        })
        .then(res => {
          if (res.data.successful) {
            this.putmember.length = 0;        
            this.form.member.length = 0;   
            
               
            this.showSelect = false;
            this.showMember = false;  
            this.$emit("saved");
          } else {
            this.putmember.length = 0;        
            this.form.member.length = 0;
            this.showMember = false; 
            this.$Notice.warning({
              title: "提示",
              desc: res.data.error_msg
            });
          }
        });
    },
    getCompany() {
      let method = "GET";
      let url = "api/cost/csearch";
      axios
        .request({
          url: url,
          method: method,
        })
        .then(res => {
          if (res.data.successful) {
            this.companys = res.data.successful
          } else {
            this.$Notice.warning({
              title: "提示",
              desc: res.data.error_msg,
            });
          }
        });
    },
    getMembers() {
      let method = "GET";
      let url = "api/cost/csearchs/";
          url += this.form.company?this.form.company:1;
      axios
        .request({
          url: url,
          method: method,
        })
        .then(res => {
          if (res.data.successful) {
            this.showMember = true,
            this.members = res.data.successful
          } else {
            this.showSelect = false,
            this.showMember = false,
            this.$Notice.warning({
              title: "提示",
              desc: res.data.error_msg,
            });
          }
        });
    },
    getnum(id) {
      Array.prototype.remove = function(val) { 
        var index = this.indexOf(val); 
        if (index > -1) { 
        this.splice(index, 1); 
        } 
      };
      
      
      if(this.putmember.indexOf(id) > -1){
        this.putmember.remove(id);
      }else{
        this.putmember.push(id);
        this.form.member = this.putmember;
      }
      console.log(this.putmember)
    },
    getCon() {
            this.putmember.splice(0);
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
      // console.log(this.putmember)
        this.showSelect = false;
        this.form.company = id;
        this.form.hospital_name = name;
        this.getMembers();
    }
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
    // getName(id,name) {
    //     this.showSelect = false;
    //     this.form.name = name;
    //     let method = "GET";
    //     let url = "api/cost/msearchs/";
    //         url += id;
    //     axios
    //         .request({
    //         url: url,
    //         method: method,
    //         })
    //         .then(res => {
    //         if (res.data.successful) {
    //             this.member = res.data.successful,
    //             this.form.memberID = res.data.successful.id,
    //             this.bank = res.data.bank,
    //             this.showMember =true
    //         } else {
    //             this.$Notice.warning({
    //             title: "提示",
    //             desc: res.data.error_msg,
    //             });
    //         }
    //         });
    // }
  },
  mounted() {
    this.getCompany();
  },
};
</script>
<style scoped>
.info{
    color: #fff;
}
.box{
    position: relative;
}
.searchSelect{
    
    margin-bottom: 50px;
    z-index: 1;
    width: 375px;
    max-height: 100px;
    position: absolute;
    overflow: auto;
    left: 90px;
    top: 31px;
    list-style:none;
    background-color: #ccc;
    border: #ccc solid 1px;
}
.searchSelect li{
    padding-left: 10px;
    background-color: #ffffff;
}
.memberinfo{
    margin-left: 90px;
    margin-bottom: 20px;
    width: 375px;
    background-color: #FFFBE5;
    padding: 30px 0 30px 30px ;
}
.cheboxs:nth-of-type(odd){
  margin-left: 90px;
  margin-bottom: 20px;
}
.cheboxs:nth-of-type(even){
  margin-left: 30px;
  margin-bottom: 20px;
}
</style>